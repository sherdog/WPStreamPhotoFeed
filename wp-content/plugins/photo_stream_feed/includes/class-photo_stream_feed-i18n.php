<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       interactivearmy.com
 * @since      1.0.0
 *
 * @package    PhotoStreamFeed
 * @subpackage PhotoStreamFeed/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Live_Feed_Panel
 * @subpackage PhotoStreamFeed/includes
 * @author     Mike Sheridan <mike@interactivearmy.com>
 */
class PhotoStreamFeedi18n {

	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'photo_stream_feed',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
