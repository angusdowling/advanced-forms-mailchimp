<?php
/**
 * Plugin Name: Advanced Forms Mailchimp
 * Description: Add-on for integrating mailchimp to Advanced Forms
 * Version: 1.0.0
 * Author: Angus Dowling
 *
 * Text Domain: advanced-forms-mailchimp
 *
 * @package AFMC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define AFMC_PLUGIN_FILE.
if ( ! defined( 'AFMC_PLUGIN_FILE' ) ) {
	define( 'AFMC_PLUGIN_FILE', __FILE__ );
}

// Include the main AF_MC class.
if ( ! class_exists( 'AF_MC' ) ) {
	include_once dirname( __FILE__ ) . '/includes/class-af-mc.php';
}

/**
 * Main instance of AF_MC.
 *
 * Returns the main instance of AF_MC to prevent the need to use globals.
 *
 * @return AF_MC
 */
function afmc() {
	return AF_MC::instance();
}

// Global for backwards compatibility.
$GLOBALS['af_mc'] = afmc();
