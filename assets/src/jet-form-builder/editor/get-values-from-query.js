const {
		  TextControl,
		  SelectControl,
		  ToggleControl,
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
		<TextControl
			label={ label( 'count_to' ) }
			help={ label( 'count_to_description' ) }
			value={ settings.count_to }
			onChange={ newVal => onChangeSetting( newVal, 'count_to' ) }
		/>
		<ToggleControl
			label={ label( 'get_one' ) }
			checked={ settings.get_one ?? false }
			onChange={ newVal => onChangeSetting( newVal, 'get_one' ) }
		/>
		{
			settings.get_one && 
			<TextControl
				label={ label( 'property' ) }
				value={ settings.property }
				onChange={ newVal => onChangeSetting( newVal, 'property' ) }
			/>
		}
	</>;
} );
