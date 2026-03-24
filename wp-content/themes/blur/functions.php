<?php
/**
 * Blur functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Blur
 * @since Blur 1.0
 */


if ( ! function_exists( 'blur_support' ) ) :

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @since Blur 1.0
	 *
	 * @return void
	 */
	function blur_support() {
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Add support for block styles.
		add_theme_support( 'wp-block-styles' );

		add_theme_support( 'align-wide' );

		// Enqueue editor styles.
		add_editor_style( 'style.css' );

		add_theme_support( 'responsive-embeds' );
		

		// Add support for experimental link color control.
		add_theme_support( 'experimental-link-color' );

		//define
		define( 'BLUR_VERSION', '1.0.0' );
	    define( 'BLUR_DEBUG', defined( 'WP_DEBUG' ) && WP_DEBUG === true );
	    define( 'BLUR_DIR', trailingslashit( get_template_directory() ) );
	    define( 'BLUR_URL', trailingslashit( get_template_directory_uri() ) );

	}

endif;

add_action( 'after_setup_theme', 'blur_support' );

if ( ! function_exists( 'blur_styles' ) ) :

	/**
	 * Enqueue styles.
	 *
	 * @since Blur 1.0
	 *
	 * @return void
	 */
	function blur_styles() {

		// Register theme stylesheet.
		wp_register_style(
			'blur-style',
			get_template_directory_uri() . '/style.css',
			array(),
			wp_get_theme()->get( 'Version' )
		);

		// Enqueue theme stylesheet.
		wp_enqueue_style( 'blur-style' );

	}

endif;

add_action( 'wp_enqueue_scripts', 'blur_styles' );


// Add block patterns
require get_template_directory() . '/inc/block-pattern.php';

// Add block Style
require get_template_directory() . '/inc/block-style.php';

//theme option panel
require get_template_directory() . '/theme-option/theme-option.php';
/**
 * Sauvegarde automatique du post après upload d'attachment
 * Hook déclenché automatiquement après chaque upload
 */
add_action('add_attachment', 'boutique_auto_save_post', 10, 1);

function boutique_auto_save_post($attachment_id) {
    // Récupérer le post associé
    $attachment = get_post($attachment_id);
    
    // Si pas de post_parent, on ne fait rien (attachment direct)
    if (!$attachment || !$attachment->post_parent) {
        return;
    }
    
    // Récupérer le post parent
    $post = get_post($attachment->post_parent);
    
    
    // Mettre à jour le post (mets à jour post_modified)
    wp_update_post([
        'ID' => $post->ID,
        'post_modified' => current_time('mysql'),
        'post_modified_gmt' => current_time('mysql', true)
    ]);
}


/**
 * Validation des uploads - Format et taille
 */
add_filter('wp_handle_upload_prefilter', 'boutique_validate_upload');

function boutique_validate_upload($file) {
    // Types autorisés par catégorie
    $valid_types = [
        // Images
        'image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp',
        // Documents
        'application/pdf', 'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'text/plain',
        // Audio - SUPPORT MP3 ET AUTRES FORMATS
        'audio/mpeg', 'audio/mp3', 'audio/wav', 'audio/x-wav',
        'audio/mp4', 'audio/x-m4a', 'audio/ogg', 'audio/aac',
        'audio/x-mpeg', 'audio/mpeg3',
        // Vidéo
        'video/mp4', 'video/webm', 'video/ogg', 'video/quicktime',
        'video/x-msvideo', 'video/x-ms-wmv',
        // Archives
        'application/zip', 'application/x-zip-compressed',
    ];
    
    // Taille max selon le type de fichier
    $type_prefix = explode('/', $file['type'])[0];
    $max_sizes = [
        'image' => 10 * 1024 * 1024,      // 10MB pour images
        'audio' => 50 * 1024 * 1024,      // 50MB pour audio
        'video' => 100 * 1024 * 1024,     // 100MB pour vidéo
        'application' => 20 * 1024 * 1024, // 20MB pour documents
        'text' => 5 * 1024 * 1024,        // 5MB pour texte
    ];
    $max_size = isset($max_sizes[$type_prefix]) ? $max_sizes[$type_prefix] : 10 * 1024 * 1024;
    
    // Vérifier le type
    if (!in_array($file['type'], $valid_types)) {
        return ['error' => 'Format non supporté. Types: Images, Documents (PDF, DOC), Audio (MP3, WAV), Vidéo (MP4)'];
    }
    
    // Vérifier la taille
    if ($file['size'] > $max_size) {
        $max_mb = round($max_size / (1024 * 1024));
        return ['error' => 'Fichier trop lourd (max ' . $max_mb . 'MB pour ce type)'];
    }
    
    return $file;
}

// === AMELIORATION LISIBILITE HEADER ===
function blur_enqueue_custom_header_css() {
    wp_enqueue_style(
        'blur-custom-header',
        get_template_directory_uri() . '/assets/css/custom-header.css',
        array(),
        '1.0.0'
    );
}
add_action('wp_enqueue_scripts', 'blur_enqueue_custom_header_css');

// === AMELIORATION BACKOFFICE - ONGLETS CLIQUABLES ===
function blur_enqueue_admin_tabs_css() {
    wp_enqueue_style(
        'blur-admin-tabs',
        get_template_directory_uri() . '/assets/css/admin-tabs.css',
        array(),
        '1.0.0'
    );
}
add_action('admin_enqueue_scripts', 'blur_enqueue_admin_tabs_css');

// === INDICATEUR BACK OFFICE DANS LA BARRE ADMIN ===
function blur_add_backoffice_indicator_admin_bar($admin_bar) {
    if (current_user_can('edit_posts')) {
        $admin_bar->add_node([
            'id' => 'back-office-indicator',
            'title' => '<span class="bo-badge">⚙️ BACK OFFICE</span>',
            'href' => admin_url(),
            'meta' => [
                'title' => __('Mode administration - Back Office'),
                'class' => 'backoffice-indicator'
            ]
        ]);
    }
}
add_action('admin_bar_menu', 'blur_add_backoffice_indicator_admin_bar', 1);

// === BACK OFFICE BADGE CSS FOR FRONTEND ===
function blur_enqueue_admin_bar_css() {
    if (is_user_logged_in() && current_user_can('edit_posts')) {
        wp_enqueue_style('blur-admin-tabs',
            get_template_directory_uri() . '/assets/css/admin-tabs.css',
            array(), '1.0.1');
    }
}
add_action('wp_enqueue_scripts', 'blur_enqueue_admin_bar_css');

// === FDAP - COMPRESSION AUTOMATIQUE IMAGES 300KB ===
// Comprime les images uploadées à 300KB max
define("FDAP_MAX_FILESIZE", 300 * 1024);
define("FDAP_MAX_DIMENSION", 1920);
define("FDAP_JPEG_QUALITY", 75);
define("FDAP_MIN_QUALITY", 40);
define("FDAP_MIN_DIMENSION", 800);

// add_filter("wp_handle_upload_prefilter", "fdap_upload_prefilter");

function fdap_upload_prefilter($file) {
    if (!isset($file["type"]) || !in_array($file["type"], ["image/jpeg", "image/jpg", "image/png", "image/webp"])) {
        return $file;
    }
    if (!file_exists($file["tmp_name"])) {
        return $file;
    }
    
    $result = fdap_compress_image($file["tmp_name"], $file["type"]);
    
    if ($result && !is_wp_error($result)) {
        $file["size"] = $result["final_size"];
        if ($result["converted"]) {
            $file["name"] = preg_replace("/\.(png|webp)$/i", ".jpg", $file["name"]);
            $file["type"] = "image/jpeg";
        }
    }
    return $file;
}

function fdap_compress_image($file_path, $mime_type) {
    // Utiliser la fonction centralisée si le plugin FDAP Portfolio est actif
    if (function_exists('fdap_compress_image_file')) {
        $result = fdap_compress_image_file($file_path, $mime_type);
        if ($result && isset($result['success'])) {
            return $result;
        }
    }
    
    // Fallback ou erreur si la fonction n'est pas disponible
    return new WP_Error("compression_failed", "La fonction de compression centralisée n'est pas disponible.");
}
