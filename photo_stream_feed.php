<?php

/**
 * @package           Live_Feed_Panel
 *
 * @wordpress-plugin
 * Plugin Name:       LiveFeedPanel
 * Plugin URI:        photo_stream_feed
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Mike Sheridan
 * Author URI:        interactivearmy.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       photo_stream_feed
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
define( 'LIVE_FEED_PANEL_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-photo_stream_feed-activator.php
 */
function activate_live_feed_panel() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-photo_stream_feed-activator.php';
	Live_Feed_Panel_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-photo_stream_feed-deactivator.php
 */
function deactivate_live_feed_panel() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-photo_stream_feed-deactivator.php';
	Live_Feed_Panel_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_live_feed_panel' );
register_deactivation_hook( __FILE__, 'deactivate_live_feed_panel' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-photo_stream_feed.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_live_feed_panel() {

	$plugin = new Live_Feed_Panel();
	$plugin->run();

}
run_live_feed_panel();
