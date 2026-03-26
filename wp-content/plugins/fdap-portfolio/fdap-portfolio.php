<?php
/**
 * Plugin Name: FDAP Portfolio
 * Description: Fiches d'activités pédagogiques pour portfolios étudiants.
 * Version: 1.0.3
 * Author: Patrick L'Hôte
 * Text Domain: fdap-portfolio
 * Requires at least: 5.0
 * Requires PHP: 7.4
 */

defined('ABSPATH') || exit;

// Constants
define('FDAP_VERSION', '1.0.6');
define('FDAP_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('FDAP_PLUGIN_URL', plugin_dir_url(__FILE__));

// Load classes - late priority to avoid conflicts
add_action('plugins_loaded', function() {
    require_once FDAP_PLUGIN_DIR . 'includes/class-post-type.php';
    require_once FDAP_PLUGIN_DIR . 'includes/class-shortcodes.php';
    require_once FDAP_PLUGIN_DIR . 'includes/class-admin.php';
    require_once FDAP_PLUGIN_DIR . 'includes/helpers.php';
    
    // Register CPT
    new FDAP_Post_Type();
    
    // Register shortcodes
    new FDAP_Shortcodes();
    
    // Admin & impersonation features
    new FDAP_Admin();

}, 20);

// Template loader for single-fdap
add_filter('single_template', function($template) {
    if (is_admin()) {
        return $template;
    }
    
    global $post;
    if (!$post || !is_object($post)) {
        return $template;
    }
    
    if (get_post_type($post) === 'fdap') {
        $plugin_template = FDAP_PLUGIN_DIR . 'templates/single-fdap.php';
        if (file_exists($plugin_template)) {
            return $plugin_template;
        }
    }
    
    return $template;
}, 20);

// Activation
register_activation_hook(__FILE__, function() {
    require_once FDAP_PLUGIN_DIR . 'includes/class-post-type.php';
    $pt = new FDAP_Post_Type();
    $pt->register();
    flush_rewrite_rules();
});

// Deactivation
register_deactivation_hook(__FILE__, function() {
    flush_rewrite_rules();
});

/**
 * Compress uploaded images - ONLY for FDAP uploads
 * Checks for fdap_nonce to identify FDAP form submissions
 */
add_filter('wp_handle_upload', function($upload, $context = 'upload') {
    // Only process image files from FDAP forms
    if (!in_array($upload['type'] ?? '', ['image/jpeg', 'image/png', 'image/webp'])) {
        return $upload;
    }
    
    // Check if this is an FDAP upload
    if (!isset($_POST['fdap_nonce']) || !wp_verify_nonce($_POST['fdap_nonce'], 'fdap_form_submit')) {
        return $upload;
    }
    
    // Skip if file doesn't exist
    if (!file_exists($upload['file'])) {
        return $upload;
    }
    
    // Appel de la fonction de compression centralisée
    if (function_exists('fdap_compress_image_file')) {
        $result = fdap_compress_image_file($upload['file'], $upload['type']);
        if ($result) {
            $upload['size'] = $result['final_size'];
        }
    }
    
    return $upload;
}, 10, 2);

// Enqueue styles - ONLY on FDAP pages
add_action('wp_enqueue_scripts', function() {
    global $post;
    
    // Don't load on admin pages
    if (is_admin()) {
        return;
    }
    
    // Only load on FDAP pages
    if (is_page('fdap-2') || is_page('mes-fdap') || (is_singular() && $post && get_post_type($post) === 'fdap')) {
        wp_enqueue_style('fdap-style', FDAP_PLUGIN_URL . 'assets/css/style.css', [], FDAP_VERSION);
    }
});

/**
 * AJAX Sauvegarde d'une compétence personnalisée
 */
add_action('wp_ajax_fdap_add_custom_competence', function() {
    if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'fdap_form_submit')) {
        wp_send_json_error(['message' => 'Session expirée, veuillez rafraîchir la page.']);
    }
    
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'Vous devez être connecté.']);
    }

    $new_comp = sanitize_text_field($_POST['competence'] ?? '');
    if (empty($new_comp) || $new_comp === 'Autre (à préciser)...') {
        wp_send_json_error(['message' => 'Veuillez saisir un intitulé valide.']);
    }

    $customs = get_option('_fdap_custom_competencies', []);
    if (!is_array($customs)) $customs = [];

    if (!in_array($new_comp, $customs)) {
        $customs[] = $new_comp;
        update_option('_fdap_custom_competencies', $customs);
        wp_send_json_success(['message' => 'Compétence ajoutée au référentiel !']);
    } else {
        wp_send_json_success(['message' => 'Déjà existant']); // On valide quand même
    }
});



require_once FDAP_PLUGIN_DIR . 'includes/class-export.php';
