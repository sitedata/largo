<?php
/**
 * Set up the theme customizer.
 *
 * @package Largo
 */

/**
 * Include other customizer files.
 */
function largo_include_custom_controls() {
	require get_template_directory() . '/inc/customizer/panels.php';
	require get_template_directory() . '/inc/customizer/sections.php';
	require get_template_directory() . '/inc/customizer/settings.php';
}
add_action( 'customize_register', 'largo_include_custom_controls', -999 );

/**
 * Enqueue customizer preview related scripts.
 */
function largo_customizer_preview_js() {
	wp_enqueue_script( 'largo-customize-preview', get_template_directory_uri() . '/inc/customizer/assets/scripts/customize-preview.js', array( 'customize-preview' ), '1.0', true );
}
add_action( 'customize_preview_init', 'largo_customizer_preview_js' );

/**
 * Load dynamic logic for the customizer controls area.
 */
function largo_customizer_panels_js() {
	wp_enqueue_script( 'largo-customize-controls', get_template_directory_uri() . '/inc/customizer/assets/scripts/customize-controls.js', array( 'jquery', 'customize-controls' ), '1.0', true );
}
add_action( 'customize_controls_enqueue_scripts', 'largo_customizer_panels_js' );

/**
 * Add support for the fancy new edit icons.
 *
 * @link https://make.wordpress.org/core/2016/02/16/selective-refresh-in-the-customizer/
 */
function largo_selective_refresh_support( $wp_customize ) {

	// The <div> classname to append edit icon too.
	$settings = array(
		'blogname'          => '.site-title a', // @TODO update selector
		'blogdescription'   => '.site-blurb', // @TODO update selector
		'_copyright_text' => '.site-info', // @TODO update selector
	);

	// Loop through, and add selector partials.
	foreach ( (array) $settings as $setting => $selector ) {
		$args = array( 'selector' => $selector );
		$wp_customize->selective_refresh->add_partial( $setting, $args );
	}
}
add_action( 'customize_register', 'largo_selective_refresh_support' );

/**
 * Add live preview support via postMessage.
 *
 * Note: You will need to hook this up via livepreview.js
 *
 * @link https://codex.wordpress.org/Theme_Customization_API#Part_3:_Configure_Live_Preview_.28Optional.29
 */
function largo_live_preview_support( $wp_customize ) {

	// Settings to apply live preview to.
	$settings = array(
		'blogname',
		'blogdescription',
		'header_textcolor',
		'background_image',
		'_copyright_text',
	);

	// Loop through and add the live preview to each setting.
	foreach ( (array) $settings as $setting_name ) {

		// Try to get the customizer setting.
		$setting = $wp_customize->get_setting( $setting_name );

		// Skip if it is not an object to avoid notices.
		if ( ! is_object( $setting ) ) {
			continue;
		}

		// Set the transport to avoid page refresh.
		$setting->transport = 'postMessage';
	}
}
add_action( 'customize_register', 'largo_live_preview_support', 999 );
