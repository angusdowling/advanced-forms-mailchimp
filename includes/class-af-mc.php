<?php
/**
 * AF_MC setup
 *
 * @package  AF_MC
 */

defined( 'ABSPATH' ) || exit;

/**
 * Main AF_MC Class.
 *
 * @class AF_MC
 */
final class AF_MC {

	/**
	 * AF_MC version.
	 *
	 * @var string
	 */
	public $version = '1.0.0';

	/**
	 * The single instance of the class.
	 *
	 * @var AF_MC
	 */
	protected static $_instance = null;

	/**
	 * Main AF_MC Instance.
	 *
	 * Ensures only one instance of AF_MC is loaded or can be loaded.
	 *
	 * @static
	 * @see afmc()
	 * @return AF_MC - Main instance.
	 * 
	 * @since 1.0.0
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * AF_MC Constructor.
	 */
	public function __construct() {
		$this->define_constants();
		$this->includes();

		do_action( 'af_mc_loaded' );
	}

	/**
	 * Define AFMC Constants.
	 * 
	 * @since 1.0.0
	 */
	private function define_constants() {
		$this->define( 'AFMC_ABSPATH', dirname( AFMC_PLUGIN_FILE ) . '/' );
		$this->define( 'AFMC_VERSION', $this->version );
	}

	/**
	 * Define constant if not already set.
	 *
	 * @param string      $name  Constant name.
	 * @param string|bool $value Constant value.
	 * 
	 * @since 1.0.0
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 * 
	 * @since 1.0.0
	 */
	public function includes() {
		include_once AFMC_ABSPATH . 'includes/admin/class-af-mc-admin.php';
		include_once AFMC_ABSPATH . 'includes/class-af-mc-register.php';
	}

	/**
	 * Get the plugin url.
	 *
	 * @return string
	 */
	public function plugin_url() {
		return untrailingslashit( plugins_url( '/', AFMC_PLUGIN_FILE ) );
	}

	/**
	 * Get the plugin path.
	 *
	 * @return string
	 */
	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( AFMC_PLUGIN_FILE ) );
	}

}