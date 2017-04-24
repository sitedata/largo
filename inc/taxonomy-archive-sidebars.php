<?php
/**
 * @TODO Add Description
 *
 * @package Largo
 */

// Get all registered taxonomies
$taxonomies = get_taxonomies();

/**
 * Exclude WP Core admin taxonomies (and any others added via the filter)
 *
 * To exclude another taxonomy, include the following in your child theme:
 * function add_excluded_taxonomy( $exclude_array ) {
 *   return array_push( $exclude_array, 'new_taxonomy', 'second_new_taxonomy' ); // Add as few or as many taxonomies as you'd like
 * }
 * add_filter( 'largo_excluded_taxonomies', 'add_excluded_taxonomy' );
 */
$excluded_taxonomies = apply_filters(
	'largo_excluded_taxonomies',
	array(
		'nav_menu',
		'link_category',
	)
);

foreach ( $taxonomies as $taxonomy ) {

	// Skip this taxonomy if it's on the excluded list
	if ( in_array( $taxonomy, $excluded_taxonomies ) ) {
		continue;
	}
	add_action( $taxonomy . '_add_form_fields', 'largo_term_meta_create_widget_regions' );
	add_action( $taxonomy . '_edit_form_fields', 'largo_term_meta_edit_widget_regions' );
	add_action( 'create_' . $taxonomy, 'save_taxonomy_custom_meta' );
	add_action( 'edited_' . $taxonomy, 'save_taxonomy_custom_meta' );
}

function largo_term_meta_create_widget_regions( $term ) {
	// this will add the custom meta field to the add new term page
	?>
	<div class="form-field">
		<label for="custom_term_sidebars">
			<input type="checkbox" name="custom_term_sidebars" value="1" id="custom_term_sidebars"<?php checked( $term_meta, 1 ); ?>>
			<?php _e( 'Custom Sidebars', 'largo' ); ?>
		</label>
		<p class="description"><?php _e( 'Make custom widget areas for this term\'s page?','largo' ); ?></p>
	</div>
	<?php
}

function largo_term_meta_edit_widget_regions( $term ) {
	// put the term ID into a variable
	$t_id = $term->term_id;

	$term_meta = get_term_meta( $term->term_id, 'custom_sidebars', true ); ?>

	<tr class="form-field">
	<th scope="row" valign="top"><label for="custom_term_sidebars"><?php _e( 'Custom Sidebars', 'largo' ); ?></label></th>
		<td>
			<input type="checkbox" name="custom_term_sidebars" value="1" id="custom_term_sidebars"<?php checked( $term_meta, 1 ); ?>>
			<p class="description"><?php _e( 'Make custom widget areas for this term\'s page?','largo' ); ?></p>
		</td>
	</tr>
	<?php
}

function save_taxonomy_custom_meta( $term_id ) {
	if ( isset( $_POST['custom_term_sidebars'] ) ) {
		update_term_meta( $term_id, 'custom_sidebars', true );
	} else {
		delete_term_meta( $term_id, 'custom_sidebars' );
	}
}
