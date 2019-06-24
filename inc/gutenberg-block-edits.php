<?php

/**
 * Enqueue scripts to extend default block editor.
 */
function largo_extend_block_editor() {

    wp_enqueue_script(
        'blocks-image-customizations',
		get_template_directory_uri() . '/js/blocks-image-customization.js',
        array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'wp-api' ),
        '1.0.0',
        true
    );
	
}
add_action( 'enqueue_block_editor_assets', 'largo_extend_block_editor' );

/**
 * Register custom fields for the REST api
 */
function largo_register_custom_rest_fields() {

	register_rest_field( 'attachment', 'media_credit', 
		array(
			'get_callback' => 'largo_display_custom_fields_in_rest_api',
			'schema' => null,
		)
	);

}
add_action( 'rest_api_init', 'largo_register_custom_rest_fields' );

/**
 * Configure data for custom fields to display in REST api
 * 
 * @param Array $object The post object
 * @return Array the new object meta data
 */
function largo_display_custom_fields_in_rest_api( $object ) {

    $post_id = $object['id'];

	$meta = get_post_meta( $post_id );
	
	$meta_fields = ['_media_credit'];

    if ( isset( $meta['_media_credit' ] ) && isset( $meta['_media_credit' ][0] ) ) {
		
		//return the post meta
		return $meta['_media_credit' ][0];
		
    }
	
    return;
	
}