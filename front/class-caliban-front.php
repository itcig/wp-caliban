<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Caliban
 * @subpackage Caliban/public
 */

namespace Caliban\WP\Front;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Caliban
 * @subpackage Caliban/public
 * @author     Your Name <email@example.com>
 */
class Caliban_Front {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function init() {
		// Set config
		// This must occur before the Constructor for Caliban is called or it will set its own default constants
		$this->load_config();

		// Start server to server JS and recieve beacon requests
		\Caliban\Caliban::get_instance()->server();
	}

	/**
	 * Load WP options into global constants and coalesce with ENV. Settings in the database always take precedence.
	 */
	public function load_config() {

		$caliban_options = $caliban_settings = get_option('caliban_settings');

		$settings_meta = \Caliban\WP\Admin\Caliban_Admin_Settings::get_instance()->get_settings_meta();

		foreach ($settings_meta as $setting_key => $setting_props) {

			$constant_name = $setting_props['constant_name'];

			if (!$constant_name) {
				continue;
			}

			if (!defined($constant_name) && (
					isset($caliban_options[$setting_key]) || isset($_ENV[$constant_name])
				)) {

				// This should never be `null` due to conditional check above
				$setting_value = $caliban_options[$setting_key] ?? $_ENV[$constant_name];

				$data_type = $setting_props['data_type'] ?? 'string';

				// Explode comma-delimited strings
				if ($data_type === 'string_array') {
					$setting_value = explode(',', $setting_value);
				}

				// Convert boolean strings as well as all truthy values to true/false
				if ($data_type === 'bool') {
					$setting_value = boolval($setting_value);
				}

				define($constant_name, $setting_value);
			}
		}
	}

	/**
	 * Output JS tracker to the footer
	 */
	public function load_js_tracker() {

//		$caliban = \Caliban\Caliban::get_instance()->init()->save();

		// Create new tracker JS client
		$tracker = \Caliban\Caliban::get_instance()->client();

		// Use `apply_filters()` to set event + values

		// TODO: Need to send session Id to JS or retrieve via URL/Cookie in caliban.js

		if (defined('CBN_PROPERTY_ID')) {
			$tracker->set('setPropertyId', CBN_PROPERTY_ID);
		}

		if (defined('CBN_CACHE_EXPIRATION')) {
			$tracker->set('setSessionTimeout', CBN_CACHE_EXPIRATION);
		}

		if (defined('CBN_IGNORE_PARAMS')) {
			$tracker->set('setIgnoreParams', CBN_IGNORE_PARAMS);
		}

		if (defined('CBN_APPEND_PARAMS')) {
			$tracker->set('setAppendParams', CBN_APPEND_PARAMS);
		}

		if (defined('CBN_CAMPAIGN_START_PARAMS')) {
			$tracker->set('setCampaignStartParams', CBN_CAMPAIGN_START_PARAMS);
		}

		if (defined('CBN_IGNORE_CLASSES')) {
			$tracker->set('setIgnoreClasses', CBN_IGNORE_CLASSES);
		}

		if (defined('CBN_DEBUG')) {
			$tracker->set('setDebug', CBN_DEBUG);
		}

		if (defined('CBN_FORM_INPUT_NAMESPACE')) {
			$tracker->set('setFormInputNamespace', CBN_FORM_INPUT_NAMESPACE);
		}

		if (defined('CBN_ENABLE_LINK_TRACKING')) {
			$tracker->set('enableLinkTracking', CBN_ENABLE_LINK_TRACKING);
		}

		$tracker->set('trackRequest');

		// Load Caliban tracker
		$tracker->load_tracker();
	}
}
