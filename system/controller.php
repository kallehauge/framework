<?php
/**
 * ------------------------------------------------------
 *	The Controller
 * ------------------------------------------------------
 *	Purpose:
 *		Provide user-created controllers with the oppertunity to load
 *		and display pages and models.
 *
 *  Initialization:
 *		This class should be extended by the user-created controllers
 *		if any of these functionalities should be available.
 *
 *	Dependencies:
 *		parent::__construct(); by user-created controllers
 *		./system/view.php
 *		./system/loader.php
 */

// Require dependencies
require_once SYS_PATH . 'view.php';
require_once SYS_PATH . 'loader.php';

// The Object
class Controller {
	
	// Declare variables
	protected $view;
	protected $load;

	// Constructor
	public function __construct() {
		// Instantiate the Load class
		$this->load = new Loader();
		// Instantiate the View class
		$this->view = new View();
	}

}