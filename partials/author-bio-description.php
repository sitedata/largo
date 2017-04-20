<?php
/**
 * Describe the author through their biographical information
 *
 * Used in the author bio widget
 * @since 0.4
 */

// Author name
if ( is_author() ) {
	echo '<h1 class="fn n">' . $author_obj->display_name . '</h1>';
} else {
	printf( __( '<h3 class="widgettitle">About <span class="fn n"><a class="url" href="%1$s" rel="author" title="See all posts by %2$s">%2$s</a></span></h3>', 'largo' ),
		get_author_posts_url( $author_obj->ID, $author_obj->user_nicename ),
		esc_attr( $author_obj->display_name )
	);
}

// Avatar
if ( largo_has_avatar( $author_obj->user_email ) ) {
	echo '<div class="photo">' . get_avatar( $author_obj->ID, 96, '', $author_obj->display_name ) . '</div>';
} elseif ( $author_obj->type == 'guest-author' && get_the_post_thumbnail( $author_obj->ID ) ) {
	$photo = get_the_post_thumbnail( $author_obj->ID, array( 96,96 ) );
	$photo = str_replace( 'attachment-96x96 wp-post-image', 'avatar avatar-96 photo', $photo );
	echo '<div class="photo">' . $photo . '</div>';
}

/**
 * Action allowing additional output on the author bio before the author description
 *
 * This action has a parameter $author_obj, which your action function may use for whatever purpose
 * @param $author_obj
 * @since 1.0
 */
do_action( 'largo_author_bio_before_description', $author_obj );

// Description
if ( $author_obj->description ) {
	echo '<p>' . esc_attr( $author_obj->description ) . '</p>';
}

/**
 * Action allowing additional output on the author bio after the author description
 *
 * This action has a parameter $author_obj, which your action function may use for whatever purpose
 * @param $author_obj
 * @since 1.0
 */
do_action( 'largo_author_bio_after_description', $author_obj );
