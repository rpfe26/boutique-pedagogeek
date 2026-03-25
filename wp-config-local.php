<?php
/**
 * Configuration WordPress pour développement local SANS Docker
 * Installer: brew install php mysql
 * Copier vers wp-config.php après configuration
 */

// ** Réglages MySQL - Installation native ** //
define( 'DB_NAME', 'wordpress' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', '' );  // Vide par défaut sur Homebrew
define( 'DB_HOST', '127.0.0.1' );  // ou 'localhost'
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );

/**
 * Préfixe de base de données
 */
$table_prefix = 'wp_';

/**
 * Pour les développeurs : le mode débogage de WordPress
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );

/**
 * URL du site (modifiable selon votre IP/port)
 * Pour changer: modifier ces lignes ou utiliser --url avec le serveur PHP
 */
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost:8080';
define( 'WP_HOME', $protocol . '://' . $host );
define( 'WP_SITEURL', $protocol . '://' . $host );

/**
 * Clés de sécurité
 * Générer les vôtres sur https://api.wordpress.org/secret-key/1.1/salt/
 */
define( 'AUTH_KEY',         'put your unique phrase here' );
define( 'SECURE_AUTH_KEY',  'put your unique phrase here' );
define( 'LOGGED_IN_KEY',    'put your unique phrase here' );
define( 'NONCE_KEY',        'put your unique phrase here' );
define( 'AUTH_SALT',        'put your unique phrase here' );
define( 'SECURE_AUTH_SALT', 'put your unique phrase here' );
define( 'LOGGED_IN_SALT',   'put your unique phrase here' );
define( 'NONCE_SALT',       'put your unique phrase here' );

/* C'est tout, ne touchez pas à ce qui suit ! Bonne publication ! */
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}

require_once ABSPATH . 'wp-settings.php';
