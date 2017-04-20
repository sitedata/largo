<?php
/*
 * Social links for the author described in $author_object
 *
 * Used in the Author Bio widget
 *
 * @param WP_User $author_object the author
 * @since 0.5.3
 */
?>
<ul class="social-links">

	<?php
	/**
	 * Output all social media buttons
	 */
	do_action( 'largo_author_bio_social_links', $author_obj );
	?>

</ul>
