<?php
function reviews_icon_func( $atts, $content ){
	extract( shortcode_atts( array(
		'icon' => '',
		'color' => '',
		'size' => '',
	), $atts ) );

	return '<span class="fa fa-'.esc_attr( $icon ).'" style="color: '.esc_attr( $color ).'; font-size: '.esc_attr( $size ).'; margin: 5px 2px;"></span>';
}

add_shortcode( 'icon', 'reviews_icon_func' );

function reviews_icon_params(){
	return array(
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Select Icon","reviews"),
			"param_name" => "icon",
			"value" => reviews_awesome_icons_list(),
			"description" => esc_html__("Select an icon you want to display.","reviews")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Icon Color","reviews"),
			"param_name" => "color",
			"value" => '',
			"description" => esc_html__("Select color of the icon.","reviews")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Icon Size","reviews"),
			"param_name" => "size",
			"value" => '',
			"description" => esc_html__("Input size of the icon.","reviews")
		),

	);
}

if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => esc_html__("Icon", 'reviews'),
	   "base" => "icon",
	   "category" => esc_html__('Content', 'reviews'),
	   "params" => reviews_icon_params()
	) );
}

?>