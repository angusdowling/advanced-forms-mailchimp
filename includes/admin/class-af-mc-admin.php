<?php
/**
 * Admin Fields
 *
 * @author      Angus Dowling
 * @category    Admin
 * @package     AFMC/Admin
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'AF_MC_Admin', false ) ) :

/**
 * AF_MC_Admin Class.
 */
class AF_MC_Admin {

	/**
	 * AF_MC_Admin Constructor.
	 */
	public function __construct() {
		$this->init_hooks();
	}

	/**
	 * Hook into actions and filters.
	 * 
	 * @since 1.0.0
	 */
	private function init_hooks() {
		// add_action( 'acf/render_field/type=text', array( $this, 'add_email_field_inserter' ), 20, 1 );
		add_filter( 'af/form/settings_fields', array($this, 'mc_dashboard'), 1, 10 );

		add_filter( 'acf/load_field/name=subscriber_email', array( $this, 'populate_email_field_choices' ), 10, 1 );
		add_filter( 'acf/load_field/name=subscriber_name', array( $this, 'populate_email_field_choices' ), 10, 1 );
	}

	/**
	 * Populates the email recipient field select with the current form's fields
	 *
	 * @since 1.0.0
	 *
	 */
	function populate_email_field_choices( $field ) {
		
		global $post;	
		
		if ( $post && 'af_form' == $post->post_type ) {
			
			$form_key = get_post_meta( $post->ID, 'form_key', true );
			
			$field['choices'] = _af_form_field_choices( $form_key, 'regular' );
			
		}
		
		return $field;
		
	}

	/**
	 * Add fields to dashboard
	 * 
	 * @since 1.0.0
	 */
	public function mc_dashboard($settings_field_group) {
		if( isset( $settings_field_group['fields'] ) ) {
			$fields = array(
				array (
					'key' => 'field_form_mailchimp_tab',
					'label' => '<span class="dashicons dashicons-email"></span>Mailchimp',
					'name' => '',
					'type' => 'tab',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'placement' => 'left',
					'endpoint' => 0,
				),
				array (
					'key'               => 'field_form_mailchimp_api_key',
					'label'             => 'API Key',
					'name'              => 'api_key',
					'type'              => 'text',
					'prefix'            => '',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '50%',
						'class' => '',
						'id'    => '',
					),
					'default_value' => '',
					'placeholder'   => '',
					'prepend'       => '',
					'append'        => '',
					'maxlength'     => '',
					'readonly'      => 0,
					'disabled'      => 0,
				),
				array (
					'key'               => 'field_form_mailchimp_list_id',
					'label'             => 'List ID',
					'name'              => 'list_id',
					'type'              => 'text',
					'prefix'            => '',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '50%',
						'class' => '',
						'id'    => '',
					),
					'default_value' => '',
					'placeholder'   => '',
					'prepend'       => '',
					'append'        => '',
					'maxlength'     => '',
					'readonly'      => 0,
					'disabled'      => 0,
				),
				array (
					'key' => 'field_form_mailchimp_subscriber_email',
					'label' => 'Subscriber Email',
					'name' => 'subscriber_email',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'wrapper' => array (
						'width' => '50%',
						'class' => '',
						'id' => '',
					),
					'choices' => array (
					),
					'default_value' => array (
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'ajax' => 0,
					'return_format' => 'value',
					'placeholder' => '',
				),
				array (
					'key' => 'field_form_mailchimp_subscriber_name',
					'label' => 'Subscriber Name',
					'name' => 'subscriber_name',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'wrapper' => array (
						'width' => '50%',
						'class' => '',
						'id' => '',
					),
					'choices' => array (
					),
					'default_value' => array (
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'ajax' => 0,
					'return_format' => 'value',
					'placeholder' => '',
				),
			);

			$settings_field_group['fields'] = array_merge( $settings_field_group['fields'], $fields );
		}

		return $settings_field_group;
	}

}

endif;

return new AF_MC_Admin();