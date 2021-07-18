<?php

	/**********************************************************************
	***********************************************************************
	REVIEWS FUNCTIONS
	**********************************************************************/
if( is_dir( get_stylesheet_directory() . '/languages' ) ) {
	load_theme_textdomain('reviews', get_stylesheet_directory() . '/languages');
}
else{
	load_theme_textdomain('reviews', get_template_directory() . '/languages');
}

if( !function_exists('reviews_load_path') ){
function reviews_load_path( $path ){
	if ( file_exists( get_stylesheet_directory() . '/' . $path )) {
	    return get_stylesheet_directory() . '/' . $path;
	} else {
	    return get_template_directory() . '/' . $path;
	}	
}
}

if( !function_exists('reviews_update') ){
function reviews_update(){
	$current_version = 37;
	$installed_version = get_option( 'reviews_version' );
	if( empty( $installed_version ) ){
		$installed_version = 10;
	}
	if( $installed_version < 12 ){
		global $wpdb;
		$reviews = get_posts(array(
			'post_type' => 'review',
			'post_status' => 'publish',
			'posts_per_page' => '-1'
		));
		if( !empty( $reviews ) ){
			foreach( $reviews as $review ){
				update_post_meta( $review->ID, 'review_clicks', '0' );
			}
		}
	}
	if( $installed_version < 26  ){
		global $wpdb;
		$old_images = $wpdb->get_results( "SELECT * FROM {$wpdb->postmeta} WHERE meta_key = 'review_images'" );
		if( !empty( $old_images ) ){
			foreach( $old_images as $old_array ){
				$image_ids = maybe_unserialize( maybe_unserialize( $old_array->meta_value ) );
				if( !empty( $image_ids ) && is_array( $image_ids ) ){
					delete_post_meta( $old_array->post_id, 'review_images' );
					foreach( $image_ids as $image_id ){
						add_post_meta( $old_array->post_id, 'review_images', $image_id );
					}
				}
			}
		}
	}
	if( $installed_version < 28  ){
		global $wpdb;
		$old_images = $wpdb->get_results( "SELECT * FROM {$wpdb->postmeta} WHERE meta_key = 'gallery_images'" );
		if( !empty( $old_images ) ){
			foreach( $old_images as $old_array ){
				$image_ids = maybe_unserialize( maybe_unserialize( $old_array->meta_value ) );
				if( !empty( $image_ids ) && is_array( $image_ids ) ){
					delete_post_meta( $old_array->post_id, 'gallery_images' );
					foreach( $image_ids as $image_id ){
						add_post_meta( $old_array->post_id, 'gallery_images', $image_id );
					}
				}
			}
		}
	}
	update_option( 'reviews_version', $current_version );
}
add_action('init', 'reviews_update');
}

if( !function_exists('recipe_check_plugins') ){
function recipe_check_plugins() {
	if( function_exists('sc_activate') ):
		$smeta_data = get_plugins( '/social-connect' );
	    if( $smeta_data['social-connect.php']['Version'] != '1.7' ):
		    ?>
		    <div class="notice notice-success is-dismissible error">
		        <p><?php esc_html_e( 'Reinstall Social Connect plugin ( Delete it and theme will offer you to install it again )', 'reviews' ); ?></p>
		    </div>
		    <?php
	    endif;
	endif;
	if( function_exists('reviews_register_types') ):
		$smeta_data = get_plugins( '/reviews-cpt' );
	    if( $smeta_data['reviews-cpt.php']['Version'] != '1.4' ):
		    ?>
		    <div class="notice notice-success is-dismissible error">
		        <p><?php esc_html_e( 'Reinstall Reviews Custom Post Types plugin ( Delete it and theme will offer you to install it again ) After go to Settings -> Permalinks and resave them ( click Save Changes button )', 'reviews' ); ?></p>
		    </div>
		    <?php
	    endif;
	endif;
}
add_action( 'admin_notices', 'recipe_check_plugins' );
}

if( !function_exists('reviews_requred_plugins') ){
function reviews_requred_plugins(){
	$plugins = array(
		array(
				'name'                 => esc_html__( 'Redux Options', 'reviews' ),
				'slug'                 => 'redux-framework',
				'required'             => true,
				'version'              => '',
				'force_activation'     => false,
				'force_deactivation'   => false,
				'external_url'         => '',
		),	
		array(
				'name'                 => esc_html__( 'Smeta', 'reviews' ),
				'slug'                 => 'smeta',
				'source'               => get_template_directory() . '/lib/plugins/smeta.zip',
				'required'             => true,
				'version'              => '',
				'force_activation'     => false,
				'force_deactivation'   => false,
				'external_url'         => '',
		),
		array(
				'name'                 => esc_html__( 'User Avatar', 'reviews' ),
				'slug'                 => 'wp-user-avatar',
				'required'             => true,
				'version'              => '',
				'force_activation'     => false,
				'force_deactivation'   => false,
				'external_url'         => '',
		),
		array(
				'name'                 => esc_html__( 'Reviews Custom Post Types', 'reviews' ),
				'slug'                 => 'reviews-cpt',
				'source'               => get_template_directory() . '/lib/plugins/reviews-cpt.zip',
				'required'             => true,
				'version'              => '',
				'force_activation'     => false,
				'force_deactivation'   => false,
				'external_url'         => '',
		),
		array(
				'name'                 => esc_html__( 'Social Connect', 'reviews' ),
				'slug'                 => 'social-connect',
				'source'               => get_template_directory() . '/lib/plugins/social-connect.zip',
				'required'             => true,
				'version'              => '',
				'force_activation'     => false,
				'force_deactivation'   => false,
				'external_url'         => '',
		),
		array(
				'name'                 => esc_html__( 'MCE Table Buttons', 'reviews' ),
				'slug'                 => 'mce-table-buttons',
				'source'               => get_template_directory() . '/lib/plugins/mce-table-buttons.zip',
				'required'             => true,
				'version'              => '',
				'force_activation'     => false,
				'force_deactivation'   => false,
				'external_url'         => '',
		),
	);

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
			'domain'           => 'reviews',
			'default_path'     => '',
			'menu'             => 'install-required-plugins',
			'has_notices'      => true,
			'is_automatic'     => false,
			'message'          => '',
			'strings'          => array(
				'page_title'                      => esc_html__( 'Install Required Plugins', 'reviews' ),
				'menu_title'                      => esc_html__( 'Install Plugins', 'reviews' ),
				'installing'                      => esc_html__( 'Installing Plugin: %s', 'reviews' ),
				'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'reviews' ),
				'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'reviews' ),
				'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'reviews' ),
				'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'reviews' ),
				'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'reviews' ),
				'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'reviews' ),
				'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'reviews' ),
				'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'reviews' ),
				'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'reviews' ),
				'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'reviews' ),
				'activate_link'                   => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'reviews' ),
				'return'                          => esc_html__( 'Return to Required Plugins Installer', 'reviews' ),
				'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'reviews' ),
				'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'reviews' ),
				'nag_type'                        => 'updated'
			)
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'reviews_requred_plugins' );
}

if (!isset($content_width))
	{
	$content_width = 1920;
	}

/* do shortcodes in the excerpt */
add_filter('the_excerpt', 'do_shortcode');


if( !function_exists('reviews_count_clicks') ){
function reviews_count_clicks(){
	$post_id = get_the_ID();
	$review_clicks = get_post_meta( $post_id, 'review_clicks', true );
	if( !empty( $review_clicks ) ){
		$review_clicks++;
	}
	else{
		$review_clicks = 1;
	}

	update_post_meta( $post_id, 'review_clicks', $review_clicks );
}
}

/* include custom made widgets */
if( !function_exists('reviews_widgets_init') ){
function reviews_widgets_init(){

	register_sidebar(array(
		'name' => esc_html__('Blog Sidebar', 'reviews') ,
		'id' => 'blog',
		'before_widget' => '<div class="widget white-block clearfix %2$s" >',
		'after_widget' => '</div>',
		'before_title' => '<div class="widget-title-wrap"><h5 class="widget-title"><i class="fa fa-angle-double-right"></i>',
		'after_title' => '</h5></div>',
		'description' => esc_html__('Appears on the right side of the blog single page.', 'reviews')
	));	

	register_sidebar(array(
		'name' => esc_html__('Reviews Sidebar', 'reviews') ,
		'id' => 'reviews',
		'before_widget' => '<div class="widget white-block clearfix %2$s" >',
		'after_widget' => '</div>',
		'before_title' => '<div class="widget-title-wrap"><h5 class="widget-title"><i class="fa fa-angle-double-right"></i>',
		'after_title' => '</h5></div>',
		'description' => esc_html__('Appears on the right side of the reviews single pages.', 'reviews')
	));		

	register_sidebar(array(
		'name' => esc_html__('Reviews Search Sidebar', 'reviews') ,
		'id' => 'reviews-search',
		'before_widget' => '<div class="widget white-block clearfix %2$s" >',
		'after_widget' => '</div>',
		'before_title' => '<div class="widget-title-wrap"><h5 class="widget-title"><i class="fa fa-angle-double-right"></i>',
		'after_title' => '</h5></div>',
		'description' => esc_html__('Appears on the left side of the reviews search page.', 'reviews')
	));	

	register_sidebar(array(
		'name' => esc_html__('Page Left Sidebar', 'reviews') ,
		'id' => 'left',
		'before_widget' => '<div class="widget white-block clearfix %2$s" >',
		'after_widget' => '</div>',
		'before_title' => '<div class="widget-title-wrap"><h5 class="widget-title"><i class="fa fa-angle-double-right"></i>',
		'after_title' => '</h5></div>',
		'description' => esc_html__('Appears on the left side of the page.', 'reviews')
	));	
	
	register_sidebar(array(
		'name' => esc_html__('Page Right Sidebar', 'reviews') ,
		'id' => 'right',
		'before_widget' => '<div class="widget white-block clearfix %2$s" >',
		'after_widget' => '</div>',
		'before_title' => '<div class="widget-title-wrap"><h5 class="widget-title"><i class="fa fa-angle-double-right"></i>',
		'after_title' => '</h5></div>',
		'description' => esc_html__('Appears on the right side of the page.', 'reviews')
	));

	register_sidebar(array(
		'name' => esc_html__('Bottom Sidebar 1', 'reviews') ,
		'id' => 'bottom-1',
		'before_widget' => '<div class="widget white-block clearfix %2$s" >',
		'after_widget' => '</div>',
		'before_title' => '<div class="widget-title-wrap"><h5 class="widget-title"><i class="fa fa-angle-double-right"></i>',
		'after_title' => '</h5></div>',
		'description' => esc_html__('Appears on the right side of the page.', 'reviews')
	));	

	register_sidebar(array(
		'name' => esc_html__('Bottom Sidebar 2', 'reviews') ,
		'id' => 'bottom-2',
		'before_widget' => '<div class="widget white-block clearfix %2$s" >',
		'after_widget' => '</div>',
		'before_title' => '<div class="widget-title-wrap"><h5 class="widget-title"><i class="fa fa-angle-double-right"></i>',
		'after_title' => '</h5></div>',
		'description' => esc_html__('Appears on the right side of the page.', 'reviews')
	));	

	register_sidebar(array(
		'name' => esc_html__('Bottom Sidebar 3', 'reviews') ,
		'id' => 'bottom-3',
		'before_widget' => '<div class="widget white-block clearfix %2$s" >',
		'after_widget' => '</div>',
		'before_title' => '<div class="widget-title-wrap"><h5 class="widget-title"><i class="fa fa-angle-double-right"></i>',
		'after_title' => '</h5></div>',
		'description' => esc_html__('Appears on the right side of the page.', 'reviews')
	));	


	register_sidebar(array(
		'name' => esc_html__('Bottom Sidebar 4', 'reviews') ,
		'id' => 'bottom-4',
		'before_widget' => '<div class="widget white-block clearfix %2$s" >',
		'after_widget' => '</div>',
		'before_title' => '<div class="widget-title-wrap"><h5 class="widget-title"><i class="fa fa-angle-double-right"></i>',
		'after_title' => '</h5></div>',
		'description' => esc_html__('Appears on the right side of the page.', 'reviews')
	));		
}

add_action('widgets_init', 'reviews_widgets_init');
}

if( !function_exists('reviews_wp_title') ){
function reviews_wp_title( $title, $sep ) {
	global $paged, $page, $reviews_slugs;

	if ( is_feed() ){
		return $title;
	}

	if( !empty( $_GET[$reviews_slugs['keyword']] ) ){
		$title = $_GET[$reviews_slugs['keyword']]." $sep ".$title;
	}

	if( !empty( $_GET[$reviews_slugs['review-category']] ) ){
		$term = get_term_by( 'slug', $_GET[$reviews_slugs['review-category']], 'review-category' );
		$title = $term->name." $sep ".$title;
	}

	if( !empty( $_GET[$reviews_slugs['review-tag']] ) ){
		$term = get_term_by( 'slug', $_GET[$reviews_slugs['review-tag']], 'review-tag' );
		$title = $term->name." $sep ".$title;
	}

	return $title;
}
add_filter( 'wp_title', 'reviews_wp_title', 10, 2 );
}

if( !function_exists('reviews_wp_title_new') ){
function reviews_wp_title_new( $title ) {
	global $reviews_slugs;
	if( !empty( $_GET[$reviews_slugs['keyword']] ) ){
		$title['title'] = $_GET[$reviews_slugs['keyword']]." - ".$title['title'];
	}

	if( !empty( $_GET[$reviews_slugs['review-category']] ) ){
		$term = get_term_by( 'slug', $_GET[$reviews_slugs['review-category']], 'review-category' );
		$title['title'] = $term->name." - ".$title['title'];
	}

	if( !empty( $_GET[$reviews_slugs['review-tag']] ) ){
		$term = get_term_by( 'slug', $_GET[$reviews_slugs['review-tag']], 'review-tag' );
		$title['title'] = $term->name." - ".$title['title'];
	}

    return $title;
}
add_filter( 'document_title_parts', 'reviews_wp_title_new', 10, 1 );
}

if( !function_exists('reviews_wp_seo_title') ){
function reviews_wp_seo_title( $title ) {
	global $reviews_slugs;
	if( !empty( $_GET[$reviews_slugs['keyword']] ) ){
		$title = $_GET[$reviews_slugs['keyword']]." - ".$title;
	}

	if( !empty( $_GET[$reviews_slugs['review-category']] ) ){
		$term = get_term_by( 'slug', $_GET[$reviews_slugs['review-category']], 'review-category' );
		$title = $term->name." - ".$title;
	}

	if( !empty( $_GET[$reviews_slugs['review-tag']] ) ){
		$term = get_term_by( 'slug', $_GET[$reviews_slugs['review-tag']], 'review-tag' );
		$title = $term->name." - ".$title;
	}

    return $title;
}
add_filter( 'wpseo_title', 'reviews_wp_seo_title' );
}

/* total_defaults */
if( !function_exists('reviews_defaults') ){
function reviews_defaults( $id ){	
	$defaults = array(
		'enable_sticky'  => 'yes',
		'show_top_bar' => 'no',
		'top_bar_message' => 'no',
		'site_logo' => array( 'url' => '' ),
		'site_favicon' => array( 'url' => '' ),
		'home_bs_img_1' => array( 'url' => '' ),
		'home_bs_img_2' => array( 'url' => '' ),
		'home_bs_img_3' => array( 'url' => '' ),
		'home_bs_img_4' => array( 'url' => '' ),
		'home_bs_img_5' => array( 'url' => '' ),
		'home_bs_img_6' => array( 'url' => '' ),
		'home_bs_img_7' => array( 'url' => '' ),
		'home_bs_img_8' => array( 'url' => '' ),
		'home_bs_img_9' => array( 'url' => '' ),
		'home_bs_img_10' => array( 'url' => '' ),
		'home_bs_title' => '',
		'home_bs_subtitle' => '',
		'similar_reviews_num' => '3',
		'reviews_per_page' => '8',
		'reviews_listing_style' => 'masonry',
		'reviews_cta_text' => esc_html__( 'READ MORE', 'reviews' ),
		'reviews_show_author' => 'yes',
		'title_before_images' => 'no',
		'trans_review' => 'review',
		'trans_review-category' => 'review-category',
		'trans_review-tag' => 'review-tag',
		'trans_keyword' => 'keyword',
		'trans_sort' => 'sort',
		'enable_share' => 'yes',
		'facebook_share' => 'yes',
		'twitter_share' => 'yes',
		'google_share' => 'yes',
		'linkedin_share' => 'yes',
		'tumblr_share' => 'yes',
		'mail_chimp_api' => '',
		'mail_chimp_list_id' => '',
		'registration_subject' => '',
		'registration_message' => '',
		'sender_name' => '',
		'sender_email' => '',
		'recover_subject' => '',
		'recover_message' => '',
		'top_bar_bg_color' => '#ffffff',
		'top_bar_font' => '#676767',
		'navigation_bg_color' => '#2980B9',
		'navigation_font_color' => '#ffffff',
		'navigation_font' => 'Montserrat',
		'navigation_font_size' => '13px',
		'breadcrumbs_bg_color' => '#ffffff',
		'breadcrumbs_font_color' => '#676767',
		'main_button_bg_color' => '#9ACC55',
		'main_button_font_color' => '#ffffff',
		'main_button_bg_color_hvr' => '#232323',
		'main_button_font_color_hvr' => '#ffffff',
		'pag_button_bg_color_active' => '#454545',
		'pag_button_font_color_active' => '#ffffff',
		'text_font' => 'Open+Sans',
		'text_font_size' => '13px',
		'text_line_height' => '23px',
		'title_font' => 'Montserrat',
		'h1_font_size' => '38px',
		'h1_line_height' => '1.25',
		'h2_font_size' => '32px',
		'h2_line_height' => '1.25',
		'h3_font_size' => '28px',
		'h3_line_height' => '1.25',
		'h4_font_size' => '22px',
		'h4_line_height' => '1.25',
		'h5_font_size' => '18px',
		'h5_line_height' => '1.25',
		'h6_font_size' => '13px',
		'h6_line_height' => '1.25',
		'body_bg_image' => array( 'url' => '' ),
		'body_bg_color' => '#f5f5f5',
		'copyrights_bg_color' => '#333',
		'copyrights_font_color' => '#ffffff',
		'cta_bg_color' => '#9ACC55',
		'cta_font_color' => '#ffffff',
		'cta_bg_color_hvr' => '#232323',
		'cta_font_color_hvr' => '#ffffff',
		'contact_form_email' => '',
		'contact_map' => '',
		'copyrights' => '',
		'copyrights-facebook' => '',
		'copyrights-twitter' => '',
		'copyrights-google' => '',
		'copyrights-linkedin' => '',
		'copyrights-tumblr' => '',
	);
	
	if( isset( $defaults[$id] ) ){
		return $defaults[$id];
	}
	else{
		
		return '';
	}
}
}

/* get option from theme options */
if( !function_exists('reviews_get_option') ){
function reviews_get_option($id){
	global $reviews_options;
	if( isset( $reviews_options[$id] ) ){
		$value = $reviews_options[$id];
		if( isset( $value ) ){
			return $value;
		}
		else{
			return '';
		}
	}
	else{
		return reviews_defaults( $id );
	}
}
}

/* setup neccessary theme support, add image sizes */
if( !function_exists('reviews_setup') ){
function reviews_setup(){
	add_theme_support('automatic-feed-links');
	add_theme_support( "title-tag" );
	add_theme_support('html5', array(
		'comment-form',
		'comment-list'
	));
	register_nav_menu('top-navigation', esc_html__('Top Navigation', 'reviews'));
	
	add_theme_support('post-thumbnails' );
	add_theme_support('post-formats',array( 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' ));
	
	set_post_thumbnail_size( 848, 477, true );
	if (function_exists('add_image_size')){
		add_image_size( 'reviews-box-thumb', 360, 203, true );
		add_image_size( 'reviews-box-thumb-alt', 263, 197, true );
		add_image_size( 'reviews-widget-thumb', 50, 50, true );
		add_image_size( 'reviews-avatar-thumb', 25, 25, true );
	}
	add_editor_style();
}
add_action('after_setup_theme', 'reviews_setup');
}

if( !function_exists('reviews_enqueue_font') ){
function reviews_enqueue_font() {
	$load_fonts = array(
		reviews_get_option( 'text_font' ),
		reviews_get_option( 'title_font' ),
		reviews_get_option( 'navigation_font' ),	
	);

	$list = array();
	$loaded_fonts = array();
	foreach( $load_fonts as $font ){
		if( !in_array( $font, $loaded_fonts ) ){
			$loaded_fonts[] = $font;
		}
	}

	foreach( $loaded_fonts as $font ){
		$list[] = $font.':400,700'.( $font == 'Montserrat' ? ',600' : '' );
	}

	$list = implode( '|', $list ).'&subset=all';

	$font_family = str_replace( '+', ' ', $list );
    $font_url = '';
    if ( 'off' !== _x( 'on', 'Google font: on or off', 'reviews' ) ) {
        $font_url = add_query_arg( 'family', urlencode( $font_family ), "//fonts.googleapis.com/css" );
    }

    wp_enqueue_style( 'reviews-fonts', $font_url, array(), '1.0.0' );
}
}


/* setup neccessary styles and scripts */
if( !function_exists('reviews_scripts_styles') ){
function reviews_scripts_styles(){
	/* bootstrap */
	wp_enqueue_style( 'reviews-bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css' );
	wp_enqueue_script('reviews-bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), false, true);

	wp_enqueue_style( 'reviews-awesome', get_template_directory_uri() . '/css/font-awesome.min.css' );
	wp_enqueue_style( 'reviews-carousel', get_template_directory_uri() . '/css/owl.carousel.css' );
	
	reviews_enqueue_font();	
	
	if (is_singular() && comments_open() && get_option('thread_comments')){
		wp_enqueue_script('comment-reply');
	}

		
	/* responsiveslides */
	wp_enqueue_script( 'reviews-responsiveslides',  get_template_directory_uri() . '/js/responsiveslides.min.js', array('jquery'), false, true);

	/* custom */
	wp_enqueue_style( 'reviews-magnific-css', get_template_directory_uri() . '/css/magnific-popup.css' );
	wp_enqueue_script('reviews-magnific', get_template_directory_uri() . '/js/jquery.magnific-popup.min.js', array('jquery'), false, true);


	wp_enqueue_script('reviews-imagesloaded', get_template_directory_uri() . '/js/imagesloaded.js', array('jquery'), false, true);
	wp_enqueue_script('reviews-masonry', get_template_directory_uri() . '/js/masonry.js', array('jquery'), false, true);
	wp_enqueue_script('reviews-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array('jquery'), false, true);
	wp_enqueue_script('reviews-custom', get_template_directory_uri() . '/js/custom.js', array('jquery'), false, true);
	$enable_sticky = reviews_get_option( 'enable_sticky' );
	if( empty( $enable_sticky ) ){
		$enable_sticky = 'yes';
	}
	wp_localize_script( 'reviews-custom', 'reviews_data', array(
		'comment_error' 		=> esc_html__( 'All fields are required', 'reviews' ),
		'allow_empty_review' 	=> reviews_get_option('allow_empty_review'),
		'enable_sticky' 		=> $enable_sticky
	) );

}
add_action('wp_enqueue_scripts', 'reviews_scripts_styles', 2);
}

if( !function_exists('reviews_add_main_style') ){
function reviews_add_main_style(){
	wp_enqueue_style('reviews-style', get_stylesheet_uri() , array('dashicons'));
	ob_start();
	include( reviews_load_path( 'css/main-color.css.php' ) );
	$custom_css = ob_get_contents();
	ob_end_clean();
	wp_add_inline_style( 'reviews-style', $custom_css );	
}
add_action('wp_enqueue_scripts', 'reviews_add_main_style', 4);
}

if( !function_exists('reviews_admin_scripts_styles') ){
function reviews_admin_scripts_styles(){
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_script( 'jquery-ui-sortable' );
	wp_enqueue_script( 'jquery-ui-dialog' );

	wp_enqueue_style( 'reviews-jquery-ui', 'http://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css' );
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_style( 'reviews-awesome', get_template_directory_uri() . '/css/font-awesome.min.css' );

	wp_enqueue_script('reviews-admin', get_template_directory_uri() . '/js/admin.js', array('jquery'), false, true);
	wp_enqueue_style( 'reviews-admin', get_template_directory_uri() . '/css/admin.css' );
}
add_action('admin_enqueue_scripts', 'reviews_admin_scripts_styles');
}


/* add admin-ajax */
if( !function_exists('reviews_custom_head') ){
function reviews_custom_head(){
	echo '<script type="text/javascript">var ajaxurl = \'' . admin_url('admin-ajax.php') . '\';</script>';
}
add_action('wp_head', 'reviews_custom_head');
}

/* check if smeta plugin is installed */
if( !function_exists('reviews_smeta_images') ){
function reviews_smeta_images( $meta_key, $post_id, $default ){
	if(class_exists('SM_Frontend')){
		global $sm;
		return $result = $sm->sm_get_meta($meta_key, $post_id);
	}
	else{		
		return $default;
	}
}
}

/* add custom meta fields using smeta to post types. */
if( !function_exists('reviews_custom_meta') ){
function reviews_custom_meta(){

	$post_meta_standard = array(
		array(
			'id' => 'iframe_standard',
			'name' => esc_html__( 'Input url to be embeded', 'reviews' ),
			'type' => 'text',
		),
	);
	
	$meta_boxes[] = array(
		'title' => esc_html__( 'Standard Post Information', 'reviews' ),
		'pages' => 'post',
		'fields' => $post_meta_standard,
	);	
	
	$post_meta_gallery = array(
		array(
			'id' => 'gallery_images',
			'name' => esc_html__( 'Add images for the gallery', 'reviews' ),
			'type' => 'image',
			'repeatable' => 1
		)
	);

	$meta_boxes[] = array(
		'title' => esc_html__( 'Gallery Post Information', 'reviews' ),
		'pages' => 'post',
		'fields' => $post_meta_gallery,
	);	
	
	
	$post_meta_audio = array(
		array(
			'id' => 'iframe_audio',
			'name' => esc_html__( 'Input URL for the audio', 'reviews' ),
			'type' => 'text',
		),
		
		array(
			'id' => 'audio_type',
			'name' => esc_html__( 'Select type of the audio', 'reviews' ),
			'type' => 'select',
			'options' => array(
				'embed' => esc_html__( 'Embed', 'reviews' ),
				'direct' => esc_html__( 'Direct Link', 'reviews' )
			)
		),
	);
	
	$meta_boxes[] = array(
		'title' => esc_html__( 'Audio Post Information', 'reviews' ),
		'pages' => 'post',
		'fields' => $post_meta_audio,
	);
	
	$post_meta_video = array(
		array(
			'id' => 'video',
			'name' => esc_html__( 'Input video URL', 'reviews' ),
			'type' => 'text',
		),
		array(
			'id' => 'video_type',
			'name' => esc_html__( 'Select video type', 'reviews' ),
			'type' => 'select',
			'options' => array(
				'self' => esc_html__( 'Self Hosted', 'reviews' ),
				'remote' => esc_html__( 'Embed', 'reviews' ),
			)
		),
	);
	
	$meta_boxes[] = array(
		'title' => esc_html__( 'Video Post Information', 'reviews' ),
		'pages' => 'post',
		'fields' => $post_meta_video,
	);
	
	$post_meta_quote = array(
		array(
			'id' => 'blockquote',
			'name' => esc_html__( 'Input the quotation', 'reviews' ),
			'type' => 'textarea',
		),
		array(
			'id' => 'cite',
			'name' => esc_html__( 'Input the quoted person\'s name', 'reviews' ),
			'type' => 'text',
		),
	);
	
	$meta_boxes[] = array(
		'title' => esc_html__( 'Quote Post Information', 'reviews' ),
		'pages' => 'post',
		'fields' => $post_meta_quote,
	);	

	$post_meta_link = array(
		array(
			'id' => 'link',
			'name' => esc_html__( 'Input link', 'reviews' ),
			'type' => 'text',
		),
	);
	
	$meta_boxes[] = array(
		'title' => esc_html__( 'Link Post Information', 'reviews' ),
		'pages' => 'post',
		'fields' => $post_meta_link,
	);

	$reviews_meta = array(
		array(
			'id' => 'review_clicks',
			'name' => esc_html__( 'Review Clicks', 'reviews' ),
			'type' => 'text',
			'default' => '0'
		),
		array(
			'id' => 'review_images',
			'name' => esc_html__( 'Add images', 'reviews' ),
			'type' => 'image',
			'repeatable' => 1
		),
		array(
			'id' => 'review_tabs',
			'name' => esc_html__( 'Add Tab', 'reviews' ),
			'type' => 'group',
			'fields' => array(
				array(
					'id' => 'review_tab_title',
					'type' => 'text',
					'name' => esc_html__( 'Tab Title', 'reviews' ),
				),
				array(
					'id' => 'review_tab_content',
					'type' => 'wysiwyg',
					'name' => esc_html__( 'Tab Content', 'reviews' ),
				)				
			),
			'repeatable' => 1
		),
		array(
			'id' => 'review_pros',
			'name' => esc_html__( 'Product / Service Pros', 'reviews' ),
			'type' => 'text',
			'repeatable' => 1
		),
		array(
			'id' => 'review_cons',
			'name' => esc_html__( 'Product / Service Cons', 'reviews' ),
			'type' => 'text',
			'repeatable' => 1
		),
		array(
			'id' => 'reviews_score',
			'name' => esc_html__( 'Scores', 'reviews' ),
			'type' => 'group',
			'fields' => array(
				array(
					'id' => 'review_criteria',
					'name' => esc_html__( 'Name Of Criteria', 'reviews' ),					
					'type' => 'text',
				),
				array(
					'id' => 'review_score',
					'type' => 'select',
					'name' => esc_html__( 'Criteria Score', 'reviews' ),					
					'options' => array(
						'1' => '1',
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'5' => '5'
					),
				)				
			),
			'repeatable' => 1
		),
	);

	$meta_boxes[] = array(
		'title' => esc_html__( 'Reviews Details', 'reviews' ),
		'pages' => 'review',
		'fields' => $reviews_meta,
	);	

	$reviews_meta = array(
		array(
			'id' => 'review_cta_link',
			'name' => esc_html__( 'Button Link', 'reviews' ),
			'type' => 'text',
		),		
	);

	$meta_boxes[] = array(
		'title' => esc_html__( 'Call To Action Button', 'reviews' ),
		'pages' => 'review',
		'fields' => $reviews_meta,
	);

	$reviews_meta = array(
		array(
			'id' => 'reviews_wtb',
			'name' => esc_html__( 'Stores', 'reviews' ),
			'type' => 'group',
			'fields' => array(
				array(
					'id' => 'review_wtb_store_link',
					'name' => esc_html__( 'Store Link', 'reviews' ),					
					'type' => 'text',
				),
				array(
					'id' => 'review_wtb_store_name',
					'name' => esc_html__( 'Store Name', 'reviews' ),
					'type' => 'text',
				),
				array(
					'id' => 'review_wtb_store_logo',
					'name' => esc_html__( 'Store Logo', 'reviews' ),
					'type' => 'image',
				),
				array(
					'id' => 'review_wtb_price',
					'name' => esc_html__( 'Price', 'reviews' ),
					'type' => 'text',
				),
				array(
					'id' => 'review_wtb_sale_price',
					'name' => esc_html__( 'Sale Price', 'reviews' ),
					'type' => 'text',
				),
				array(
					'id' => 'review_wtb_product_link',
					'name' => esc_html__( 'Product / Service Link', 'reviews' ),
					'type' => 'text',
				),
			),
			'repeatable' => 1
		),	
	);

	$meta_boxes[] = array(
		'title' => esc_html__( 'Where To Buy', 'reviews' ),
		'pages' => 'review',
		'fields' => $reviews_meta,
	);

	return $meta_boxes;
}

add_filter('cmb_meta_boxes', 'reviews_custom_meta');
}

if( !function_exists('reviews_get_top_rated') ){
function reviews_get_top_rated( $num ){
	global $wpdb;
	$results = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT postmeta2.meta_value AS reviews FROM {$wpdb->postmeta} AS postmeta1 LEFT JOIN {$wpdb->postmeta} AS postmeta2 ON postmeta1.post_id = postmeta2.post_id WHERE postmeta1.meta_key = 'review_score' AND postmeta2.meta_key = 'review_reviews' GROUP BY postmeta2.meta_key ORDER BY AVG(postmeta1.meta_value)",
			$num
		)
	);
	$result_array = array();
	foreach( $results as $result ){
		$result_array[] = $result->reviews;
	}

	return $result_array;
}
}

if( !class_exists('reviews_walker') ){
class reviews_walker extends Walker_Nav_Menu {
  
	/**
	* @see Walker::start_lvl()
	* @since 3.0.0
	*
	* @param string $output Passed by reference. Used to append additional content.
	* @param int $depth Depth of page. Used for padding.
	*/
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul role=\"menu\" class=\" dropdown-menu\">\n";
	}

	/**
	* @see Walker::start_el()
	* @since 3.0.0
	*
	* @param string $output Passed by reference. Used to append additional content.
	* @param object $item Menu item data object.
	* @param int $depth Depth of menu item. Used for padding.
	* @param int $current_page Menu item ID.
	* @param object $args
	*/
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$mega_menu_content = get_post_meta( $item->ID, 'mega_menu_content', true );
		/**
		* Dividers, Headers or Disabled
		* =============================
		* Determine whether the item is a Divider, Header, Disabled or regular
		* menu item. To prevent errors we use the strcasecmp() function to so a
		* comparison that is not case sensitive. The strcasecmp() function returns
		* a 0 if the strings are equal.
		*/
		if ( strcasecmp( $item->attr_title, 'divider' ) == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="divider">';
		} 
		else if ( strcasecmp( $item->title, 'divider') == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="divider">';
		} 
		else if ( strcasecmp( $item->attr_title, 'dropdown-header') == 0 && $depth === 1 ) {
			$output .= $indent . '<li role="presentation" class="dropdown-header">' . esc_attr( $item->title );
		} 
		else if ( strcasecmp($item->attr_title, 'disabled' ) == 0 ) {
			$output .= $indent . '<li role="presentation" class="disabled"><a href="#">' . esc_attr( $item->title ) . '</a>';
		} 
		else {
			$class_names = $value = '';
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
			
			if ( $args->has_children || !empty($mega_menu_content) ){
				$class_names .= ' dropdown';
			}
			
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
			$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li' . $id . $value . $class_names .'>';

			$atts = array();
			$atts['title'] = ! empty( $item->title )	? $item->title	: '';
			$atts['target'] = ! empty( $item->target )	? $item->target	: '';
			$atts['rel'] = ! empty( $item->xfn )	? $item->xfn	: '';

			// If item has_children add atts to a.
			$atts['href'] = ! empty( $item->url ) ? $item->url : '';
			if ( $args->has_children || !empty( $mega_menu_content ) ) {
				$atts['data-toggle']	= 'dropdown';
				$atts['class']	= 'dropdown-toggle';
				$atts['data-hover']	= 'dropdown';
				$atts['aria-haspopup']	= 'true';
			} 

			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			$item_output = $args->before;

			/*
			* Glyphicons
			* ===========
			* Since the the menu item is NOT a Divider or Header we check the see
			* if there is a value in the attr_title property. If the attr_title
			* property is NOT null we apply it as the class name for the glyphicon.
			*/
			
			$item_output .= '<a'. $attributes .'>';

			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			if( ( $args->has_children ) || !empty( $mega_menu_content ) ){
				$item_output .= ' <i class="fa fa-angle-down"></i>';
			}
			$item_output .= '</a>';
			if( !empty( $mega_menu_content ) ){
				$mega_menu = get_post( $mega_menu_content );
				$item_output .= '<div class="mega_menu_dropdown dropdown-menu">'.apply_filters( 'the_content', $mega_menu->post_content ).'</div>';
			}
			$item_output .= $args->after;
			
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}

	/**
	* Traverse elements to create list from elements.
	*
	* Display one element if the element doesn't have any children otherwise,
	* display the element and its children. Will only traverse up to the max
	* depth and no ignore elements under that depth.
	*
	* This method shouldn't be called directly, use the walk() method instead.
	*
	* @see Walker::start_el()
	* @since 2.5.0
	*
	* @param object $element Data object
	* @param array $children_elements List of elements to continue traversing.
	* @param int $max_depth Max depth to traverse.
	* @param int $depth Depth of current element.
	* @param array $args
	* @param string $output Passed by reference. Used to append additional content.
	* @return null Null on failure with no changes to parameters.
	*/
	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
		if ( ! $element )
			return;

		$id_field = $this->db_fields['id'];

		// Display this element.
		if ( is_object( $args[0] ) ){
		   $args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
		}

		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

	/**
	* Menu Fallback
	* =============
	* If this function is assigned to the wp_nav_menu's fallback_cb variable
	* and a manu has not been assigned to the theme location in the WordPress
	* menu manager the function with display nothing to a non-logged in user,
	* and will add a link to the WordPress menu manager if logged in as an admin.
	*
	* @param array $args passed from the wp_nav_menu function.
	*
	*/
	public static function fallback( $args ) {
		if ( current_user_can( 'manage_options' ) ) {

			extract( $args );

			$fb_output = null;

			if ( $container ) {
				$fb_output = '<' . $container;

				if ( $container_id ){
					$fb_output .= ' id="' . $container_id . '"';
				}

				if ( $container_class ){
					$fb_output .= ' class="' . $container_class . '"';
				}

				$fb_output .= '>';
			}

			$fb_output .= '<ul';

			if ( $menu_id ){
				$fb_output .= ' id="' . $menu_id . '"';
			}

			if ( $menu_class ){
				$fb_output .= ' class="' . $menu_class . '"';
			}

			$fb_output .= '>';
			$fb_output .= '<li><a href="' . admin_url( 'nav-menus.php' ) . '">Add a menu</a></li>';
			$fb_output .= '</ul>';

			if ( $container ){
				$fb_output .= '</' . $container . '>';
			}

			echo  $fb_output;
		}
	}
}
}

/*generate random password*/
if( !function_exists('reviews_random_string') ){
function reviews_random_string( $length = 10 ) {
	$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$random = '';
	for ($i = 0; $i < $length; $i++) {
		$random .= $characters[rand(0, strlen($characters) - 1)];
	}
	return $random;
}
}


/* create tags list */
if( !function_exists('reviews_the_tags') ){
function reviews_the_tags(){
	$tags = get_the_tags();
	$list = array();
	if( !empty( $tags ) ){
		foreach( $tags as $tag ){
			$list[] = '<a href="'.esc_url( get_tag_link( $tag->term_id ) ).'">'.$tag->name.'</a>';
		}
	}
	
	return join( ", ", $list );
}
}

if( !function_exists('reviews_custom_tax') ){
function reviews_custom_tax( $tax, $post_id = '' ){
	global $reviews_slugs;
	if( empty( $post_id ) ){
		$post_id = get_the_ID();
	}
	$search = reviews_get_permalink_by_tpl( 'page-tpl_search' );
	$terms = get_the_terms( $post_id, $tax );
	$list = array();
	if( !empty( $terms ) ){
		foreach( $terms as $term ){
			$list[] = '<a rel="nofollow" href="'.esc_url( add_query_arg( array( $reviews_slugs[$tax] => $term->slug ), $search ) ).'">'.$term->name.'</a>';
		}
	}
	
	return join( ", ", $list );
}
}

if( !function_exists('reviews_cloud_sizes') ){
function reviews_cloud_sizes($args) {
	$args['smallest'] = 13;
	$args['largest'] = 13;
	$args['unit'] = 'px';
	return $args; 
}
add_filter('widget_tag_cloud_args','reviews_cloud_sizes');
}

if( !function_exists('reviews_the_category') ){
function reviews_the_category(){
	$list = '';
	$categories = get_the_category();
	if( !empty( $categories ) ){
		foreach( $categories as $category ){
			$list .= '<a href="'.esc_url( get_category_link( $category->term_id ) ).'">'.$category->name.'</a> ';
		}
	}
	
	return $list;
}
}

/* check if the blog has any media */
if( !function_exists('reviews_has_media') ){
function reviews_has_media(){
	$post_format = get_post_format();
	switch( $post_format ){
		case 'aside' : 
			return has_post_thumbnail() ? true : false; break;
			
		case 'audio' :
			$post_meta = get_post_custom();
			$iframe_audio = get_post_meta( get_the_ID(), 'iframe_audio', true );
			if( !empty( $iframe_audio ) ){
				return true;
			}
			else if( has_post_thumbnail() ){
				return true;
			}
			else{
				return false;
			}
			break;
			
		case 'chat' : 
			return has_post_thumbnail() ? true : false; break;
		
		case 'gallery' :
			$post_meta = get_post_custom();
			$gallery_images = get_post_meta( get_the_ID(), 'gallery_images' );
			if( !empty( $gallery_images ) ){
				return true;
			}
			else if( has_post_thumbnail() ){
				return true;
			}			
			else{
				return false;
			}
			break;
			
		case 'image':
			return has_post_thumbnail() ? true : false; break;
			
		case 'link' :
			$post_meta = get_post_custom();
			$link = get_post_meta( get_the_ID(), 'link', true );
			if( !empty( $link ) ){
				return true;
			}
			else{
				return false;
			}
			break;
			
		case 'quote' :
			$post_meta = get_post_custom();
			$blockquote = get_post_meta( get_the_ID(), 'blockquote', true );
			$cite = get_post_meta( get_the_ID(), 'cite', true );
			if( !empty( $blockquote ) || !empty( $cite ) ){
				return true;
			}
			else if( has_post_thumbnail() ){
				return true;
			}
			else{
				return false;
			}
			break;
		
		case 'status' :
			return has_post_thumbnail() ? true : false; break;
	
		case 'video' :
			$post_meta = get_post_custom();
			$video_url = get_post_meta( get_the_ID(), 'video', true );		
			if( !empty( $video_url ) ){
				return true;
			}
			else if( has_post_thumbnail() ){
				return true;
			}
			else{
				return false;
			}
			break;
			
		default: 
			$post_meta = get_post_custom();
			$iframe_standard = get_post_meta( get_the_ID(), 'iframe_standard', true );
			if( !empty( $iframe_standard ) ){
				return true;
			}
			else if( has_post_thumbnail() ){
				return true;
			}
			else{
				return false;
			}
			break;
	}	
}
}


/*======================CONTACT FUNCTIONS==============*/
if( !function_exists('reviews_send_contact') ){
function reviews_send_contact(){
	$errors = array();
	$name = esc_sql( $_POST['name'] );	
	$email = esc_sql( $_POST['email'] );
	$subject = esc_sql( $_POST['subject'] );
	$message = esc_sql( $_POST['message'] );
	$phone = esc_sql( $_POST['phone'] );
	if( empty( $name ) || empty( $subject ) || empty( $email ) || empty( $message ) ){
		$response = array(
			'error' => esc_html__( 'Required fields are marked with *.', 'reviews' ),
		);
	}
	else if( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
		$response = array(
			'error' => esc_html__( 'E-mail address is not valid.', 'reviews' ),
		);	
	}
	else{
		$email_to = reviews_get_option( 'contact_form_email' );
		$message = "
			".esc_html__( 'Name: ', 'reviews' )." {$name} \n			
			".esc_html__( 'Email: ', 'reviews' )." {$email} \n
			".esc_html__( 'Message: ', 'reviews' )."\n {$message} \n
			".esc_html__( 'Phone: ', 'reviews' )."\n {$phone} \n
		";
		
		$info = @wp_mail( $email_to, $subject, $message );
		if( $info ){
			$response = array(
				'success' => esc_html__( 'Your message was successfully submitted.', 'reviews' ),
			);
		}
		else{
			$response = array(
				'error' => esc_html__( 'Unexpected error while attempting to send e-mail.', 'reviews' ),
			);
		}
		
	}
	
	echo json_encode( $response );
	die();	
}
add_action('wp_ajax_contact', 'reviews_send_contact');
add_action('wp_ajax_nopriv_contact', 'reviews_send_contact');
}

/* =======================================================SUBSCRIPTION FUNCTIONS */
if( !function_exists('reviews_send_subscription') ){
function reviews_send_subscription( $email = '' ){
	$email = !empty( $email ) ? $email : $_POST["email"];
	$response = array();	
	if( filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
		include( reviews_load_path( 'includes/mailchimp.php' ) );
		$chimp_api = reviews_get_option("mail_chimp_api");
		$chimp_list_id = reviews_get_option("mail_chimp_list_id");
		if( !empty( $chimp_api ) && !empty( $chimp_list_id ) ){
			$mc = new MailChimp( $chimp_api );
			$result = $mc->call('lists/subscribe', array(
				'id'                => $chimp_list_id,
				'email'             => array( 'email' => $email )
			));
			
			if( $result === false) {
				$response['error'] = esc_html__( 'There was an error contacting the API, please try again.', 'reviews' );
			}
			else if( isset($result['status']) && $result['status'] == 'error' ){
				$response['error'] = json_encode($result);
			}
			else{
				$response['success'] = esc_html__( 'You have successuffly subscribed to the newsletter.', 'reviews' );
			}
			
		}
		else{
			$response['error'] = esc_html__( 'API data are not yet set.', 'reviews' );
		}
	}
	else{
		$response['error'] = esc_html__( 'Email is empty or invalid.', 'reviews' );
	}
	
	echo json_encode( $response );
	die();
}
add_action('wp_ajax_subscribe', 'reviews_send_subscription');
add_action('wp_ajax_nopriv_subscribe', 'reviews_send_subscription');
}

if( !function_exists('reviews_hex2rgb') ){
function reviews_hex2rgb( $hex ){
	$hex = str_replace("#", "", $hex);

	$r = hexdec(substr($hex,0,2));
	$g = hexdec(substr($hex,2,2));
	$b = hexdec(substr($hex,4,2));
	return $r.", ".$g.", ".$b; 
}
}

if( !function_exists('reviews_comments') ){
function reviews_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	$add_below = ''; 
	$current_user = wp_get_current_user();
	$author_email = $current_user->user_email;
	global $rate_criterias, $reviews_microdata_review, $reviews_user_overall;
	?>
	<!-- comment -->
	<div class="row comment-row <?php echo $comment->comment_parent != '0' ? esc_attr( 'comment-margin-left' ) : ''; ?> " id="comment-<?php echo esc_attr( get_comment_ID() ) ?>">
		<!-- comment media -->
		<div class="col-sm-12">
			<div class="comment-avatar">
				<?php echo get_avatar( $comment, 100 ); ?>
			</div>
			<div class="comment-content-wrap">
				<div class="comment-name">
					<div class="pull-left">
						<p>
							<strong><?php comment_author(); ?></strong> - <span><?php comment_time( 'F j, Y '.esc_html__('@','reviews').' H:i' ); ?></span>
						</p>
					</div>
					<span class="pull-right">
					<?php
					if( !is_singular( 'review' ) ){
						comment_reply_link( 
							array_merge( 
								$args,
								array( 
									'reply_text' => '<i class="fa fa-share"></i> <small>'.esc_html__( 'Reply', 'reviews' ).'</small>', 
									'add_below' => $add_below, 
									'depth' => $depth, 
									'max_depth' => $args['max_depth'] 
								) 
							) 
						); 
					}?>				
					</span>				
					<div class="clearfix"></div>
				</div>
				<?php 
				if ($comment->comment_approved != '0'){
				?>
					<?php
					if( is_singular( 'review' ) ){
						ob_start();
						comment_text();
						$comment_text = ob_get_contents();
						ob_end_clean();
						if( stristr( $comment_text, '[empty_review_' ) ){
							$comment_text = '';
						}

						if( strlen( $comment_text ) > 250 ){
							$comment_text = '<div class="display-more">'.$comment_text.'</div><div class="display-less">'.wpautop( substr( strip_tags( $comment_text ), 0, 250) ).'</div><a href="javascript:;" class="show-more" data-less="'.esc_html__( '<< Show Less', 'reviews' ).'">'.esc_html__( '>> Show More', 'reviews' ).'</a>';
						}

						echo '<div class="row">';					
							echo '<div class="col-sm-'.( empty( $comment_text ) ? esc_attr('12') : esc_attr('6') ).'">';
								$reviews = get_comment_meta( $comment->comment_ID, 'review', true );
								if( !empty( $reviews ) ){
									echo '<ul class="list-unstyled ordered-list">';
									$reviews = explode( ',', $reviews );
									$user_overall = 0;
									$user_rates = 0;

									$counter = 0;

									for( $i=0; $i<sizeof($reviews); $i++ ){
										if( !empty( $rate_criterias[$i] ) ){
											$temp = explode( '|', $reviews[$i] );
											echo '<li>'.$rate_criterias[$i].'<span class="value user-ratings">';
											reviews_rating_display( $temp[1] );
											echo '</span></li>';
											$user_overall += $temp[1];
											$user_rates++;

											/* Increment overall user rate */
											if( empty( $reviews_user_overall[$counter] ) ){
												$reviews_user_overall[$counter] = 0;
											}
											$reviews_user_overall[$counter] += $temp[1];
											$counter++;
										}
									}
									$user_overall = $user_overall / $user_rates;
									echo '<li>';
										echo '<strong>'.esc_html__( 'Overall', 'reviews' ).':</strong>';
										echo '<span class="value user-ratings">';
											reviews_rating_display( $user_overall );
										echo '</span>';
									echo '</li>';
									echo '</ul>';

									$reviews_microdata_review[] = '{
										"@type": "Review",
										"author": '.json_encode( get_comment_author() ).',
										"datePublished": "'.get_comment_time('Y-m-d').'",
										"description": '.json_encode( get_comment_text() ).',
										"name": "",
										"reviewRating": {
											"@type": "Rating",
											"bestRating": "5",
											"ratingValue": "'.round( $user_overall, 1 ).'",
											"worstRating": "1"
										}
									}';
								}
							echo '</div>';
							if( !empty( $comment_text ) ){
								echo '<div class="col-sm-6">';
									echo $comment_text;
								echo '</div>';
							}
						echo '</div>';
					}
					else{
						comment_text();
					}

					?>
				<?php 
				}
				else{ ?>
					<p><?php esc_html_e('Your comment is awaiting moderation.', 'reviews'); ?></p>				
				<?php
				}
				?>	
			</div>		
		</div><!-- .comment media -->
	</div><!-- .comment -->
	<?php  
}
}

if( !function_exists('reviews_end_comments') ){
function reviews_end_comments(){
	return "";
}
}

if( !function_exists('reviews_embed_html') ){
function reviews_embed_html( $html ) {
    return '<div class="video-container">' . $html . '</div>';
}
add_filter( 'embed_oembed_html', 'reviews_embed_html', 10, 3 );
add_filter( 'video_embed_html', 'reviews_embed_html' ); // Jetpack
}

if( !function_exists('reviews_password_form') ){
function reviews_password_form() {
	global $post;
	$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
	$form = '<form class="protected-post-form" action="' . site_url() . '/wp-login.php?action=postpass" method="post">
				' . esc_html__( "This post is password protected. To view it please enter your password below:", "reviews" ) . '
				<label for="' . $label . '">' . esc_html__( "Password:", "reviews" ) . ' </label><div class="reviews-form"><input name="post_password" class="form-control" id="' . $label . '" type="password" /><a class="btn btn-default submit-live-form"><i class="fa fa-sign-in"></i></a></div>
			</form>
	';
	return $form;
}
add_filter( 'the_password_form', 'reviews_password_form' );
}

if( !function_exists('reviews_shortcode_style') ){
function reviews_shortcode_style( $style_css ){
	$style_css = str_replace( '<style', '<style scoped', $style_css );
	return $style_css;
}
}

/* VIEWS AND LIKES */
/* add new column to the posts listing in the admin area*/
if( !function_exists('reviews_set_extra_columns') ){
function reviews_set_extra_columns( $columns ){
	$columns = array_slice($columns, 0, count($columns) - 1, true) + array("review_id" => esc_html__( 'ID', 'reviews' )) + array_slice($columns, count($columns) - 1, count($columns) - 1, true);
	$columns = array_slice($columns, 0, count($columns) - 1, true) + array("author_average" => esc_html__( 'Author Rate', 'reviews' )) + array_slice($columns, count($columns) - 1, count($columns) - 1, true);
	$columns = array_slice($columns, 0, count($columns) - 1, true) + array("user_average" => esc_html__( 'User Rate', 'reviews' )) + array_slice($columns, count($columns) - 1, count($columns) - 1, true) ;	
	$columns = array_slice($columns, 0, count($columns) - 1, true) + array("review_clicks" => esc_html__( 'Clicks', 'reviews' )) + array_slice($columns, count($columns) - 1, count($columns) - 1, true) ;	
	return $columns;
}
add_filter( 'manage_edit-review_columns', 'reviews_set_extra_columns' );
}

if( !function_exists('reviews_extra_columns') ){
function reviews_extra_columns( $column, $post_id ){
	switch ( $column ) {
		case 'author_average' :
			$author_average = get_post_meta( $post_id, 'author_average', true );
			reviews_rating_display( $author_average );
			break;
		case 'user_average' :
			$user_average = get_post_meta( $post_id, 'user_average', true );
			reviews_rating_display( $user_average );
			break;			
		case 'review_clicks' :
			$review_clicks = get_post_meta( $post_id, 'review_clicks', true );
			echo !empty( $review_clicks ) ? $review_clicks : '0';
			break;
		case 'review_id' :
			echo $post_id;
			break;
	}
}
add_action( 'manage_review_posts_custom_column' , 'reviews_extra_columns' , 10, 2 );
}

if( !function_exists('reviews_sorting_by_extra') ){
function reviews_sorting_by_extra( $columns ){
	$custom = array(
		'author_average'	=> 'author_average',
		'user_average'	=> 'user_average',
		'review_clicks'	=> 'review_clicks',
	);
	return wp_parse_args($custom, $columns);
}
add_filter( 'manage_edit-review_sortable_columns', 'reviews_sorting_by_extra' );
}

if( !function_exists('reviews_sort_by_extra')){
function reviews_sort_by_extra( $query ){
	if( ! is_admin() ){
		return;	
	}

	$orderby = $query->get( 'orderby');
	if( $orderby == 'author_average' || $orderby == 'user_average' || $orderby == 'review_clicks' ){
		$query->set( 'meta_key', $orderby );
		$query->set( 'orderby', 'meta_value_num' );
	}
}
add_action( 'pre_get_posts', 'reviews_sort_by_extra' );
}

if( !function_exists('reviews_get_reviews') ){
function reviews_get_reviews(){
	$post_array = array();
	$args = array( 'post_type' => 'review', 'post_status' => 'publish', 'posts_per_page' => -1 );
	$posts = get_posts( $args );
	
	foreach( $posts as $post ){
		$post_array[$post->post_title] = $post->ID;
	}
	
	return $post_array;
}
}

if( !function_exists('reviews_review_category') ){
function reviews_review_category( $icon_only = false, $post_id = '' ){
	global $reviews_slugs;
	if( empty( $post_id ) ){
		$post_id = get_the_ID();
	}
	$review_categories = reviews_get_object_terms_hierarchical( $post_id,  'review-category' );
	$review_categories = reviews_hierarchical_list( $review_categories );
	if( !empty( $review_categories ) ){
		$permalink = reviews_get_permalink_by_tpl( 'page-tpl_search' );
		$term = array_pop( $review_categories );
		if( !$icon_only ){
			echo '<a rel="nofollow" href="'.esc_url( add_query_arg( array( $reviews_slugs['review-category'] => $term->slug ), $permalink ) ).'">'.$term->name.'</a>';
		}
		else{
			$main = $review_categories[0];
			if( empty( $main ) ){
				$main = $term;
			}
			if( !empty( $main ) ){
				$term_meta = get_option( 'taxonomy_'.$main->term_id );
				if( !empty( $term_meta['category_icon'] ) ){
					$icon = $term_meta['category_icon'];
				}
				else{
					$icon = 'crosshairs'	;
				}
				echo '<a rel="nofollow" title="'.esc_attr( $term->name ).'" href="'.esc_url( add_query_arg( array( $reviews_slugs['review-category'] => $term->slug ), $permalink ) ).'"><i class="fa fa-'.esc_attr( $icon ).'"></i></a>';
			}
		}
	}

}
}

if( !function_exists('reviews_get_taxonomy_list') ){
function reviews_get_taxonomy_list( $taxonomy, $direction = 'right', $fields = 'ids', $parent = 0 ){
	$terms = get_terms( $taxonomy, array( 'parent' => $parent ) );
	$terms_array = array();
	if( !empty( $terms ) ){
		foreach( $terms as $term ){
			if( $direction == 'right' ){
				if( $fields == 'ids' ){
					$terms_array[$term->term_id] = $term->name;
				}
				else{
					$terms_array[$term->slug] = $term->name;	
				}
			}
			else{
				if( $fields == 'ids' ){
					$terms_array[$term->name] = $term->term_id;
				}
				else{
					$terms_array[$term->name] = $term->slug;	
				}
			}
		}
	}

	return $terms_array;
}
}

if( !function_exists('reviews_display_children') ){
function reviews_display_children( $taxonomy, $term_id, $permalink, $number = '' ){
	global $reviews_slugs;
	$terms = get_terms( $taxonomy, array( 'parent' => $term_id, 'number' => $number, 'hide_empty' => false ) );
	$list = '';
	if( !empty( $terms ) ){		
		foreach( $terms as $term ){
			$list .= '<a rel="nofollow" href="'.esc_url( add_query_arg( array( $reviews_slugs['review-category'] => $term->slug ), $permalink ) ).'" class="clearfix">
					'.$term->name.'<span class="badge">'.$term->count.'</span>
				  </a>';
		}
	}

	echo $list;
}
}

if( !function_exists('reviews_display_children_all_cat') ){
function reviews_display_children_all_cat( $taxonomy, $children, $permalink, $permalink_cats, $num_subs ){
	global $reviews_slugs;
	$list = '';
	foreach( $children as $child ){
		$has_children = false;
		$children_more = get_terms( 'review-category', array( 'hide_empty' => false, 'number' => $num_subs, 'parent' => $child->term_id ) );
		if( !empty( $children_more ) ){
			$has_children = true;
		}
		$list .= '<a rel="nofollow" href="'.esc_url( add_query_arg( array( $reviews_slugs['review-category'] => $child->slug ), $has_children ? $permalink_cats : $permalink ) ).'" class="clearfix">
				'.$child->name.'<span class="badge">'.$child->count.'</span>
			  </a>';
	}

	echo $list;
}
}

/* get url by page template */
if( !function_exists('reviews_get_permalink_by_tpl') ){
function reviews_get_permalink_by_tpl( $template_name ){
	$page = get_pages(array(
		'meta_key' => '_wp_page_template',
		'meta_value' => $template_name . '.php'
	));
	if(!empty($page)){
		return get_permalink( $page[0]->ID );
	}
	else{
		return "javascript:;";
	}
}
}

if( !function_exists('reviews_icons_list') ){
function reviews_icons_list( $value ){
	$icons_list = reviews_awesome_icons_list();
	
	$select_data = '<option value="">'.esc_html__( 'No Icon', 'reviews' ).'</option>';
	
	foreach( $icons_list as $key => $label){
		if( !empty( $key ) ){
			$select_data .= '<option value="'.esc_attr( $key ).'" '.( $value == $key ? 'selected="selected"' : '' ).'">'.$key.'</option>';
		}

	}
	
	return $select_data;
}
}

if( !function_exists('reviews_calculate_ratings') ){
function reviews_calculate_ratings( $post_id = '' ){
	if( empty( $post_id ) )	{
		$post_id = get_the_ID();
	}
	$author_average = get_post_meta( $post_id, 'author_average', true );
	$user_average = get_post_meta( $post_id, 'user_average', true );
	if( empty( $author_average ) ){
		$author_average = 0;
	}
	if( empty( $user_average ) ){
		$user_average = 0;
	}
	echo '<span class="author-ratings pull-left">';
	echo '<span class="rating-title">'.esc_html__( 'AUTHOR RATE', 'reviews' ).'</span>';
		reviews_rating_display( $author_average );
	echo '</span>';

	if( comments_open( $post_id ) ){
		echo '<span class="user-ratings pull-right">';
		$direction = reviews_get_option( 'direction' );
		if( $direction == 'rtl' ){
			echo '<span class="rating-title">('.reviews_display_count_reviews( $post_id ).') '.esc_html__( 'USERS RATE', 'reviews' ).'</span>';
		}
		else{
			echo '<span class="rating-title">'.esc_html__( 'USERS RATE', 'reviews' ).' ('.reviews_display_count_reviews( $post_id ).')</span>';
		}
			reviews_rating_display( $user_average );
	}
	echo '</span>';
}
}

if( !function_exists('reviews_display_count_reviews') ){
function reviews_display_count_reviews( $post_id ){
	$user_reviews = get_post_meta( $post_id, 'user_ratings_count', true );
	if( empty( $user_reviews ) ){
		$user_reviews = 0;
	}
	return $user_reviews;
}
}

if( !function_exists('reviews_rating_display') ){
function reviews_rating_display( $average ){
	if( empty( $average ) ){
		$average = 0;
	}
	$stars = array();
	if( $average < 0.5 ){
		for( $i=0; $i<5; $i++ ){
			$stars[] = '<i class="fa fa-star-o"></i>';
		}
	}
	else if( $average < 1 ){
		$stars[] = '<i class="fa fa-star"></i>';
		for( $i=0; $i<5; $i++ ){
			$stars[] = '<i class="fa fa-star-o"></i>';
		}		
	}
	else{
		$flag = false;
		for( $i=1; $i<=5; $i+=0.5 ){
			if( $i <= $average ){
				if( floor( $i ) == $i ){
					$stars[] = '<i class="fa fa-star"></i>';
				}
			}
			else{
				if( !$flag ){
					if( floor( $i ) == $i ){
						$stars[] = '<i class="fa fa-star-half-o"></i>';
					}
					$flag = true;
				}
				else{
					if( floor( $i ) == $i ){
						$stars[] = '<i class="fa fa-star-o"></i>';
					}
				}
			}
		}
	}


	echo join( "", $stars);
}
}

/* --------------------------------------------------------DISABLE BAR---------------------------------------------------*/
/* REGISTER */
if( !function_exists('reviews_register') ){
function reviews_register(){
	$response = array();
	$registration_terms = reviews_get_option( 'registration_terms' );

	if( wp_verify_nonce($_POST['register_field'], 'register') ){
		$username = isset( $_POST['username'] ) ? $_POST['username'] : '';
		$email = isset( $_POST['email'] ) ? $_POST['email'] : '';
		$password = isset( $_POST['password'] ) ? $_POST['password'] : '';
		$repeat_password = isset( $_POST['repeat_password'] ) ? $_POST['repeat_password'] : '';	
		$terms = isset( $_POST['terms'] ) ? true : false;
		if( empty( $registration_terms ) ){
			$terms = true;
		}
		if( $terms ){
			if( empty( $_POST['captcha'] ) ){
				if( !empty( $username ) ){
					if( !empty( $email ) && filter_var($email, FILTER_VALIDATE_EMAIL) ){
						if( !empty( $password ) && !empty( $repeat_password ) && $password == $repeat_password ){
							if( !username_exists( $username ) ){
								if( !email_exists( $email ) ){
			                        $user_id = wp_insert_user(array(
			                            'user_login'  => $username,
			                            'user_pass'   => $password,
			                            'user_email'  => $email
			                        ));
			                        if( !is_wp_error($user_id) ) {
			                            wp_update_user(array(
			                                'ID' => $user_id, 
			                            ));	                        	
			                        	$confirmation_hash = reviews_random_string(10);
			                            update_user_meta( $user_id, 'user_active_status', 'inactive' );
			                            update_user_meta( $user_id, 'confirmation_hash', $confirmation_hash );

			                            $confirmation_message = reviews_get_option( 'registration_message' );
			                            $confirmation_link = reviews_get_permalink_by_tpl( 'page-tpl_register_login' );
			                            $confirmation_link = esc_url( add_query_arg( array( 'username' => $username, 'confirmation_hash' => $confirmation_hash ), $confirmation_link ) );
			                            
			                            $confirmation_message = str_replace( '%LINK%', $confirmation_link, $confirmation_message );

			                            $registration_subject = reviews_get_option( 'registration_subject' );

			                            $email_sender = reviews_get_option( 'sender_email' );
			                            $name_sender = reviews_get_option( 'sender_name' );
			                            $headers   = array();
			                            $headers[] = "MIME-Version: 1.0";
			                            $headers[] = "Content-Type: text/html; charset=UTF-8"; 
			                            $headers[] = "From: ".esc_attr( $name_sender )." <".esc_attr( $email_sender ).">";

			                            $info = @wp_mail( $email, $registration_subject, $confirmation_message, $headers );
			                            if( $info ){
			                            	$response['message'] = '<div class="alert alert-success">'.esc_html__( 'You have registered. Email with the confirmation link is sent on the email address you have provided.', 'reviews' ).'</div>';
			                            }
			                            else{
			                                $response['message'] = '<div class="alert alert-danger">'.esc_html__( 'There was an error trying to send confirmation link to you', 'reviews' ).'</div>';
			                            }                            

			                        }
			                        else{
			                        	$response['message'] = '<div class="alert alert-danger">'.esc_html__( 'There was an error trying to register you', 'reviews' ).'</div>';
			                        }
								}
								else{
									$response['message'] = '<div class="alert alert-danger">'.esc_html__( 'Email is already registered', 'reviews' ).'</div>';					
								}
							}
							else{
								$response['message'] = '<div class="alert alert-danger">'.esc_html__( 'Username is already taken', 'reviews' ).'</div>';			
							}
						}
						else{
							$response['message'] = '<div class="alert alert-danger">'.esc_html__( 'Passwords do not match', 'reviews' ).'</div>';		
						}
					}
					else{
						$response['message'] = '<div class="alert alert-danger">'.esc_html__( 'Email is invalid', 'reviews' ).'</div>';	
					}
				}
				else{
					$response['message'] = '<div class="alert alert-danger">'.esc_html__( 'Username is empty', 'reviews' ).'</div>';
				}
			}
			else{
				$response['message'] = '<div class="alert alert-danger">'.esc_html__( 'Captcha is wrong.', 'reviews' ).'</div>';
			}
		}
		else{
			$response['message'] = '<div class="alert alert-danger">'.esc_html__( 'You need to accept terms & conditions', 'reviews' ).'</div>';
		}
	}
	else{
		$response['message'] = '<div class="alert alert-danger">'.esc_html__( 'You do not have permission for this action', 'reviews' ).'</div>';
	}
	echo json_encode( $response );
	die();
}
add_action('wp_ajax_register', 'reviews_register');
add_action('wp_ajax_nopriv_register', 'reviews_register');
}

/* LOGIN */
if( !function_exists('reviews_login') ){
function reviews_login(){
	$response = array();
	if( wp_verify_nonce($_POST['login_field'], 'login') ){
		$username = isset( $_POST['username'] ) ? $_POST['username'] : '';
		$password = isset( $_POST['password'] ) ? $_POST['password'] : '';
		if( !empty( $username ) && !empty( $password ) ){
			$user = get_user_by( 'login', $username );
			if( $user ){
				$confirmation_hash_db = get_user_meta( $user->ID, 'user_active_status', true );
				if( $confirmation_hash_db == 'active' ){
			        $user = wp_signon( array(
			            'user_login' => $username,
			            'user_password' => $password,
			            'remember' => isset( $_POST['remember_me'] ) ? true : false
			        ), false );
			        
			        if ( is_wp_error( $user ) ){
			            switch( $user->get_error_code() ){
			                case 'invalid_username': 
			                    $message = esc_html__( 'Invalid username', 'reviews' ); 
			                    break;
			                case 'incorrect_password':
			                    $message = esc_html__( 'Invalid password', 'reviews' ); 
			                    break;          
			                default:
			                    $message = esc_html__( 'All fields are required', 'reviews' ); 
			                    break;                    
			            }
			            $response['message'] = '<div class="alert alert-danger">'.$message.'</div>';
			        }
			        else{
			        	$response['message'] = '<div class="alert alert-success">'.esc_html__( 'You have been logged in, now you will be redirected,', 'reviews' ).'</div>';
			            $response['url'] = !empty( $_POST['referer'] ) ? $_POST['referer'] : home_url( '/' );
			        }
			    }
			    else{
			    	$response['message'] = '<div class="alert alert-danger">'.esc_html__( 'Account is not active', 'reviews' ).'</div>';
			    }
			}
		    else{
		    	$response['message'] = '<div class="alert alert-danger">'.esc_html__( 'Username does not exists', 'reviews' ).'</div>';
		    }			
	    }
	    else{
	    	$response['message'] = '<div class="alert alert-danger">'.esc_html__( 'All fields are required', 'reviews' ).'</div>';
	    }
	}
	else{
		$response['message'] = '<div class="alert alert-danger">'.esc_html__( 'You do not have permission for this action', 'reviews' ).'</div>';
	}
	echo json_encode( $response );
	die();
}
add_action('wp_ajax_login', 'reviews_login');
add_action('wp_ajax_nopriv_login', 'reviews_login');
}

if( !function_exists('reviews_recover_action') ){
function reviews_recover_action(){
	$response = array();
	if( wp_verify_nonce($_POST['recover_field'], 'recover') ){
		$hash = isset( $_POST['hash'] ) ? $_POST['hash'] : '';
		$user = isset( $_POST['user'] ) ? $_POST['user'] : '';
		$new_password = isset( $_POST['new_password'] ) ? $_POST['new_password'] : '';
		$new_password_repeat = isset( $_POST['new_password_repeat'] ) ? $_POST['new_password_repeat'] : '';
		if( !empty( $hash ) && !empty( $user ) && !empty( $new_password ) && !empty( $new_password_repeat ) ){
			$user = get_user_by( 'ID', $user );
			if( !empty( $user ) ){
				$saved_hash = get_user_meta( $user->ID, 'change_pass_hash', true );
				if( $hash == $saved_hash ){
					if( $new_password == $new_password_repeat ){
		                $update_fields = array(
		                    'ID'            => $user->ID,
		                    'user_pass'     => $new_password,
		                );
		                wp_update_user( $update_fields );
		                delete_user_meta( $user->ID, 'change_pass_hash' );
		                $response['message'] = '<div class="alert alert-success">'.esc_html__( 'Password is changed, you can log in now', 'reviews' ).'</div>';  
					}
					else{
						$response['message'] = '<div class="alert alert-danger">'.esc_html__( 'Passwords do not match', 'reviews' ).'</div>';  	
					}
				}
				else{
					$response['message'] = '<div class="alert alert-danger">'.esc_html__( 'Hash is invalid', 'reviews' ).'</div>';  
				}
			}
			else{
				$response['message'] = '<div class="alert alert-danger">'.esc_html__( 'User does not exists', 'reviews' ).'</div>';	
			}
		}
		else{
			$response['message'] = '<div class="alert alert-danger">'.esc_html__( 'Fields are empty', 'reviews' ).'</div>';
		}
	}
	else{
		$response['message'] = '<div class="alert alert-danger">'.esc_html__( 'You do not have permission for this action', 'reviews' ).'</div>';
	}

	echo json_encode( $response );
	die();
}
add_action('wp_ajax_recover_action', 'reviews_recover_action');
add_action('wp_ajax_nopriv_recover_action', 'reviews_recover_action');
}

if( !function_exists('reviews_recover') ){
function reviews_recover(){
	$response = array();
	if( wp_verify_nonce($_POST['recover_field'], 'recover') ){
		$email = isset( $_POST['email'] ) ? $_POST['email'] : '';
		if( !empty( $email ) && filter_var($email, FILTER_VALIDATE_EMAIL) ){
			if( email_exists( $email ) ){
				$user = get_user_by( 'email', $email );
				$hash = reviews_random_string( 30 );
                $link = reviews_get_permalink_by_tpl( 'page-tpl_forgot_password' );
                update_user_meta( $user->ID, 'change_pass_hash', $hash );
                $link = esc_url( add_query_arg( array( 'user' => $user->ID, 'hash' => $hash ), $link ) );

                $lost_password_message = reviews_get_option( 'recover_message' );
                $lost_password_message = str_replace( "%LINK%", $link, $lost_password_message );

                $email_sender = reviews_get_option( 'sender_email' );
                $name_sender = reviews_get_option( 'sender_name' );
                $headers   = array();
                $headers[] = "MIME-Version: 1.0";
                $headers[] = "Content-Type: text/html; charset=UTF-8"; 
                $headers[] = "From: ".esc_attr( $name_sender )." <".esc_attr( $email_sender ).">";   

                $lost_password_subject = reviews_get_option( 'recover_subject' );

                $message_info = wp_mail( $email, $lost_password_subject, $lost_password_message, $headers );
                if( $message_info ){
                    $response['message'] = '<div class="alert alert-success">'.esc_html__( 'Email with password recovery instructions is sent to your mail', 'reviews' ).'</div>';  
                }
                else{
                    $response['message'] = '<div class="alert alert-danger">'.esc_html__( 'There was an error trying to send an email', 'reviews' ).'</div>';  
                }
			}
			else{
				$response['message'] = '<div class="alert alert-danger">'.esc_html__( 'Email is not registered', 'reviews' ).'</div>';	
			}
		}
		else{
			$response['message'] = '<div class="alert alert-danger">'.esc_html__( 'Email is invalid', 'reviews' ).'</div>';
		}
	}
	else{
		$response['message'] = '<div class="alert alert-danger">'.esc_html__( 'You do not have permission for this action', 'reviews' ).'</div>';
	}

	echo json_encode( $response );
	die();
}
add_action('wp_ajax_recover', 'reviews_recover');
add_action('wp_ajax_nopriv_recover', 'reviews_recover');
}

/* USER META */
if( !function_exists('reviews_add_social_meta') ){
function reviews_add_social_meta( $user ){
    ?>
        <h3><?php esc_html_e( 'User Status', 'reviews' ) ?></h3>
        <?php $user_active_status = get_user_meta( $user->ID, 'user_active_status', true ); ?>
        <table class="form-table">
            <tr>
                <th><label for="user_active_status"><?php esc_html_e( 'User Status', 'reviews' ); ?></label></th>
                <td>
                	<select name="user_active_status">
                		<option <?php echo $user_active_status == 'inactive' ? esc_attr('selected="selected"') : '' ?> value="inactive"><?php esc_html_e( 'Inactive', 'reviews' ) ?></option>
                		<option <?php echo empty( $user_active_status ) || $user_active_status == 'active' ? 'selected="selected"' : '' ?> value="active"><?php esc_html_e( 'Active', 'reviews' ) ?></option>
                	</select>
                </td>
            </tr>
        </table>        
    <?php
}
add_action( 'show_user_profile', 'reviews_add_social_meta' );
add_action( 'edit_user_profile', 'reviews_add_social_meta' );
}

if( !function_exists('reviews_save_user_meta') ){
function reviews_save_user_meta( $user_id ){
    update_user_meta( $user_id,'user_active_status', sanitize_text_field( $_POST['user_active_status'] ) );
}
add_action( 'personal_options_update', 'reviews_save_user_meta' );
add_action( 'edit_user_profile_update', 'reviews_save_user_meta' );
}

/* --------------------------------------------------------USER COLUMNS---------------------------------------------------*/
/* add user activation user status to the columns */
if( !function_exists('reviews_active_column') ){
function reviews_active_column($columns) {
    $columns['active'] = esc_html__( 'Activation Status', 'reviews' );
    return $columns;
}
add_filter('manage_users_columns', 'reviews_active_column');
}
 
/* add user activation user status data to the columns */
if( !function_exists('reviews_active_column_content') ){
function reviews_active_column_content( $value, $column_name, $user_id ){
	if ( 'active' == $column_name ){
		$usermeta = get_user_meta( $user_id, 'user_active_status', true );
		if( empty( $usermeta ) ||  $usermeta == "active" ){
			return esc_html__( 'Activated', 'reviews' );
		}
		else{
			return esc_html__( 'Need Confirmation', 'reviews' );
		}
	}
    return $value;
}
add_action('manage_users_custom_column',  'reviews_active_column_content', 10, 3);
}

if( !function_exists('reviews_parse_video_url') ){
function reviews_parse_video_url( $url ){
	if( stristr( $url, 'tube' ) ){
		$temp = explode( '?v=', $url );
		$url = '//www.youtube.com/embed/'.$temp[1].'?rel=0';
	}
	else if( stristr( $url, 'vimeo' ) ){
		$temp = explode( '/', $url );
		$url = '//player.vimeo.com/video/'.$temp[sizeof($temp)-1];
	}
	return $url;
}
}

/* COMMENTS REVIEWS  */
if( !function_exists('reviews_calculate_average_rating') ){
function reviews_calculate_average_rating( $post_id ){
	global $wpdb;
	$reviews = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT commentmeta1.meta_value AS review FROM {$wpdb->commentmeta}  AS commentmeta1 LEFT JOIN {$wpdb->comments} AS comments ON commentmeta1.comment_id = comments.comment_ID WHERE comments.comment_approved = 1 AND commentmeta1.meta_key = 'review' AND commentmeta1.comment_id IN ( SELECT comment_ID FROM {$wpdb->comments} WHERE comment_post_ID = %d )",
			$post_id
		)
	);	
	
	$user_average = 0;
	if( !empty( $reviews ) ){
		foreach( $reviews as $review ){
			$reviews_list = explode( ',', $review->review );
			$review_comment_sum = 0;
			if( !empty( $reviews_list ) ){
				foreach( $reviews_list as $reviews_list_item ){
					$temp = explode( '|', $reviews_list_item );
					$review_comment_sum += $temp[1];
				}
				$user_average += $review_comment_sum / count( $reviews_list );
			}
		}

		$user_average = $user_average / count( $reviews );
	}
	update_post_meta( $post_id, 'user_average', round( $user_average, 2 ) );
	update_post_meta( $post_id, 'user_ratings_count', count( $reviews ) );
}
}

if( !function_exists('reviews_calcualte_author_rate') ){
function reviews_calcualte_author_rate( $post_id ){
	if ( ! isset( $_POST['reviews_score'] ) ) {
		return;
	}	
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ( !empty( $_POST ) && $_POST['wp-preview'] == 'dopreview' ) ) {
		return;
	}
	$average_score = 0;
	$counter = 0;
	$reviews_score = $_POST['reviews_score'];
	if( !empty( $reviews_score ) ){
		foreach( $reviews_score as $key => $data ){
			if( $key !== 'cmb-group-x' ){
				$average_score += $data['review_score']['cmb-field-0'];
				$counter++;
			}
		}
	}
	
	if( $counter !== 0 ){
		$average_score = $average_score / $counter;
		$average_score = number_format( $average_score, 2 );
	}

	update_post_meta( $post_id, 'author_average', $average_score );

	$user_average = get_post_meta( $post_id, 'user_average', true );

	if( (int)$user_average === 0 ){
		reviews_calculate_average_rating( $post_id );
	}
	if( empty( $user_average ) ){
		update_post_meta( $post_id, 'user_average', 0 );
		update_post_meta( $post_id, 'user_ratings_count', 0 );
	}

}
add_action( 'save_post', 'reviews_calcualte_author_rate' );
}

if( !function_exists('reviews_breadcrumbs') ){
function reviews_breadcrumbs(){
	global $reviews_slugs;
	$page_on_front = get_option('page_on_front');
	$breadcrumbs = '';
	if( ( is_home() && empty( $page_on_front ) ) || is_front_page() ){
		return $breadcrumbs;
	}
	else{
		$breadcrumbs = '<ul class="list-unstyled list-inline breadcrumbs-list">';
		$breadcrumbs .= '<li><a href="'.esc_url( home_url('/') ).'">'.esc_html__( 'Home', 'reviews' ).'</a></li>';
		if( is_home() ){
			$breadcrumbs .= '<li>'.get_the_title( get_option('page_for_posts') ).'</li>';
		}
		else if( is_404() ){
			$breadcrumbs .= '<li>'.esc_html__( '404 Page', 'reviews' ).'</li>';
		}
		else if( is_tax('review-category') ){
			$term = get_term_by( 'slug', get_query_var('term'), get_query_var('taxonomy') );
			$breadcrumbs .= '<li>'.esc_html__('Category - ', 'reviews').$term->name.'</li>';			
		}
		else if( is_tax('review-tag') ){
			$term = get_term_by( 'slug', get_query_var('term'), get_query_var('taxonomy') );
			$breadcrumbs .= '<li>'.esc_html__('Tag - ', 'reviews').$term->name.'</li>';			
		}		
		else if( is_category() ){
			$breadcrumbs .= '<li><a href="'.get_permalink( get_option('page_for_posts') ).'">'.get_the_title( get_option('page_for_posts') ).'</a></li>';			
			$breadcrumbs .= '<li>'.esc_html__('Category - ', 'reviews').single_cat_title(' ',false).'</li>';
		}
		else if( is_tag() ){
			$breadcrumbs .= '<li><a href="'.get_permalink( get_option('page_for_posts') ).'">'.get_the_title( get_option('page_for_posts') ).'</a></li>';			
			$breadcrumbs .= '<li>'.esc_html__('Tag - ', 'reviews').get_query_var('tag').'</li>';
		}
		else if( is_author() ){
			if( !empty( $_GET['post_type'] ) ){
				$breadcrumbs .= '<li><a href="'.reviews_get_permalink_by_tpl( 'page-tpl_search' ).'">'.esc_html__( 'Search', 'reviews' ).'</a></li>';			
				$breadcrumbs .= '<li>'.esc_html__('Reviews written by ', 'reviews'). get_the_author_meta( 'display_name' ).'</li>';
			}
			else{
				$breadcrumbs .= '<li><a href="'.get_permalink( get_option('page_for_posts') ).'">'.get_the_title( get_option('page_for_posts') ).'</a></li>';			
				$breadcrumbs .= '<li>'.esc_html__('Posts written by ', 'reviews'). get_the_author_meta( 'display_name' ).'</li>';
			}
		}
		else if( is_search() ){
			$breadcrumbs .= '<li><a href="'.get_permalink( get_option('page_for_posts') ).'">'.get_the_title( get_option('page_for_posts') ).'</a></li>';			
			$breadcrumbs .= '<li>'.esc_html__('Search results for: ', 'reviews').' '. get_search_query().'</li>';
		}
		else if( is_archive() ){
			$breadcrumbs .= '<li><a href="'.get_permalink( get_option('page_for_posts') ).'">'.get_the_title( get_option('page_for_posts') ).'</a></li>';			
			$breadcrumbs .= '<li>'.esc_html__('Archive for ', 'reviews').single_month_title(' ',false).'</li>';
		}
		else if( is_page_template( 'page-tpl_search.php' ) ){
			$breadcrumbs .= '<li>'.esc_html__( 'Reviews search results', 'reviews' );
			if( !empty( $_GET[$reviews_slugs['review-category']] ) ){
				$term = get_term_by( 'slug', $_GET[$reviews_slugs['review-category']], 'review-category' );
				$breadcrumbs .= esc_html__(' in ', 'reviews').$term->name;
			}
			if( !empty( $_GET[$reviews_slugs['keyword']] ) ){
				$breadcrumbs .= esc_html__(' for ', 'reviews').'"'.$_GET[$reviews_slugs['keyword']].'"';
			}
			if( !empty( $_GET[$reviews_slugs['review-tag']] ) ){
				$breadcrumbs .= esc_html__(' tagged with', 'reviews').'"'.$_GET[$reviews_slugs['review-tag']].'"';
			}			
			$breadcrumbs .= '</li>';
		}
		else if( is_page_template( 'page-tpl_all_categories.php' ) ){
			if( isset( $_GET[$reviews_slugs['review-category']] ) ){
				$breadcrumbs .= '<li><a href="'.get_the_permalink().'">'.get_the_title().'</a></li>';	
				$term = get_term_by( 'slug', $_GET[$reviews_slugs['review-category']], 'review-category' );
				if( !empty( $term ) ){
					$breadcrumbs .= '<li>'.$term->name.'</li>';
				}
			}
			else{
				$breadcrumbs .= '<li>'.get_the_title().'</li>';
			}
		}
		else if( is_singular('post') ){
			$blog_id = get_option('page_for_posts');
			if( !empty( $blog_id ) ){
				$breadcrumbs .= '<li><a href="'.get_permalink( $blog_id ).'">'.get_the_title( $blog_id ).'</a></li>';
			}
			$category = get_the_category(); 
			if($category[0]){
				$breadcrumbs .= '<li><a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a></li>';
			}
			$breadcrumbs .= '<li>'.get_the_title().'</li>';
		}
		else if( is_singular('review') ){
			the_post();
			$terms = reviews_get_object_terms_hierarchical( get_the_ID(),  'review-category' );
			if( !empty( $terms ) ){
				$breadcrumbs .= reviews_list_categories_li( $terms );
			}
			$breadcrumbs .= '<li>'.get_the_title().'</li>';
		}
		else{
			$breadcrumbs .= '<li>'.get_the_title().'</li>';	
		}
		$breadcrumbs .= '</ul>';
	}

	return $breadcrumbs;
}
}

if( !function_exists('reviews_hierarchical_list') ){
function reviews_hierarchical_list( $list ){
	$list_array = array();
	foreach( $list as $list_item ){
		$list_array[] = $list_item;
		if( !empty( $list_item->children ) ){
			$list_array = array_merge( $list_array, reviews_hierarchical_list($list_item->children) );
		}
	}

	return $list_array;
}
}

if( !function_exists('reviews_get_object_terms_hierarchical') ){
function reviews_get_object_terms_hierarchical( $object_ids, $taxonomies, $args = array() ) {

	$tree  = array();
	$terms = wp_get_object_terms( $object_ids, $taxonomies, $args );

	if ( ! empty( $terms ) ) {
		foreach ( $terms as $term ) {
			if ( $term->parent == 0 ) {
				$tree[ $term->term_id ] = $term;
				$tree[ $term->term_id ]->children = reviews_get_child_terms( $term->term_id, $terms );
			}
		}
	}

	return $tree;
}
}

if( !function_exists('reviews_get_child_terms') ){
function reviews_get_child_terms( $parent_id, $terms ) {
	$children = array();
	foreach ( $terms as $term ) {
		if ( $term->parent == $parent_id ) {
			$children[ $term->term_id ] = $term;
			$children[ $term->term_id ]->children = reviews_get_child_terms( $term->term_id, $terms );
		}
	}

	return $children;
}
}

if( !function_exists('reviews_list_categories_li') ){
function reviews_list_categories_li( $terms ){
	global $reviews_slugs;
	$list = '';
	foreach( $terms as $term ){
		$list .= '<li><a rel="nofollow" href="'.esc_url( add_query_arg( array( $reviews_slugs['review-category'] => $term->slug ), reviews_get_permalink_by_tpl( 'page-tpl_search' ) )  ).'">'.$term->name.'</a></li>';
		if( !empty( $term->children ) )	{
			$list .= reviews_list_categories_li( $term->children );
		}
	}

	return $list;
}
}

if( !function_exists('reviews_display_categories_filter') ){
function reviews_display_categories_filter( $ancestors = array(), $permalink = '', $parent = 0, $depth = 0 ){
	global $reviews_slugs;
	$categories = get_terms( 'review-category', array(
		'hide_empty' => false,
		'parent' => $parent
	));

	if( !empty( $categories ) ){
		foreach( $categories as $category ){
			$option = '<option value="'.esc_attr( $category->slug ).'" '.( isset( $_GET[$reviews_slugs['review-category']] ) && $_GET[$reviews_slugs['review-category']] == $category->slug ? 'selected="selected"' : '' ).'>';
			$option .= str_repeat('&nbsp;&nbsp;', $depth).$category->name.' ('.reviews_count_filter( $category ).')';
			$option .= '</option>';
			echo  $option;

			if( in_array( $category->term_id, $ancestors ) ){
				reviews_display_categories_filter( $ancestors, $permalink, $category->term_id, $depth+1 );
			}
		}
	}
}
}

$reviews_term_count = array();
if( !function_exists('reviews_count_filter') ){
function reviews_count_filter( $category ){
	global $reviews_term_count, $wpdb, $reviews_slugs;
	if( empty( $reviews_term_count ) ){

		$review_category = isset( $_GET[$reviews_slugs['review-category']] ) ? esc_sql( $_GET[$reviews_slugs['review-category']] ) : '';
		$review_tag = isset( $_GET[$reviews_slugs['review-tag']] ) ? esc_sql( $_GET[$reviews_slugs['review-tag']] ) : '';
		$keyword = isset( $_GET[$reviews_slugs['keyword']] ) ? esc_sql( $_GET[$reviews_slugs['keyword']] ) : '';

		$query = "SELECT terms1.term_id as ID, COUNT(posts.ID) AS posts 
					FROM {$wpdb->posts} AS posts 
					LEFT JOIN {$wpdb->term_relationships} AS termsrel1 ON posts.ID = termsrel1.object_id 
					LEFT JOIN {$wpdb->terms} AS terms1 ON termsrel1.term_taxonomy_id = terms1.term_id 
					LEFT JOIN {$wpdb->term_taxonomy} AS tax ON termsrel1.term_taxonomy_id = tax.term_taxonomy_id ";
		if( !empty( $review_tag ) ){
			$query .= "LEFT JOIN {$wpdb->term_relationships} AS termsrel2 ON posts.ID = termsrel2.object_id  ";
			$query .= "LEFT JOIN {$wpdb->terms} AS terms2 ON termsrel2.term_taxonomy_id = terms2.term_id ";
			$query .= "LEFT JOIN {$wpdb->term_taxonomy} AS tax2 ON termsrel2.term_taxonomy_id = tax2.term_taxonomy_id ";
		}
		$query .= "
					WHERE posts.post_type = 'review' 
					AND posts.post_status = 'publish' 
					AND tax.taxonomy = 'review-category' 
					";
		if( !empty( $keyword ) ){
			$keywords = explode( " ", $keyword );
			$query .= "AND ";
			for( $i=0; $i<sizeof( $keywords ); $i++ ){
				$query .= "( posts.post_title LIKE '%".esc_sql( $keywords[$i] )."%' OR posts.post_content LIKE '%".esc_sql( $keywords[$i] )."%' ) ";
				if( $i<sizeof( $keywords )-1 ){
					$query .= "AND ";
				}
			}
		}
		if( !empty( $review_tag ) ){
			$query .= "AND terms2.slug = '".esc_sql( $review_tag )."' ";
			$query .= "AND tax2.taxonomy = 'review-tag' ";
		}
		$query .= "GROUP BY terms1.term_id";

		$reviews_term_count = $wpdb->get_results( $query );

	}

	$count = 0;
	foreach( $reviews_term_count as $key => $item ){
		if( $item->ID == $category->term_id ){
			$count = $item->posts;
			unset( $reviews_term_count[$key] );
			break;
		}
	}	

	return $count;
}
}

if( !function_exists('reviews_author_list') ){
function reviews_author_list(){
	$users = get_users();
	$users_list = array();
	if( !empty( $users ) ){
		foreach( $users as $user ){
			if( !empty( $user->display_name ) ){
				$users_list[$user->display_name] = $user->ID;
			}
			else{
				$users_list[$user->display_name] = $user->ID;	
			}
		}
	}

	return $users_list;
}
}

/* Slug manipulatoin */
global $reviews_slugs;
$reviews_slugs = array(
	'review' => 'review',
	'review-category' => 'review-category',
	'review-tag' => 'review-tag',
	'keyword' => 'keyword',
	'sort' => 'sort',
);

if( !function_exists('reviews_get_slugs') ){
function reviews_get_slugs(){
	global $reviews_slugs;
	foreach( $reviews_slugs as &$slug ){
		$trans = reviews_get_option( 'trans_'.$slug );
		if( !empty( $trans ) ){
			$slug = $trans;
		}
	}
}
add_action( 'init', 'reviews_get_slugs', 1, 0);
}

if( !function_exists('reviews_set_direction') ){
function reviews_set_direction() {
	global $wp_locale, $wp_styles;

	$_user_id = get_current_user_id();
	$direction = reviews_get_option( 'direction' );
	if( empty( $direction ) ){
		$direction = 'ltr';
	}

	if ( $direction ) {
		update_user_meta( $_user_id, 'rtladminbar', $direction );
	} else {
		$direction = get_user_meta( $_user_id, 'rtladminbar', true );
		if ( false === $direction )
			$direction = isset( $wp_locale->text_direction ) ? $wp_locale->text_direction : 'ltr' ;
	}

	$wp_locale->text_direction = $direction;
	if ( ! is_a( $wp_styles, 'WP_Styles' ) ) {
		$wp_styles = new WP_Styles();
	}
	$wp_styles->text_direction = $direction;
}
add_action( 'init', 'reviews_set_direction' );
}

if( !function_exists('reviews_lazy_load_product_images') ){
function reviews_lazy_load_product_images($attr) {
	$attr['data-src'] = $attr['src'];
	$attr['src'] = get_template_directory_uri().'/images/holder.jpg';
	$attr['class'] .= ' reviews-lazy-load';
	return $attr;
}
}

if( !function_exists('reviews_single_review_slider_images') ){
function reviews_single_review_slider_images( $image_id ) {
	$post_thumbnail_data = wp_get_attachment_image_src( $image_id, 'post-thumbnail' );
	$full_image_data = wp_get_attachment_image_src( $image_id, 'full' );
	$alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
	echo '<a href="'.$full_image_data[0].'">
			<img class="reviews-lazy-load" src="'.esc_url( get_template_directory_uri().'/images/holder.jpg' ).'" data-src="'.esc_url( $post_thumbnail_data[0] ).'" width="'.esc_attr( $post_thumbnail_data[1] ).'" height="'.esc_attr( $post_thumbnail_data[2] ).'" alt="'.esc_attr( $alt ).'">
		  </a>';
}
}

if( !function_exists( 'reviews_replace_callback' ) ){
function reviews_replace_callback( $matches ){
	return '<strong>'.$matches[1].'</strong>';
}
}

if( !function_exists( 'reviews_quick_search' ) ){
function reviews_quick_search(){
	global $wpdb;
	$value = mb_strtolower( esc_sql( $_POST['val'] ) );

	$html = '<ul class="list-unstyled clearfix">';
	if( !empty( $value ) ){
		$items = $wpdb->get_results( $wpdb->prepare( "SELECT ID, post_title, post_type FROM {$wpdb->posts} WHERE LOWER( post_title ) LIKE %s AND post_type = 'review' AND post_status = 'publish'", '%'.$value.'%' ) );
		if( !empty( $items ) ){
			foreach( $items as $item ){
				$post_title = $item->post_title;
				$post_title = preg_replace_callback( '/('.$value.')/i', 'reviews_replace_callback', $post_title, -1 );
				$html .= '
				<li>
					<a href="'.get_permalink( $item->ID ).'">
						'.get_the_post_thumbnail( $item->ID, 'reviews-widget-thumb' ).'
						<div class="review-qs-info">
							<h6>'.$post_title.'</h6>
						</div>
						<div class="clearfix"></div>
					</a>
				</li>
				';
			}
		}
	}
	$html .= '</ul>';

	echo $html;
	die();
}
add_action('wp_ajax_quick_search', 'reviews_quick_search');
add_action('wp_ajax_nopriv_quick_search', 'reviews_quick_search');
}

function reviews_subscriber_clear_access_side_menu(){
    remove_menu_page('edit.php?post_type=review');
    remove_menu_page('edit.php?post_type=mega_menu');
    remove_menu_page('wpcf7');
}

function reviews_subscriber_clear_access_menu_bar(){
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('wpseo-menu');
}

if(!current_user_can('delete_posts') && current_user_can('edit_posts') ) {
	add_action('admin_menu', 'reviews_subscriber_clear_access_side_menu');
	add_action('wp_before_admin_bar_render', 'reviews_subscriber_clear_access_menu_bar');
}

include( reviews_load_path( 'includes/class-tgm-plugin-activation.php' ) );
include( reviews_load_path( 'includes/widgets.php' ) );
include( reviews_load_path( 'includes/fonts.php' ) );
include( reviews_load_path( 'includes/shortcodes.php' ) );
include( reviews_load_path( 'includes/font-icons.php' ) );
include( reviews_load_path( 'includes/menu-extender.php' ) );
include( reviews_load_path( 'includes/gallery.php' ) );
include( reviews_load_path( 'includes/review-cat.php' ) );
include( reviews_load_path( 'includes/theme-options.php' ) );
include( reviews_load_path( 'includes/comments-meta.php' ) );
include( reviews_load_path( 'includes/reviews-panel.php' ) );
include( reviews_load_path( 'includes/radium-one-click-demo-install/init.php' ) );

foreach ( glob( get_template_directory().'/includes/shortcodes/*.php' ) as $filename ){
	include( reviews_load_path( 'includes/shortcodes/'.basename( $filename ) ) );
}
?>