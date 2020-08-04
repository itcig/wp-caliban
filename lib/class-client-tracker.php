<?php

/**
 * Client tracker filters and customizations from within WP app.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Caliban
 */

namespace Caliban\WP;

/**
 * Client tracker filters and customizations from within WP app
 */
class ClientTracker {
	/**
	 * Set a property of the JS client tracker
	 *
	 * @param $method_name The name of the JS client API method to call
	 * @param mixed $method_args Scalar or associative array of arguments to pass to the JS method as object
	 *
	 * @return void
	 */
	public static function set ($method_name, $method_args) {
		// We cannot set client tracker properties after it has been built using this filter
		if (did_action('wp_head')) {
			trigger_error("Tracker has already been set in `wp_head`, please call this filter earlier in the Wordpress action sequence.", E_USER_WARNING);
		} else {
			add_filter('caliban_client_tracker', function (\Caliban\Client\Client $tracker) use ($method_name, $method_args) {
				$tracker->set($method_name, $method_args);

				return $tracker;
			}, 10, 1);
		}
	}
}


