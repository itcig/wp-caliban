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

	private static $instances = [];

	private $settings_meta;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	protected function __construct() {

		$this->settings_meta = [
			'property_id' => [
				'data_type' => 'string',
				'constant_name' => 'CBN_PROPERTY_ID',
			],
			'session_timeout' => [
				'data_type' => 'string',
				'constant_name' => 'CBN_CACHE_EXPIRATION',
			],
			'ignore_params' => [
				'data_type' => 'string_array',
				'constant_name' => 'CBN_IGNORE_PARAMS',
			],
			'append_params' => [
				'data_type' => 'string_array',
				'constant_name' => 'CBN_APPEND_PARAMS',
			],
			'first_attribution_params' => [
				'data_type' => 'string_array',
				'constant_name' => 'CBN_FIRST_ATTRIBUTION_PARAMS',
			],
			'campaign_start_params' => [
				'data_type' => 'string_array',
				'constant_name' => 'CBN_CAMPAIGN_START_PARAMS',
			],
			'ignore_classes' => [
				'data_type' => 'string_array',
				'constant_name' => 'CBN_IGNORE_CLASSES',
			],
			'redis_servers' => [
				'data_type' => 'string',
				'constant_name' => 'CBN_REDIS_SERVERS',
			],
			'redis_options' => [
				'data_type' => 'json_array',
				'constant_name' => 'CBN_REDIS_OPTIONS',
			],
			'debug' => [
				'data_type' => 'bool',
				'constant_name' => 'CBN_DEBUG',
			],
			'debug_container' => [
				'data_type' => 'bool',
				'constant_name' => 'CBN_DEBUG_CONTAINER',
			],
			'form_input_namespace' => [
				'data_type' => 'string',
				'constant_name' => 'CBN_FORM_INPUT_NAMESPACE',
			],
			'enable_link_tracking' => [
				'data_type' => 'bool',
				'constant_name' => 'CBN_ENABLE_LINK_TRACKING',
			],
		];

	}

	public static function get_instance() {

		$class = get_called_class();

		if (!isset(self::$instances[$class])) {
			self::$instances[$class] = new static();
		}

		return self::$instances[$class];
	}

	public function get_settings_meta() {
		return $this->settings_meta;
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

			$allowed_keys = array_keys($this->settings_meta);

			// Check keys in $_POST against allowed keys, ignore any inputs not included
			$filtered_form_values = array_filter($_POST, function ($value, $key) use ($allowed_keys) {
				return in_array($key, $allowed_keys);
			}, ARRAY_FILTER_USE_BOTH);

			$sanitized_form_values = [];

			// Remove backslashes from json data inputs escaping quotes
			foreach ($this->settings_meta as $key => $value) {

				$setting_value = $filtered_form_values[$key] ?? null;

				if ($setting_value) {
					$sanitized_form_values[$key] = stripslashes($setting_value);
				}

				$data_type = $value['data_type'] ?? null;

				// Unchecked, checkboxes are not passed but these should be falsey, not null
				// Important to check if the key isset instead of the value
				if ($data_type === 'bool' && !isset($filtered_form_values[$key])) {
					$sanitized_form_values[$key] = 0;
				}
			}

            // Update options table in database
			update_option('caliban_settings', $sanitized_form_values);
		}

		// Populate input values on settings-form-page
		$caliban_settings = get_option('caliban_settings', []);

		require_once plugin_dir_path(__FILE__) . 'templates/settings-form-page.php';
	}

}
