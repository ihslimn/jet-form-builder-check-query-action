<?php
/**
 * Plugin Name: JetFormBuilder - JetEngine Query Actions
 * Plugin URI:  https://crocoblock.com/
 * Description: Actions to get values from query and to check query results.
 * Version:     1.1.0
 * Author:      Crocoblock
 * Author URI:  https://crocoblock.com/
 * Text Domain: jet-forms-addon-boilerplate-simple
 * License:     GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die();
}

add_action( 'plugins_loaded', function() {

	if ( ! function_exists( 'jet_form_builder' ) || ! function_exists( 'jet_engine' ) ) {

		add_action( 'admin_notices', function() {
			$class = 'notice notice-error';
			$message = '<b>WARNING!</b> <b>JetFormBuilder - JetEngine Query Actions</b> plugin requires both <b>JetFormBuilder</b> and <b>JetEngine</b> plugins to be installed and activated.';
			printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), wp_kses_post( $message ) );
		} );

		return;

	}

	require trailingslashit( plugin_dir_path( __FILE__ ) ) . 'includes/plugin.php';

	\JFB_Check_Query_Action\Plugin::instance()->set_path( trailingslashit( plugin_dir_path( __FILE__ ) ) );
	\JFB_Check_Query_Action\Plugin::instance()->set_url( trailingslashit( plugins_url( '', __FILE__ ) ) );
	\JFB_Check_Query_Action\Plugin::instance()->init_components();

}, 100 );
