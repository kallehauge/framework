<?php
/**
 * ------------------------------------------------------
 *	The View controller
 * ------------------------------------------------------
 *
 *	How to use it:
 *		Call it from the controller and 
 *		$this->view->display(page, array);
 */
class View {

	// Protected array, that will make data available for the following pages.
	protected $array = array();

	// Function used to display pages and pass data to the page, form the controller
	public function display($name, $data = null) {

		// Check if anything have been passed with the page-request.
		if( isset($data) && is_array($data) ){
			// Apply the data to the .
			$this->array = $data;
		}

		// Extract rows from $this->array, as variables or objects.
		extract($this->array, EXTR_SKIP);

		// Defines file-extensions that can be loaded.
		$exts[] = '.php';
		$exts[] = '.htm';
		$exts[] = '.html';

		// Loop through the extensions and checks if the file exist.
		foreach ($exts as $ext) {
			// Locate the position of the extension (INT : FALSE).
			$pos = strpos($name, $ext);
			// If the position of the extension doesn't equal FALSE
			if( $pos !== FALSE ) {
				// Remove the extension
				$name = substr($name, 0, $pos);
				// Define path and filename
				$file = VIEW_PATH . $name . $ext;
			} else {
				// Define path and file-name + append extension.
				$file = VIEW_PATH . $name . $ext;
			}
			
			// Check if the file exist and require it.
			if( file_exists($file) ) include_once( $file );
		}
	}
}