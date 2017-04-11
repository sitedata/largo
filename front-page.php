<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Largo
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		$homepage_sections = get_theme_mod( 'largo_homepage_layout_settings', 5 );
		if ( $homepage_sections || is_customize_preview() ) {
			$count = 1;
			while ( $count <= $homepage_sections ) {
				$columns = get_theme_mod( "largo_homepage_layout_settings_$count", 5 );
				$column_count = 1;
				echo '<div class="section" id="section-' . $count . '">';
				echo 'Section ' . $count . ' (' . $columns . ' Columns)';
				while ( $column_count <= $columns ) { ?>
					<div class="column">
						<?php if ( is_active_sidebar( "section-$count-column-$column_count" ) ) : ?>
							<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
								<?php dynamic_sidebar( "section-$count-column-$column_count" ); ?>
							</div><!-- #primary-sidebar -->
						<?php endif; ?>
					</div>

					<?php
					$column_count++;
				}
				echo '</div>';
				$count++;
			}
		}
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
