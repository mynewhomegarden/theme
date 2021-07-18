<?php
function reviews_gap_func( $atts, $content ){
	extract( shortcode_atts( array(
		'height' => '',
	), $atts ) );

	return '<span style="height: '.esc_attr( $height ).'; display: block;"></span>';
}

add_shortcode( 'gap', 'reviews_gap_func' );

function reviews_gap_params(){
	return array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Gap Height","reviews"),
			"param_name" => "height",
			"value" => '',
			"description" => esc_html__("Input gap height.","reviews")
		),
	);
}

if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => esc_html__("Gap", 'reviews'),
	   "base" => "gap",
	   "category" => esc_html__('Content', 'reviews'),
	   "params" => reviews_gap_params()
	) );
}
?>