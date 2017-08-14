<?php
/**
 * Customizer panels.
 *
 * @package Largo
 */
/**
 * Add a custom panels to attach sections too.
 */
function largo_customize_panels( $wp_customize ) {}
add_action( 'customize_register', 'largo_customize_panels' );
