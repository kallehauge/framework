<?php
/**
 * ---------------------------------------------------------------
 * 	Config file
 * ---------------------------------------------------------------
 */
	$config['db']['host'] = '127.0.0.1';
	$config['db']['user'] = 'root';
	$config['db']['pass'] = '';
	$config['db']['name'] = 'framework';
	$config['db']['charset'] = 'utf8';
	/* If PDO = true, it will be the driver for a PDO connectin.
	   If PDO is set to "FALSE", the Driver will fallback to MySQLi. */
	$config['db']['PDO'] = True;
	$config['db']['driver'] = 'mysql';


/**
 * ---------------------------------------------------------------
 * 	Folder names (and paths)
 * ---------------------------------------------------------------
 *
 * 	These variables must contain the name of the folders.
 * 	Include the path if the folder is not in the same directory
 * 	as this file.
 *
 * 	NO TRAILING SLASH!
 */
	// Views
	$views_directory = 'application/views';
	// Models
	$models_directory = 'application/models';
	// Controllers
	$controllers_directory = 'application/controllers';

/* End of file "./system/config.php" */