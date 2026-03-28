<?php
/**
 * FDAP Integration (Independent of Theme)
 * Centralizes file validation, image compression and auto-saving for FDAP uploads.
 */

defined('ABSPATH') || exit;

class FDAP_Integration {

    public function __construct() {
        // File validation & compression
        add_filter('wp_handle_upload_prefilter', [$this, 'validate_and_precompress'], 10);
        
        // Auto-save post modified date after upload
        add_action('add_attachment', [$this, 'auto_save_fdap_post'], 10, 1);
        
        // Admin bar nodes for easy access - High priority to ensure persistence
        add_action('admin_bar_menu', [$this, 'add_fdap_admin_bar_nodes'], 999);
        
        // Force show admin bar for logged in users (critical for students)
        add_filter('show_admin_bar', [$this, 'force_show_admin_bar']);
    }

    /**
     * Force show admin bar for all logged in users
     */
    public function force_show_admin_bar($show) {
        if (is_user_logged_in()) {
            return true;
        }
        return $show;
    }

    /**
     * Centralized validation and compression before upload
     */
    public function validate_and_precompress($file) {
        // Only process if it's an FDAP upload (identified by nonce)
        if (!isset($_POST['fdap_nonce']) || !wp_verify_nonce($_POST['fdap_nonce'], 'fdap_form_submit')) {
            return $file;
        }

        // 1. Validation (Format & Size)
        $valid_types = [
            // Images
            'image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp',
            // Documents
            'application/pdf', 'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'text/plain',
            // Audio
            'audio/mpeg', 'audio/mp3', 'audio/wav', 'audio/x-wav',
            'audio/mp4', 'audio/x-m4a', 'audio/ogg', 'audio/aac',
            'audio/x-mpeg', 'audio/mpeg3',
            // Vidéo
            'video/mp4', 'video/webm', 'video/ogg', 'video/quicktime',
            'video/x-msvideo', 'video/x-ms-wmv',
            // Archives
            'application/zip', 'application/x-zip-compressed',
        ];

        $type_prefix = explode('/', $file['type'])[0];
        $max_sizes = [
            'image' => 10 * 1024 * 1024,
            'audio' => 50 * 1024 * 1024,
            'video' => 100 * 1024 * 1024,
            'application' => 20 * 1024 * 1024,
            'text' => 5 * 1024 * 1024,
        ];
        $max_size = $max_sizes[$type_prefix] ?? 10 * 1024 * 1024;

        if (!in_array($file['type'], $valid_types)) {
            return ['error' => 'Format non supporté pour le Portfolio FDAP (Images, PDF, DOC, MP3, MP4, ZIP).'];
        }

        if ($file['size'] > $max_size) {
            $max_mb = round($max_size / (1024 * 1024));
            return ['error' => 'Fichier trop volumineux (max ' . $max_mb . 'MB pour ce type).'];
        }

        // 2. Compression (if image)
        if (in_array($file['type'], ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'])) {
            if (file_exists($file['tmp_name']) && function_exists('fdap_compress_image_file')) {
                // We use the centralized quality settings
                $result = fdap_compress_image_file($file['tmp_name'], $file['type']);
                if ($result && !is_wp_error($result)) {
                    $file['size'] = $result['final_size'];
                }
            }
        }

        return $file;
    }

    /**
     * Auto-save FDAP post when an attachment is added to it
     */
    public function auto_save_fdap_post($attachment_id) {
        $attachment = get_post($attachment_id);
        if (!$attachment || !$attachment->post_parent) return;

        $parent = get_post($attachment->post_parent);
        if ($parent && $parent->post_type === 'fdap') {
            wp_update_post([
                'ID' => $parent->ID,
                'post_modified' => current_time('mysql'),
                'post_modified_gmt' => current_time('mysql', true)
            ]);
        }
    }

    /**
     * Add FDAP Quick Access to the Top Admin Bar
     */
    public function add_fdap_admin_bar_nodes($admin_bar) {
        if (!is_user_logged_in()) return;

        $is_admin = current_user_can('edit_others_posts');
        
        $mes_fdap_page = get_page_by_path('mes-fdap');
        $mes_fdap_url = $mes_fdap_page ? get_permalink($mes_fdap_page) : home_url('/mes-fdap/');
        
        $new_fdap_page = get_page_by_path('fdap-2');
        $new_fdap_url = $new_fdap_page ? get_permalink($new_fdap_page) : home_url('/fdap-2/');

        // Main Node
        $admin_bar->add_node([
            'id'    => 'fdap-portfolio',
            'title' => '<span class="ab-icon dashicons dashicons-portfolio" style="top:2px;"></span> FDAP Portfolio',
            'href'  => $is_admin ? admin_url('admin.php?page=fdap-dashboard') : $mes_fdap_url,
            'meta'  => ['title' => 'Accès rapide Portfolio']
        ]);

        if ($is_admin) {
            // Admin Sub-nodes
            $admin_bar->add_node([
                'id'     => 'fdap-admin-all',
                'parent' => 'fdap-portfolio',
                'title'  => '📊 Tableau de bord global',
                'href'   => admin_url('admin.php?page=fdap-dashboard')
            ]);
            $admin_bar->add_node([
                'id'     => 'fdap-admin-students',
                'parent' => 'fdap-portfolio',
                'title'  => '👥 Suivi par élève',
                'href'   => admin_url('admin.php?page=fdap-by-student')
            ]);
        } else {
            // Student Sub-nodes
            $admin_bar->add_node([
                'id'     => 'fdap-student-list',
                'parent' => 'fdap-portfolio',
                'title'  => '📂 Mes fiches',
                'href'   => $mes_fdap_url
            ]);
            $admin_bar->add_node([
                'id'     => 'fdap-student-new',
                'parent' => 'fdap-portfolio',
                'title'  => '➕ Nouvelle activité',
                'href'   => $new_fdap_url
            ]);
        }
    }
}
