<?php
/**
 * ------------------------------------------------------
 *	The "Index page" controller
 * ------------------------------------------------------
 *
 *	Reminder: If you don't inherit the parent constructor,
 *	you'll lose some important functions.
 *	Example: $this->view->display();
 */
class Index extends Controller {

	function __construct() {
		// Initialize the parent constructor.
		parent::__construct();
	}

	// The index function will work as default for the constructor.
	public function index() {
		// Load model
		$model = $this->load->model('index_model');

		// Get data from model
		$data['default'] = $model->test();

		// View page & pass data
		$this->view->display('index', $data);
	}

	public function test($test = null) {
		echo "<br>Route: Index/test<br>";
		echo "Argument: ". $test;
	}
}