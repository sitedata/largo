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
 		'largo_header_scripts',
 		array(
 			'default'           => '',
 			'sanitize_callback' => 'force_balance_tags',
 		)
 	);
 	// Create the setting field.
 	$wp_customize->add_control(
 		'largo_header_scripts',
 		array(
 			'label'       => esc_html__( 'Header Scripts', 'largo' ),
 			'description' => esc_html__( 'Additional scripts to add to the header. Basic HTML tags are allowed.', 'largo' ),
 			'section'     => 'basic-settings',
 			'type'        => 'textarea',
 		)
 	);
 }
 // add_action( 'customize_register', '_customize_additional_scripts' );
