const {
		  TextControl,
		  SelectControl,
	  } = wp.components;

const {
		  addAction,
	  } = JetFBActions;

addAction( 'jfbc_get_query_values', function GetQueryValues( {
											   settings,
											   label,
											   onChangeSetting,
										   } ) {

	return <>
		<SelectControl
            label={ label( 'query_id' ) }
			labelPosition="side"
            value={ settings.query_id }
            options={ JetEngineListingData.queriesList }
            onChange={ newVal => onChangeSetting( newVal, 'query_id' ) }
            __nextHasNoMarginBottom
        />
		<TextControl
			label={ label( 'store_to' ) }
			value={ settings.store_to }
			onChange={ newVal => onChangeSetting( newVal, 'store_to' ) }
		/>
	</>;
} );
