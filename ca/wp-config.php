<?php


/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'devsit7_cagdevdemo' );

/** MySQL database username */
define( 'DB_USER', 'devsit7_cagdevde' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Lul{2gm)GXFJ' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '7fvnI2Om=%LQB~-=3-@qgpSlymi%|sZgkv5+h>y#qo4x-N6S&Yx/`LDA*<X5Fi-y');
define('SECURE_AUTH_KEY',  'zlD=n}FnspdYfvb 8mkID|S)|}6xA<tRut6x$Y(C^YIVTRGVtZluF=^Hk@Wa{Vf!');
define('LOGGED_IN_KEY',    '5,MI/PqMIB>yq56e4_>x56`7wh1]O15wIixnX%GMc]Y&.^x2|rTXIP#$y]-?>446');
define('NONCE_KEY',        ':mg(y-de^vEdT>Y(h76T89^+y} 9-o7Sy)}?HK:1!-#ORW5Rr*T%a${K2!-}A{X`');
define('AUTH_SALT',        '95X>UyZVo%s}^d7pZw>lU1J1nUFJ|]HHW(kDDW-S^6RR-+--7c/udlr[VTFt_m)8');
define('SECURE_AUTH_SALT', '{2pZ@Ysk|~;~U|+|Q1+lF?q* Mj2-U|~;Ya33Lny]a|ibO]vS6nm;K8+bjRoFC9C');
define('LOGGED_IN_SALT',   'xl.JIa-O=$8DM~On!)KRunXP%NF,E_A4-ppI*Vl8dO7..-jz01[&nxdQ+II5:+%C');
define('NONCE_SALT',       'ZX7eRi}4z(Mf)D$ []3{cf}C}F]Y+Ry_+$`UT!-OicL{E,r;yFl KqS+d^hPejh+');


/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_t8d0ez1_';




/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
