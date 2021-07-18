<?php
function reviews_alert_func( $atts, $content ){
	extract( shortcode_atts( array(
		'text' => '',
		'border_color' => '',
		'bg_color' => '',
		'font_color' => '',
		'icon' => '',
		'closeable' => 'no',
		'close_icon_color' => '',
		'close_icon_color_hvr' => '',
	), $atts ) );

	$rnd = reviews_random_string();

	$style_css = '
		<style>
			.'.$rnd.'.alert .close{
				color: '.$close_icon_color.';
			}
			.'.$rnd.'.alert .close:hover{
				color: '.$close_icon_color_hvr.';
			}
		</style>
	';

	return reviews_shortcode_style( $style_css ).'
	<div class="alert '.esc_attr( $rnd ).' alert-default '.( $closeable == 'yes' ? esc_attr( 'alert-dismissible' ) : '' ).'" role="alert" style=" color: '.esc_attr( $font_color ).'; border-color: '.esc_attr( $border_color ).'; background-color: '.esc_attr( $bg_color ).';">
		'.( !empty( $icon ) && $icon !== 'No Icon' ? '<i class="fa fa-'.esc_attr( $icon ).'"></i>' : '' ).'
		'.$text.'
		'.( $closeable == 'yes' ? '<button type="button" class="close" data-dismiss="alert"> <span aria-hidden="true">×</span> <span class="sr-only">'.esc_html__( 'Close', 'reviews' ).'</span> </button>' : '' ).'
	</div>';
}

add_shortcode( 'alert', 'reviews_alert_func' );

function reviews_alert_params(){
	return array(
		array(
			"type" => "textarea",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Text","reviews"),
			"param_name" => "text",
			"value" => '',
			"description" => esc_html__("Input alert text.","reviews")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Border Color","reviews"),
			"param_name" => "border_color",
			"value" => '',
			"description" => esc_html__("Select border color for the alert box.","reviews")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Background Color Color","reviews"),
			"param_name" => "bg_color",
			"value" => '',
			"description" => esc_html__("Select background color of the alert box.","reviews")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Text Color","reviews"),
			"param_name" => "font_color",
			"value" => '',
			"description" => esc_html__("Select font color for the alert box text.","reviews")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Icon","reviews"),
			"param_name" => "icon",
			"value" => reviews_awesome_icons_list(),
			"description" => esc_html__("Select icon.","reviews")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Closeable","reviews"),
			"param_name" => "closeable",
			"value" => array(
				esc_html__( 'No', 'reviews' ) => 'no',
				esc_html__( 'Yes', 'reviews' ) => 'yes'
			),
			"description" => esc_html__("Enable or disable alert closing.","reviews")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Close Icon Color","reviews"),
			"param_name" => "close_icon_color",
			"value" => '',
			"description" => esc_html__("Select color for the close icon.","reviews")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Close Icon Color On Hover","reviews"),
			"param_name" => "close_icon_color_hvr",
			"value" => '',
			"description" => esc_html__("Select color for the close icon on hover.","reviews")
		),
	);
}

if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => esc_html__("Alert", 'reviews'),
	   "base" => "alert",
	   "category" => esc_html__('Content', 'reviews'),
	   "params" => reviews_alert_params()
	) );
}
?>