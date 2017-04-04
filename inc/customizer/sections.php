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

	// Homepage Layout
	$wp_customize->add_section(
		'largo_homepage_layout_section',
		array(
			'title'    => esc_html__( 'Sections', 'largo' ),
			'priority' => 10,
			'panel'    => 'homepage_layout',
		)
	);

	$mods = get_theme_mod( 'largo_homepage_layout_settings' );
	$mods = 5;
	$count = 1;
	while ( $mods >= $count ) {
		$wp_customize->add_section(
			"largo_homepage_layout_section-$count",
			array(
				'title'    => esc_html__( 'Section ', 'largo' ) . $count,
				'priority' => 10,
				'panel'    => 'homepage_layout',
			)
		);
		$count++;
	}
}
add_action( 'customize_register', '_customize_sections' );
