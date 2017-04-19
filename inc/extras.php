<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Largo
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function largo_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'largo_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function largo_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'largo_pingback_header' );


/**
 * Send anything to the error log in a human-readable format
 *
 * @param 	mixed $stuff the stuff to be sent to the error log.
 * @since 	0.4
 */
if (!  function_exists( 'var_log' ) ) {
	function var_log( $stuff ) {
		error_log( var_export( $stuff, true ) );
	}
}

/**
 * Returns a Facebook username or ID from the URL
 *
 * @param   string  $url a Facebook url
 * @return  string  the Facebook username or id extracted from the input string
 * @since   0.4
 */
function largo_fb_url_to_username( $url )  {
	$urlParts = explode( '/', $url );
	if ( end( $urlParts ) == '' ) {
		// URL has a trailing slash
		$urlParts = array_slice( $urlParts, 0 , -1 );
	}
	$username = end( $urlParts );
	if ( preg_match( '/profile.php/', $username ) ) {
		// a profile id
		preg_match( '/id=([0-9]+)/', $username, $matches );
		$username = $matches[1];
	} else {
		// hopefully there's a username
		preg_match( '/[^\?&#]+/', $username, $matches);
		if ( isset( $matches[0] ) ){
			$username = $matches[0];
		}
	}
	return $username;
}

/**
 * Returns a Twitter username (without the @ symbol)
 *
 * @param 	string 	$url a twitter url
 * @return 	string	the twitter username extracted from the input string
 * @since 	0.3
 */
function largo_twitter_url_to_username( $url ) {
	$urlParts = explode( '/', $url );
	if ( end( $urlParts ) == '' ) {
		// URL has a trailing slash
		$urlParts = array_slice( $urlParts, 0 , -1 );
	}
	$username = preg_replace( '/@/', '', end( $urlParts ) );
	// strip the ?&# URL parameters if they're present
	// this will let through all other characters
	preg_match( '/[^\?&#]+/', $username, $matches );
	if ( isset( $matches[0] ) ){
		$username = $matches[0];
	}
	return $username;
}
