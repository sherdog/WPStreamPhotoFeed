<?php
/**
 * Class Template - a very simple PHP class for rendering PHP templates
 */
class PhotoStreamFeed_Template {
	/**
	 * Location of expected template
	 *
	 * @var string
	 */
	public $viewDirectory;
	/**
	 * Template constructor.
	 *
	 * @param $folder
	 */
	function __construct( $directory = null ){
	    if ( $directory ) {
	        $this->setViewDirectory( $directory );
		}
	}
	/**
	 * Simple method for updating the base folder where templates are located.
	 *
	 * @param $folder
	 */
	function setViewDirectory( $directory ){
		// normalize the internal folder value by removing any final slashes
	    $this->viewDirectory = rtrim( $directory, '/' );
	}
	/**
	 * Find and attempt to render a template with variables
	 *
	 * @param $suggestions
	 * @param $variables
	 *
	 * @return string
	 */
	function render( $suggestions, $variables = array() ){
	    
	    $variables['html_helper'] = new WP_Html_Helper();
		$template = $this->findTemplate( $suggestions );
		$output = '';
		if ( $template ){
			$output = $this->renderTemplate( $template, $variables );
		}
		return $output;
	}
	/**
	 * Look for the first template suggestion
	 *
	 * @param $suggestions
	 *
	 * @return bool|string
	 */
	function findTemplate( $suggestions ){
		if ( !is_array( $suggestions ) ) {
			$suggestions = array( $suggestions );
		}
		$suggestions = array_reverse( $suggestions );
		$found = false;
		foreach( $suggestions as $suggestion ){
			$file = "{$this->viewDirectory}/{$suggestion}.php";
			if ( file_exists( $file ) ){
				$found = $file;
				break;
			}
		}
		return $found;
	}
	/**
	 * Execute the template by extracting the variables into scope, and including
	 * the template file.
	 *
	 * @internal param $template
	 * @internal param $variables
	 *
	 * @return string
	 */
	function renderTemplate( /*$template, $variables*/ ){
		ob_start();
		foreach ( func_get_args()[1] as $key => $value) {
			${$key} = $value;
		}
		include func_get_args()[0];
		return ob_get_clean();
	}
}