<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/itcig
 * @since             1.0.0
 * @package           Caliban
 *
 * @wordpress-plugin
 * Plugin Name:       Caliban
 * Plugin URI:        https://github.com/itcig/wp-caliban
 * Description:       Caliban tracker Wordpress plugin
 * Version:           1.0.0
 * Author:            Capitol Information Group
 * Author URI:        https://github.com/itcig
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

namespace Caliban\WP;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('CALIBAN_VERSION', '1.0.0');
define('CALIBAN_PATH', plugin_dir_path(__FILE__));
define('CALIBAN_URL', plugin_dir_url(__FILE__));

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-caliban-activator.php
 */
function activate_caliban() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-caliban-activator.php';
	Caliban_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-caliban-deactivator.php
 */
function deactivate_caliban() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-caliban-deactivator.php';
	Caliban_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_caliban' );
register_deactivation_hook( __FILE__, 'deactivate_caliban' );


/**
 * require_once() all non hidden php files in a given path
 */
try {
	spl_autoload_register(function(string $class) : void {
		$class_name_parts = explode('\\', $class);
		$class_name = array_pop($class_name_parts);
		$namespace =  implode('\\', $class_name_parts);

		$folder = str_replace('\\', '/', strtolower(preg_replace('/Caliban\\\WP\\\?/', '', $namespace)));

		if (empty($folder)) {
			$folder = 'lib';
		}

		if (strpos($namespace, 'Caliban\\WP') === 0) {
			$class_file = 'class-' . strtolower(
					str_replace('_', '-',
						str_replace('__', '_', ltrim(
							strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0', $class_name)),
							'_')))) . '.php';

			// Resolve issue with Admin and public classes
			if (file_exists(CALIBAN_PATH . "{$folder}/{$class_file}")) {
				require_once(CALIBAN_PATH . "{$folder}/{$class_file}");
			}
		}
	});
} catch (\Exception $error) {
	// Maybe do something?
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-caliban.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_caliban() {

	$plugin = new Caliban_WP();
	$plugin->run();

}
run_caliban();
