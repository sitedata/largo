<?php
/**
 * Author Bio Widget
 *
 * archive.php uses this widget to create the header of the Author Archive page
 *
 * @package Largo
 */
class largo_author_widget extends WP_Widget {

	/*
	 * Set up the widget
	 */
	function __construct() {
		$widget_ops = array(
			'classname' 	=> 'largo-author',
			'description'	=> __('Show the author bio in a widget', 'largo')
		);
		parent::__construct( 'largo-author-widget', __( 'Author Bio (Largo)', 'largo' ), $widget_ops );
	}

	/*
	 * Render the widget output
	 */
	function widget( $args, $instance ) {

		global $post;

		$authors = array();
		$bios = '';

		if( get_post_meta( $post->ID, 'largo_byline_text' ) )
			$byline_text = esc_attr( get_post_meta( $post->ID, 'largo_byline_text', true ) );

		if( ( is_singular() ) && empty($byline_text) ) {
			if ( is_singular() ) {
				if ( function_exists( 'get_coauthors' ) ) {
					$authors = get_coauthors( get_queried_object_id() );
				} else {
					$authors = array( get_user_by( 'id', get_queried_object()->post_author ) );
				}
			}

			// make sure we have at least one bio before we show the widget
			foreach ( $authors as $key => $author ) {
				$bio = trim( $author->description );
				if ( !is_author() && empty( $bio ) ) {
					unset( $authors[$key] );
				} else {
					$bios .= $bio;
				}
			}
		}

		if ( ! empty( $bios ) ) {
			echo $args['before_widget'];

			foreach( $authors as $author_obj ) {
				$context = array('author_obj' => $author_obj); ?>

					<div class="author-box row-fluid author vcard clearfix">
						<?php largo_render_template( 'partials/author-bio', 'description', $context ); ?>
						<?php largo_render_template( 'partials/author-bio', 'social-links', $context ); ?>
					</div>
			<?php }

			echo $args['after_widget'];
		}
	}

	/*
	 * Widget update function: sanitizes title.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}

	/*
	 * This widget has no configuration
	 */
	function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'largo' );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'largo' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}

	/**
	 * Output the user email on the social media buttons
	 */
	static public function author_maybe_email( $author_obj ) {
		$email = $author_obj->user_email;

		/*
		 * Make whether to show the author's email address filterable, defaulting to not show
		 *
		 * Since this filter has 2 parameters, you'll need to set the fourth argument
		 * on add_action to `2` even if you're just blanket enabling the filter.
		 *
		 * You may also want to register a user profile checkbox that enables or disables
		 * display of email for this particular user.
		 *
		 * @see https://developer.wordpress.org/reference/functions/add_action/
		 * @since 1.0
		 * @param bool $whether Whether to show the email address
		 * @param int $author_id The ID of the author whose email address we are considering
		 */
		$show_email = apply_filters( 'largo_author_maybe_email', false, $author_obj->ID );

		if ( $email && $show_email  ) { ?>
			<li class="email">
				<a class="email" href="mailto:<?php echo esc_attr( $email ); ?>" title="e-mail <?php echo esc_attr( $author_obj->display_name ); ?>"><i class="icon-mail"></i></a>
			</li>
		<?php }
	}

	/**
	 * Output the user archive link on the social media buttons
	 */
	static public function author_maybe_posts_url( $author_obj ) {
		if ( !is_author() ) {
			printf(
				__( '<li class="author-posts-link"><a class="url" href="%1$s" rel="author" title="See all posts by %2$s">More by %2$s</a></li>', 'largo' ),
				get_author_posts_url( $author_obj->ID, $author_obj->user_nicename ),
				!empty( $author_obj->first_name ) ? esc_attr( $author_obj->first_name ) : __("this author", 'largo')
			);
		}
	}
}


// putting these outside the widget so that they apply even when the widget is not being loaded
add_action( 'largo_author_bio_social_links', 'largo_author_widget::author_maybe_posts_url', 99, 1 );
add_action( 'largo_author_bio_social_links', 'largo_author_widget::author_maybe_email', 20, 1 );
