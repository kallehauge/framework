<?php
/**
 * ------------------------------------------------------
 *	URL processing && Initialize Controller-handler
 * ------------------------------------------------------
 *	Purpose:
 *		Works as the bootstrap of the framework.
 *
 *  Initialization:
 *		This file is instantiated in "./index.php".
 *
 *	Dependencies:
 *		./system/...
 */
	/* Testing purpose */
	$router['test'] = "index/test";
	$router['test/*'] = "index/test/*";
	$router['test/*/*'] = "index/test/*/*/";
	$router['test/*/*/*'] = "index/test/*/*/*";
	$router['stuff/stuff'] = "index/stuff2";
	$router['stuff2/stuff2'] = "index/stuff2";
	
	/* Default */
	$router['default_controller'] = "index";