<?php
function reviews_row_func( $atts, $content ){

	return '<div class="row">'.do_shortcode( $content ).'</div>';
}

add_shortcode( 'row', 'reviews_row_func' );

function reviews_row_params(){
	return array();
}
?>