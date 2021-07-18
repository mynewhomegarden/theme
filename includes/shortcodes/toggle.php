<?php
function reviews_toggle_func( $atts, $content ){
	extract( shortcode_atts( array(
		'title' => '',
		'toggle_content' => '',
		'state' => '',
	), $atts ) );

	if( empty( $toggle_content ) ){
		$toggle_content = $content;
	}
	$rnd = reviews_random_string();

	return '
		<div class="panel-group" id="accordion_'.esc_attr( $rnd ).'" role="tablist" aria-multiselectable="true">
		  <div class="panel panel-default">
		    <div class="panel-heading" role="tab" id="heading_'.esc_attr( $rnd ).'">
		      <div class="panel-title">
		        <a class="'.( $state == 'in' ? '' : esc_attr( 'collapsed' ) ).'" data-toggle="collapse" data-parent="#accordion_'.esc_attr( $rnd ).'" href="#coll_'.esc_attr( $rnd ).'" aria-expanded="true" aria-controls="coll_'.esc_attr( $rnd ).'">
		        	'.$title.'
		        	<i class="fa fa-chevron-circle-down animation"></i>
		        </a>
		      </div>
		    </div>
		    <div id="coll_'.esc_attr( $rnd ).'" class="panel-collapse collapse '.esc_attr( $state ).'" role="tabpanel" aria-labelledby="heading_'.esc_attr( $rnd ).'">
		      <div class="panel-body">
		        '.apply_filters( 'the_content', $toggle_content ).'
		      </div>
		    </div>
		  </div>
		</div>';
}

add_shortcode( 'toggle', 'reviews_toggle_func' );

function reviews_toggle_params(){
	return array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Title","reviews"),
			"param_name" => "title",
			"value" => '',
			"description" => esc_html__("Input toggle title.","reviews")
		),
		array(
			"type" => "textarea_raw_html",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Content","reviews"),
			"param_name" => "toggle_content",
			"value" => '',
			"description" => esc_html__("Input toggle title.","reviews")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Default State","reviews"),
			"param_name" => "state",
			"value" => array(
				esc_html__( 'Closed', 'reviews' ) => '',
				esc_html__( 'Opened', 'reviews' ) => 'in',
			),
			"description" => esc_html__("Select default toggle state.","reviews")
		),

	);
}

if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => esc_html__("Toggle", 'reviews'),
	   "base" => "toggle",
	   "category" => esc_html__('Content', 'reviews'),
	   "params" => reviews_toggle_params()
	) );
}

?>