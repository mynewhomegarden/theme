<?php
function reviews_button_func( $atts, $content ){
	extract( shortcode_atts( array(
		'text' => '',
		'link' => '',
		'target' => '',
		'bg_color' => '',
		'bg_color_hvr' => '',
		'border_radius' => '',
		'border_color' => '',
		'border_width' => '',
		'border_color_hvr' => '',
		'icon' => '',
		'font_color' => '',
		'font_color_hvr' => '',
		'size' => 'normal',
		'align' => '',
		'btn_width' => 'normal',
		'inline' => 'no',
		'margin' => ''
	), $atts ) );

	$rnd = reviews_random_string();

	$style_css = '
	<style>
		a.'.$rnd.', a.'.$rnd.':active, a.'.$rnd.':visited, a.'.$rnd.':focus{
			border-style: solid;
			display: '.( $btn_width == 'normal' ? 'inline-block' : 'block' ).';
			'.( !empty( $bg_color ) ? 'background-color: '.$bg_color.';' : '' ).'
			'.( !empty( $font_color ) ? 'color: '.$font_color.';' : '' ).'
			'.( !empty( $border_radius ) ? 'border-radius: '.$border_radius.';' : '' ).'
			'.( !empty( $border_color ) ? 'border-color: '.$border_color.';' : '' ).'
			'.( !empty( $border_width ) ? 'border-width: '.$border_width.';' : '' ).'
		}
		a.'.$rnd.':hover{
			border-style: solid;
			display: '.( $btn_width == 'normal' ? 'inline-block' : 'block' ).';
			'.( !empty( $bg_color_hvr ) ? 'background-color: '.$bg_color_hvr.';' : '' ).'
			'.( !empty( $font_color_hvr ) ? 'color: '.$font_color_hvr.';' : '' ).'
			'.( !empty( $border_color_hvr ) ? 'border-color: '.$border_color_hvr.';' : '' ).'
			'.( !empty( $border_width ) ? 'border-width: '.$border_width.';' : '' ).'
		}		
	</style>
	';

	return reviews_shortcode_style( $style_css ).'
	<div class="btn-wrap" style="margin: '.esc_attr( $margin ).'; text-align: '.esc_attr( $align ).'; '.( $inline == 'yes' ? esc_attr( 'display: inline-block;' ) : '' ).' '.( $inline == 'yes' && $align == 'right' ? esc_attr( 'float: right;' ) : '' ).'">
		<a href="'.esc_url( $link ).'" class="btn btn-default '.esc_attr( $size ).' '.esc_attr( $rnd ).' '.( $link != '#' && $link[0] == '#' ? esc_attr( 'slideTo' ) : '' ).'" target="'.esc_attr( $target ).'">
			'.( $icon != 'No Icon' && $icon != '' ? '<i class="fa fa-'.esc_attr( $icon ).' '.( empty( $text ) ? 'no-margin' : '' ).'"></i>' : '' ).'
			'.$text.'
		</a>
	</div>';
}

add_shortcode( 'button', 'reviews_button_func' );

function reviews_button_params(){
	return array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Button Text","reviews"),
			"param_name" => "text",
			"value" => '',
			"description" => esc_html__("Input button text.","reviews")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Button Link","reviews"),
			"param_name" => "link",
			"value" => '',
			"description" => esc_html__("Input button link.","reviews")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Select Window","reviews"),
			"param_name" => "target",
			"value" => array(
				esc_html__( 'Same Window', 'reviews' ) => '_self',
				esc_html__( 'New Window', 'reviews' ) => '_blank',
			),
			"description" => esc_html__("Select window where to open the link.","reviews")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Background Color","reviews"),
			"param_name" => "bg_color",
			"value" => '',
			"description" => esc_html__("Select button background color.","reviews")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Background Color On Hover","reviews"),
			"param_name" => "bg_color_hvr",
			"value" => '',
			"description" => esc_html__("Select button background color on hover.","reviews")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Button Border Radius","reviews"),
			"param_name" => "border_radius",
			"value" => '',
			"description" => esc_html__("Input button border radius. For example 5px or 5ox 9px 0px 0px or 50% or 50% 50% 20% 10%.","reviews")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Border Width","reviews"),
			"param_name" => "border_width",
			"value" => '',
			"description" => esc_html__("Input border width.","reviews")
		),		
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Border Color","reviews"),
			"param_name" => "border_color",
			"value" => '',
			"description" => esc_html__("Select button border color.","reviews")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Border Color On Hover","reviews"),
			"param_name" => "border_color_hvr",
			"value" => '',
			"description" => esc_html__("Select button border color on hover.","reviews")
		),		
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Select Icon","reviews"),
			"param_name" => "icon",
			"value" => reviews_awesome_icons_list(),
			"description" => esc_html__("Select an icon you want to display.","reviews")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Font Color","reviews"),
			"param_name" => "font_color",
			"value" => '',
			"description" => esc_html__("Select button font color.","reviews")
		),
		array(
			"type" => "colorpicker",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Font Color On Hover","reviews"),
			"param_name" => "font_color_hvr",
			"value" => '',
			"description" => esc_html__("Select button font color on hover.","reviews")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Button Size","reviews"),
			"param_name" => "size",
			"value" => array(
				esc_html__( 'Normal', 'reviews' ) => '',
				esc_html__( 'Medium', 'reviews' ) => 'medium',
				esc_html__( 'Large', 'reviews' ) => 'large',
			),
			"description" => esc_html__("Select button size.","reviews")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Button Align","reviews"),
			"param_name" => "align",
			"value" => array(
				esc_html__( 'Left', 'reviews' ) => 'left',
				esc_html__( 'Center', 'reviews' ) => 'center',
				esc_html__( 'Right', 'reviews' ) => 'right',
			),
			"description" => esc_html__("Select button align.","reviews")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Select Button Width","reviews"),
			"param_name" => "btn_width",
			"value" => array(
				esc_html__( 'Normal', 'reviews' ) => 'normal',
				esc_html__( 'Full Width', 'reviews' ) => 'full',
			),
			"description" => esc_html__("Select button width.","reviews")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Display Inline","reviews"),
			"param_name" => "inline",
			"value" => array(
				esc_html__( 'No', 'reviews' ) => 'no',
				esc_html__( 'Yes', 'reviews' ) => 'yes',
			),
			"description" => esc_html__("Display button inline.","reviews")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Button Margins","reviews"),
			"param_name" => "margin",
			"value" => '',
			"description" => esc_html__("Add button margins.","reviews")
		),
	);
}

if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => esc_html__("Button", 'reviews'),
	   "base" => "button",
	   "category" => esc_html__('Content', 'reviews'),
	   "params" => reviews_button_params()
	) );
}

?>