<?php
/**
 * ------------------------------------------------------
 *	Database
 * ------------------------------------------------------
 *	Purpose:
 *		This class will provide a safe connection to the database
 *
 *  Initialization:
 *		This class is extended by "./system/model.php".
 *
 *	Dependencies:
 *		./config.php (required by "./index.php")
 */
class Database {

	// Database connection.
	protected $db = null;
	
	// Setting database connection varible if called.
	protected function __construct() {

		// Lazy loading the connection (if the connection isn't already set).
		if( $this->db === null ) {
			// If PDO is set to "TRUE" in "./config.php"
			if( DB_PDO === True ) {
				$this->db = $this->PDO_Driver();
			} else {
				// Else default back to MySQLi
				$this->db = $this->MySQLi_Driver();
			}
		}
	}

	private function PDO_Driver() {
		// Try to connect to the database (using constants defined in "./config.php").
		try {
			// Tries to connect
			$con = new PDO(DB_DRIVER.':host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET, DB_USER, DB_PASS);
			// Set the database error-mode to throw exceptions
			/*
				ERRMODE_EXCEPTION
				ERRMODE_SILENT
			*/
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			// Set the successfull connection to the class variable. 
			return $con;
		} catch( PDOException $exception ) {
			echo 'ERROR: ' . $exception->getMessage();
		}
	}

	private function MySQLi_Driver() {

		// The connection:
		$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		// Check for connection-errors.
		if( $con->connect_error) {
			// Kill the script and provide error message
			die('Connection error (' . $con->connect_errno .')' . $con->connect_error);
		}
		
		// Define character set
		if( ! $con->set_charset(DB_CHARSET) ) {
			// Or provide error message
			printf("Error loading character set: %s\n", $con->error);
		}

		// Return the connection.
		return $con;
	}
}

/* End of file: './system/database.php' */