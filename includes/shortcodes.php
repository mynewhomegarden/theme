<?php

class Shortcodes{
	
	function __construct(){
		if( is_admin() ){
			add_action( 'init', array( $this, 'shortcode_buttons' ) );
			add_action('wp_ajax_shortcode_call', array( $this, 'shortcode_options' ) );
			add_action('wp_ajax_nopriv_shortcode_call', array( $this, 'shortcode_options' ) );
		}
	}

	function shortcode_buttons(){
		add_filter( "mce_external_plugins", array( $this, "add_buttons" ) );
	    add_filter( 'mce_buttons', array( $this, 'register_buttons' ) );	
	}
	

	function add_buttons( $plugin_array ) {
		$screen = get_current_screen();
		$plugin_array['reviews'] = get_template_directory_uri() . '/js/shortcodes.js';	
	    
	    return $plugin_array;
	}

	function register_buttons( $buttons ) {
	    array_push( $buttons, 'reviewsgrid', 'reviewselements', 'reviewselementsmega' ); 
	    return $buttons;
	}

	function shortcode_options(){
		$shortcode = $_POST['shortcode'];
		echo  $this->$shortcode();
		die();
	}


	function render_options( $fields ){
		$fields_html = '';
		foreach( $fields as $field ){
			if( !in_array( $field['type'], array( 'css_editor', 'textarea_html' ) ) ){
				$fields_html .= '<div class="shortcode-option"><label>'.$field['heading'].'</label>';
				switch ( $field['type'] ){
					case 'textfield' : 
						$fields_html .= '<input type="text" class="shortcode-field" name="'.esc_attr( $field['param_name'] ).'" value="'.esc_attr( $field['value'] ).'">';
						break;
					case 'dropdown' :
						$options = '';
						if( !empty( $field['value'] ) ){
							foreach( $field['value'] as $option_name => $option_value ){
								$options .= '<option value="'.esc_attr( $option_value ).'">'.$option_name.'</option>';
							}
						}
						$fields_html .= '<select name="'.esc_attr( $field['param_name'] ).'" class="shortcode-field">'.$options.'</select>';
						break;
					case 'multidropdown' :
						$options = '';
						if( !empty( $field['value'] ) ){
							foreach( $field['value'] as $option_name => $option_value ){
								$options .= '<option value="'.esc_attr( $option_value ).'">'.$option_name.'</option>';
							}
						}
						$fields_html .= '<select name="'.esc_attr( $field['param_name'] ).'" class="shortcode-field" multiple>'.$options.'</select>';
						break;
					case 'colorpicker' :
						$fields_html .= '<input type="text" name="'.esc_attr( $field['param_name'] ).'" class="shortcode-field shortcode-colorpicker" value="'.esc_attr( $field['value'] ).'" />';
						break;
					case 'attach_image' :
						$fields_html .= '<div class="shortcode-image-holder"></div><div class="clearfix"></div>
										<a href="javascript:;" class="shortcode-add-image button">'.esc_html__( 'Add Image', 'reviews' ).'</a>
										<input type="hidden" name="'.esc_attr( $field['param_name'] ).'" class="shortcode-field" value="'.esc_attr( $field['value'] ).'">';
						break;	
					case 'attach_images' :
						$fields_html .= '<div class="shortcode-images-holder"></div><div class="clearfix"></div>
										<a href="javascript:;" class="shortcode-add-images button">'.esc_html__( 'Add Images', 'reviews' ).'</a>
										<input type="hidden" name="'.esc_attr( $field['param_name'] ).'" class="shortcode-field" value="'.esc_attr( $field['value'] ).'">';
						break;
					case 'textarea' :					
						$fields_html .= '<textarea name="'.esc_attr( $field['param_name'] ).'" class="shortcode-field">'.$field['value'].'</textarea>';
						break;
					case 'textarea_raw_html' :					
						$fields_html .= '<textarea name="'.esc_attr( $field['param_name'] ).'" class="shortcode-field">'.$field['value'].'</textarea>';
						break;						
				}
				$fields_html .= '<div class="description">'.$field['description'].'</div></div>';
			}
		}


		echo  $fields_html.'<a href="javascript:;" class="shortcode-save-options button">'.esc_html__( 'Insert', 'reviews' ).'</a>';
		die();

	}
	/* FUNCTIONS FOR THE reviews GRID */
	function row(){
		echo '';
		die();
	}
	function categories_list(){
		$fields = $this->render_options( reviews_categories_list_params() );
	}
	function column(){
		$fields = $this->render_options( reviews_column_params() );
	}
	function accordion(){
		$fields = $this->render_options( reviews_accordion_params() );
	}
	function alert(){
		$fields = $this->render_options( reviews_alert_params() );
	}
	function button(){
		$fields = $this->render_options( reviews_button_params() );
	}
	function gap(){
		$fields = $this->render_options( reviews_gap_params() );
	}	
	function banner(){
		$fields = $this->render_options( reviews_banner_params() );
	}	
	function bg_gallery(){
		$fields = $this->render_options( reviews_bg_gallery_params() );
	}
	function icon(){
		$fields = $this->render_options( reviews_icon_params() );
	}
	function iframe(){
		$fields = $this->render_options( reviews_iframe_params() );
	}
	function label(){
		$fields = $this->render_options( reviews_label_params() );
	}
	function latest_blogs(){
		$fields = $this->render_options( reviews_latest_blogs_params() );
	}
	function reviews(){
		$fields = $this->render_options( reviews_params() );
	}	
	function progressbar(){
		$fields = $this->render_options( reviews_progressbar_params() );
	}
	function tabs(){
		$fields = $this->render_options( reviews_tabs_params() );
	}
	function title(){
		$fields = $this->render_options( reviews_title_params() );
	}
	function toggle(){
		$fields = $this->render_options( reviews_toggle_params() );
	}
	function authors(){
		$fields = $this->render_options( reviews_authors_params() );
	}
	function mega_menu_reviews(){
		$fields = $this->render_options( reviews_mega_menu_reviews_params() );
	}	
}

new Shortcodes();

?>