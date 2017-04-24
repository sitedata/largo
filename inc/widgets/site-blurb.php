<?php
/**
 * Site Blurb Widget
 *
 * @package Largo
 * @since Largo 1.0
 */
class largo_site_blurb extends WP_Widget {

	/*
	 * Set up the widget
	 */
	function __construct() {
		$widget_ops = array(
			'classname' 	=> 'largo-site-blurb',
			'description'	=> __('Show the site blurb in a widget', 'largo')
		);
		parent::__construct( 'largo-site-blurb', __( 'Site Blurb (Largo)', 'largo' ), $widget_ops );
	}

	/*
	 * Render the widget output
	 */
	function widget( $args, $instance ) {

		global $post;
		$author_id = $post->post_author;

		$output = '';

		echo $args['before_widget'];

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

		echo '<div class="site-blurb">';

			$output = get_option( 'site_blurb' ) ? stripslashes( get_option( 'site_blurb' ) ) : '';

			apply_filters( 'largo_site_blurb_widget', $output );
			echo $output;

		echo '</div>';

		echo $args['after_widget'];

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
