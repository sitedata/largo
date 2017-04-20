<?php
/**
 * Functions related to avatars
 */

/**
 * Determine whether or not a user has an avatar.
 *
 * It's a wrapper for largo_has_gravatar, providing a way to answer
 * "yes" in the event that we add other forms of avatar.
 *
 * @param $email string an author's email address
 * @return bool true if an avatar is available for this user
 * @since 0.4
 */
function largo_has_avatar( $email ) {
	if ( largo_has_gravatar( $email ) ) {
		return true;
	}
	return false;
}

/**
 * Determine whether or not an author has a valid gravatar image
 * see: http://codex.wordpress.org/Using_Gravatars
 *
 * @param $email string an author's email address
 * @return bool true if a gravatar is available for this user
 * @since 0.3
 */
function largo_has_gravatar( $email ) {
	// Craft a potential url and test its headers
	$hash = md5( strtolower( trim( $email ) ) );
	$cache_key = 'largo_has_gravatar_' . $hash;
	if ( false !== ( $cache_value = get_transient( $cache_key ) ) ) {
		return (bool) $cache_value;
	}
	$uri = 'http://www.gravatar.com/avatar/' . $hash . '?d=404';
	$response = wp_remote_head( $uri );
	if ( 200 == wp_remote_retrieve_response_code( $response ) ) {
		$cache_value = '1';
	} else {
		$cache_value = '0';
	}
	set_transient( $cache_key, $cache_value );
	return (bool) $cache_value;
}
