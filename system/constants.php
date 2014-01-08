<?php
/**
 * ------------------------------------------------------
 *	Constants
 * ------------------------------------------------------
 *	Purpose:
 *		Provide constant-helper for the entire framework.
 *
 *  Initialization:
 *		This file is called by "./index.php".
 *
 *	Dependencies:
 *		./config.php
 *
 *	Warning:
 *		Do not change the names of the constants. They are being used
 *		in other files, and any change will most likely "corrupt"
 *		libraries and core files.
 */

/**
 * ---------------------------------------------------------------
 * 	Define database configurations
 * ----------------------------------------------------------------
 */
	// Host
	define('DB_HOST', $config['db']['host']);
	// User name
	define('DB_USER', $config['db']['user']);
	// User password
	define('DB_PASS', $config['db']['pass']);
	// Database name
	define('DB_NAME', $config['db']['name']);
	// Database Character set
	define('DB_CHARSET', $config['db']['charset']);
	// Database PDO
	define('DB_PDO', $config['db']['PDO']);
	// Database Driver
	define('DB_DRIVER', $config['db']['driver']);


/**
 * ---------------------------------------------------------------
 * 	Define the BASE_URL path
 * ----------------------------------------------------------------
 *
 *	The following code removes "index.php?" from the original URL,
 *	so this code is dependent on the .htaccess file that is packed
 *	with this framework (or one with the same base functionallity).
 */
	// Get the host-name
	$base_url = 'HTTP://'. $_SERVER['HTTP_HOST'];
	// Extends $base_url and adds URI (but leaves out index.php):
	$base_url .= str_replace( basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME'] );
	// Trim the right side of '/' for safety.
	$base_url = rtrim($base_url, '/');
	// Define the BASEPATH + adds a '/'.
	define('BASE_URL', $base_url.'/');


/**
 * ---------------------------------------------------------------
 * 	Define directory paths
 * ---------------------------------------------------------------
 *
 * 	DO NOT CHANGE THE DEFINED NAMES! If you want to edit paths,
 *	please go to "./config.php" and change it there.
 */
	// Views
	defineDirectoryPath('VIEW_PATH', $views_directory);
	// Models
	defineDirectoryPath('MODEL_PATH', $models_directory);
	// Controllers
	defineDirectoryPath('CON_PATH', $controllers_directory);

	// Define function
	function defineDirectoryPath($name, $directory) {
		// Trim directory for trailing slashes
		$directory = rtrim($directory, '/');
		// If the directory exists => execute
		if (is_dir($directory)) {
			// Define the directory
			define($name, $directory.'/');
		}
		else {
			// If the directory doesn't exists (included the BASE_URL)
			if ( ! is_dir(ROOT . $directory.'/')) {
				// Error message
				exit('Your '. $name .' doesn\'t appear to be set correctly.');
			}
			// Define directory with BASE_URL
			define($name, ROOT . $directory.'/');
		}
	}

/* End of file "./system/constants.php" */