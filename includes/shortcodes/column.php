<?php
function reviews_column_func( $atts, $content ){
	extract( shortcode_atts( array(
		'md' => '12'
	), $atts ) );

	return '<div class="col-md-'.esc_attr( $md ).'">'.do_shortcode( $content ).'</div>';
}

add_shortcode( 'column', 'reviews_column_func' );

function reviews_column_params(){
	return array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Column Size","reviews"),
			"param_name" => "md",
			"value" => '12',
			"description" => esc_html__("Input column size. min 1 max 12. Sum of these numbers in a row must be 12.","reviews")
		),
	);
}
?>