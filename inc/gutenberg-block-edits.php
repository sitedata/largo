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