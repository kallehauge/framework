<?php
/**
 * ------------------------------------------------------
 *	Load models
 * ------------------------------------------------------
 *	Purpose:
 *		This class will help load models or other files from the controller.
 *
 *  Initialization:
 *		This class is called by "./system/controller.php".
 *
 *	Dependencies:
 *		None.
 */
class Loader {

	// Load user-created models
	public function model($file) {
		// Locate the position of the extension (INT : FALSE).
		$pos = strpos($file, '.php');
		// If the position of the extension doesn't equal FALSE
		if( $pos !== FALSE ) {
			// Remove the extension
			$file = substr($file, 0, $pos);
		}
		// If the file exists
		if(file_exists(MODEL_PATH . $file . '.php')) {
			// Require the model
			require_once( MODEL_PATH . $file . '.php' );
			// Instanciate the model
			return new $file();
		} else {
			// Kill script and provide error
			die('Model doesn\'t exist: "'. $file .'" !');
		}
	}

	// Load library
	public function lib($file) {
		// Locate the position of the extension (INT : FALSE).
		$pos = strpos($file, '.php');
		// If the position of the extension doesn't equal FALSE
		if( $pos !== FALSE ) {
			// Remove the extension
			$file = substr($file, 0, $pos);
		}
		// If the file exists
		if( file_exists( SYS_PATH . '/library/' . $file . '.php' )) {
			// Require the model
			require_once( SYS_PATH . '/library/' . $file . '.php' );
			// Instanciate the model
			return new $file();
		} else {
			// Kill script and provide error
			die('Library doesn\'t exist: "'. $file .'" !');
		}
	}
}