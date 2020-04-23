<?php
/**
 * Template for various non-category archive pages (tag, term, date, etc.)
 *
 * @package Largo
 * @since 0.1
 * @filter largo_partial_by_post_type
 */

get_header();
$queried_object = get_queried_object();
?>

<div class="clearfix">

	<?php
		if ( have_posts() || largo_have_featured_posts() ) {

			// queue up the first post so we know what type of archive page we're dealing with.
			the_post();

			/*
			 * Display some different stuff in the header
			 * depending on what type of archive page we're looking at
			 */

			if ( is_author() ) {
				$rss_link = get_author_feed_link( get_the_author_meta( 'ID' ) );
			} elseif ( is_tag() ) {
				$title = single_tag_title( '', false );
				$description = tag_description();
				$rss_link = get_tag_feed_link( get_queried_object_id() );
			} elseif ( is_tax() ) {
				$title = single_term_title( '', false );
				$description = term_description();

				// rss links for custom taxonomies are a little tricky.
				$term_id = intval( $queried_object->term_id );
				$tax = $queried_object->taxonomy;
				$rss_link = get_term_feed_link( $term_id, $tax );
			} elseif ( is_date() ) {
				$description = __( 'Select a different month:', 'largo' );
				if ( is_month() ) {
					// translators: this is the PHP date format string for the month and year. Passed to get_the_date(). https://www.php.net/manual/en/datetime.formats.date.php .
					$date_format = _x( 'F Y', 'largo' );
					// translators: %s is the month and year.
					$title = sprintf( __( 'Monthly Archives: <span>%s</span>', 'largo' ), get_the_date( $date_format ) );
				} elseif ( is_year() ) {
					// translators: this is the PHP date format string for the year. Passed to get_the_date(). https://www.php.net/manual/en/datetime.formats.date.php .
					$date_format = _x( 'Y', 'largo' );
					// translators: %s is the year.
					$title = sprintf( __( 'Yearly Archives: <span>%s</span>', 'largo' ), get_the_date( $date_format ) );
				} else {
					$title = esc_html_e( 'Blog Archives', 'largo' );
				}
			} elseif ( is_post_type_archive() ) {
				$post_type = $wp_query->query_vars['post_type'];
				/**
				 * Make the title of the post_type archive filterable
				 *
				 * @param string $title The title of the archive page
				 * @since 0.5.4
				 */
				$title = apply_filters(
					'largo_archive_' . $post_type . '_title',
					post_type_archive_title( '', false )
				);
				/**
				 * Make the feed url of the post_type archive filterable
				 *
				 * @param string $title The title of the archive page
				 * @since 0.5.5
				 */
				$rss_link = apply_filters(
					'largo_archive_' . $post_type . '_feed',
					site_url( '/feed/?post_type=' . rawurlencode( $post_type ) )
				);
			}
		?>

		<header class="archive-background clearfix">
			<?php
				if ( isset( $rss_link ) ) {
					printf(
						'<a class="rss-link rss-subscribe-link" href="%1$s">%2$s <i class="icon-rss"></i></a>',
						esc_attr( $rss_link ),
						esc_html_x( 'Subscribe', 'rss link', 'largo' )
					);
				}

				if ( is_object( $queried_object ) ) {
					largo_hero( largo_get_term_meta_post( $queried_object->taxonomy, $queried_object->term_id ) );
				}

				if ( isset( $title ) ) {
					echo '<h1 class="page-title">' . esc_html( $title ) . '</h1>';
				}

				if ( isset( $description ) ) {
					echo '<div class="archive-description">' . wp_kses_post( $description ) . '</div>';
				}

				if ( is_date() ) {
			?>
					<nav class="archive-dropdown">
						<select name="archive-dropdown" onchange='document.location.href=this.options[this.selectedIndex].value;'>
							<option value=""><?php esc_html_e( 'Select Month', 'largo' ); ?></option>
							<?php
								wp_get_archives(
									array(
										'type'   => 'monthly',
										'format' => 'option',
									)
								);
							?>
						</select>
					</nav>
			<?php
				} elseif ( is_author() ) {
					the_widget( 'largo_author_widget', array( 'title' => '' ) );
				}
			?>
		</header>

		<div class="row-fluid clearfix">
			<div class="stories span8" role="main" id="content">
			<?php do_action( 'largo_archive_before_stories' ); ?>
			<?php
				// Having previously pulled the first post to get information about the taxonomy,
				// we now wind the posts back so we can go through the loop as usual.
				rewind_posts();
				$counter = 1;
				while ( have_posts() ) {
					the_post();
					$post_type = get_post_type();
					$partial = largo_get_partial_by_post_type( 'archive', $post_type, 'archive' );
					get_template_part( 'partials/content', $partial );
					do_action( 'largo_loop_after_post_x', $counter, $context = 'archive' );
					$counter++;
				}

				largo_content_nav( 'nav-below' );
			?>
			</div><!-- end content -->
			<?php get_sidebar(); ?>
		</div>
		<?php } else {
			get_template_part( 'partials/content', 'not-found' );
		}
	?>
</div>

<?php get_footer();
