<?php

/**
 *
 * @link              http://inoic.com
 * @since             1.0.0
 * @package           Inoic_Core
 *
 * @wordpress-plugin
 * Plugin Name:       Inoic Core
 * Plugin URI:        http://inoic.com
 * Description:       This is a plugin for all functionality of Inoic's WordPress Themes.
 * Version:           1.0.0
 * Author:            Inoic
 * Author URI:        http://inoic.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       inoic-core
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-inoic-core-activator.php
 */
function activate_inoic_core() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-inoic-core-activator.php';
	Inoic_Core_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-inoic-core-deactivator.php
 */
function deactivate_inoic_core() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-inoic-core-deactivator.php';
	Inoic_Core_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_inoic_core' );
register_deactivation_hook( __FILE__, 'deactivate_inoic_core' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-inoic-core.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_inoic_core() {

	$plugin = new Inoic_Core();
	$plugin->run();

}
run_inoic_core();
