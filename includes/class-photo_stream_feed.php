<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       interactivearmy.com
 * @since      1.0.0
 *
 * @package    Live_Feed_Panel
 * @subpackage Live_Feed_Panel/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Live_Feed_Panel
 * @subpackage Live_Feed_Panel/includes
 * @author     Mike Sheridan <mike@interactivearmy.com>
 */
class Live_Feed_Panel {

    
	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Live_Feed_Panel_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;
	
	/**
	 * @since 1.0
	 * @var string $plugin_path base path to the photo_stream_feed folder.
	 * @access protected
	 */
	
	protected $plugin_path;
	
	/**
	 * @since 1.0.1
	 * @var WP_Template $template renders the views with the datas.
	 * @access protected;
	 */
	
	protected $template;
	
	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
	    
		if ( defined( 'LIVE_FEED_PANEL_VERSION' ) ) {
			$this->version = LIVE_FEED_PANEL_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'photo_stream_feed';
		
		$this->plugin_path = plugin_dir_path( dirname( __FILE__ ) );

		$this->load_dependencies();
		
		$this->template = new WP_Template($this->plugin_path . '/' . 'views/');
		
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Live_Feed_Panel_Loader. Orchestrates the hooks of the plugin.
	 * - Live_Feed_Panel_i18n. Defines internationalization functionality.
	 * - Live_Feed_Panel_Admin. Defines all hooks for the admin area.
	 * - Live_Feed_Panel_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-photo_stream_feed-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-photo_stream_feed-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-photo_stream_feed-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-photo_stream_feed-public.php';
		
		
		require_once plugin_dir_path( dirname ( __FILE__ ) ) . 'includes/IModule.php';
		
		require_once plugin_dir_path( dirname ( __FILE__ ) ) . 'includes/WP_Module.php';
		
		require_once plugin_dir_path( dirname ( __FILE__ ) ) . 'includes/WP_Template.php';
		
		require_once plugin_dir_path( dirname ( __FILE__ ) ) . 'includes/WP_Html_Helper.php';

		$this->loader = new Live_Feed_Panel_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Live_Feed_Panel_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Live_Feed_Panel_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Live_Feed_Panel_Admin( $this, $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'instantiate', 1);

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Live_Feed_Panel_Public( $this, $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Live_Feed_Panel_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
	
	public function get_plugin_path() {
	    return $this->plugin_path;
	}
	
	
	public function get_template() {
	    return $this->template;
	}

}
