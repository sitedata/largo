<?php
/**
 * Enable multiple WYSIWYG editors in the theme customizer.
 *
 * @package Largo
 */

if ( class_exists( 'WP_Customize_Control' ) ) :

	/**
	 * Class to create a custom text editor control
	 */
	class _Radio_Button_Custom_Control extends WP_Customize_Control {

		public $type = 'radio';

		/**
		 * Render the content on the theme customizer page
		 */
		public function render_content() {
			?>

			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>

			<div class="radiobutton">
			<?php foreach( $this->choices as $key => $choice ) : ?>
				<label>
					<input type="radio" value="<?php echo $key; ?>" name="_customize-radio-largo_homepage_layout_settings" data-customize-setting-link="largo_homepage_layout_settings"<?php checked( $key, $this->link ); ?>>
					<?php echo $choice; ?><br>
				</label>
			<?php endforeach; ?>
			</div>
			<script>
				jQuery( document ).ready(function($) {
					$( ".radiobutton" ).buttonset();
				});
			</script>
			<?php
		}
	}
endif;
