<?php
/**
 * Customize API: WP_Customize_Color_Control class
 *
 * @package WordPress
 * @subpackage Customize
 * @since 4.4.0
 */

/**
 * Customize Color Control class.
 *
 * @since 3.4.0
 *
 * @see WP_Customize_Control
 */
class Radio_Button_Custom_Control extends WP_Customize_Control {
	/**
	 * Type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'radiobutton';

	/**
	 * Statuses.
	 *
	 * @access public
	 * @var array
	 */
	public $statuses;

	/**
	 * Mode.
	 *
	 * @since 4.7.0
	 * @access public
	 * @var string
	 */
	public $mode = 'full';

	/**
	 * Constructor.
	 *
	 * @since 3.4.0
	 * @uses WP_Customize_Control::__construct()
	 *
	 * @param WP_Customize_Manager $manager Customizer bootstrap instance.
	 * @param string               $id      Control ID.
	 * @param array                $args    Optional. Arguments to override class property defaults.
	 */
	public function __construct( $manager, $id, $args = array() ) {
		$this->statuses = array( '' => __('Default') );
		parent::__construct( $manager, $id, $args );
	}

	/**
	 * Enqueue scripts/styles for the color picker.
	 *
	 * @since 3.4.0
	 */
	public function enqueue() {
		if ( 'buttonset' === $this->mode || 'image' === $this->mode ) {
			wp_enqueue_script( 'jquery-ui-button' );
		}
	}

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @since 3.4.0
	 * @uses WP_Customize_Control::to_json()
	 */
	public function to_json() {
		parent::to_json();

		$this->json['choices'] = $this->choices;
		$this->json['link']    = $this->get_link();
		$this->json['value']   = $this->value();
		$this->json['id']      = $this->id;
	}

	/**
	 * Don't render the control content from PHP, as it's rendered via JS on load.
	 *
	 * @since 3.4.0
	 */
	public function render_content() {}

	/**
	 * Render a JS template for the content of the color picker control.
	 *
	 * @since 4.1.0
	 */
	 // @TODO see https://www.nosegraze.com/image-select-control-wordpress-customizer/
	public function content_template() {
		?>
		<# if ( ! data.choices ) {
			return;
		} #>

		<# if (data.label) { #>
			<span class="customize-control-title">{{ data.label }}</span>
		<# } #>
		<# if (data.description) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>

		<div id="input_{{ data.id }}" class="radiobutton">
			<# for (key in data.choices) { #>
				<input id="{{ data.id }}{{ key }}" type="radio" value="{{ key }}" data-customize-setting-link="largo_homepage_layout_settings" {{{ data.link }}}<# if (key === data.value) { #> checked="checked" <# } #> />
				<label for="{{ data.id }}{{ key }}">{{ data.choices[ key ] }}</label>
			<# } #>

		</div>
		<?php
	}
}
