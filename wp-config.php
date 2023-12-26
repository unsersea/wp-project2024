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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wp-project2024-db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'S_U6^p4jD[OJnzaL]4%1XE^+h$Z/b<_utU5}WZG;!<<tV`(Td=:#=Db$%Fw7_.Gb' );
define( 'SECURE_AUTH_KEY',  ' %)a%) +N9/rq&g#9Ay+1JU(Bg2CkVgLX)i_*Mg8%+rs+U8!p2j`6M*s9*u%e+-U' );
define( 'LOGGED_IN_KEY',    '=a0W9*)#z=r9 BYF}QQDl }Etl&W}gB ~:0Re7?KeoT[++Xo8[_yQa9FOI$3Kqv;' );
define( 'NONCE_KEY',        '3F76t3XsE:)vntO{oge6d}^OZNY[,UCE!TP]64^##w[ZeFsgGpkyK^JQgj~=(yAu' );
define( 'AUTH_SALT',        'ra&$.._Z5<:u`E[1Uy Y;)3TXsaS7rh]!FU* s5i`NVPESl<^eezVqnwPrU{A9x9' );
define( 'SECURE_AUTH_SALT', 'j[gR{ J^uSD74tg >7$eunm()B{G1C51}FwR=M1~; o^GsvefZuLgR#1STW~T$X_' );
define( 'LOGGED_IN_SALT',   'MVo}k6-4HQS{Z0G(oD4*4|_EGx-xX1&AVA$I=eh@2@xf5q:%B0-8]Xa2X&(Q>Ub<' );
define( 'NONCE_SALT',       'IR/H5<n]$iGf>JV/+^bV0!G;d7l;.)l9h]@WN-N5-D_FWh(WEmkt)p0?LPAw(d{&' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
// define( 'WP_DEBUG', false );
define( 'WP_DEBUG', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

/** Sets up Email config */
define("SMTP_USER", "undersea250@gmail.com"); // EMAIL ACCOUNT
define("SMTP_PASS", "mxwcouqzbwogimbn"); // PASSWORD TOKEN EMAIL
define("SMTP_HOST", "smtp.gmail.com");
define("SMTP_SECURE", "ssl");
define("SMTP_PORT", "465");
define("SMTP_AUTH", true);
// define("SMTP_DEBUG", 0);
// define("SMTP_HTML", true);