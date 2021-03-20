<?php
/**
 * Various customizations for the admin dashboard
 *
 * @package Largo
 * @since 0.1
 */

// dashboad widgets for everyone!
function largo_dashboard_widgets() {
	global $wp_meta_boxes;

	unset(
		$wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins'],
		$wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary'],
		$wp_meta_boxes['dashboard']['side']['core']['dashboard_primary'],
		$wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links'],
		$wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']
	);

	wp_add_dashboard_widget( 'dashboard_quick_links', __( 'Project Largo Help', 'largo' ), 'largo_dashboard_quick_links' );

}

/**
 * Largo dashboard quick links
 */
function largo_dashboard_quick_links() {
	echo '<div class="list-widget">';
		printf(
			'<p>%1$s</p>',
			__( 'If you\'re having trouble with your site, want to request a new feature or are just interested in learning more about Project Largo, here are a few helpful links:', 'largo' )
		);
		echo '<ul>';
			$links = array(
				// these are translated with their HTML in case we have different-language versions of these
				__( '<a href="https://largo.wpbuddy.co/">Largo Project Website</a>', 'largo' ),
				__( '<a href="https://largo.readthedocs.io/">Largo Documentation</a>', 'largo' ),
				__( '<a href="https://largo.wpbuddy.co/support">Help Desk and Knowledge Base</a>', 'largo' ),
				__( '<a href="mailto:support@wpbuddy.co">Contact Us</a>', 'largo' ),
			);
			foreach ( $links as $link ) {
				printf(
					'<li>%1$s</li>',
					$link
				);
			}
		echo '</ul>';
		printf(
			'<p>%1$s</p>',
			__( 'Developers can also log issues on <a href="https://github.com/WPBuddy/Largo">the theme\'s GitHub repository</a>. We welcome contributions.', 'largo' ), // translate the HTML in case the link needs localization.
		);
	echo '</div>';
}

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

// load the dashboard customizations
add_action('login_head', 'largo_custom_login_logo');
add_action('wp_dashboard_setup', 'largo_dashboard_widgets');

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
	$args = array( 'id' => 'website', 'title' => 'Main Website', 'href' => 'https://largo.inn.org//', 'parent' => 'largo_admin_mega' );
	$wp_admin_bar->add_node( $args );

	// Documentation
	$args = array( 'id' => 'largo_docs', 'title' => 'Documentation', 'href' => 'https://largo.readthedocs.io/', 'parent' => 'largo_admin_mega' );
	$wp_admin_bar->add_node( $args );

	// Knowledge Base
	$args = array( 'id' => 'knowledge_base', 'title' => 'Knowledge Base', 'href' => 'https://support.inn.org/', 'parent' => 'largo_admin_mega' );
	$wp_admin_bar->add_node( $args );

	// Member Help Desk
	$args = array( 'id' => 'support', 'title' => 'Help Desk', 'href' => 'https://support.inn.org/', 'parent' => 'largo_admin_mega' );
	$wp_admin_bar->add_node( $args );

	// Member Forums
	$args = array( 'id' => 'user_forums', 'title' => 'Community Forums', 'href' => 'https://support.inn.org/', 'parent' => 'largo_admin_mega' );
	$wp_admin_bar->add_node( $args );

	// Largo on GitHub
	$args = array( 'id' => 'github', 'title' => 'Largo on GitHub', 'href' => 'https://github.com/inn/largo', 'parent' => 'largo_admin_mega' );
	$wp_admin_bar->add_node( $args );

	// Largo on Twitter
	$args = array( 'id' => 'twitter', 'title' => '@LargoProject on Twitter', 'href' => 'https://twitter.com/largoproject', 'parent' => 'largo_admin_mega');
	$wp_admin_bar->add_node( $args );

	// INN Nerds
	$args = array( 'id' => 'inn_nerds', 'title' => 'INN Nerds', 'href' => 'https://labs.inn.org/', 'parent' => 'largo_admin_mega' );
	$wp_admin_bar->add_node( $args );

	// About INN
	$args = array( 'id' => 'about_inn', 'title' => 'About INN', 'href' => 'https://inn.org', 'parent' => 'largo_admin_mega' );
	$wp_admin_bar->add_node( $args );

	// Donate
	$args = array( 'id' => 'donate_inn', 'title' => 'Donate', 'href' => 'https://inn.org/donate/', 'parent' => 'largo_admin_mega' );
	$wp_admin_bar->add_node( $args );

}

// add a credit line to the admin footer
function largo_admin_footer_text( $default_text ) {
	return '<span id="footer-thankyou">This website powered by <a href="https://largo.inn.org/">Project Largo</a> from <a href="https://inn.org/">INN</a> and <a href="https://wordpress.org">WordPress</a>.</span>';
}
add_filter( 'admin_footer_text', 'largo_admin_footer_text' );

// remove the links menu item and the media options
function largo_admin_menu() {
	remove_menu_page( 'link-manager.php' );
	remove_menu_page( 'options-media.php' );
}
add_action( 'admin_menu', 'largo_admin_menu' );
