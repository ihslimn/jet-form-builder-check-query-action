<?php

namespace JFB_Check_Query_Action;

if ( ! defined( 'WPINC' ) ) {
	die();
}

class Plugin {
	/**
	 * Instance.
	 *
	 * Holds the plugin instance.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @var Plugin
	 */
	public static $instance = null;

	private string $path = '';

	private string $url = '';

	public $slug = 'jfb-check-query-action';

	public function set_path( $path ) {
		if ( ! $this->path ) {
			$this->path = $path;
		}
	}

	public function set_url( $url ) {
		if ( ! $this->url ) {
			$this->url = $url;
		}
	}

	public function plugin_path( $path = '' ) {
		return $this->path . $path;
	}

	public function plugin_url( $url = '' ) {
		return $this->url . $url;
	}

	public function init_components() {

		require $this->plugin_path( 'includes/jet-form-builder/actions/check-query.php' );
		Jet_Form_Builder\Actions\Check_Query::register();
		require $this->plugin_path( 'includes/jet-form-builder/actions/get-values-from-query.php' );
		Jet_Form_Builder\Actions\Get_Query_Values::register();

		add_action( 'jet-engine/register-macros', array( $this, 'register_macros' ) );

	}

	public function register_macros() {

		require_once $this->plugin_path( 'includes/jet-engine/macros/form-field-value.php' );

		new JetEngine\Macros\Form_Field_Value();

	}

	public function get_version() {
		return '1.1.0';
	}

	/**
	 * Instance.
	 *
	 * Ensures only one instance of the plugin class is loaded or can be loaded.
	 *
	 * @return Plugin An instance of the class.
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}

Plugin::instance();
