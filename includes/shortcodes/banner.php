<?php
function reviews_banner_func( $atts, $content ){
	extract( shortcode_atts( array(
		'link' => '',
		'bg_image' => '',
	), $atts ) );

	return '
	<a href="'.esc_url( $link ).'" class="banner" target="_blank" rel="nofollow">
		'.wp_get_attachment_image( $bg_image, 'full' ).'
	</a>';
}

add_shortcode( 'banner', 'reviews_banner_func' );

function reviews_banner_params(){
	return array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Link","reviews"),
			"param_name" => "link",
			"value" => '',
			"description" => esc_html__("Input banner link.","reviews")
		),
		array(
			"type" => "attach_image",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Banner Background Image","reviews"),
			"param_name" => "bg_image",
			"value" => '',
			"description" => esc_html__("Select banner background image.","reviews")
		),
	);
}

if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => esc_html__("Banner", 'reviews'),
	   "base" => "banner",
	   "category" => esc_html__('Content', 'reviews'),
	   "params" => reviews_banner_params()
	) );
}
?>