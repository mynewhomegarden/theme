<?php
function reviews_bg_gallery_func( $atts, $content ){
	extract( shortcode_atts( array(
		'images' => '',
		'thumb_image_size' => 'post-thumbnail',
		'columns' => '3',
	), $atts ) );

	ob_start();
	echo do_shortcode( '[gallery columns="'.esc_attr( $columns ).'" ids="'.esc_attr( $images ).'" size="'.esc_attr( $thumb_image_size ).'"]' );
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}

add_shortcode( 'bg_gallery', 'reviews_bg_gallery_func' );

function reviews_get_image_sizes(){
	$sizes = get_intermediate_image_sizes();
	$sizes_right = array();
	foreach( $sizes as $size ){
		$sizes_right[$size] = $size;
	}

	return $sizes_right;
}

function reviews_bg_gallery_params(){
	return array(
		array(
			"type" => "attach_images",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Select Images","reviews"),
			"param_name" => "images",
			"value" => '',
			"description" => esc_html__("Select images for the gallery.","reviews")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Thumbnail Image Size","reviews"),
			"param_name" => "thumb_image_size",
			"value" => reviews_get_image_sizes(),
			"description" => esc_html__("Select image size you want to display for the thumbnails.","reviews")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Columns","reviews"),
			"param_name" => "columns",
			"value" => array(
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
				'6' => '6',
				'7' => '7',
				'8' => '8',
				'9' => '9',
				'10' => '10',
			),
			"description" => esc_html__("Select number of columns for the thumbnails.","reviews")
		),
	);
}
if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => esc_html__("Gallery", 'reviews'),
	   "base" => "bg_gallery",
	   "category" => esc_html__('Content', 'reviews'),
	   "params" => reviews_bg_gallery_params()
	) );
}

?>