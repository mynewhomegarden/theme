<?php
function reviews_accordion_func( $atts, $content ){
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

	$rnd = reviews_random_string();

	$html = '';

	if( !empty( $titles ) ){
		for( $i=0; $i<sizeof( $titles ); $i++ ){
			if( !empty( $titles[$i] ) ){
				$html .= '
				  <div class="panel panel-default">
				    <div class="panel-heading" role="tab" id="heading_'.esc_attr( $i ).'">
				      <div class="panel-title">
				        <a class="'.( $i !== 0 ? 'collapsed' : '' ).'" data-toggle="collapse" data-parent="#accordion_'.esc_attr( $rnd ).'" href="#coll_'.esc_attr( $i ).'_'.esc_attr( $rnd ).'" aria-expanded="true" aria-controls="coll_'.esc_attr( $i ).'_'.esc_attr( $rnd ).'">
				        	'.$titles[$i].'
				        	<i class="fa fa-chevron-circle-down animation"></i>
				        </a>
				      </div>
				    </div>
				    <div id="coll_'.esc_attr( $i ).'_'.esc_attr( $rnd ).'" class="panel-collapse collapse '.( $i == 0 ? 'in' : '' ).'" role="tabpanel" aria-labelledby="heading_'.esc_attr( $i).'">
				      <div class="panel-body">
				        '.( !empty( $contents[$i] ) ? apply_filters( 'the_content', $contents[$i] ) : '' ).'
				      </div>
				    </div>
				  </div>
				';
			}
		}
	}

	return '
		<div class="panel-group" id="accordion_'.esc_attr( $rnd ).'" role="tablist" aria-multiselectable="true">
		'.$html.'
		</div>';
}

add_shortcode( 'accordion', 'reviews_accordion_func' );

function reviews_accordion_params(){
	return array(
		array(
			"type" => "textarea",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Titles","reviews"),
			"param_name" => "titles",
			"value" => '',
			"description" => esc_html__("Input accordion titles separated by /n/.","reviews")
		),
		array(
			"type" => "textarea_raw_html",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Contents","reviews"),
			"param_name" => "contents",
			"value" => '',
			"description" => esc_html__("Input accordion contents separated by /n/.","reviews")
		),

	);
}

if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => esc_html__("Accordion", 'reviews'),
	   "base" => "accordion",
	   "category" => esc_html__('Content', 'reviews'),
	   "params" => reviews_accordion_params()
	) );
}
?>