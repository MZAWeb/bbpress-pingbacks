<?php
/**
 * Helper function to get the singleton instance of the
 * bbPress_Pingbacks class.
 *
 * @return bbPress_Pingbacks
 */
function bbp_pingbacks() {
	return bbPress_Pingbacks::instance();
}

/**
 * Returns an array of pingbacks for the given or current topic
 *
 * @return bool
 */
function bbp_have_pingbacks() {
	return bbp_pingbacks()->have_pingbacks();
}

/**
 * Returns the current pingback and advances the array
 *
 * @return array
 */
function bbp_the_pingback() {
	$GLOBALS['comment'] = bbp_pingbacks()->the_pingback();
}