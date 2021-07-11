<?php

/**
 * Fired during plugin activation
 *
 * @link       interactivearmy.com
 * @since      1.0.0
 *
 * @package    Live_Feed_Panel
 * @subpackage Live_Feed_Panel/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Live_Feed_Panel
 * @subpackage Live_Feed_Panel/includes
 * @author     Mike Sheridan <mike@interactivearmy.com>
 */
class Live_Feed_Panel_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;

		require_once ABSPATH . '/wp-admin/includes/upgrade.php';
		$charset_collate = $wpdb->get_charset_collate();

		$table = $wpdb->prefix . 'lfp_live_feeds';
		dbDelta("CREATE TABLE $table (
   			 id int(11) NOT NULL AUTO_INCREMENT,
   			 date_created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   			 url varchar(255),
			 title varchar(100),
			 hashtags varchar(100),
			 latitude varchar(100),
			 longitude varchar(100),
			 city varchar(100),
			 state varchar(10),
			 zip varchar(10),
			 streamer_id int(11) NOT NULL,
			 PRIMARY KEY  (id)
		) $charset_collate;");

		$table = $wpdb->prefix . 'lfp_streamers';
		dbDelta("CREATE TABLE $table (
   			 id int(11) NOT NULL AUTO_INCREMENT,
   			 date_created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   			 youtube_username varchar(155),
			 facebook_username varchar(155),
			 twitch_username varchar(155),
			 name varchar(25),
			 city varchar(25),
			 state varchar(25),
			 zip varchar(25),
             platform varchar(100),
			 cashapp_address varchar(100),
			 venmo_address varchar(100),
			 paypal_address varchar(100),
			 PRIMARY KEY  (id)
		) $charset_collate;");

		$table = $wpdb->prefix . 'lfp_current_stream';
		dbDelta("CREATE TABLE $table (
   			 id int(11) NOT NULL AUTO_INCREMENT,
   			 date_created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   			 live_feed_id int(11) NOT NULL,
			 transition_type_id int(11) NOT NULL,
			 PRIMARY KEY  (id)
		) $charset_collate;");

		$table = $wpdb->prefix . 'lfp_transition_types';
		dbDelta("CREATE TABLE $table (
   			 id int(11) NOT NULL AUTO_INCREMENT,
   			 date_created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   			 name varchar(100) NOT NULL,
			 PRIMARY KEY (id)
		) $charset_collate;");

		$table = $wpdb->prefix . 'lfp_stream_walls';
		dbDelta("CREATE TABLE $table (
   			 id int(11) NOT NULL AUTO_INCREMENT,
   			 date_created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   			 name varchar(100) NOT NULL,
			 current tinyint DEFAULT 0,
			 PRIMARY KEY  (id)
		) $charset_collate; ");

		$table = $wpdb->prefix . 'lfp_stream_wall_sports';
		dbDelta("CREATE TABLE $table (
   			 id int(11) NOT NULL AUTO_INCREMENT,
   			 date_created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   			 stream_wall_id int(11) NOT NULL,
			 live_feed_id int(11) NOT NULL,
			 featured tinyint DEFAULT 0,
			 PRIMARY KEY  (id)
		) $charset_collate;");
	}
}
