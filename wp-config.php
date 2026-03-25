<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'wordpress' );

/** Database password */
define( 'DB_PASSWORD', 'cfcd53621057a9455d6eed97' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'WKqELxwFn7keWzcZU1T4CS8QirQBqPGCL5ErhP3T' );
define( 'SECURE_AUTH_KEY',  'Dqfp76L217KAp1KcWLE3XkfszBA5PnRJgFUmb8lt' );
define( 'LOGGED_IN_KEY',    'freLI4aH5faElJsRb9fXV1yVxX2lIkjybjy1Wikn' );
define( 'NONCE_KEY',        'VhVvVll0I1rrxZN9WBu7uzU9oRK7GELTTRspl3fi' );
define( 'AUTH_SALT',        '3TJnzPuPvT81Ssh6W1Pw7cQgirzqalzyueky32fT' );
define( 'SECURE_AUTH_SALT', 'zIKLSeVmnoxyxd7Eu8LKDm4MXf9OJLLJDLSykRZ6' );
define( 'LOGGED_IN_SALT',   'FuPKjgWk5S2W2XNJ077kD0KN6yZ6flJ5zA7TQPWG' );
define( 'NONCE_SALT',       'vSpCWysOR6NgYIu2mhi3CnvN4GfpPPvpj65C2Lu7' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
