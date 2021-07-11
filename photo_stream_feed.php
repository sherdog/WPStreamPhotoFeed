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

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PHOTO_STREAM_FEED_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-live-feed-panel-activator.php
 */
function activate_live_feed_panel() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-live-feed-panel-activator.php';
	Live_Feed_Panel_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-live-feed-panel-deactivator.php
 */
function deactivate_live_feed_panel() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-live-feed-panel-deactivator.php';
	Live_Feed_Panel_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_live_feed_panel' );
register_deactivation_hook( __FILE__, 'deactivate_live_feed_panel' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-live-feed-panel.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run() {

	$plugin = new PhotoStreamFeed();
	$plugin->run();

}

run();
