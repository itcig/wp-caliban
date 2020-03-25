<?php

/**
 * The admin settings for the plugin.
 *
 * Defines the admin settings page and plugin options.
 *
 * @package    Caliban
 * @subpackage Caliban/admin
 * @author     Your Name <email@example.com>
 */

namespace Caliban\WP\Admin;

class Caliban_Admin_Settings {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of this plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct($plugin_name, $version) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function admin_menu() {
		add_options_page(
		    'Caliban',
            'Caliban',
            'manage_options',
            'caliban_settings_page',
			[$this, 'caliban_settings_display']
		);
	}

	public function caliban_settings_display() {

		if (!current_user_can('manage_options')) {
			wp_die('Unauthorized User');
		}

		if (isset($_POST['form_caliban_settings_submitted'])) {

			$allowed_keys = [
				'property_id',
				'append_params',
				'ignore_classes',
				'debug_forms',
				'session_timeout',
				'enable_link_tracking',
			];

			// Check keys in $_POST against allowed keys, ignore any inputs not included
			$filtered_form_values = array_filter($_POST, function ($value, $key) use ($allowed_keys) {
				return in_array($key, $allowed_keys);
			}, ARRAY_FILTER_USE_BOTH);

			$sanitized_form_values = [];

			// Remove backslashes from json data inputs escaping quotes
            foreach ($filtered_form_values as $key => $value) {
                $sanitized_form_values[$key] = stripslashes($value);
            }

            // Update options table in database
			update_option('caliban_settings', $sanitized_form_values);
		}

		// Populate input values on settings-form-page
		$caliban_settings = get_option('caliban_settings');

		require_once plugin_dir_path(__FILE__) . 'templates/settings-form-page.php';
	}

}
