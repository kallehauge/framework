<?php
/**
 * ------------------------------------------------------
 *	URL processing && Initialize Controller-handler
 * ------------------------------------------------------
 *	Purpose:
 *		Works as the bootstrap of the framework by instanciating
 *		the correct controllers and handles custom routes
 *
 *  Initialization:
 *		This file is instantiated in "./index.php".
 *
 *	Dependencies:
 *		./router.php (required inside constructor)
 *		./system/router.php
 *		./system/controller.php
 *		./system/model.php
 */

// Require dependencies
require_once SYS_PATH . 'router.php';
require_once SYS_PATH . 'controller.php';
require_once SYS_PATH . 'model.php';

// The kernel which handles routes
class Kernel {

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
			//var_dump($route);
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
	 *		2. possible function name
	 *		2. possible arguments
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
		// If there are no URN
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

	/**
	 * ------------------------------------------------------
	 *	Explode Router (convert from string)
	 * ------------------------------------------------------
	 *	Process the Router and divide it up to equivalent:
	 *		1. controller name
	 *		2. possible function name
	 *		2. possible arguments
	 */
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

	/** 
	 * ----------------------------------------
	 * Convert URL to desired Route
	 * ----------------------------------------
	 */
	protected function route_controller($url, $router) {
		// Count amount of rows in the url-array
		$url_count = count($url);

		// Loop through each route
		foreach ($router as $key => $route) {
			// Shorthand variables
			$name = $route['name'];
			$values = $route['value'];
			$value_count = count( $values );
			$value_index = $value_count - 1;

			// Count amount of rows in the route's name
			$route_count = count($name);

			// If there is only 1 row in both arrays
			if( $url_count === $route_count && $url_count === 1) {
				// If the names are identical
				if( $url[0] === $name ) {
					return $values;
				} else {
					return False;
				}
			}
			// If the amount of rows in Route and URL is the same (is_array to ignore "default_controller" or possible strings)
			elseif( is_array($name) && $url_count === $route_count ) {
				// Compare arrays and find the difference
				$diff = array_diff($url, $name);
				// Count amount of differences
				$diff_count = count($diff);

				// If the two arrays are identical
				if ( $diff_count === 0 ) {
					// Instantiate controller (and exit the rest of the script)
					return $values;
				}

				// "Key" and 4x random
				if( $route_count === 5 ) {
					// Compare all URL values to the route or *
					if( $url[0] === $name[0] AND
						$url[1] === $name[1] OR $name[1] === '*' AND 
						$url[2] === $name[2] OR $name[2] === '*' AND
						$url[3] === $name[3] OR $name[3] === '*' AND
						$url[4] === $name[4] OR $name[4] === '*' )
					{
						// Find the difference(s) from the url and the route-name
						$diff = array_diff($url, $name);
						// Reset array-keys
						$diff = array_values($diff);

						// For each value in the route (based on count)
						for ($i = 0; $i < $value_count; $i++) { 
							// If the value equals '*'
							if( $values[$i] === '*' ) {
								// Change value from * to first row in $dif (array)
								$values[$i] = $diff[0];
								// Remove assigned row from array
								unset($diff[0]);
								// Re-order keys (so it will be diff[0] next time too)
								$diff = array_values($diff);
							}
						}
						// Return the changed route
						return $values;
					}
				}

				// "Key" and 3x random
				elseif( $route_count === 4 ) {					
					// Compare all URL values to the route or *
					if( $url[0] === $name[0] AND
						$url[1] === $name[1] OR $name[1] === '*' AND 
						$url[2] === $name[2] OR $name[2] === '*' AND
						$url[3] === $name[3] OR $name[3] === '*' )
					{
						// Find the difference(s) from the url and the route-name
						$diff = array_diff($url, $name);
						// Reset array-keys
						$diff = array_values($diff);

						// For each value in the route (based on count)
						for ($i = 0; $i < $value_count; $i++) { 
							// If the value equals '*'
							if( $values[$i] === '*' ) {
								// Change value from * to first row in $dif (array)
								$values[$i] = $diff[0];
								// Remove assigned row from array
								unset($diff[0]);
								// Re-order keys (so it will be diff[0] next time too)
								$diff = array_values($diff);
							}
						}
						// Return the changed route
						return $values;
					}
				}

				// "Key" and 2x random
				elseif( $route_count === 3 ) {
					// Compare all URL values to the route or *
					if( $url[0] === $name[0] AND
						$url[1] === $name[1] OR $name[1] === '*' AND 
						$url[2] === $name[2] OR $name[2] === '*' )
					{
						// Find the difference(s) from the url and the route-name
						$diff = array_diff($url, $name);
						// Reset array-keys
						$diff = array_values($diff);

						// For each value in the route (based on count)
						for ($i = 0; $i < $value_count; $i++) { 
							// If the value equals '*'
							if( $values[$i] === '*' ) {
								// Change value from * to first row in $dif (array)
								$values[$i] = $diff[0];
								// Remove assigned row from array
								unset($diff[0]);
								// Re-order keys (so it will be diff[0] next time too)
								$diff = array_values($diff);
							}
						}
						// Return the changed route
						return $values;
					}
				}

				// "Key" and 1x random
				elseif( $route_count === 2 ) {
					// If the first values match
					if( $url[0] === $name[0] ) {
						// replace last value as variable
						$values[$value_index] = $url[1];
						// return changed value-array
						return $values;
					}
				}
			}
		}
	}
}

/* End of file 'kernel.php' */