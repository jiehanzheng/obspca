<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'obspca');

/** MySQL database username */
define('DB_USER', 'obspca_wp');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '1q)%CTe~S&GR8z}qoufcew*oO{:Lj;0G]P#_>w5u</[;o67=z/qj&,xZBl?R@9-s');
define('SECURE_AUTH_KEY',  'xmnyA-B~,cf++jr.3:4 fH(R+s W_*-{~-O/pc_]Fs_q`*FzN)$8uW7p2-TVGQ,}');
define('LOGGED_IN_KEY',    '~c#XrBMTDGT|8B#H(onI$eR9I[ip8s2z>$P:|PH moIF|Vl*He1VyAa.9Oet_l)c');
define('NONCE_KEY',        '+]Jc|pr@w(|}tF<vfVW-5= 6f-Y3!DY-u;&m}cVax>>eX+dl>RtI:>D?WU+x+M?-');
define('AUTH_SALT',        '[e1_-0yDCx>.731X#uNxhe>mVc+^(}h`0433)sbYOZ@-|H<7sllV@p}tA$<`:uMh');
define('SECURE_AUTH_SALT', '?dtck.VKINgdn=+Z%n|h`|p=J}w;3+-F,BTD-uvkof`|VMl[4/!Ca8{gT`kShY*|');
define('LOGGED_IN_SALT',   'Ozxa8~O U.gl]PIMS5hZ8Hu,y[P]sv|=bf~7HUjua;-678Z-pM9PPuQr+J+0V3<9');
define('NONCE_SALT',       'kDaV{Nq&Nsjb=Ttug$S(|{,;QB0AQ*V- C3?q]|Wl*qayv.{lW:c45![CU-f=uC]');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);
define('SAVEQUERIES', false);

// if not on us1, we are on development machine
if (!in_array(gethostname(), array('us1'))) {
  define('WP_HOME', 'http://localhost');
  define('WP_SITEURL', 'http://localhost');
}

define('FS_METHOD', 'direct');

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
