<?php
/**
 * Customizer settings.
 *
 * @package Largo
 */

 /**
  * Register additional scripts.
  */
 function _customize_additional_scripts( $wp_customize ) {
 	// Register a setting.
 	$wp_customize->add_setting(
 		'site_blurb',
 		array(
 			'default'           => '',
 			'sanitize_callback' => 'force_balance_tags',
 		)
 	);
 	// Create the setting field.
 	$wp_customize->add_control(
 		'site_blurb',
 		array(
 			'label'       => esc_html__( 'Site Description', 'largo' ),
 			'description' => esc_html__( 'Enter a short blurb about your site. This is used in a sidebar widget.', 'largo' ),
 			'section'     => 'basic_settings',
 			'type'        => 'textarea',
 		)
 	);
 }
 add_action( 'customize_register', '_customize_additional_scripts' );
