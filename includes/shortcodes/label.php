<?php
function reviews_label_func( $atts, $content ){
	extract( shortcode_atts( array(
		'text' => '',
		'bg_color' => '',
		'font_color' => '',
	), $atts ) );

	return '<span class="label label-default" style="color: '.esc_attr( $font_color ).'; background-color: '.esc_attr( $bg_color ).'">'.$text.'</span>';
}

add_shortcode( 'label', 'reviews_label_func' );

function reviews_label_params(){
	return array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Text","reviews"),
			"param_name" => "text",
			"value" => '',
			"description" => esc_html__("Input label text.","reviews")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Background Color Color","reviews"),
			"param_name" => "bg_color",
			"value" => '',
			"description" => esc_html__("Select background color of the label.","reviews")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Text Color","reviews"),
			"param_name" => "font_color",
			"value" => '',
			"description" => esc_html__("Select font color for the label text.","reviews")
		),

	);
}

if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => esc_html__("Label", 'reviews'),
	   "base" => "label",
	   "category" => esc_html__('Content', 'reviews'),
	   "params" => reviews_label_params()
	) );
}

?>