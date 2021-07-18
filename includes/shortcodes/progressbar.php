<?php
function reviews_progressbar_func( $atts, $content ){
	extract( shortcode_atts( array(
		'label' => '',
		'value' => '',
		'color' => '',
		'bgcolor' => '',
		'label_color' => '',
		'height' => '',
		'font_size' => '',
		'icon' => '',
		'border_radius' => '',
		'style' => '',
		'label_pos' => ''
	), $atts ) );

	$rnd = reviews_random_string();

	$style_css = '
	<style>
		.'.$rnd.'{
			'.( !empty( $border_radius ) ? 'border-radius: '.$border_radius.';' : '' ).'
			'.( !empty( $height ) ? 'height: '.$height.';' : '' ).'
			'.( !empty( $bgcolor ) ? 'background-color: '.$bgcolor.';' : '' ).'
		}

		.'.$rnd.' .pb-label{
			'.( !empty( $font_size ) ? 'font-size: '.$font_size.';' : '' ).'
			'.( !empty( $height ) ? 'line-height: '.$height.';' : '' ).'
			'.( !empty( $label_color ) ? 'color: '.$label_color.';' : '' ).'
		}

		.'.$rnd.' .progress-bar{
			'.( !empty( $color ) ? 'background-color: '.$color.';' : '' ).'
		}

		.'.$rnd.' .progress-bar-value{
			'.( !empty( $color ) ? 'background-color: '.$color.';' : '' ).'
			'.( !empty( $label_color ) ? 'color: '.$label_color.';' : '' ).'
		}

		.'.$rnd.' .progress-bar-value:after{
			'.( !empty( $color ) ? 'border-color: '.$color.' transparent;' : '' ).'
		}
	</style>
	';

	$label = '<div class="pb-label">'.( !empty( $icon ) ? '<i class="fa fa-'.esc_attr( $icon ).'"></i>' : '' ).''.$label.'</div>';

	return reviews_shortcode_style( $style_css ).'
	'.( $label_pos == 'above-pb' ? $label : '' ).'
	<div class="progress '.esc_attr( $rnd ).'">
	  	<div class="progress-bar '.esc_attr( $style ).'" style="width: '.esc_attr( $value ).'%" role="progressbar" aria-valuenow="'.esc_attr( $value ).'" aria-valuemin="0" aria-valuemax="100">
	  		<div class="progress-bar-value">'.$value.'%</div>
	  		'.( $label_pos !== 'above-pb' ? $label : '' ).'
	  	</div>
	</div>';
}

add_shortcode( 'progressbar', 'reviews_progressbar_func' );

function reviews_progressbar_params(){
	return array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Label","reviews"),
			"param_name" => "label",
			"value" => '',
			"description" => esc_html__("Input progress bar label.","reviews")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Label Font Size","reviews"),
			"param_name" => "font_size",
			"value" => '',
			"description" => esc_html__("Input label font size.","reviews")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Value","reviews"),
			"param_name" => "value",
			"value" => '',
			"description" => esc_html__("Input progress bar value. Input number only unit is in percentage.","reviews")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Progress Bar Color","reviews"),
			"param_name" => "color",
			"value" => '',
			"description" => esc_html__("Select progress bar color.","reviews")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Progress Bar Background Color","reviews"),
			"param_name" => "bgcolor",
			"value" => '',
			"description" => esc_html__("Select progress bar background color.","reviews")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Progress Bar Label Color","reviews"),
			"param_name" => "label_color",
			"value" => '',
			"description" => esc_html__("Select progress bar label color.","reviews")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Progress Bar Label Position","reviews"),
			"param_name" => "label_pos",
			"value" => array(
				esc_html__( 'On Progress Bar', 'reviews' ) => '',
				esc_html__( 'Above Progress Bar', 'reviews' ) => 'above-pb',
			),
			"description" => esc_html__("Select location of the label.","reviews")
		),		
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Progress Bar Height","reviews"),
			"param_name" => "height",
			"value" => '',
			"description" => esc_html__("Input progress bar height.","reviews")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Progress Bar Label Icon","reviews"),
			"param_name" => "icon",
			"value" => reviews_awesome_icons_list(),
			"description" => esc_html__("Select icon for the label.","reviews")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Progress Bar Border Radius","reviews"),
			"param_name" => "border_radius",
			"value" => '',
			"description" => esc_html__("Input progress bar border radius.","reviews")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Progress Bar Style","reviews"),
			"param_name" => "style",
			"value" => array(
				esc_html__( 'Normal', 'reviews' ) => '',
				esc_html__( 'Stripes', 'reviews' ) => 'progress-bar-striped',
				esc_html__( 'Active Stripes', 'reviews' ) => 'progress-bar-striped active',
			),
			"description" => esc_html__("Select progress bar style.","reviews")
		),
	);
}

if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => esc_html__("Progress Bar", 'reviews'),
	   "base" => "progressbar",
	   "category" => esc_html__('Content', 'reviews'),
	   "params" => reviews_progressbar_params()
	) );
}

?>