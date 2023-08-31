const {
		  TextControl,
		  ToggleControl,
		  SelectControl,
	  } = wp.components;

const {
		  addAction,
	  } = JetFBActions;

addAction( 'jfbc_check_query', function CheckQueryAction( {
											   settings,
											   label,
											   onChangeSetting,
										   } ) {

	return <>
		<SelectControl
            label={ label( 'query_id' ) }
            value={ settings.query_id }
            options={ JetEngineListingData.queriesList }
            onChange={ newVal => onChangeSetting( newVal, 'query_id' ) }
            __nextHasNoMarginBottom
        />
		<TextControl
			label={ label( 'error_message' ) }
			value={ settings.error_message }
			onChange={ newVal => onChangeSetting( newVal, 'error_message' ) }
		/>
		<ToggleControl
			label={ label( 'on_has_results' ) }
			help={
				settings.on_has_results
					? 'Form will throw an error if query has results.'
					: 'Form will throw an error if query has no results.'
			}
			checked={ settings.on_has_results }
			onChange={ newVal => onChangeSetting( newVal, 'on_has_results' ) }
		/>
	</>;
} );
