<?php
function reviews_iframe_func( $atts, $content ){
	extract( shortcode_atts( array(
		'link' => '',
		'proportion' => '',
	), $atts ) );

	return '
		<div class="embed-responsive embed-responsive-'.esc_attr( $proportion ).'">
		  <iframe class="embed-responsive-item" src="'.esc_url( $link ).'"></iframe>
		</div>';
}

add_shortcode( 'iframe', 'reviews_iframe_func' );

function reviews_iframe_params(){
	return array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Iframe link","reviews"),
			"param_name" => "link",
			"value" => '',
			"description" => esc_html__("Input link you want to embed.","reviews")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Iframe Proportion","reviews"),
			"param_name" => "proportion",
			"value" => array(
				esc_html__( '4 by 3', 'reviews' ) => '4by3',
				esc_html__( '16 by 9', 'reviews' ) => '16by9',
			),
			"description" => esc_html__("Select iframe proportion.","reviews")
		),

	);
}

if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => esc_html__("Iframe", 'reviews'),
	   "base" => "iframe",
	   "category" => esc_html__('Content', 'reviews'),
	   "params" => reviews_iframe_params()
	) );
}

?>