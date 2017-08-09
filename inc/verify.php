<?php
/**
 * Adds site verification meta tags for various services
 * Descriptions of what these are used for can be found in options.php
 * or in the Appearance > Theme Options > Advanced section of the WP admin
 *
 * @since 0.3
 */
function largo_verify() {

	// These services only require the verification meta tag on the homepage
	if ( is_home() ) {
		if ( get_theme_mod( 'twitter_acct_id') ) {
			echo '<meta property="twitter:account_id" content="' . get_theme_mod( 'twitter_acct_id') . '" />';
		}
		if ( get_theme_mod( 'google_site_verification') ) {
			echo '<meta name="google-site-verification" content="' . get_theme_mod( 'google_site_verification') . '" />';
		}
		if ( get_theme_mod( 'bitly_verification') ) {
			echo '<meta name="bitly-verification" content="' . get_theme_mod( 'bitly_verification') . '"/>';
		}
	}

	// Facebook uses these for any page that creates an associated open graph object so we need them on every page
	if ( get_theme_mod( 'fb_admins') ) {
		echo '<meta property="fb:admins" content="' . get_theme_mod( 'fb_admins') . '" />';
	}
	if ( get_theme_mod( 'fb_app_id') ) {
		echo '<meta property="fb:app_id" content="' . get_theme_mod( 'fb_app_id') . '" />';
	}
}
add_action( 'wp_head', 'largo_verify' );
