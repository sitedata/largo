<?php
/**
 * Functions related to pagination of posts and archives
 *
 * @package Largo
 */

if ( ! function_exists( 'largo_entry_content' ) ) {
	/**
	 * Filter for query_vars that wants all query vars.
	 *
	 * @param Array $qvars Array of query vars.
	 * @return Array
	 */
	function my_queryvars( $qvars ) {
		$qvars[] = 'all';
		return $qvars;
	}
	add_filter( 'query_vars', 'my_queryvars' );

	/**
	 * Replaces the_content() with paginated content (if <!--nextpage--> is used in the post)
	 *
	 * @param WP_Post|int $post The post for which we are getting the content.
	 * @since 0.3
	 */
	function largo_entry_content( $post ) {

		global $wp_query, $numpages;
		$no_pagination = false;

		if ( isset( $wp_query->query_vars['all'] ) ) {
			$no_pagination = $wp_query->query_vars['all'];
		}

		if ( $no_pagination ) {
			// @todo why doesn't this just use the_content?
			echo apply_filters( 'the_content', $post->post_content );
			$page = $numpages + 1;
		} else {
			the_content();
			if ( is_singular() && $numpages > 1 ) {
				largo_custom_wp_link_pages( '' );
			}
		}
	}
}

if ( ! function_exists( 'largo_custom_wp_link_pages' ) ) {
	/**
	 * Adds pagination to single posts
	 * Based on: https://bavotasan.com/2012/a-better-wp_link_pages-for-wordpress/
	 *
	 * @params Array $args same array of arguments as accepted by wp_link_pages
	 * See: https://codex.wordpress.org/Function_Reference/wp_link_pages
	 * @return formatted output in html (or echo)
	 * @since 0.3
	 */
	function largo_custom_wp_link_pages( $args ) {
		$defaults = array(
			'before'           => '<div class="post-pagination">',
			'after'            => '</div>',
			'text_before'      => '',
			'text_after'       => '',
			'nextpagelink'     => __( 'Next Page', 'largo' ),
			'previouspagelink' => __( 'Previous Page', 'largo' ),
			'pagelink'         => '%',
			'echo'             => 1,
		);

		$r = wp_parse_args( $args, $defaults );
		$r = apply_filters( 'wp_link_pages_args', $r );

		global $page, $numpages, $multipage, $more, $pagenow;

		$output = '';
		if ( $multipage ) {
			// @todo what is the provenance of this comment?
			//if ( 'number' == $next_or_number ) {
				$output .= $r['before'];

				// previous page.
				$i = $page - 1;
				if ( $i && $more ) {
					$output .= _wp_link_page( $i );
					$output .= $r['text_before'] . $r['previouspagelink'] . $r['text_after'] . '</a>|';
				}

				// list of page #s.
				for ( $i = 1; $i < ( $numpages + 1 ); $i = $i + 1 ) {
					$j = str_replace( '%', $i, $r['pagelink'] );
					$output .= ' ';
					if ( $i != $page || ( ( ! $more ) && ( $page == 1 ) ) ) {
						$output .= _wp_link_page( $i );
					} else {
						$output .= '<span class="current-post-page">';
					}

					$output .= $r['text_before'] . $j . $r['text_after'];
					if ( $i != $page || ( ( ! $more ) && ( $page == 1 ) ) ) {
						$output .= '</a>';
					} else {
						$output .= '</span>';
					}
				}

				// next page.
				$i = $page + 1;
				if ( $i <= $numpages && $more ) {
					$output .= '|' . _wp_link_page( $i );
					$output .= $r['text_before'] . $r['nextpagelink'] . $r['text_after'] . '</a>';
				}

				$output .= '|<a href="' . esc_attr( add_query_arg( array( 'all' => '1' ), get_permalink() ) ) . '" title="View all pages">View As Single Page</a>';

				$output .= $r['after'];
		}

		if ( $r['echo'] ) {
			echo $output;
		}

		return $output;
	}
}

if ( ! function_exists( 'largo_content_nav' ) ) {
	/**
	 * Display navigation to next/previous pages when applicable
	 *
	 * @since 0.3
	 * @param String $nav_id Which nav?
	 * @param Boolean $in_same_cat Do the thing in the same category?
	 */
	function largo_content_nav( $nav_id, $in_same_cat = false ) {
		global $wp_query;

		if ( 'single-post-nav-below' === $nav_id ) { ?>

			<nav id="nav-below" class="pager post-nav clearfix">
				<?php
					// @todo: fix this to not do variable assignment within condition.
					if ( $prev = get_previous_post( $in_same_cat ) ) {
						if ( get_the_post_thumbnail( $prev->ID ) ) {
							$image = wp_get_attachment_image_src( get_post_thumbnail_id( $prev->ID ) );
							printf(
								// translators: %1$s is permalink. %2$s is the name for the generic 'post' type post on this site. %3$s is the post title of the previous post. %4$s is an image src.
								__( '<div class="previous"><a href="%1$s"><img class="thumb" src="%4$s" /><h5>Previous %2$s</h5><span class="meta-nav">%3$s</span></a></div>', 'largo' ),
								esc_attr( get_permalink( $prev->ID ) ),
								esc_html( of_get_option( 'posts_term_singular' ) ),
								esc_html( $prev->post_title ),
								esc_attr( $image[0] )
							);
						} else {
							printf(
								// translators: %1$s is permalink. %2$s is the name for the generic 'post' type post on this site. %3$s is the post title of the previous post.
								__('<div class="previous"><a href="%1$s"><h5>Previous %2$s</h5><span class="meta-nav">%3$s</span></a></div>', 'largo'),
								esc_attr( get_permalink( $prev->ID ) ),
								esc_html( of_get_option( 'posts_term_singular' ) ),
								esc_html( $prev->post_title )
							);
						}
					}
					if ( $next = get_next_post( $in_same_cat ) ) {
						if ( get_the_post_thumbnail( $next->ID ) ) {
							$image = wp_get_attachment_image_src( get_post_thumbnail_id( $next->ID ) );
							printf(
								// translators: %1$s is permalink. %2$s is the name for the generic 'post' type post on this site. %3$s is the post title of the previous post. %4$s is an image src.
								__('<div class="next"><a href="%1$s"><img class="thumb" src="%4$s" /><h5>Next %2$s</h5><span class="meta-nav">%3$s</span></a></div>', 'largo'),
								esc_attr( get_permalink( $next->ID ) ),
								esc_html( of_get_option( 'posts_term_singular' ) ),
								esc_html( $next->post_title ),
								esc_attr( $image[0] )
							);
						} else {
							printf(
								// translators: %1$s is permalink. %2$s is the name for the generic 'post' type post on this site. %3$s is the post title of the previous post.
								__('<div class="next"><a href="%1$s"><h5>Next %2$s</h5><span class="meta-nav">%3$s</span></a></div>', 'largo'),
								esc_attr( get_permalink( $next->ID ) ),
								esc_html( of_get_option( 'posts_term_singular' ) ),
								esc_html( $next->post_title )
							);
						}
					}
					?>
			</nav><!-- #nav-below -->

		<?php } elseif ( $wp_query->max_num_pages > 1 ) {
			$posts_term = of_get_option( 'posts_term_plural' );

			largo_render_template(
				'partials/load-more-posts',
				null,
				array(
					'nav_id' => $nav_id,
					'the_query' => $wp_query,
					'posts_term' => ( ! empty( $posts_term ) ) ? $posts_term : esc_html__( 'Posts', 'largo' )
				)
			);
		}
	}
}

