<?php

/**
 * @package           PhotoStreamFeed
 *
 * @wordpress-plugin
 * Plugin Name:       PhotoStreamFeed
 * Plugin URI:        photo-stream-feed
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Mike Sheridan
 * Author URI:        interactivearmy.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       photo-stream-feed
 * Domain Path:       /languages
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'PHOTO_STREAM_FEED_VERSION', '1.0.0' );

function activate_photo_stream_feed() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-photo_stream_feed-activator.php';
	PhotoStreamFeedActivator::activate();
}

function deactivate_photo_stream_feed() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-photo_stream_feed-deactivator.php';
	PhotoStreamFeedDeactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_photo_stream_feed' );
register_deactivation_hook( __FILE__, 'deactivate_photo_stream_feed' );

require plugin_dir_path( __FILE__ ) . 'includes/class-photo_stream_feed.php';

function run() {

	$plugin = new PhotoStreamFeed();
	$plugin->run();

}

run();
