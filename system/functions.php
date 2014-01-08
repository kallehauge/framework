<?php
/**
 * ------------------------------------------------------
 *	Functions for general
 * ------------------------------------------------------
 *	In this file you'll find general functions to help with
 *	the MVC structure; such as base_url() and redirect().
 */

// Base Url to help work with absolute paths in ex: paths for css and js files.
function base_url($path = null) {
	// Trim any possible starting or trailing '/' to avoid errors
	$path = trim($path, '/');
	// Concatenate the BASE_URL and the provided path.
	$fullPath = BASE_URL .'/'. $path;
	// Return the end result.
	return $fullPath;
}

// Simple redirect adapter
function redirect($location = null) {
	// If the argument have been left out
	if( empty($location) ) {
		// Return a redirect to the base url
		return header( 'location: ' . base_url() );
	}
	// Else if an argument have been provided
	elseif( !empty($location) ) {
		// Return a redirect to the wanted destination
		return header( 'location: ' . base_url($location) );
	}
}