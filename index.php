<?php
/**
 *	---------------------------------------------------------------------------------------
 *	INTRODUCTION:
 *
 *	This is the landing-page for the URL after our Rewrite in the .htaccess file.
 *	All data given in the URL will go directly to this page and be processed.
 *	---------------------------------------------------------------------------------------
 */

/**
 * ---------------------------------------------------------------
 * 	ROOT: define the path to "./index.php"
 * ---------------------------------------------------------------
 *	Defines the ROOT constant to the local location
 *	of the current file "./index.php"
 */
	// If the root constant doesn't exist:
	if(!defined('ROOT')) {
		// Define ROOT as current file-path (with a trailing slash)
		define('ROOT', dirname(__FILE__) . '/');
	}

/**
 * ------------------------------------------------------
 *	Require configuration settings
 * ------------------------------------------------------
 */
	require_once ROOT . 'config.php';

/**
 * ------------------------------------------------------
 *	Define System Path (based on ROOT).
 * ------------------------------------------------------
 *	Define the path to the "./system" folder where the
 *	"constants.php" file can be located.
 */
	if(!defined('SYS_PATH')) {
		define('SYS_PATH', ROOT . 'system/');
	}

/**
 * ------------------------------------------------------
 *	Require constants
 * ------------------------------------------------------
 *	Get constants like "DB information" and "VIEW_PATH"
 */
	require_once SYS_PATH . 'constants.php';

/**
 * ------------------------------------------------------
 *	Instantiate the MVC kernel
 * ------------------------------------------------------
 *
 *	Purpose:
 *		The kernel takes care of URL processing and handles
 *		the controllers in the 'controllers' folder.
 *
 *	Dependencies:
 *		File: './system/kernel.php' is required.
 */
	// Require Kernel.php
	require_once SYS_PATH . 'kernel.php';
	// Instantiate kernel
	$kernel = new kernel();
/* End of file 'index.php' */
