<?php
/**
 * Plugin Name: ButterBean Example
 * Plugin URI:  https://github.com/justintadlock/butterbean
 * Description: Example plugin using ButterBean.  Adds a manager to the edit page screen.
 * Version:     1.0.0
 * Author:      Justin Tadlock
 * Author URI:  http://themehybrid.com
 *
 * @package    ButterBeanExample
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2016, Justin Tadlock
 * @link       https://github.com/justintadlock/butterbean
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

if ( ! class_exists( 'ButterBean_Example' ) ) {

	/**
	 * Main ButterBean class.  Runs the show.
	 *
	 * @since  1.0.0
	 * @access public
	 */
	final class ButterBean_Example {

		/**
		 * Sets up initial actions.
		 *
		 * @since  1.0.0
		 * @access private
		 * @return void
		 */
		private function setup_actions() {

			// Register managers, sections, settings, and controls.
			// I'm separating these out into their own methods so that the code
			// is cleaner and easier to follow.  This is just an example, so feel
			// free to experiment.
			add_action( 'butterbean_register', array( $this, 'register_managers' ), 10, 2 );
			add_action( 'butterbean_register', array( $this, 'register_sections' ), 10, 2 );
			add_action( 'butterbean_register', array( $this, 'register_settings' ), 10, 2 );
			add_action( 'butterbean_register', array( $this, 'register_controls' ), 10, 2 );
		}

		/**
		 * Registers managers.  In this example, we're registering a single manager.
		 * A manager is essentially our "tabbed meta box".  It needs to have
		 * sections and controls added to it.
		 *
		 * @since  1.0.0
		 * @access public
		 * @param  object  $butterbean  Instance of the `ButterBean` object.
		 * @param  string  $post_type
		 * @return void
		 */
		public function register_managers( $butterbean, $post_type ) {

			if ( 'page' !== $post_type )
				return;

			$butterbean->register_manager(
				'bbe_example',
				array(
					'label'     => 'ButterBean Example',
					'post_type' => array( 'post', 'page' ),
					'context'   => 'normal',
					'priority'  => 'high'
				)
			);
		}

		/**
		 * Registers sections.
		 *
		 * @since  1.0.0
		 * @access public
		 * @param  object  $butterbean  Instance of the `ButterBean` object.
		 * @param  string  $post_type
		 * @return void
		 */
		public function register_sections( $butterbean, $post_type ) {

			if ( 'page' !== $post_type )
				return;

			// Gets the manager object we want to add sections to.
			$manager = $butterbean->get_manager( 'bbe_example' );

			$manager->register_section(
				'bbe_text_fields',
				array(
					'label' => 'Text Fields',
					'icon'  => 'dashicons-edit'
				)
			);

			$manager->register_section(
				'bbe_common_fields',
				array(
					'label' => 'Common Fields',
					'icon'  => 'dashicons-admin-generic'
				)
			);

			$manager->register_section(
				'bbe_color_fields',
				array(
					'label' => 'Color Fields',
					'icon'  => 'dashicons-art'
				)
			);

			$manager->register_section(
				'bbe_radio_fields',
				array(
					'label' => 'Radio Fields',
					'icon'  => 'dashicons-carrot'
				)
			);

			$manager->register_section(
				'bbe_special_fields',
				array(
					'label' => 'Special Fields',
					'icon'  => 'dashicons-star-filled'
				)
			);
		}

		/**
		 * Registers settings.
		 *
		 * @since  1.0.0
		 * @access public
		 * @param  object  $butterbean  Instance of the `ButterBean` object.
		 * @param  string  $post_type
		 * @return void
		 */
		public function register_settings( $butterbean, $post_type ) {

			if ( 'page' !== $post_type )
				return;

			// Gets the manager object we want to add settings to.
			$manager = $butterbean->get_manager( 'bbe_example' );

			// Text field setting.
			$manager->register_setting(
				'bbe_text_a',
				array( 'sanitize_callback' => 'wp_filter_nohtml_kses', 'default' => 'yay' )
			);

			// Textarea setting.
			$manager->register_setting(
				'bbe_textarea_a',
				array( 'sanitize_callback' => 'wp_kses_post', 'default' => 'Hello world' )
			);

			// Checkbox setting.
			$manager->register_setting(
				'bbe_checkbox_a',
				array( 'sanitize_callback' => 'butterbean_validate_boolean' )
			);

			// Multiple checkboxes array.
			$manager->register_setting(
				'bbe_checkboxes_a',
				array( 'type' => 'array', 'sanitize_callback' => 'sanitize_key' )
			);

			// Radio input.
			$manager->register_setting(
				'bbe_radio_a',
				array( 'sanitize_callback' => 'sanitize_key' )
			);

			// Radio image.
			$manager->register_setting(
				'bbe_radio_image_a',
				array( 'sanitize_callback' => 'sanitize_key', 'default' => 'planet-burst' )
			);

			// Select input.
			$manager->register_setting(
				'bbe_select_a',
				array( 'sanitize_callback' => 'sanitize_key' )
			);

			// Datetime.  Note the `datetime` setting type sanitizes on its own.
			$manager->register_setting(
				'bbe_date_a',
				array( 'type' => 'datetime' )
			);

			// Color picker setting.
			$manager->register_setting(
				'bbe_color_a',
				array( 'sanitize_callback' => 'sanitize_hex_color_no_hash', 'default' => '#232323' )
			);

			// Color palette.
			$manager->register_setting(
				'bbe_palette_a',
				array( 'sanitize_callback' => 'sanitize_key' )
			);

			// Image upload.
			$manager->register_setting(
				'bbe_image_a',
				array( 'sanitize_callback' => array( $this, 'sanitize_absint' ) )
			);

			// Multiple avatars.
			$manager->register_setting(
				'bbe_multiavatars_a',
				array(
					'type'              => 'array',
					'sanitize_callback' => array( $this, 'sanitize_absint' )
				)
			);
		}

		/**
		 * Registers controls.
		 *
		 * @since  1.0.0
		 * @access public
		 * @param  object  $butterbean  Instance of the `ButterBean` object.
		 * @param  string  $post_type
		 * @return void
		 */
		public function register_controls( $butterbean, $post_type ) {

			if ( 'page' !== $post_type )
				return;

			// Gets the manager object we want to add controls to.
			$manager = $butterbean->get_manager( 'bbe_example' );

			// Basic text input control (the default).
			$manager->register_control(
				'bbe_text_a',
				array(
					'type'        => 'text',
					'section'     => 'bbe_text_fields',
					'attr'        => array( 'class' => 'widefat' ),
					'label'       => 'Example Text',
					'description' => 'Example description.'
				)
			);

			// Textarea control.
			$manager->register_control(
				'bbe_textarea_a',
				array(
					'type'        => 'textarea',
					'section'     => 'bbe_text_fields',
					'attr'        => array( 'class' => 'widefat' ),
					'label'       => 'Example Textarea',
					'description' => 'Example description.'
				)
			);

			// Single boolean checkbox.
			$manager->register_control(
				'bbe_checkbox_a',
				array(
					'type'        => 'checkbox',
					'section'     => 'bbe_common_fields',
					'label'       => 'Example Checkbox',
					'description' => 'Example description.'
				)
			);

			// Multiple checkboxes.
			$manager->register_control(
				'bbe_checkboxes_a',
				array(
					'type'        => 'checkboxes',
					'section'     => 'bbe_common_fields',
					'label'       => 'Example Checkbox',
					'description' => 'Example description.',
					'choices'     => array(
						'choice_d' => 'Choice D',
						'choice_e' => 'Choice E',
						'choice_f' => 'Choice F',
					)
				)
			);

			// Radio input fields.
			$manager->register_control(
				'bbe_radio_a',
				array(
					'type'        => 'radio',
					'section'     => 'bbe_radio_fields',
					'label'       => 'Example Radio',
					'description' => 'Example description.',
					'choices'     => array(
						''         => 'None',
						'choice_a' => 'Choice A',
						'choice_b' => 'Choice B',
						'choice_c' => 'Choice C',
					)
				)
			);

			// Select control.
			$manager->register_control(
				'bbe_select_a',
				array(
					'type'        => 'select',
					'section'     => 'bbe_common_fields',
					'label'       => 'Example Select',
					'description' => 'Example description.',
					'choices'     => array(
						''         => '',
						'choice_x' => 'Choice X',
						'choice_y' => 'Choice Y',
						'choice_z' => 'Choice Z'
					)
				)
			);

			// Select control with optgroup.
			$manager->register_control(
				'bbe_select_b',
				array(
					'type'        => 'select-group',
					'section'     => 'bbe_common_fields',
					'label'       => 'Example Select B',
					'description' => 'Example description.',
					'choices'  => array(
						'' => '',
						array(
							'label' => 'Citrus',
							'choices' => array(
								'grapefruit' => 'Grapefruit',
								'lemon'      => 'Lemon',
								'lime'       => 'Lime',
								'orange'     => 'Orange',
							)
						),
						array(
							'label'   => 'Melons',
							'choices' => array(
								'banana-melon' => 'Banana',
								'cantaloupe'   => 'Cantaloupe',
								'honeydew'     => 'Honeydew',
								'watermelon'   => 'Watermelon'
							)
						)
					)
				)
			);

			// Color picker control.
			$manager->register_control(
				'bbe_color_a',
				array(
					'type'        => 'color',
					'section'     => 'bbe_color_fields',
					'label'       => 'Pick a color',
					'description' => 'Example description.'
				)
			);

			// Color palette control.
			$manager->register_control(
				'bbe_palette_a',
				array(
					'type'        => 'palette',
					'section'     => 'bbe_color_fields',
					'label'       => 'Pick a color palette',
					'description' => 'Example description.',
					'choices'     => array(
						'cilantro' => array(
							'label'  => 'Cilantro',
							'colors' => array( '99ce15', '389113', 'BDE066', 'DB412C' )
						),
						'quench' => array(
							'label'  => 'Quench',
							'colors' => array( '#ffffff', '#7cc7dc', '#60A4B9', '#a07096' )
						),
						'cloudy-days' => array(
							'label'  => 'Cloudy Days',
							'colors' => array( '#E2735F', '#eaa16e', '#FBDF8B', '#ffe249' )
						)
					)
				)
			);

			// Radio image control.

			$uri = trailingslashit( plugin_dir_url(  __FILE__ ) );

			$manager->register_control(
				'bbe_radio_image_a',
				array(
					'type'        => 'radio-image',
					'section'     => 'bbe_radio_fields',
					'label'       => 'Example Radio Image',
					'description' => 'Example description.',
					'choices' => array(
						'horizon' => array(
							'url'   => $uri . 'images/horizon-thumb.jpg',
							'label' => 'Horizon'
						),
						'orange-burn' => array(
							'url'   => $uri . 'images/orange-burn-thumb.jpg',
							'label' => 'Orange Burn'
						),
						'planet-burst' => array(
							'url'   => $uri . 'images/planet-burst-thumb.jpg',
							'label' => 'Planet Burst'
						),
						'planets-blue' => array(
							'url'   => $uri . 'images/planets-blue-thumb.jpg',
							'label' => 'Blue Planets'
						),
						'space-splatters' => array(
							'url'   => $uri . 'images/space-splatters-thumb.jpg',
							'label' => 'Space Splatters'
						)
					)
				)
			);

			// Image upload control.
			$manager->register_control(
				'bbe_image_a',
				array(
					'type'        => 'image',
					'section'     => 'bbe_special_fields',
					'label'       => 'Example Image',
					'description' => 'Example description.',
					'size'        => 'thumbnail'
				)
			);

			// Datetime control.
			$manager->register_control(
				'bbe_date_a',
				array(
					'type'        => 'datetime',
					'section'     => 'bbe_special_fields',
					'label'       => 'Example Date',
					'description' => 'Example description.'
				)
			);

			// Multi-avatars user radio control.
			$manager->register_control(
				'bbe_multiavatars_a',
				array(
					'type'        => 'multi-avatars',
					'section'     => 'bbe_special_fields',
					'label'       => 'Example Multi Avatars',
					'description' => 'Example description.',
				)
			);
		}

		/**
		 * Sanitize function for integers.
		 *
		 * @since  1.0.0
		 * @access public
		 * @param  int     $value
		 * @return int|string
		 */
		public function sanitize_absint( $value ) {

			return $value && is_numeric( $value ) ? absint( $value ) : '';
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @access public
		 * @return object
		 */
		public static function get_instance() {

			static $instance = null;

			if ( is_null( $instance ) ) {
				$instance = new self;
				$instance->setup_actions();
			}

			return $instance;
		}

		/**
		 * Constructor method.
		 *
		 * @since  1.0.0
		 * @access private
		 * @return void
		 */
		private function __construct() {}
	}

	ButterBean_Example::get_instance();
}
