<?php
/**
 * Customizer sections.
 *
 * @package Largo
 */

/**
 * Add a custom sections.
 */
function largo_customize_sections( $wp_customize ) {

	$wp_customize->add_section( 'basic_settings', array(
		'title'          => esc_html__( 'Basic Settings', 'largo' ),
		'priority'       => 21,
//		'description'    => esc_html__( '', 'largo' ),
	) );

	$wp_customize->add_section( 'theme_images', array(
		'title'          => esc_html__( 'Theme Images', 'largo' ),
		'priority'       => 21,
//		'description'    => esc_html__( '', 'largo' ),
	) );

	$wp_customize->add_section( 'layout', array(
		'title'          => esc_html__( 'Layout', 'largo' ),
		'priority'       => 21,
//		'description'    => esc_html__( '', 'largo' ),
	) );

	$wp_customize->add_section( 'navigation', array(
		'title'          => esc_html__( 'Navigation', 'largo' ),
		'priority'       => 21,
//		'description'    => esc_html__( '', 'largo' ),
	) );

	$wp_customize->add_section( 'advanced', array(
		'title'          => esc_html__( 'Advanced', 'largo' ),
		'priority'       => 21,
//		'description'    => esc_html__( '', 'largo' ),
	) );
}
add_action( 'customize_register', 'largo_customize_sections' );
