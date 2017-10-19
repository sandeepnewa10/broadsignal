<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.orionorigin.com/
 * @since             1.0.0
 * @package           Grand-Popo
 *
 * @wordpress-plugin
 * Plugin Name:       Grand-Popo Core
 * Plugin URI:        orionorigin.com/plugins
 * Description:       Grand-Popo Theme Toolkit.
 * Version:           1.0.0
 * Author:            ORION
 * Author URI:        http://demos.orionorigin.com/grand-popo/?utm_source=wordpress&utm_campaign=Grand-Popo&utm_medium=core-plugin
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       grand-popo
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-grand_popo-activator.php
 */
function activate_grand_popo() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-grand_popo-activator.php';
	Grand_popo_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-grand_popo-deactivator.php
 */
function deactivate_grand_popo() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-grand_popo-deactivator.php';
	Grand_popo_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_grand_popo' );
register_deactivation_hook( __FILE__, 'deactivate_grand_popo' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-grand_popo.php';
require plugin_dir_path( __FILE__ ) . 'includes/functions.php';
if(!class_exists("Orion_Library"))
{
    require plugin_dir_path(__FILE__) . 'includes/class-orion-library.php';
}
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_grand_popo() {

	$plugin = new Grand_popo();
	$plugin->run();

}
run_grand_popo();
