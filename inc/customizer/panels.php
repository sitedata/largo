<?php
/**
 * Customizer panels.
 *
 * @package Largo
 */

/**
 * Add a custom panels.
 */
function largo_customize_panels( $wp_customize ) {

	// Register a new panel.
	$wp_customize->add_panel( 'site-options', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => esc_html__( 'Site Options', 'largo' ),
		'description'    => esc_html__( 'Other theme options.', 'largo' ),
	) );

	// Register a new panel.
	$wp_customize->add_panel( 'layout', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => esc_html__( 'Layout', 'largo' ),
		'description'    => esc_html__( 'layout settings.', 'largo' ),
	) );
}
add_action( 'customize_register', 'largo_customize_panels' );
