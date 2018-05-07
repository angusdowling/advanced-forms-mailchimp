<?php
/**
 * Mailchimp Register
 *
 * @author      Angus Dowling
 * @category    Admin
 * @package     AFMC/Admin
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'AF_MC_Register', false ) ) :

/**
 * AF_MC_Register Class.
 */
class AF_MC_Register {

	/**
	 * AF_MC_Register Constructor.
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
		add_action('af/form/submission', array($this, 'mc_register'), 10, 3 );
	}

	/**
	 * Register user to mailchimp
	 * 
	 * @since 1.0.0
	 */
	public function mc_register( $form, $fields, $args ) {
		$api_key = get_field('field_form_mailchimp_api_key', $form['post_id']);
		$list_id = get_field('field_form_mailchimp_list_id', $form['post_id']);

		foreach( $fields as $field ) {
			if( $field['key'] == get_field('field_form_mailchimp_subscriber_email', $form['post_id']) ) {
				$email = $field['_input'];
			}

			if( $field['key'] == get_field('field_form_mailchimp_subscriber_name', $form['post_id']) ) {
				$name = $field['_input'];

				if( preg_match('/\s/', $name) ) {
					$name_split = explode(" ", $name);
					$fname = $name_split[0];
					$lname = end($name_split);
				}
			}
		}

		// Bail early
		if(!isset($email) ||
			!isset( $name ) ||
			empty($api_key) ||
			empty( $list_id ) ) {
			return false;
		}
		
		$auth    = base64_encode( 'user:'.$api_key );
		$region  = explode('-', $api_key)[1];
		$data    = json_encode(array(
			'apikey'        => $api_key,
			'email_address' => $email,
			'status'        => 'subscribed',
			'merge_fields'  => array(
				'FNAME' => isset($fname) ? $fname : $name,
				'LNAME' => isset($lname) ? $lname : ""
			)
		));

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://{$region}.api.mailchimp.com/3.0/lists/${list_id}/members");
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
			'Authorization: Basic '.$auth));
		curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);

		$result = curl_exec($ch);

		// TODO: Error handling, revalidation, cancelling of form submission
	}

}

endif;

return new AF_MC_Register();