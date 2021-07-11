<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       interactivearmy.com
 * @since      1.0.0
 *
 * @package    Live_Feed_Panel
 * @subpackage Live_Feed_Panel/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Live_Feed_Panel
 * @subpackage Live_Feed_Panel/admin
 * @author     Mike Sheridan <mike@interactivearmy.com>
 */
class Live_Feed_Panel_Admin {

    private $wp;
    
	/**
	* Main controlller/loader that we neeed to pass along down to the modules.
	*
	* @since    1.0.0
	* @access   private
	* @var      Object    $loader main controller that handles hooks n shit
	*/
	private $loader;

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
	
	
	private $moduleDirectories = [];
	
	
	
	private $modules = [];

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $loader, $plugin_name, $version ) {
	    
		$this->loader = $loader;
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		
	}

	public function instantiate() {

	    
	    //loop over the modules whcih will register with wordpress and create menu sub items.
	    //todo - add some better sorting.
	    
		$pluginPath = plugin_dir_path(__FILE__) . 'modules/';
		
		$this->readModuleDirectories($pluginPath);
		
		foreach($this->moduleDirectories as $slug => $modulePathData) {
		    
		    if (file_exists($modulePathData->classPath)) {
		        
		        include($modulePathData->classPath);
		        
		        $class = new $slug();
		        $class->init($this->loader);
		        $class->setParent($modulePathData->parent);
		        $class->setSlug($modulePathData->slug);
		        
		        $this->modules[] = $class;
		        $this->createMenuItem($class, $modulePathData);
		    }
		}
	}
	
	function createMenuItem($moduleClass, $moduleData) {
	    
	    if ($moduleData->parent != "/") {
	        
	        add_submenu_page(
	            $moduleClass->getParent(),
	            $moduleClass->getMenuTitle(),
	            $moduleClass->getPageTitle(),
	            $moduleClass->getManagedOptions(),
	            $moduleClass->getSlug(),
	            array( $moduleClass, 'display' ),
	            $moduleClass->getSortOrder()
            );
	        
	    } else {
	        
	        add_menu_page(
	            $moduleClass->getMenuTitle(),
	            $moduleClass->getPageTitle(),
	            $moduleClass->getManagedOptions(),
	            $moduleClass->getSlug(),
	            array( $moduleClass, 'display' ),
	            $moduleClass->getIcon(),
	            $moduleClass->getSortOrder()
            );
	    }
	}
	
	private function readModuleDirectories($path, $parent = "/") {
	    
	    $blacklistFolders = ['views', 'controllers', 'models', 'misc', 'helpers'];
	    $dirHandle = opendir($path);
	    
	    while($item = readdir($dirHandle)) {
	        
	        if ($item === ".." || $item === "." ) {
	            continue;
	        }
	        
	        $filePath = $path . "/" . $item;
	        $className = $item . '.php';
	        $classPath = $filePath.'/'.$className;
	        
	        if (file_exists($classPath) && is_dir($filePath)) {
	            
	            if (!in_array($item, $blacklistFolders)) {
	                
	                $tmpObj = [];
	                $tmpObj["classPath"] = $classPath;
	                $tmpObj["parent"] = $parent;
	                $tmpObj["slug"] = $item;
	                
	                $this->moduleDirectories[$item] = (object)$tmpObj;
	            }
	            
	            $this->readModuleDirectories($filePath, $item);
	        }
	    }
	    
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Live_Feed_Panel_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Live_Feed_Panel_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/photo_stream_feed-admin.css', array(), $this->version, 'all' );
		
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/bootstrap_3_4_1.css', array(), $this->version, 'all' );
		
		

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Live_Feed_Panel_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Live_Feed_Panel_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
	    

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/photo_stream_feed-admin.js', array( 'jquery' ), $this->version, false );
	    
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/bootstrap_3_4_1.js', array( 'jquery' ), $this->version, false );

	}

}
