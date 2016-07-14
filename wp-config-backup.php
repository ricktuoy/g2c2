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
define('DB_NAME', 'wp_g2c2');

/** MySQL database username */
define('DB_USER', 'wpuser_g2c2');

/** MySQL database password */
define('DB_PASSWORD', 'G20c09N');

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
define('AUTH_KEY',         'oVe#dgX2|H(zv~gQYW u)V.PUU_#=VNp}i]Uw-6NO}<]oe`Oslc]b5g5b2I2R5_H');
define('SECURE_AUTH_KEY',  'J0z|1:~(V!{:z?pJr?eldJqKlZq6;PI3 T5h&$4FGchVlS_MJE*x<(,F_hD$|SO<');
define('LOGGED_IN_KEY',    'L=r|]r+q3]+-fV-+&d_,-RFNpw_bKZ+!?VNa;#v]{KhZF<G4_4i`,t%Jocr{hk? ');
define('NONCE_KEY',        'eLN2)xZkY$F&@ou;oL&sy:),$M-)C9-:pgT<-Uklzm#;1B/2{c|1@qx8oy%(DpK>');
define('AUTH_SALT',        '8d4Q+s.-6+S,r$+5XVSJ_khM+(Oma:<|Q%u;+o2iiU?x2}$}+O.ePO~NASSFEHrf');
define('SECURE_AUTH_SALT', '1P9K>!2v]Ez2@X#@~,3=%;4QLC7F-9~6l$xmc`1~5)[DNTq{MQ~-J$FSCWfD#r}:');
define('LOGGED_IN_SALT',   'txfia7)3;DPr}Ysv1}/f|/#YI 4T_QKE8ic_]sBf$JB$6yjVR;^w L)L>DJ&n1d9');
define('NONCE_SALT',       ']TZ)|PT$vhbw+/u._Sjz%E!sF?mY6I1F2?4![[+#u,AtY]3#S55I}MOIIWG^UA]u');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
