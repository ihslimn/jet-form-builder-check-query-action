<?php

namespace JFB_Check_Query_Action\Jet_Form_Builder\Actions;

use JFB_Check_Query_Action\Plugin;
use Jet_Form_Builder\Actions\Manager;
use Jet_Form_Builder\Actions\Types\Base as ActionBase;
use Jet_Form_Builder\Actions\Action_Handler;
use Jet_Engine\Query_Builder\Manager as Queries;
use Jet_Form_Builder\Exceptions\Action_Exception;

class Get_Query_Values extends ActionBase {

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
		return 'jfbc_get_query_values';
	}

	public function get_name() {
		return 'Get Values From Query';
	}

	public function self_script_name() {
		return 'JFBGetQueryValues';
	}

	public function editor_labels() {
		return array(
			'query_id'             => 'Query to get values from',
			'store_to'             => 'Field to store results into',
			'get_one'              => 'Get single value',
			'property'             => 'Property to get value from',
			'count_to'             => 'Field to store query count into',
			'count_to_description' => 'Leave empty if no need to save count',
		);
	}

	public function visible_attributes_for_gateway_editor() {
		return array();
	}

	public function do_action( array $request, Action_Handler $handler ) {

		$query_id = $this->settings['query_id'] ?? '';

		if ( ! $query_id ) {
			throw new Action_Exception( 'No query ID provided' );
		}

		$store_to = $this->settings['store_to'] ?? '';

		if ( ! $store_to ) {
			throw new Action_Exception( 'Set the field to store query results to' );
		}

		$query = Queries::instance()->get_query_by_id( $query_id );

		if ( ! $query ) {
			throw new Action_Exception( 'Query not found' );
		}
		
		$items = $query->get_items();

		$get_one = $this->settings['get_one'] ?? false;

		if ( ! $get_one ) {

			$items = array_map( function( $item ) {

				$result = ( array ) $item;
	
				$result['_jfbc_item_id'] = jet_engine()->listings->data->get_current_object_id( $item );
	
				return $result;
	
			}, $items );
			
		} else {
			$property = $this->settings['property'] ?? '';
			$items    = $items[0]->$property ?? '';
		}

		if ( ! empty( $this->settings['count_to'] ) ) {
			jet_fb_context()->update_request( $query->get_items_total_count(), $this->settings['count_to'] );
		}

		jet_fb_context()->update_request( $items, $store_to );

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
