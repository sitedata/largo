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

		extract( $args );

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
			echo $before_widget;

			foreach( $authors as $author_obj ) {
				$context = array('author_obj' => $author_obj); ?>

					<div class="author-box row-fluid author vcard clearfix">
						<?php largo_render_template( 'partials/author-bio', 'description', $context ); ?>
						<?php largo_render_template( 'partials/author-bio', 'social-links', $context ); ?>
					</div>
			<?php }

			echo $after_widget;
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
