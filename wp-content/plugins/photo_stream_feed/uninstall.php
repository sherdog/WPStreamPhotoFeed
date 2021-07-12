<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       interactivearmy.com
 * @since      1.0.0
 *
 * @package    PhotoStreamFeed
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

global $wpdb;

require_once ABSPATH . '/wp-admin/includes/upgrade.php';

$wpdb->query( "DROP TABLE IF EXISTS NestoNovo" );
delete_option("my_plugin_db_version");

$table_name = $wpdb->prefix . 'lfp_live_feeds';
dbDelta("DROP TABLE IF EXISTS $table_name;");

$table_name = $wpdb->prefix . 'lfp_streamers';
dbDelta("DROP TABLE IF EXISTS $table_name;");

$table_name = $wpdb->prefix . 'lfp_current_stream';
dbDelta("DROP TABLE IF EXISTS $table_name;");

$table_name = $wpdb->prefix . 'lfp_transition_types';
dbDelta("DROP TABLE IF EXISTS $table_name;");

$table_name = $wpdb->prefix . 'lfp_stream_walls';
dbDelta("DROP TABLE IF EXISTS $table_name;");

$table_name = $wpdb->prefix . 'lfp_stream_wall_sports';
dbDelta("DROP TABLE IF EXISTS $table_name;");
