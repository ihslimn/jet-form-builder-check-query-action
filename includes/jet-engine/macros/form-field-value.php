<?php

namespace JFB_Check_Query_Action\JetEngine\Macros;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die();
}

class Form_Field_Value extends \Jet_Engine_Base_Macros {

	public function macros_tag() {
		return 'check_query_form_field_value';
	}

	public function macros_name() {
		return 'JFB Check Query - Form Field Value';
	}

	public function macros_args() {
		return array(
			'field_name'    => array(
				'label'   => 'Field name',
				'type'    => 'text',
				'default' => '',
			),
		);
	}

	public function macros_callback( $args = array() ) {

		$field_name = ! empty( $args['field_name'] ) ? $args['field_name'] : null;

		if ( ! $field_name ) {
			return '';
		}

		$field_values = jet_fb_request_handler()->get_request();

		if ( empty( $field_values ) ) {
			return '';
		}

		$result = $field_values[ $field_name ] ?? '';

		if ( is_array( $result ) && is_scalar( array_values( $result )[0] ) ) {
			$result = implode( ',', $result );
		}

		if ( ! is_scalar( $result ) ) {
			$result = '';
		}

		return $result;

	}
	
}
