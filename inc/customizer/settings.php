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
		'_header_scripts',
		array(
			'default'           => '',
			'sanitize_callback' => 'force_balance_tags',
		)
	);

	// Create the setting field.
	$wp_customize->add_control(
		'_header_scripts',
		array(
			'label'       => esc_html__( 'Header Scripts', 'largo' ),
			'description' => esc_html__( 'Additional scripts to add to the header. Basic HTML tags are allowed.', 'largo' ),
			'section'     => '_additional_scripts_section',
			'type'        => 'textarea',
		)
	);

	// Register a setting.
	$wp_customize->add_setting(
		'_footer_scripts',
		array(
			'default'           => '',
			'sanitize_callback' => 'force_balance_tags',
		)
	);

	// Create the setting field.
	$wp_customize->add_control(
		'_footer_scripts',
		array(
			'label'       => esc_html__( 'Footer Scripts', 'largo' ),
			'description' => esc_html__( 'Additional scripts to add to the footer. Basic HTML tags are allowed.', 'largo' ),
			'section'     => '_additional_scripts_section',
			'type'        => 'textarea',
		)
	);
}
add_action( 'customize_register', '_customize_additional_scripts' );

/**
 * Register a social icons setting.
 */
function _customize_social_icons( $wp_customize ) {

	// Create an array of our social links for ease of setup.
	$social_networks = array( 'facebook', 'googleplus', 'instagram', 'linkedin', 'twitter' );

	// Loop through our networks to setup our fields.
	foreach ( $social_networks as $network ) {

		// Register a setting.
		$wp_customize->add_setting(
			'_' . $network . '_link',
			array(
				'default' => '',
				'sanitize_callback' => 'esc_url',
	        )
	    );

	    // Create the setting field.
	    $wp_customize->add_control(
	        '_' . $network . '_link',
	        array(
	            'label'   => sprintf( esc_html__( '%s Link', 'largo' ), ucwords( $network ) ),
	            'section' => '_social_links_section',
	            'type'    => 'text',
	        )
	    );
	}
}
add_action( 'customize_register', '_customize_social_icons' );

/**
 * Register copyright text setting.
 */
function _customize_copyright_text( $wp_customize ) {

	// Register a setting.
	$wp_customize->add_setting(
		'_copyright_text',
		array(
			'default' => '',
		)
	);

	// Create the setting field.
	$wp_customize->add_control(
		new _Text_Editor_Custom_Control(
			$wp_customize,
			'_copyright_text',
			array(
				'label'       => esc_html__( 'Copyright Text', 'largo' ),
				'description' => esc_html__( 'The copyright text will be displayed in the footer. Basic HTML tags allowed.', 'largo' ),
				'section'     => '_footer_section',
				'type'        => 'textarea',
			)
		)
	);
}
add_action( 'customize_register', '_customize_copyright_text' );

/**
 *
 */
function largo_customize_homepage_layout( $wp_customize ) {

	// Register a setting.
	$wp_customize->add_setting(
		'largo_homepage_layout_settings',
		array(
			'default' => '',
    	'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'largo_homepage_layout_settings',
		array(
			'label'    => __( 'Sections', 'largo' ),
			'description' => __( 'How many content sections?', 'largo' ),
			'section'  => 'largo_homepage_layout_section',
			'type'     => 'radio',
			'choices'  => array(
				'1'  => 'One',
				'2' => 'Two',
				'3' => 'Three',
				'4' => 'Four',
				'5' => 'Five',
			),
		)
	);

//	$mods = get_theme_mod( 'largo_homepage_layout_settings' );
	$mods = 5;
	$count = 1;
	while ( $mods >= $count ) {
		$wp_customize->add_setting(
			"largo_homepage_layout_settings_$count",
			array(
				'default' => '',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			"largo_homepage_layout_settings_$count",
			array(
				'label'    => __( 'Section Columns', 'largo' ),
				'description' => __( 'How many columns in this section?', 'largo' ),
				'section'  => "largo_homepage_layout_section-$count",
				'type'     => 'radio',
				'choices'  => array(
					'1'  => 'One',
					'2' => 'Two',
					'3' => 'Three',
					'4' => 'Four',
				),
			)
		);
		$count++;
	}

}
add_action( 'customize_register', 'largo_customize_homepage_layout' );
