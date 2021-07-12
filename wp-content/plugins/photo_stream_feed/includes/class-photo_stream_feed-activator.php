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
class PhotoStreamFeedActivator {

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

		$table = $wpdb->prefix . 'psf_settings';
		dbDelta("CREATE TABLE $table (
   			 id int(11) NOT NULL AUTO_INCREMENT,
			 photo_stream_feed_token varchar(100),
   			 photo_stream_feed_token_expiration datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			 last_search_uuid varchar(255),
			 PRIMARY KEY  (id)
		) $charset_collate;");

		$table = $wpdb->prefix . 'psf_image_categories';
		dbDelta("CREATE TABLE $table (
   			 id int(11) NOT NULL AUTO_INCREMENT,
			 psf_album_name varchar(255),
			 PRIMARY KEY  (id)
		) $charset_collate;");


		$table = $wpdb->prefix . 'psf_images';
		dbDelta("CREATE TABLE $table (
			id int(11) NOT NULL AUTO_INCREMENT,
   			psf_image_categories_id int(11) NOT NULL,
			 psg_image_name varchar(255),
			 PRIMARY KEY  (id)
		) $charset_collate;");
	}
}
