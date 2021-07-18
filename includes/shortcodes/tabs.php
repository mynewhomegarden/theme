<?php
function reviews_tabs_func( $atts, $content ){
	extract( shortcode_atts( array(
		'titles' => '',
		'contents' => ''
	), $atts ) );

	$titles = explode( "/n/", $titles );
	if( empty( $contents ) ){
		$contents = $content;
	}
	$contents = explode( "/n/", $contents );

	$titles_html = '';
	$contents_html = '';

	$random = reviews_random_string();

	if( !empty( $titles ) ){
		for( $i=0; $i<sizeof( $titles ); $i++ ){
			$titles_html .= '<li role="presentation" class="'.( $i == 0 ? esc_attr( 'active' ) : '' ).'"><a href="#tab_'.esc_attr( $i ).'_'.esc_attr( $random ).'" role="tab" data-toggle="tab">'.$titles[$i].'</a></li>';
			$contents_html .= '<div role="tabpanel" class="tab-pane fade '.( $i == 0 ? esc_attr( 'in active' ) : '' ).'" id="tab_'.esc_attr( $i ).'_'.esc_attr( $random ).'">'.( !empty( $contents[$i] ) ? apply_filters( 'the_content', $contents[$i] ) : '' ).'</div>';
		}
	}

	return '
	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
	  '.$titles_html.'
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
	  '.$contents_html.'
	</div>';
}

add_shortcode( 'tabs', 'reviews_tabs_func' );

function reviews_tabs_params(){
	return array(
		array(
			"type" => "textarea",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Titles","reviews"),
			"param_name" => "titles",
			"value" => '',
			"description" => esc_html__("Input tab titles separated by /n/.","reviews")
		),
		array(
			"type" => "textarea_raw_html",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Contents","reviews"),
			"param_name" => "contents",
			"value" => '',
			"description" => esc_html__("Input tab contents separated by /n/.","reviews")
		),

	);
}

if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => esc_html__("Tabs", 'reviews'),
	   "base" => "tabs",
	   "category" => esc_html__('Content', 'reviews'),
	   "params" => reviews_tabs_params()
	) );
}

?>