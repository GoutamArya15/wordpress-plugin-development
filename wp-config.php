<?php

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */
define('WP_MEMORY_LIMIT', '512M');


// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'gautam');

/** Database username */
define('DB_USER', 'root');

/** Database password */
define('DB_PASSWORD', '');

/** Database hostname */
define('DB_HOST', 'localhost');

/** Database charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The database collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

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
define('AUTH_KEY',         '1a&:HlmCNc[&cR%*5*uDb#ExAOjAcWB6*dEj?%iNKN<8>bvvK?+[>x`Q*^_uJIJn');
define('SECURE_AUTH_KEY',  'y)s#m?IO%_v<~*q;Cn@>$5_x}[jZh8O&] ?lRXS2?XZs]52OA`WNQQ{Fw$;Jz9k7');
define('LOGGED_IN_KEY',    'z7T9Jw59)8Fly]o#M{dhY}<#Lqp~n50_9k_/(2n}{sNO9md5V)pnk:|KC8LcKgzU');
define('NONCE_KEY',        '|z$M9QgL~vqm I-W{B*5Ei_b*R>%y04.QoItsZsW=aFs,( gHDZlxMG/Ev?_6W_O');
define('AUTH_SALT',        'Ozm<o:w.P=a<(c*)CVz 5g|cyoyFy!^j7_Ik0U2i!!|YoH^fwF!n/QZ%AJQ~>yPO');
define('SECURE_AUTH_SALT', 'cW.wwp{wv;-DrAOlj2;fUhvaw<#iJs{_c+b/nr|?-9.pCmzC?vC?RN16 (q6~q/q');
define('LOGGED_IN_SALT',   'OqDZtq<?469BkTaYDJQwl#rD DlbT80:)0Sw-YanVia~ta*9;Bk/k#r_`X0Tl9h?');
define('NONCE_SALT',       'Doo1;:VG?U4$Juii/C.(!W/c6FY#6.J8`Q^2DR?5~y:%f>qx`?C+c8*heEhNJ7Fq');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define('WP_DEBUG', true);


/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (! defined('ABSPATH')) {
	define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
