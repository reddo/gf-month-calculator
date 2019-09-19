<?php

GFForms::include_addon_framework();

class GFMonthCalculatorFieldAddOn extends GFAddOn {

	protected $_version = GF_SIMPLE_FIELD_ADDON_VERSION;
	protected $_min_gravityforms_version = '1.9';
	protected $_slug = 'gf-month-calculator';
	protected $_path = 'gf-month-calculator/gf-month-calculator.php';
	protected $_full_path = __FILE__;
	protected $_title = 'Gravity Forms Month Calculator Field Add-On';
	protected $_short_title = 'Month Calculator Field Add-On';

	/**
	 * @var object $_instance If available, contains an instance of this class.
	 */
	private static $_instance = null;

	/**
	 * Returns an instance of this class, and stores it in the $_instance property.
	 *
	 * @return object $_instance An instance of this class.
	 */
	public static function get_instance() {
		if ( self::$_instance == null ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Include the field early so it is available when entry exports are being performed.
	 */
	public function pre_init() {
		parent::pre_init();

		if ( $this->is_gravityforms_supported() && class_exists( 'GF_Field' ) ) {
			require_once( 'includes/class-month-calculator-gf-field.php' );
		}
	}

	public function init_admin() {
		parent::init_admin();

		add_filter( 'gform_tooltips', array( $this, 'tooltips' ) );
		add_action( 'gform_field_appearance_settings', array( $this, 'field_appearance_settings' ), 10, 2 );
	}


	// # SCRIPTS & STYLES -----------------------------------------------------------------------------------------------

	/**
	 * Include month-calculator-script.js when the form contains a 'month-calculator' type field.
	 *
	 * @return array
	 */
	public function scripts() {
		$scripts = array(
			array(
				'handle'  => 'month_calculator_script_js',
				'src'     => $this->get_base_url() . '/js/month-calculator-script.js',
				'version' => $this->_version,
				'deps'    => array( 'jquery' ),
				'enqueue' => array(
					array( 'field_types' => array( 'month-calculator' ) ),
				),
			),

		);

		return array_merge( parent::scripts(), $scripts );
	}

	/**
	 * Include month-calculator-styles.css when the form contains a 'month-calculator' type field.
	 *
	 * @return array
	 */
	public function styles() {
		$styles = array(
			array(
				'handle'  => 'my_styles_css',
				'src'     => $this->get_base_url() . '/css/month-calculator-styles.css',
				'version' => $this->_version,
				'enqueue' => array(
					array( 'field_types' => array( 'month-calculator' ) )
				)
			)
		);

		return array_merge( parent::styles(), $styles );
	}


	// # FIELD SETTINGS -------------------------------------------------------------------------------------------------

	/**
	 * Add the tooltips for the field.
	 *
	 * @param array $tooltips An associative array of tooltips where the key is the tooltip name and the value is the tooltip.
	 *
	 * @return array
	 */
	public function tooltips( $tooltips ) {
		$simple_tooltips = array(
			'input_class_setting' => sprintf( '<h6>%s</h6>%s', esc_html__( 'Input CSS Classes', 'gf-month-calculator' ), esc_html__( 'The CSS Class names to be added to the field input.', 'gf-month-calculator' ) ),
		);

		return array_merge( $tooltips, $simple_tooltips );
	}

	/**
	 * Add the custom setting for the Month Calculator field to the Appearance tab.
	 *
	 * @param int $position The position the settings should be located at.
	 * @param int $form_id The ID of the form currently being edited.
	 */
	public function field_appearance_settings( $position, $form_id ) {
		// Add our custom setting just before the 'Custom CSS Class' setting.
		if ( $position == 250 ) {
			?>
			<li class="input_class_setting field_setting">
				<label for="input_class_setting">
					<?php esc_html_e( 'Input CSS Classes', 'gf-month-calculator' ); ?>
					<?php gform_tooltip( 'input_class_setting' ) ?>
				</label>
				<input id="input_class_setting" type="text" class="fieldwidth-1" onkeyup="SetInputClassSetting(jQuery(this).val());" onchange="SetInputClassSetting(jQuery(this).val());"/>
			</li>

			<?php
		}
	}

}