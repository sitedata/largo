<?php
/**
 * Customizer panels.
 *
 * @package Largo
 */

/**
 * Add a custom panels to attach sections too.
 */
function _customize_panels( $wp_customize ) {

	// Register a new panel.
	$wp_customize->add_panel( 'site-options', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => esc_html__( 'Site Options', 'largo' ),
		'description'    => esc_html__( 'Other theme options.', 'largo' ),
	) );

	// Register a new panel.
	$wp_customize->add_panel( 'homepage_layout', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => esc_html__( 'Homepage Layout', 'largo' ),
		'description'    => esc_html__( 'Homepage layouts.', 'largo' ),
	) );
}
add_action( 'customize_register', '_customize_panels' );
