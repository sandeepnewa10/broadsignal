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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'broadsignaldb');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '`;z%?dM$ gz!t}%6K%+jbw8]_+??t2cLQ<V<Fv!]!L}!S?Cn.,UR>F.{S?sw QpF');
define('SECURE_AUTH_KEY',  'L `YOyNm6P}Ns-418l.8[`@{&0@+(?C;CJ|6a6Ox5/1.9{lqVoo^Psid9ShanJc/');
define('LOGGED_IN_KEY',    'nuojg}-JOV7{a~WVuWmQ~l- E4N^bR7y!y/q|h/:u907H[.#;?9S(gGT~Ig`VAM0');
define('NONCE_KEY',        '}(U<rjV((+0_~J?qQO7(&6/MWr9YKY$Tf79|7D;+?]+Txfdai1V/b50X@vmlf)`=');
define('AUTH_SALT',        'Ut&m_Dn;~Km]PRt8D}e)If5Te)+z,]L@d!CtAa7M:?JJ:I63P$%8HM_9h_;A-UV^');
define('SECURE_AUTH_SALT', '^!7r}L.D=GG<Fg_OJ^87AB*^~vb-.~SFvN&d[;u-%ubyEzQL1(;WjSkkyYT{q2Vg');
define('LOGGED_IN_SALT',   'eI|DS0FDTIH.W^H1zn~]Ff@Dz_>4%AybH405Lk-t#EtzDNL-Cc)*~eI!x@^A^5f ');
define('NONCE_SALT',       'dbC7iy^a=xe?tPK+`O3e#d^-=nl`P%|/0z :Bniajlsjm[(UIt?Z9-wp~9kZd_%.');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'beetechsolution_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
define('WP_MEMORY_LIMIT', '100M');