<?php
/*
 * Largo Follow Widget
 *
 * @package Largo
 */
class largo_follow_widget extends WP_Widget {

	function __construct() {
		/* Widget settings. */
		$widget_ops = array(
			'classname' 	=> 'largo-follow',
			'description' 	=> __('Display links to social media sites set in Largo theme options', 'largo'),
		);

		/* Create the widget. */
		parent::__construct( 'largo-follow-widget', __('Largo Follow', 'largo'), $widget_ops );
	}

	function widget( $args, $instance ) {

		$title = apply_filters('widget_title',  $instance['title'], $instance, $this->id_base);

		echo $args['before_widget'];

		if ( is_single() && isset($args['id']) && $args['id'] == 'article-bottom' ) {
			// display the post social bar
			largo_post_social_links();
		} else {
			// Display the widget title if one was input
			if ( $title ) echo $args['before_title'] . $title . $args['after_title'];
			
			// Display the usual buttons and whatnot
			$networks = array(
				'facebook'  => __( 'Like Us on Facebook', 'largo' ),
				'twitter'   => __( 'Follow Us on Twitter', 'largo' ),
				'youtube'   => __( 'Follow Us on YouTube', 'largo' ),
				'instagram' => __( 'Follow Us on Instagram', 'largo' ),
				'linkedin'  => __( 'Find Us on LinkedIn', 'largo' ),
				'tumblr'    => __( 'Follow us on Tumblr', 'largo' ),
				'pinterest' => __( 'Follow us on Pinterest', 'largo' ),
				'github'    => __( 'Find Us on GitHub', 'largo' ),
				'flickr'    => __( 'Follow Us on Flickr', 'largo' ),
				'rss'       => __( 'Subscribe via RSS', 'largo' ),
			);
			$networks = apply_filters( 'largo_additional_networks', $networks );

			foreach ( $networks as $network => $btn_text ) {
				if ( $network == 'rss' ) {
					$link = of_get_option( 'rss_link' ) ? esc_url( of_get_option( 'rss_link' ) ) : get_feed_link();
				} else {
					$link = esc_url( of_get_option( $network . '_link' ) );
				}

				if ( ! empty( $link ) ) {
					printf(
						'<a class="%1$s subscribe btn social-btn" href="%2$s"><i class="icon-%1$s"></i>%3$s</a>',
						esc_attr( $network ),
						esc_attr( $link ),
						esc_html( $btn_text )
					);
				}
			}
		}

		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		return $instance;
	}

	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array(
			'title' => sprintf(
				// translators: %s is the site's name
				__('Follow %s', 'largo'),
				get_bloginfo('name')
			)
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e('Title', 'largo'); ?>:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" style="width:90%;" />
		</p>

	<?php
	}
}
