<?php
/**
 * Plugin Name: ButterBean Example
 * Plugin URI:  https://github.com/justintadlock/butterbean
 * Description: Example plugin using ButterBean.  Adds a manager to the edit page screen.
 * Version:     1.0.0-dev
 * Author:      Justin Tadlock
 * Author URI:  http://themehybrid.com
 *
 * @package    ButterBeanExample
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2015-2016, Justin Tadlock
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

			// Call the register function.
			add_action( 'butterbean_register', array( $this, 'register' ), 10, 2 );
		}

		public function register( $butterbean, $post_type ) {

			if ( 'page' !== $post_type )
				return;

			/* === Register Managers === */

			$butterbean->register_manager(
				'bbe_example',
				array(
					'label'     => 'ButterBean Example:',
					'post_type' => 'page',
					'context'   => 'normal',
					'priority'  => 'high'
				)
			);

			$manager = $butterbean->get_manager( 'bbe_example' );

			/* === Register Sections === */

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
				'bbe_special_fields',
				array(
					'label' => 'Special Fields',
					'icon'  => 'dashicons-star-filled'
				)
			);

			/* === Register Controls === */

			$manager->register_control(
				new ButterBean_Control_Text(
					$manager,
					'bbe_text_a',
					array(
						'section'     => 'bbe_text_fields',
						'attr'        => array( 'class' => 'widefat' ),
						'label'       => 'Example Text',
						'description' => 'Example description.'
					)
				)
			);

			$manager->register_control(
				new ButterBean_Control_Textarea(
					$manager,
					'bbe_textarea_a',
					array(
						'section'     => 'bbe_text_fields',
						'attr'        => array( 'class' => 'widefat' ),
						'label'       => 'Example Textarea',
						'description' => 'Example description.'
					)
				)
			);

			$manager->register_control(
				new ButterBean_Control_Checkbox(
					$manager,
					'bbe_checkbox_a',
					array(
						'section'     => 'bbe_common_fields',
						'label'       => 'Example Checkbox',
						'description' => 'Example description.'
					)
				)
			);

			$manager->register_control(
				new ButterBean_Control_Radio(
					$manager,
					'bbe_radio_a',
					array(
						'section'     => 'bbe_common_fields',
						'label'       => 'Example Radio',
						'description' => 'Example description.',
						'choices'     => array(
							''         => 'None',
							'choice_a' => 'Choice A',
							'choice_b' => 'Choice B',
							'choice_c' => 'Choice C',
						)
					)
				)
			);

			$manager->register_control(
				new ButterBean_Control_Select(
					$manager,
					'bbe_select_a',
					array(
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
				)
			);

			$manager->register_control(
				new ButterBean_Control_Date(
					$manager,
					'bbe_date_a',
					array(
						'section'     => 'bbe_special_fields',
						'label'       => 'Example Date',
						'description' => 'Example description.'
					)
				)
			);

			$manager->register_control(
				new ButterBean_Control_Multi_Avatars(
					$manager,
					'bbe_multiavatars_a',
					array(
						'section'     => 'bbe_special_fields',
						'label'       => 'Example Multi Avatars',
						'description' => 'Example description.',
					)
				)
			);

			/* === Register Settings === */

			$manager->register_setting(
				'bbe_text_a',
				array( 'sanitize_callback' => 'wp_filter_nohtml_kses' )
			);

			$manager->register_setting(
				'bbe_textarea_a',
				array( 'sanitize_callback' => 'wp_kses_post' )
			);

			$manager->register_setting(
				'bbe_checkbox_a',
				array( 'sanitize_callback' => 'butterbean_validate_boolean' )
			);

			$manager->register_setting(
				'bbe_radio_a',
				array( 'sanitize_callback' => 'sanitize_key' )
			);

			$manager->register_setting(
				'bbe_select_a',
				array( 'sanitize_callback' => 'sanitize_key' )
			);

			$manager->register_setting(
				new ButterBean_Setting_Date(
					$manager,
					'bbe_date_a'
				)
			);

			$manager->register_setting(
				new ButterBean_Setting_Array(
					$manager,
					'bbe_multiavatars_a',
					array( 'sanitize_callback' => 'absint' )
				)
			);
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
