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
 *		./system/router.php
 *		./system/controller.php
 *		./system/model.php
 */

// Require dependencies
require_once SYS_PATH . 'router.php';
require_once SYS_PATH . 'controller.php';
require_once SYS_PATH . 'model.php';

// The Object
class Kernel {

	// Declare variables
	protected $router;

	function __construct() {
		// Instantiate the Router class
		$this->router = new Router();
	}
}

/* End of file 'kernel.php' */