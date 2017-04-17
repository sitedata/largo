<?php
/**
 * Additional WordPress Settings
 *
 * @package Largo
 */
$settings = new Largo_Settings();

class Largo_Settings {
	function largo_settings() {
		add_filter( 'admin_init' , array( &$this, 'register_fields' ) );
	}

	function register_fields() {
		register_setting( 'general', 'site_description', 'esc_attr' );
		add_settings_field( 'site_description', '<label for="site_description">' . __( 'Site Description' , 'site_description' ) . '</label>' , array( &$this, 'fields_html' ) , 'general' );
	}
	function fields_html() {
		$value = get_option( 'site_description', '' );
		echo '<textarea rows="5" id="site_description" class="large-text code" name="site_description">' . $value . '</textarea>';
	}
}
