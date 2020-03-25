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

	/**
	 * Output JS tracker to the footer
	 */
	public function load_js_tracker() {

//		$caliban = \Caliban\Caliban::get_instance()->init()->save();

		// Create new tracker JS client
		$tracker = \Caliban\Caliban::get_instance()->client();

		$caliban_options = $caliban_settings = get_option('caliban_settings');

		// Use `apply_filters()` to set event + values

		// TODO: Need to send session Id to JS or retrieve via URL/Cookie in caliban.js

		if (!empty($caliban_options['property_id'])) {
			$tracker->set('setPropertyId', $caliban_options['property_id']);
		}

		if (!empty($caliban_options['session_timeout'])) {
			$tracker->set('setSessionTimeout', $caliban_options['session_timeout']);
		}

		if (!empty($caliban_options['append_params'])) {
			$tracker->set('setAppendParams', explode(',', $caliban_options['append_params']));
		}

		if (!empty($caliban_options['ignore_classes'])) {
			$tracker->set('setIgnoreClasses', explode(',', $caliban_options['ignore_classes']));
		}

		if (!empty($caliban_options['debug_forms'])) {
			$tracker->set('setDebugForms', true);
		}

		if (!empty($caliban_options['enable_link_tracking'])) {
			$tracker->set('enableLinkTracking', true);
		}

		$tracker->set('setCookieDomain', \Cig\get_root_domain());
		$tracker->set('trackRequest');

		// Load Caliban tracker
		$tracker->load_tracker();
	}
}
