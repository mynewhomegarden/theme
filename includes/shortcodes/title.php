<?php
function reviews_title_func( $atts, $content ){
	extract( shortcode_atts( array(
		'title' => '',
		'subtitle' => '',
		'align' => '',
		'container' => '',
	), $atts ) );

	ob_start();
	?>
	<div class="<?php echo $container == 'yes' ? esc_attr( 'white-block' ) : '' ?> title-block" style="text-align: <?php echo esc_attr( $align ) ?>">
		<h3><?php echo  $title ?></h3>
		<p><?php echo  $subtitle ?></p>
	</div>
	<?php
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

add_shortcode( 'title', 'reviews_title_func' );

function reviews_title_params(){
	return array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Title","reviews"),
			"param_name" => "title",
			"value" => '',
			"description" => esc_html__("Input title for the categories block.","reviews")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Subtitle","reviews"),
			"param_name" => "subtitle",
			"value" => '',
			"description" => esc_html__("Input subtitle for the categories block.","reviews")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Text Align","reviews"),
			"param_name" => "align",
			"value" => array(
				esc_html__( 'Center', 'reviews' ) => 'center',
				esc_html__( 'Left', 'reviews' ) => 'left',
				esc_html__( 'Right', 'reviews' ) => 'right',
			),
			"description" => esc_html__("Select title text align.","reviews")
		),	
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("With White Container","reviews"),
			"param_name" => "container",
			"value" => array(
				esc_html__( 'Yes', 'reviews' ) => 'yes',
				esc_html__( 'No', 'reviews' ) => 'no',
			),
			"description" => esc_html__("Select wheter or not to put title in the shite container .","reviews")
		),	
	);
}

if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => esc_html__("Reviews Title", 'reviews'),
	   "base" => "title",
	   "category" => esc_html__('Content', 'reviews'),
	   "params" => reviews_title_params()
	) );
}
?>