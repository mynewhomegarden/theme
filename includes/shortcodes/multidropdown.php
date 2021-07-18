<?php
if( function_exists( 'vc_map' ) ){
	 vc_add_shortcode_param( 'multidropdown', 'reviews_multidropdown', get_template_directory_uri().'/js/multidropdown.js' );
}

function reviews_multidropdown( $settings, $value ) {
	$dependency = vc_generate_dependencies_attributes( $settings );

	$select_options = '';

	if( !empty( $settings['value'] ) ){

		foreach( $settings['value'] as $label => $key ){
			$select_options .= '<option value="'.esc_attr( $key ).'">'.$label.'</option>';
		}

	}

	return '
		<div class="multidropdown-param">
			<input type="hidden" name="'.esc_attr( $settings['param_name'] ).'" class="wpb_vc_param_value wpb-textinput '.esc_attr( $settings['param_name'] ).' '.esc_attr( $settings['type'] ).'_field" value="'.esc_attr( $value ).'" ' .esc_attr( $dependency). '/>
			<select name="'.esc_attr( $settings['param_name'] ).'[]" multiple>
				'.$select_options.'
			</select>
		</div>
	';	
}
?>