<?php
/**
 *	This model is created as an example to show how
 *	the models should be structured.
 *
 *	Tip: Always inherit the parent constructor to get access to MySQLi.
 *		 How to use the connection: $this->db->mysqli_statement();
 *		 > The "db" in the connection is short for "database",
 *		 since it's the one you're communication with. <
 */
class Index_Model extends Model {

	function __construct() {
		parent::__construct();
	}

	function test() {
		// return "Index Model Virker";
		
		$query = $this->db->query("SELECT * FROM users");
		var_dump( $query->fetchObject() );
	}
}