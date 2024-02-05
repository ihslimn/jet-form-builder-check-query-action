<?php

namespace JFB_Check_Query_Action\Jet_Form_Builder\Actions;

use JFB_Check_Query_Action\Plugin;
use Jet_Form_Builder\Actions\Manager;
use Jet_Form_Builder\Actions\Types\Base as ActionBase;
use Jet_Form_Builder\Actions\Action_Handler;
use Jet_Engine\Query_Builder\Manager as Queries;

class Check_Query extends ActionBase {

	public static function register() {
		$self = new self();

		add_action(
			'jet-form-builder/actions/register',
			array( $self, 'register_action' )
		);
		add_action(
			'jet-form-builder/editor-assets/before',
			array( $self, 'editor_assets' )
		);
	}

	public function register_action( Manager $manager ) {
		$manager->register_action_type( $this );
	}

	public function get_id() {
		return 'jfbc_check_query';
	}

	public function get_name() {
		return 'Check Query Result';
	}

	public function self_script_name() {
		return 'JFBCheckQueryResult';
	}

	public function editor_labels() {
		return array(
			'query_id'       => 'Query to check',
			'on_has_results' => 'Throw error if query has results',
			'error_message'  => 'Error message',
		);
	}

	public function visible_attributes_for_gateway_editor() {
		return array();
	}

	public function throw_error( $error_message ) {
		throw new \Jet_Form_Builder\Exceptions\Action_Exception( $error_message );
	}

	public function do_action( array $request, Action_Handler $handler ) {

		$query_id       = $this->settings['query_id'] ?? '';
		$on_has_results = $this->settings['on_has_results'] ?? false;
		$error_message  = $this->settings['error_message'] ?? 'You cannot submit this form.';

		$error_message = jet_fb_parse_macro( $error_message );

		$error_message = wp_strip_all_tags( $error_message );

		if ( ! $query_id && $on_has_results ) {
			$this->throw_error( $error_message );
		}

		$query = Queries::instance()->get_query_by_id( $query_id );

		$has_items = $query->has_items();

		if ( $on_has_results && $has_items ) {
			$this->throw_error( $error_message );
		} elseif ( ! $on_has_results && ! $has_items ) {
			$this->throw_error( $error_message );
		}

	}

	public function editor_assets() {
		wp_enqueue_script(
			Plugin::instance()->slug . '-editor',
			Plugin::instance()->plugin_url( 'assets/js/builder.editor.js' ),
			array(),
			Plugin::instance()->get_version(),
			true
		);
	}
}
