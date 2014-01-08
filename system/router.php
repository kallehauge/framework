<?php
/**
 * ------------------------------------------------------
 *	The Router - A big mess! Clean this up!
 * ------------------------------------------------------
 *	Purpose:
 *		This class will determine which user-created controller to instantiate.
 *
 *  Initialization:
 *		This file is instantiated in "./system/kernel.php".
 *
 *	Dependencies:
 *		./router.php (required inside class constructor)
 */

// The Router
class Router {

	// Constructor
	public function __construct() {

		// Get router-array
		require_once ROOT . 'router.php';

		// Get URL as array.
		$url = $this->explode_url();

		// Default controller
		if( $this->default_controller($url, $router) === False) {
			// Load default and stop the rest of the script.
			return False;
		}

		// If any arguments have been provided in the URL: check if they exist without Routes, first.
		if( $this->call_controller($url) === False ) {
			
			// Explode router-array
			$router = $this->explode_router($router);
			// Get routed controller
			$route = $this->route_controller($url, $router);
			var_dump($route);
			// If the result is false, get 404 page
			if( $this->call_controller($route) === False ) {
				// require 404 page.
				echo '404: The page you are trying to access does not exist';
			}
		}		
	}

	/**
	 * ------------------------------------------------------
	 *	Explode URL (convert from string)
	 * ------------------------------------------------------
	 *	Process the URL and divide it up to:
	 *		1. controller name
	 *		2. arguments passed to the controller
	 */
	protected function explode_url() {
		// Check if the URL is set; else make it null / empty
		$url = isset($_GET['url']) ? $_GET['url'] : null;
		// Right-trim possible "/" to avoid an empty row in exploded-array
		$url = rtrim($url, '/');
		// Explode the URL to get array.
		$url = explode('/', $url);
		// Return URL
		return $url;
	}

	/**
	 * ------------------------------------------------------
	 *	Default controller
	 * ------------------------------------------------------
	 *	Purpose: Set a default controller.
	 *
	 *	If the URL is empty, this script will use "controllers/index.php"
	 *	as the default controller ('controllers/index.php');
	 */
	protected function default_controller($url, $router) {
		// If there are no URI
		if( empty($url[0]) ) {
			// Trim slashes from default controller
			$router['default_controller'] = trim($router['default_controller'], '/');
			// Explode default controller
			$router = explode('/', $router['default_controller']);
			// Require the default controller file
			require CON_PATH . $router[0] . '.php';

			// If a function have been provided
			if( isset($router[1]) ) {
				// Instantiate default controller
				$controller = new $router[0]();
				// And enter provided function
				$controller->$router[1]();
			}
			// If only the controller have been provided
			else {
				// Instantiate 'controllers/index'
				$controller = new $router[0]();
				// Enter default/index
				$controller->index();
			}

			// Return false to kill the rest of the script
			return false;
		}
	}

	protected function explode_router($router) {

		$i = 0;
		foreach ($router as $name => $value) {
			// Trim name and value for slashes.
			$name = trim($name, '/');
			$value = trim($value, '/');

			// Check for slashes in string (INT : FALSE).
			$name_pos = strpos($name, '/');
			$value_pos = strpos($value, '/');

			// Explode if possible
			if( $name_pos !== FALSE ) {
				// Explode string
				$name = explode('/', $name);
			} else {
				$name[0] = $name;
			}
			// Explode if possible
			if( $value_pos !== FALSE ) {
				// Explode string
				$value = explode('/', $value);
			} else {
				$value[0] = $value;
			}

			// Assign values
			$array[$i]['name'] = $name;
			$array[$i]['value'] = $value;

			// Add
			$i += 1;
		}

		return $array;
	}

	/**
	 * ------------------------------------------------------
	 *	The Core Router
	 * ------------------------------------------------------
	 *	Initialize the controller if the controller-file exists.
	 *	This is based on the first value of the array ($array[0])
	 */
	protected function call_controller($url) {
		// Define path to the controller
		$file = CON_PATH . $url[0] .'.php';
		// If the controller-file exists:
		if( file_exists($file) ) {
			// require controller-file
			require $file;

			// Instantiate the controller
			$controller = new $url[0]();

			/**
			 *	If there are provided 1 or 2 arguments in the url
			 *	this will pass the arguments to class inside the controller
			 */
			if( isset($url[4]) ) {
				if ( method_exists($controller, $url[1]) ) {
					// This is the same as: $controller->function( argument, argument, argument );
					$controller->{$url[1]}($url[2], $url[3], $url[4]);
				} else {
					return False;
				}
			} elseif( isset($url[3]) ) {
				if ( method_exists($controller, $url[1]) ) {
					// This is the same as: $controller->function( argument, argument );
					$controller->{$url[1]}($url[2], $url[3]);
				} else {
					return False;
				}
			} elseif( isset($url[2]) ) {
				if ( method_exists($controller, $url[1]) ) {
					// This is the same as: $controller->function( argument );
					$controller->{$url[1]}($url[2]);
				} else {
					return False;
				}
			} elseif( isset($url[1]) ) {
				if ( method_exists($controller, $url[1]) ) {
					// This is the same as: $controller->function();
					$controller->{$url[1]}();
				} else {
					if( method_exists($controller, 'index') ) {
						// This is the same as: $controller->index( argument );
						$controller->index($url[1]);
					} else {
						return False;
					}
				}
			} elseif( method_exists($controller, 'index') ) {
				// If there is no $url[1] or higher, the "index function",
				// inside the controller, will always be called as a default.
				$controller->index();
			} else {
				return False;
			}
		}
		/**
		 *	If the controller file did not exist, execute this statement.
		 *	User: 	This will be the 404-page for "page doesn't exist".
		 *	Us:		This means that the controller file don't exist.
		 */
		else {
			return False;
		}
	}

	// Get route of the wanted controller
	protected function route_controller($url, $router) {
		
		/** 
		 * ----------------------------------------
		 * Compare route name & URL
		 * ----------------------------------------
		 */

		// Count amount of rows in the url-array
		$url_count = count($url);

		// Loop through each route
		foreach ($router as $key => $route) {
			
			// Count amount of rows in the route's name
			$route_count = count($route['name']);

			// If there is only 1 row in both arrays
			if( $url_count === $route_count && $url_count === 1) {
				// If the names are identical
				if( $url[0] === $route['name'] ) {
					return $route['value'];
				} else {
					return False;
				}
			}
			// If the amount of rows in Route and URL is the same (is_array to ignore "default_controller" or possible strings)
			elseif( is_array($route['name']) && $url_count === $route_count ) {
				// Compare arrays and find the difference
				$diff = array_diff($url, $route['name']);
				// Count amount of differences
				$diff_count = count($diff);

				// If the two arrays are identical
				if ( $diff_count === 0 ) {
					// Instantiate controller (and exit the rest of the script)
					return $route['value'];
				}

/* Problem from Here */
				// Define valid
				$valid = True;
				// Go through each difference
				foreach ($diff as $value) {
					// If the difference doesn't equal "*"
					if( $value !== '*' ) {
						// Make $valid, false.
						$valid = False;
					}
				}

				// If valid were a success, instantiate controller
				if($valid === True) {

					var_dump( $route['value'] );

					//return $route['value'];
				}
			}
		}
	}
}