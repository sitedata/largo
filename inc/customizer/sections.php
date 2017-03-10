<?php
/**
 * Customizer sections.
 *
 * @package Largo
 */

/**
 * Register the section sections.
 */
function _customize_sections( $wp_customize ) {

	// Register additional scripts section.
	$wp_customize->add_section(
		'_additional_scripts_section',
		array(
			'title'    => esc_html__( 'Additional Scripts', 'largo' ),
			'priority' => 10,
			'panel'    => 'site-options',
		)
	);

	// Register a footer section.
	$wp_customize->add_section(
		'_footer_section',
		array(
			'title'    => esc_html__( 'Footer Customizations', 'largo' ),
			'priority' => 90,
			'panel'    => 'site-options',
		)
	);
}
add_action( 'customize_register', '_customize_sections' );
