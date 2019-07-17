<?php
/**
 * Functions related to social media knowledge tags
 *
 * @package Largo
 */

if ( ! function_exists( 'largo_opengraph' ) ) {
	/**
	 * Adds appropriate open graph, twittercards, and google publisher tags
	 * to the header based on the page type displayed
	 *
	 * @uses largo_twitter_url_to_username()
	 * @since 0.3
	 */
	function largo_opengraph() {

		global $post;

		// start the output; some attributes will be the same for all page types.
		echo '<meta name="twitter:card" content="summary">';

		$twitter_url =  largo_twitter_url_to_username( of_get_option( 'twitter_link' ) );
		if ( ! empty( $twitter_url ) ) {
			echo '<meta name="twitter:site" content="@' . esc_attr( $twitter_url ) . '">';
		}

		// output appropriate OG tags by page type.
		if ( is_singular() ) {
			if ( have_posts() ) {
				the_post(); // we need to queue up the post to get the post specific info.

				if ( get_the_author_meta( 'twitter' ) && ! get_post_meta( $post->ID, 'largo_byline_text' ) ) {
					echo '<meta name="twitter:creator" content="@' . esc_attr( largo_twitter_url_to_username( get_the_author_meta( 'twitter' ) ) ) . '">';
				}
				?>
				<meta property="og:title" content="<?php the_title(); ?>" />
				<meta property="og:type" content="article" />
				<meta property="og:url" content="<?php the_permalink(); ?>"/>
				<meta property="og:description" content="<?php echo esc_attr( wp_strip_all_tags( esc_html( get_the_excerpt() ) ) ); ?>" />
				<meta name="description" content="<?php echo esc_attr( wp_strip_all_tags( esc_html( get_the_excerpt() ) ) ); ?>" />
				<?php
			} // have_posts

			rewind_posts();

		} elseif ( is_front_page() ) {
			printf(
				'<meta property="og:title" content="%1$s - %2$s" />',
				esc_attr( get_bloginfo( 'name' ) ),
				esc_attr( get_bloginfo( 'description' ) )
			);
			?>
				<meta property="og:type" content="website" />
				<meta property="og:url" content="<?php echo esc_attr( home_url() ); ?>"/>
				<meta property="og:description" content="<?php echo esc_attr( get_bloginfo( 'description' ) ); ?>" />
				<meta name="description" content="<?php echo esc_attr( get_bloginfo( 'description' ) ); ?>" />
			<?php
		} else {
			// not a single post, not the front page.
			?>
				<meta property="og:title" content="<?php wp_title(); ?>" />
				<meta property="og:type" content="article" />
				<meta property="og:url" content="<?php echo esc_url( largo_get_current_url() ); ?>"/>
			<?php

			$description = '';
			// let's try to get a better description when available.
			if ( is_category() && category_description() ) {
				$description = category_description();
			} elseif ( is_author() ) {
				if ( have_posts() ) {
					the_post(); // we need to queue up the post to get the post specific info.
					if ( get_the_author_meta( 'description' ) ) {
						$description = get_the_author_meta( 'description' );
					}
				}
				rewind_posts();
			} else {
				$description = get_bloginfo( 'description' );
			}
			if ( ! empty( $description ) ) {
				echo '<meta property="og:description" content="' . esc_attr( wp_strip_all_tags( esc_html( $description ) ) ) . '" />';
				echo '<meta name="description" content="' . esc_attr( wp_strip_all_tags( esc_html( $description ) ) ) . '" />';
			}
		}

		// add a few more attributes that are common to all page types.
		echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo() ) . '" />';

		/*
		 * Images
		 */

		// set a default thumbnail; if a post has a featured image use that instead.
		if ( is_singular() && has_post_thumbnail( $post->ID ) ) {
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
			$thumbnail_url = $image[0];
		} elseif ( ! empty( of_get_option( 'logo_thumbnail_sq' ) ) ) {
			$thumbnail_url = of_get_option( 'logo_thumbnail_sq' );
		} else {
			$thumbnail_url = false;
		}

		// output the social media image.
		if ( $thumbnail_url ) {
			echo '<meta property="og:image" content="' . esc_attr( $thumbnail_url ) . '" />';
		}

	}
}
// don't add this if Yoast is active!
if ( ! class_exists( 'WPSEO_OpenGraph' ) ) {
	add_action( 'wp_head', 'largo_opengraph' );
}

/**
 * Filter wp_title() to add our custom metadata
 *
 * @since 0.6
 * @link https://github.com/INN/largo/issues/1470
 * @param Array $parts An array of title parts.
 * @return Array.
 */
function largo_wp_title_parts_filter( $parts ) {
	global $page, $paged;

	// Add the blog description for the home/front page.
	if ( is_home() || is_front_page() ) {
		$site_description = get_bloginfo( 'description', 'display' );
		if ( ! empty( $site_description ) ) {
			$parts[] = $site_description;
		}
	}

	// Add a page number if necessary:
	if ( isset( $paged ) || isset( $page ) ) {
		if ( $paged >= 2 || $page >= 2 ) {
			$parts[] = sprintf(
				// translators: %1$s is the page number.
				__( 'Page %1$s' , 'largo' ),
				max( $paged, $page )
			);
		}
	}

	$parts[] = get_bloginfo( 'name' ); // Add the blog name.

	foreach ( $parts as $i => $part ) {
		if ( empty( $part ) ) {
			unset( $parts[$i] );
		}
	}

	return $parts;
}
add_filter( 'wp_title_parts', 'largo_wp_title_parts_filter' );

/**
 * Return to using |
 *
 * @since Largo 0.6
 * @link https://developer.wordpress.org/reference/functions/wp_get_document_title/
 */
add_filter( 'document_title_separator', function( $sep ) {
	return '|';
});
