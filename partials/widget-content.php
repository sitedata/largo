<?php

// The top term
if ( isset( $instance['show_top_term'] ) && $instance['show_top_term'] == 1 && largo_has_categories_or_tags() ) {
	largo_maybe_top_term();
}

if ( ! empty( $thumb ) ) {
	// default img size
	$img_size = '60x60';
	// the thumbnail image (if we're using one)
	if ( $thumb == 'small' ) {
		$img_location = ! empty( $instance['image_align'] ) ? $instance['image_align'] : 'left';
		$img_attr = array( 'class' => $img_location . '-align' );
		$img_attr['class'] .= " attachment-small";
	} elseif ( $thumb == 'medium' ) {
		$img_location = ! empty( $instance['image_align'] ) ? $instance['image_align'] : 'left';
		$img_attr = array('class' => $img_location . '-align');
		$img_attr['class'] .= " attachment-thumbnail";
		$img_size = 'post-thumbnail';
	} elseif ( $thumb == 'large' ) {
		$img_attr = array();
		$img_attr['class'] = " attachment-large";
		$img_size = 'large';
	}

	if ( get_the_post_thumbnail( get_the_ID(), $img_size ) ) {
		?>
		<a href="<?php echo get_permalink(); ?>"><?php echo get_the_post_thumbnail( get_the_ID(), $img_size, $img_attr ); ?></a>
		<?php
	}
}
$aria_current = '';
if ( get_queried_object_id() === get_the_ID() ) {
	$aria_current .= ' aria-current="page"';
}
// the headline and optionally the post-type icon
?><h5>
	<a href="<?php echo get_permalink(); ?>"<?php echo $aria_current; ?>><?php echo get_the_title(); ?>
	<?php
		if ( isset( $instance['show_icon'] ) && $instance['show_icon'] == true ) {
			post_type_icon();
		}
	?>
	</a>
</h5>

<?php // byline on posts
if ( isset( $instance['show_byline'] ) && $instance['show_byline'] == true) {
	$hide_byline_date = ( ! empty( $instance['hide_byline_date'] ) ) ? $instance['hide_byline_date'] : true;
	?>
		<span class="byline"><?php echo largo_byline( false, $hide_byline_date, get_the_ID() ); ?></span>
	<?php
}

// the excerpt
if ( $excerpt == 'num_sentences' ) {
	$num_sentences = ( ! empty( $instance['num_sentences'] ) ) ? $instance['num_sentences'] : 2;
	?>
		<p><?php echo largo_trim_sentences( get_the_content(), $num_sentences ); ?></p>
	<?php } elseif ( $excerpt == 'custom_excerpt' ) { ?>
		<p><?php echo get_the_excerpt(); ?></p>
	<?php
}
