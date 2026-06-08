<?php
/**
 * IMPEX Football — WordPress Configuration Sample
 *
 * Copy this file to wp-config.php and update with your actual database
 * credentials and security keys before deploying.
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 * @package ImpexFootball
 */

// ============================================================
//  DATABASE SETTINGS
//  Update these with your actual MySQL credentials.
// ============================================================

/** The name of the database for WordPress */
define( 'DB_NAME', 'impex_football_db' );

/** MySQL database username */
define( 'DB_USER', 'impex_db_user' );

/** MySQL database password */
define( 'DB_PASSWORD', 'CHANGE_THIS_STRONG_PASSWORD' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables */
define( 'DB_CHARSET', 'utf8mb4' );

/** Database collation type */
define( 'DB_COLLATE', 'utf8mb4_unicode_ci' );

// ============================================================
//  AUTHENTICATION UNIQUE KEYS AND SALTS
//  Generate fresh keys at: https://api.wordpress.org/secret-key/1.1/salt/
//  IMPORTANT: Replace ALL of the lines below with your own unique values.
// ============================================================

define( 'AUTH_KEY',         'REPLACE_WITH_UNIQUE_RANDOM_VALUE_1' );
define( 'SECURE_AUTH_KEY',  'REPLACE_WITH_UNIQUE_RANDOM_VALUE_2' );
define( 'LOGGED_IN_KEY',    'REPLACE_WITH_UNIQUE_RANDOM_VALUE_3' );
define( 'NONCE_KEY',        'REPLACE_WITH_UNIQUE_RANDOM_VALUE_4' );
define( 'AUTH_SALT',        'REPLACE_WITH_UNIQUE_RANDOM_VALUE_5' );
define( 'SECURE_AUTH_SALT', 'REPLACE_WITH_UNIQUE_RANDOM_VALUE_6' );
define( 'LOGGED_IN_SALT',   'REPLACE_WITH_UNIQUE_RANDOM_VALUE_7' );
define( 'NONCE_SALT',       'REPLACE_WITH_UNIQUE_RANDOM_VALUE_8' );

// ============================================================
//  DATABASE TABLE PREFIX
//  Use a custom prefix for better security.
// ============================================================

$table_prefix = 'wp_';

// ============================================================
//  SITE URL SETTINGS
//  Update these with your actual domain.
// ============================================================

/**
 * For development (localhost), uncomment:
 */
// define( 'WP_HOME',    'http://localhost/impex' );
// define( 'WP_SITEURL', 'http://localhost/impex' );

/**
 * For production, set your live domain:
 */
// define( 'WP_HOME',    'https://www.impexfootball.com' );
// define( 'WP_SITEURL', 'https://www.impexfootball.com' );

// ============================================================
//  WORDPRESS ENVIRONMENT TYPE
//  'development', 'staging', or 'production'
// ============================================================

define( 'WP_ENVIRONMENT_TYPE', 'development' );

// ============================================================
//  DEBUG SETTINGS
//  Disable all of these on production!
// ============================================================

/** Enable WP_DEBUG mode — set to false for production */
define( 'WP_DEBUG', true );

/** Enable debug logging to /wp-content/debug.log */
define( 'WP_DEBUG_LOG', true );

/** Suppress errors from displaying on screen (leave false for production) */
define( 'WP_DEBUG_DISPLAY', false );

/** Turn off display of database errors */
define( 'DBERROR', false );

// ============================================================
//  PERFORMANCE SETTINGS
// ============================================================

/** Disable the auto-save feature during development */
// define( 'AUTOSAVE_INTERVAL', 300 );

/** Limit the number of post revisions stored */
define( 'WP_POST_REVISIONS', 5 );

/** Disable editing of theme/plugin files from admin (security) */
define( 'DISALLOW_FILE_EDIT', true );

/** Allow WordPress to update files (set to false if managed by code) */
define( 'DISALLOW_FILE_MODS', false );

/** Memory limit for WordPress */
define( 'WP_MEMORY_LIMIT', '256M' );

/** Memory limit for WP admin */
define( 'WP_MAX_MEMORY_LIMIT', '512M' );

// ============================================================
//  WOOCOMMERCE SETTINGS
// ============================================================

/**
 * Increase PHP limits for WooCommerce processing.
 * These should also be set in php.ini / .htaccess.
 */
@ini_set( 'upload_max_filesize', '64M' );
@ini_set( 'post_max_size',       '64M' );
@ini_set( 'max_execution_time',  '300' );

// ============================================================
//  SSL / HTTPS SETTINGS
//  Enable for production with SSL certificate.
// ============================================================

/**
 * Force SSL on the admin panel — strongly recommended for production.
 */
// define( 'FORCE_SSL_ADMIN', true );

/**
 * If behind a reverse proxy / load balancer:
 */
// define( 'HTTPS_DETECTION_BY_FORWARD', true );

// ============================================================
//  CACHE SETTINGS
// ============================================================

/**
 * Enable WP_CACHE if using a caching plugin (W3TC, WP Super Cache, etc.)
 */
// define( 'WP_CACHE', true );

// ============================================================
//  MULTISITE (leave disabled unless using WordPress Multisite)
// ============================================================

// define( 'WP_ALLOW_MULTISITE', true );
// define( 'MULTISITE', true );
// define( 'SUBDOMAIN_INSTALL', false );
// define( 'DOMAIN_CURRENT_SITE', 'impexfootball.com' );
// define( 'PATH_CURRENT_SITE', '/' );
// define( 'SITE_ID_CURRENT_SITE', 1 );
// define( 'BLOG_ID_CURRENT_SITE', 1 );

// ============================================================
//  ABSOLUTE PATH — DO NOT EDIT BELOW THIS LINE
// ============================================================

if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
