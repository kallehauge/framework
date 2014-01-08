<?php
/**
 * ------------------------------------------------------
 *	The Model
 * ------------------------------------------------------
 *	Purpose:
 *		Provide user-created models with the oppertunity to use
 *		functions from this object and take advantage of
 *		the database-connection.
 *
 *  Initialization:
 *		This class should be extended by the user-created models
 *		if any of these functionalities should be available.
 *
 *	Dependencies:
 *		parent::__construct(); by user-created controllers
 *		./system/database.php
 */

// Require dependencies
require_once SYS_PATH . 'database.php';

// The Object
class Model extends Database {

	// Using the construct to execute the code inside on load of the "Model class".
	function __construct() {
		parent::__construct();
	}

	/**
	 *	All models in the application will inherit this function and
	 *	can be used to escape input (will only work with MySQLi
	 *	since PDO takes advantage of "prepare").
	 *	
	 *	How to use: $this->post('input_name');
	 */
	public function post($input) {
		// Check if the input isset
		if( isset($_POST[$input]) ) {
			// Get the input-name from the argument and assign the $_POST to a variable.
			$input = $_POST[$input];
			// Escape input.
			$input = $this->db->real_escape_string($input);
			// Return the input.
			return $input;
		} else {
			// Return FALSE if the input isn't set.
			return FALSE;
		}
	}
}