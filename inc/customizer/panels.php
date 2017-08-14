<?php
/**
 * Customizer panels.
 *
 * @package Largo
 */
/**
 * Add a custom panels to attach sections too.
 */
function largo_customize_panels( $wp_customize ) {

	$wp_customize->add_panel( 'basic-settings', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => esc_html__( 'Basic Settings', 'largo' ),
//		'description'    => esc_html__( '', 'largo' ),
	) );

	$wp_customize->add_panel( 'theme-images', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => esc_html__( 'Theme Images', 'largo' ),
//		'description'    => esc_html__( '', 'largo' ),
	) );

	$wp_customize->add_panel( 'layout', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => esc_html__( 'Layout', 'largo' ),
//		'description'    => esc_html__( '', 'largo' ),
	) );

	$wp_customize->add_panel( 'navigation', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => esc_html__( 'Navigation', 'largo' ),
//		'description'    => esc_html__( '', 'largo' ),
	) );

	$wp_customize->add_panel( 'advanced', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'theme_supports' => '',
		'title'          => esc_html__( 'Advanced', 'largo' ),
//		'description'    => esc_html__( '', 'largo' ),
	) );
}
add_action( 'customize_register', 'largo_customize_panels' );
