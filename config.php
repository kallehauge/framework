<?php
/**
 * ---------------------------------------------------------------
 * 	Config file
 * ---------------------------------------------------------------
 *	Purpose:
 *		Set user-configurations for the core.
 */
	$config['db']['host'] = '127.0.0.1';
	$config['db']['user'] = 'root';
	$config['db']['pass'] = '';
	$config['db']['name'] = 'framework';
	$config['db']['charset'] = 'utf8';
	$config['db']['PDO'] = True; // PDO = False -> will fallback to a mysqli connection
	$config['db']['driver'] = 'mysql'; // The PDO driver (requires PDO = True)

/* End of file "./config.php" */