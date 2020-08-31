<?php
/*
 * @package WordPress
 * @subpackage Zemplate
 * @since Zemplate 1.0
 *
 * Theme-specific functions and definitions
 *
 * Use this file to set up any theme-specific functions you'd like to use
 * in the current theme.
 */


//======================================================================
// ACF + JSON = ZOMG
//======================================================================
add_filter('acf/settings/save_json', function($path) {
	return dirname(__DIR__) . '/acf-fields';
});
add_filter('acf/settings/load_json', function($paths) {
	unset($paths[0]);
	$paths[] = dirname(__DIR__) . '/acf-fields';
	return $paths;
});
