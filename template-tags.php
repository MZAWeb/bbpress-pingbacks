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
 * Set the 'comment' global with the next pingback in the array
 *
 * @return array
 */
function bbp_the_pingback() {
	$GLOBALS['comment'] = bbp_pingbacks()->the_pingback();
}

/**
 * echo the current pingback ID
 *
 * @return array
 */
function bbp_pingback_id() {
	$current = bbp_pingbacks()->current_pingback();
	if ( empty( $current ) )
		return;

	echo $current->comment_ID;
}

/**
 * Returns whether the topic pingbacks are active or not.
 * @param bool $default
 *
 * @return bool
 */
function bbp_allow_topic_pingbacks( $default = false ) {
	return bbp_pingbacks()->admin->allow_topic_pingbacks( $default );
}

/**
 * Returns whether the reply pingbacks are active or not.
 * @param bool $default
 *
 * @return bool
 */
function bbp_allow_reply_pingbacks( $default = false ) {
	return bbp_pingbacks()->admin->allow_reply_pingbacks( $default );
}

/**
 * Returns whether only the internal (same domain) pingbacks are active.
 * @param bool $default
 *
 * @return mixed
 */
function bbp_allow_only_internal_pingbacks( $default = false ) {
	return bbp_pingbacks()->admin->allow_only_internal_pingbacks( $default );
}