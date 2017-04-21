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

		if ( ! empty( $bios ) ) {
			echo $args['before_widget'];

			foreach( $authors as $author_obj ) {

				echo '<div class="author-box row-fluid author vcard clearfix">';

				// Author name
				printf( __( '<h3 class="widgettitle">About <span class="fn n"><a class="url" href="%1$s" rel="author" title="See all posts by %2$s">%2$s</a></span></h3>', 'largo' ),
					get_author_posts_url( $author_obj->ID, $author_obj->user_nicename ),
					esc_attr( $author_obj->display_name )
				);

				// Guest Author's set profile icon overrides any gravatar
				if ( $author_obj->type == 'guest-author' && get_the_post_thumbnail( $author_obj->ID ) ) {
					// Co-Authors Plus Guest Authors are posts
					$photo = get_the_post_thumbnail( $author_obj->ID, array( 96,96 ) );
					$photo = str_replace( 'attachment-96x96 wp-post-image', 'avatar avatar-96 photo', $photo );
					echo '<div class="photo">' . $photo . '</div>';
				} else if ( get_avatar_url( $author_obj->user_email ) ) {
					echo '<div class="photo">' . get_avatar( $author_obj->ID, 96, '', $author_obj->display_name ) . '</div>';
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

				echo '</div>';
			}

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
}
