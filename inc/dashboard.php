<?php
/**
 * Various customizations for the admin dashboard
 *
 * @package Largo
 * @since 0.1
 */

// add the largo logo to the login page
function largo_custom_login_logo() {
	echo '
		<style type="text/css">
			.login h1 a {
			  background-image: url(' . get_template_directory_uri() . '/img/largo-login-logo.png) !important;
			  background-size:  164px 169px;
			  height: 169px;
			  width: 164px;
			}
		</style>
	';
}

/**
 * Largo Dashboard / Admin Bar Menu
 * -- Priority 15 Places between WordPress Logo and My Sites
 * -- To move menu to end of items use something like priority 999
 */

add_action( 'admin_bar_menu', 'largo_dash_admin_menu', 15 );
function largo_dash_admin_menu( $wp_admin_bar ) {

	// Add Top Level Text Node for Dropdown
	$args = array( 'id' => 'largo_admin_mega', 'title' => 'Largo' );
	$wp_admin_bar->add_node( $args );

	// Main Website
	$args = array( 'id' => 'website', 'title' => 'Main Website', 'href' => 'http://largoproject.org/', 'parent' => 'largo_admin_mega' );
	$wp_admin_bar->add_node( $args );

	// Documentation
	$args = array( 'id' => 'largo_docs', 'title' => 'Documentation', 'href' => 'http://largo.readthedocs.io/', 'parent' => 'largo_admin_mega' );
	$wp_admin_bar->add_node( $args );

	// Knowledge Base
	$args = array( 'id' => 'knowledge_base', 'title' => 'Knowledge Base', 'href' => 'http://support.largoproject.org/support/solutions', 'parent' => 'largo_admin_mega' );
	$wp_admin_bar->add_node( $args );

	// Member Help Desk
	$args = array( 'id' => 'support', 'title' => 'Help Desk', 'href' => 'http://support.largoproject.org', 'parent' => 'largo_admin_mega' );
	$wp_admin_bar->add_node( $args );

	// Member Forums
	$args = array( 'id' => 'user_forums', 'title' => 'Community Forums', 'href' => 'http://support.largoproject.org/support/discussions', 'parent' => 'largo_admin_mega' );
	$wp_admin_bar->add_node( $args );

	// Largo on GitHub
	$args = array( 'id' => 'github', 'title' => 'Largo on GitHub', 'href' => 'https://github.com/inn/largo', 'parent' => 'largo_admin_mega' );
	$wp_admin_bar->add_node( $args );

	// Largo on Twitter
	$args = array( 'id' => 'twitter', 'title' => '@LargoProject on Twitter', 'href' => 'https://twitter.com/largoproject', 'parent' => 'largo_admin_mega');
	$wp_admin_bar->add_node( $args );

	// INN Nerds
	$args = array(' id' => 'inn_nerds', 'title' => 'INN Nerds', 'href' => 'http://nerds.inn.org', 'parent' => 'largo_admin_mega' );
	$wp_admin_bar->add_node( $args );

	// About INN
	$args = array( 'id' => 'about_inn', 'title' => 'About INN', 'href' => 'http://inn.org', 'parent' => 'largo_admin_mega' );
	$wp_admin_bar->add_node( $args );

	// Donate
	$args = array( 'id' => 'donate_inn', 'title' => 'Donate', 'href' => 'https://inn.org/donate', 'parent' => 'largo_admin_mega' );
	$wp_admin_bar->add_node( $args );

}

// add a credit line to the admin footer
function largo_admin_footer_text( $default_text ) {
	return '<span id="footer-thankyou">This website powered by <a href="http://largoproject.org">Project Largo</a> from <a href="http://inn.org">INN</a> and <a href="http://wordpress.org">WordPress</a>.</span>';
}
add_filter( 'admin_footer_text', 'largo_admin_footer_text' );

// remove the links menu item and the media options
function largo_admin_menu() {
	remove_menu_page( 'link-manager.php' );
	remove_menu_page( 'options-media.php' );
}
add_action( 'admin_menu', 'largo_admin_menu' );
