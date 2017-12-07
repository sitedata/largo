<?php
/**
 * Additional WordPress Settings
 *
 * @package Largo
 */
$settings = new Largo_Settings();

class Largo_Settings {
	function __construct() {
		add_filter( 'admin_init' , array( &$this, 'register_fields' ) );
	}

	function register_fields() {
		register_setting( 'general', 'site_blurb', 'esc_attr' );
		add_settings_field( 'site_blurb', '<label for="site_blurb">' . __( 'Site Blurb' , 'site_blurb' ) . '</label>' , array( &$this, 'fields_html' ) , 'general' );
	}
	function fields_html() {
		$value = get_option( 'site_blurb', '' );
		echo '<textarea rows="5" id="site_blurb" class="large-text code" name="site_blurb">' . $value . '</textarea>';
	}
}
