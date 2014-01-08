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
	$router['stuff2/stuff2'] = "index/stuff2";
	$router['test'] = "index/test/*";
	$router['stuff/stuff'] = "index/stuff2";
	$router['default_controller'] = "index";