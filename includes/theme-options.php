<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: https://docs.reduxframework.com
     * */   

    global $reviews_opts;

    if ( ! class_exists( 'Reviews_Options' ) ) {

        class Reviews_Options {

            public $args = array();
            public $sections = array();
            public $theme;
            public $ReduxFramework;

            public function __construct() {

                if ( ! class_exists( 'ReduxFramework' ) ) {
                    return;
                }

                // This is needed. Bah WordPress bugs.  ;)
                if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                    $this->initSettings();
                } else {
                    add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
                }

            }

            public function initSettings() {

                // Just for demo purposes. Not needed per say.
                $this->theme = wp_get_theme();

                // Set the default arguments
                $this->setArguments();

                // Create the sections and fields
                $this->setSections();

                if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
                    return;
                }

                // If Redux is running as a plugin, this will remove the demo notice and links
                //add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

                $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
            }

            // Remove the demo link and the notice of integrated demo from the redux-framework plugin
            function remove_demo() {

                // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
                if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                    remove_filter( 'plugin_row_meta', array(
                        ReduxFrameworkPlugin::instance(),
                        'plugin_metalinks'
                    ), null, 2 );

                    // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                    remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
                }
            }

            public function setSections() {

                /**
                 * Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
                 * */
                // Background Patterns Reader
                $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
                $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
                $sample_patterns      = array();

                if ( is_dir( $sample_patterns_path ) ) :

                    if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) :
                        $sample_patterns = array();

                        while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                            if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                                $name              = explode( '.', $sample_patterns_file );
                                $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                                $sample_patterns[] = array(
                                    'alt' => $name,
                                    'img' => $sample_patterns_url . $sample_patterns_file
                                );
                            }
                        }
                    endif;
                endif;

                /**********************************************************************
                ***********************************************************************
                OVERALL
                **********************************************************************/
                $this->sections[] = array(
                    'title' => esc_html__('Overall', 'reviews') ,
                    'icon' => '',
                    'desc' => esc_html__('This is basic section where you can set up main settings for your website.', 'reviews'),
                    'fields' => array(
                        array(
                            'id' => 'enable_sticky',
                            'type' => 'select',
                            'options' => array(
                                'yes' => esc_html__( 'Yes', 'reviews' ),
                                'no' => esc_html__( 'No', 'reviews' )
                            ),
                            'title' => esc_html__('Sticky Menu', 'reviews'),
                            'desc' => esc_html__('Enable or disable sticky menu', 'reviews'),
                            'default' => 'yes'
                        ),
                        //Show Top Bar
                        array(
                            'id' => 'show_top_bar',
                            'type' => 'select',
                            'options' => array(
                                'yes' => esc_html__( 'Yes', 'reviews' ),
                                'no' => esc_html__( 'No', 'reviews' ),
                            ),
                            'title' => esc_html__('Show Top Bar', 'reviews') ,
                            'desc' => esc_html__('Enable or hide top bar', 'reviews')
                        ),
                        //Custom Top Bar Message
                        array(
                            'id' => 'top_bar_message',
                            'type' => 'text',
                            'title' => esc_html__('Top Bar Message', 'reviews') ,
                            'desc' => esc_html__('Input custom top bar message', 'reviews')
                        ),
                        //Site Logo
                        array(
                            'id' => 'site_logo',
                            'type' => 'media',
                            'title' => esc_html__('Site Logo', 'reviews') ,
                            'desc' => esc_html__('Upload site logo', 'reviews')
                        ),
                        array(
                            'id' => 'home_bs_img_1',
                            'type' => 'media',
                            'title' => esc_html__('Home Search Image Background 1', 'reviews') ,
                            'desc' => esc_html__('Select first image for big search slider or only picture.', 'reviews')
                        ),
                        array(
                            'id' => 'home_bs_img_2',
                            'type' => 'media',
                            'title' => esc_html__('Home Search Image Background 2', 'reviews') ,
                            'desc' => esc_html__('Select slider image 2.', 'reviews')
                        ),                        
                        array(
                            'id' => 'home_bs_img_3',
                            'type' => 'media',
                            'title' => esc_html__('Home Search Image Background 3', 'reviews') ,
                            'desc' => esc_html__('Select slider image 3.', 'reviews')
                        ),
                        array(
                            'id' => 'home_bs_img_4',
                            'type' => 'media',
                            'title' => esc_html__('Home Search Image Background 4', 'reviews') ,
                            'desc' => esc_html__('Select slider image 4.', 'reviews')
                        ),
                        array(
                            'id' => 'home_bs_img_5',
                            'type' => 'media',
                            'title' => esc_html__('Home Search Image Background 5', 'reviews') ,
                            'desc' => esc_html__('Select slider image 5.', 'reviews')
                        ),
                        array(
                            'id' => 'home_bs_img_6',
                            'type' => 'media',
                            'title' => esc_html__('Home Search Image Background 6', 'reviews') ,
                            'desc' => esc_html__('Select slider image 6.', 'reviews')
                        ),
                        array(
                            'id' => 'home_bs_img_7',
                            'type' => 'media',
                            'title' => esc_html__('Home Search Image Background 7', 'reviews') ,
                            'desc' => esc_html__('Select slider image 7.', 'reviews')
                        ),                        
                        array(
                            'id' => 'home_bs_img_8',
                            'type' => 'media',
                            'title' => esc_html__('Home Search Image Background 8', 'reviews') ,
                            'desc' => esc_html__('Select slider image 8.', 'reviews')
                        ),
                        array(
                            'id' => 'home_bs_img_9',
                            'type' => 'media',
                            'title' => esc_html__('Home Search Image Background 9', 'reviews') ,
                            'desc' => esc_html__('Select slider image 9.', 'reviews')
                        ),
                        array(
                            'id' => 'home_bs_img_10',
                            'type' => 'media',
                            'title' => esc_html__('Home Search Image Background 10', 'reviews') ,
                            'desc' => esc_html__('Select slider image 10.', 'reviews')
                        ),
                        array(
                            'id' => 'home_bs_title',
                            'type' => 'text',
                            'title' => esc_html__('Big Search Title', 'reviews') ,
                            'desc' => esc_html__('Input title for the big search.', 'reviews')
                        ),
                        array(
                            'id' => 'home_bs_subtitle',
                            'type' => 'text',
                            'title' => esc_html__('Big Search Subtitle', 'reviews') ,
                            'desc' => esc_html__('Input subtitle for the big search.', 'reviews')
                        ),
                        array(
                            'id' => 'direction',
                            'type' => 'select',
                            'options' => array(
                                'ltr' => __('LTR', 'reviews'),
                                'rtl' => __('RTL', 'reviews')
                            ),
                            'title' => __('Choose Site Content Direction', 'reviews'),
                            'desc' => __('Choose overall website text direction which can be RTL (right to left) or LTR (left to right).', 'reviews'),
                            'default' => 'ltr'
                        )
                    )
                );

                
                /**********************************************************************
                ***********************************************************************
                Reviews
                **********************************************************************/
                
                $this->sections[] = array(
                    'title' => esc_html__('Reviews', 'reviews') ,
                    'icon' => '',
                    'desc' => esc_html__('Reviews setup.', 'reviews'),
                    'fields' => array(  
                        array(
                            'id' => 'all_cats_sublinks',
                            'type' => 'select',
                            'options' => array(
                                'no' => esc_html__( 'No', 'reviews' ),
                                'yes' => esc_html__( 'Yes', 'reviews' ),
                            ),
                            'title' => esc_html__("Link To Subcategories","reviews"),
                            'desc' => esc_html__("If this is set to yes then if category has subcategories link will go there instead on filter reviews from the All Categories page.","reviews"),
                            'default' => 'no'
                        ),
                        array(
                            'id' => 'allow_empty_review',
                            'type' => 'select',
                            'options' => array(
                                'no' => esc_html__( 'No', 'reviews' ),
                                'yes' => esc_html__( 'Yes', 'reviews' ),
                            ),
                            'title' => esc_html__("Allow Reviews With Rating Only","reviews"),
                            'desc' => esc_html__("Allow basic users to just rate the review by criteria without writting small summary.","reviews"),
                            'default' => 'no'
                        ),
                        array(
                            'id' => 'similar_reviews_num',
                            'type' => 'text',
                            'title' => esc_html__('Similar Reviews', 'reviews') ,
                            'desc' => esc_html__('Input number of similar reviews to show on reviews single page', 'reviews'),
                            'default' => 3
                        ),
                        array(
                            'id' => 'reviews_per_page',
                            'type' => 'text',
                            'title' => esc_html__('Reviews Per Page', 'reviews') ,
                            'desc' => esc_html__('Input number of reviews to dispaly per page', 'reviews'),
                            'default' => 8
                        ),
                        array(
                            'id' => 'reviews_listing_style',
                            'type' => 'select',
                            'options' => array(
                                'masonry' => esc_html__( 'Masonry', 'reviews' ),
                                'grid'    => esc_html__( 'Grid', 'reviews' )
                            ),
                            'title' => esc_html__('Reviews Listing Style', 'reviews') ,
                            'desc' => esc_html__('Select how to list reviews on search and taxonomy listings', 'reviews'),
                            'default' => 'masonry'
                        ),
                        array(
                            'id' => 'reviews_cta_text',
                            'type' => 'text',
                            'title' => esc_html__('Call To Action Button Text', 'reviews') ,
                            'desc' => esc_html__('Input which will be disaplyed as text on the call to action button on review single', 'reviews'),
                            'default' => esc_html__( 'READ MORE', 'reviews' )
                        ),
                        array(
                            'id' => 'reviews_show_author',
                            'type' => 'select',
                            'options' => array(
                                'yes' => esc_html__( 'Yes', 'reviews' ),
                                'no' => esc_html__( 'No', 'reviews' ),
                            ),
                            'title' => esc_html__('Show Author', 'reviews') ,
                            'desc' => esc_html__('Show or hide author on the reviews single', 'reviews'),
                            'default' => 'yes'
                        ),
                        array(
                            'id' => 'reviews_force_login',
                            'type' => 'select',
                            'options' => array(
                                'yes' => esc_html__( 'Yes', 'reviews' ),
                                'no' => esc_html__( 'No', 'reviews' ),
                            ),
                            'title' => esc_html__('Force Users To Login?', 'reviews') ,
                            'desc' => esc_html__('Force users to login before submitting review or allow them to send it without registration', 'reviews'),
                            'default' => 'yes'
                        ),
                        array(
                            'id' => 'reviews_must_be_approved',
                            'type' => 'select',
                            'options' => array(
                                'no' => esc_html__( 'No', 'reviews' ),
                                'yes' => esc_html__( 'Yes', 'reviews' ),
                            ),
                            'title' => esc_html__('Approve Reviews?', 'reviews') ,
                            'desc' => esc_html__('If this is set to yes then you need to approve the review before it gets displayed and calcualted into overall', 'reviews'),
                            'default' => 'no'
                        ),
                        array(
                            'id' => 'title_before_images',
                            'type' => 'select',
                            'options' => array(
                                'no' => esc_html__( 'No', 'reviews' ),
                                'yes' => esc_html__( 'Yes', 'reviews' ),
                            ),
                            'title' => esc_html__("Title Before Media","reviews"),
                            'desc' => esc_html__("If this is set to Yes then title on single review page will be before images.","reviews"),
                            'default' => 'no'
                        ),
                    )
                );

                /**********************************************************************
                ***********************************************************************
                SLUGS
                **********************************************************************/
                
                $this->sections[] = array(
                    'title' => esc_html__('Slugs', 'reviews') ,
                    'icon' => '',
                    'desc' => esc_html__('Slugs setup.', 'reviews'),
                    'fields' => array(  
                        array(
                            'id' => 'trans_review',
                            'type' => 'text',
                            'title' => esc_html__('Reviews Slug', 'reviews') ,
                            'desc' => esc_html__('Input slug you want to use for the review single page.', 'reviews'),
                            'default' => 'review'
                        ),
                        array(
                            'id' => 'trans_review-category',
                            'type' => 'text',
                            'title' => esc_html__('Reviews Category Slug', 'reviews') ,
                            'desc' => esc_html__('Input slug you want to use for the review categories.', 'reviews'),
                            'default' => 'review-category'
                        ),
                        array(
                            'id' => 'trans_review-tag',
                            'type' => 'text',
                            'title' => esc_html__('Reviews Tag Slug', 'reviews') ,
                            'desc' => esc_html__('Input slug you want to use for the review tags.', 'reviews'),
                            'default' => 'review-tag'
                        ),
                        array(
                            'id' => 'trans_keyword',
                            'type' => 'text',
                            'title' => esc_html__('Reviews Keyword Slug', 'reviews') ,
                            'desc' => esc_html__('Input slug you want to use for the review keyword search.', 'reviews'),
                            'default' => 'keyword'
                        ),
                        array(
                            'id' => 'trans_sort',
                            'type' => 'text',
                            'title' => esc_html__('Reviews Sort Slug', 'reviews') ,
                            'desc' => esc_html__('Input slug you want to use for the review sort search.', 'reviews'),
                            'default' => 'sort'
                        ),
                    )
                );

                /**********************************************************************
                ***********************************************************************
                SHARE
                **********************************************************************/
                
                $this->sections[] = array(
                    'title' => esc_html__('Share', 'reviews') ,
                    'icon' => '',
                    'desc' => esc_html__('Post share options.', 'reviews'),
                    'fields' => array(
                        // Enable Share
                        array(
                            'id' => 'enable_share',
                            'type' => 'select',
                            'title' => esc_html__('Enable Share', 'reviews') ,
                            'desc' => esc_html__('Enable or disable post share.', 'reviews'),
                            'options' => array(
                                'yes' => esc_html__( 'Yes', 'reviews' ),
                                'no' => esc_html__( 'No', 'reviews' ),
                            ),
                            'default' => 'yes'
                        ),
                        // Share Facebook
                        array(
                            'id' => 'facebook_share',
                            'type' => 'select',
                            'title' => esc_html__('Facebook Share', 'reviews') ,
                            'desc' => esc_html__('Enable or disable post share on Facebook.', 'reviews'),
                            'options' => array(
                                'yes' => esc_html__( 'Yes', 'reviews' ),
                                'no' => esc_html__( 'No', 'reviews' ),
                            ),
                            'default' => 'yes'
                        ),
                        // Share Twitter
                        array(
                            'id' => 'twitter_share',
                            'type' => 'select',
                            'title' => esc_html__('Twitter Share', 'reviews') ,
                            'desc' => esc_html__('Enable or disable post share on Twitter.', 'reviews'),
                            'options' => array(
                                'yes' => esc_html__( 'Yes', 'reviews' ),
                                'no' => esc_html__( 'No', 'reviews' ),
                            ),
                            'default' => 'yes'
                        ),
                        // Share Google+
                        array(
                            'id' => 'google_share',
                            'type' => 'select',
                            'title' => esc_html__('Google+ Share', 'reviews') ,
                            'desc' => esc_html__('Enable or disable post share on Google+.', 'reviews'),
                            'options' => array(
                                'yes' => esc_html__( 'Yes', 'reviews' ),
                                'no' => esc_html__( 'No', 'reviews' ),
                            ),
                            'default' => 'yes'
                        ),
                        // Share Linkedin
                        array(
                            'id' => 'linkedin_share',
                            'type' => 'select',
                            'title' => esc_html__('Linkedin Share', 'reviews') ,
                            'desc' => esc_html__('Enable or disable post share on Linkedin.', 'reviews'),
                            'options' => array(
                                'yes' => esc_html__( 'Yes', 'reviews' ),
                                'no' => esc_html__( 'No', 'reviews' ),
                            ),
                            'default' => 'yes'
                        ),
                        // Share Tumblr
                        array(
                            'id' => 'tumblr_share',
                            'type' => 'select',
                            'title' => esc_html__('Tumblr Share', 'reviews') ,
                            'desc' => esc_html__('Enable or disable post share on Tumblr.', 'reviews'),
                            'options' => array(
                                'yes' => esc_html__( 'Yes', 'reviews' ),
                                'no' => esc_html__( 'No', 'reviews' ),
                            ),
                            'default' => 'yes'
                        ),
                        // Share VK
                        array(
                            'id' => 'vk_share',
                            'type' => 'select',
                            'title' => esc_html__('VK Share', 'reviews') ,
                            'desc' => esc_html__('Enable or disable post share on VK.', 'reviews'),
                            'options' => array(
                                'yes' => esc_html__( 'Yes', 'reviews' ),
                                'no' => esc_html__( 'No', 'reviews' ),
                            ),
                            'default' => 'yes'
                        ),
                    )
                );  

                /**********************************************************************
                ***********************************************************************
                SUBSCRIPTION
                **********************************************************************/
                
                $this->sections[] = array(
                    'title' => esc_html__('Subscription', 'reviews') ,
                    'icon' => '',
                    'desc' => esc_html__('Set up subscription API key and list ID.', 'reviews'),
                    'fields' => array(
                        // Mail Chimp API
                        array(
                            'id' => 'mail_chimp_api',
                            'type' => 'text',
                            'title' => esc_html__('API Key', 'reviews') ,
                            'desc' => esc_html__('Type your mail chimp api key.', 'reviews')
                        ) , 
                        // Mail Chimp List ID
                        array(
                            'id' => 'mail_chimp_list_id',
                            'type' => 'text',
                            'title' => esc_html__('List ID', 'reviews') ,
                            'desc' => esc_html__('Type here ID of the list on which users will subscribe.', 'reviews')
                        ) ,
                    )
                );

                
                /***********************************************************************
                Appearance
                **********************************************************************/
                $this->sections[] = array(
                    'title' => esc_html__('Appearance', 'reviews') ,
                    'icon' => '',
                    'desc' => esc_html__('Set up the looks.', 'reviews'),
                    'fields' => array(
                        array(
                            'id' => 'top_bar_bg_color',
                            'type' => 'color',
                            'title' => esc_html__('Top Bar Background Color', 'reviews'),
                            'desc' => esc_html__('Select color of the top bar background.', 'reviews'),
                            'transparent' => false,
                            'default' => '#ffffff'
                        ),
                        array(
                            'id' => 'top_bar_font',
                            'type' => 'color',
                            'title' => esc_html__('Top Bar Font Color', 'reviews'),
                            'desc' => esc_html__('Select font color for the top bar.', 'reviews'),
                            'transparent' => false,
                            'default' => '#676767'
                        ),                        
                        /*--------------------------NAVIGATION-------------------------*/
                        array(
                            'id' => 'navigation_bg_color',
                            'type' => 'color',
                            'title' => esc_html__('Navigation Background Color', 'reviews'),
                            'desc' => esc_html__('Select background color of the navigation bar.', 'reviews'),
                            'default' => '#2980B9',
                            'transparent' => false,
                        ),
                        array(
                            'id' => 'navigation_font_color',
                            'type' => 'color',
                            'title' => esc_html__('Navigation Font Color', 'reviews'),
                            'desc' => esc_html__('Select font color of the navigation bar.', 'reviews'),
                            'transparent' => false,
                            'default' => '#ffffff'
                        ),
                        array(
                            'id' => 'navigation_font',
                            'type' => 'select',
                            'title' => esc_html__('Navigation Font', 'reviews'),
                            'desc' => esc_html__('Select navigation font.', 'reviews'),
                            'transparent' => false,
                            'options' => reviews_all_google_fonts(),
                            'default' => 'Montserrat'
                        ),
                        array(
                            'id' => 'navigation_font_size',
                            'type' => 'text',
                            'title' => esc_html__('Navigation Font Size', 'reviews'),
                            'desc' => esc_html__('Input navigation font size.', 'reviews'),
                            'default' => '13px'
                        ),
                        array(
                            'id' => 'link_font_color',
                            'type' => 'color',
                            'title' => esc_html__('Link Font Color', 'reviews'),
                            'desc' => esc_html__('Select font color for the link.', 'reviews'),
                            'default' => '#676767',
                            'transparent' => false,
                        ),
                        /*--------------------------BREADCRUMBS-------------------------*/
                        array(
                            'id' => 'breadcrumbs_bg_color',
                            'type' => 'color',
                            'title' => esc_html__('Breadcrumbs Background Color', 'reviews'),
                            'desc' => esc_html__('Select background color of the breadcrumbs.', 'reviews'),
                            'default' => '#ffffff',
                            'transparent' => false,
                        ),
                        array(
                            'id' => 'breadcrumbs_font_color',
                            'type' => 'color',
                            'title' => esc_html__('Breadcrumbs Font Color', 'reviews'),
                            'desc' => esc_html__('Select font color of the breadcrumbs.', 'reviews'),
                            'transparent' => false,
                            'default' => '#676767'
                        ),
                        /*--------------------------BUTTONS-------------------------*/
                        array(
                            'id' => 'main_button_bg_color',
                            'type' => 'color',
                            'title' => esc_html__('Buttons Main BG Color', 'reviews'),
                            'desc' => esc_html__('Select background color for the buttons.', 'reviews'),
                            'default' => '#9ACC55',
                            'transparent' => false,
                        ),
                        array(
                            'id' => 'main_button_font_color',
                            'type' => 'color',
                            'title' => esc_html__('Buttons Main Font Color', 'reviews'),
                            'desc' => esc_html__('Select font color for the buttons.', 'reviews'),
                            'default' => '#ffffff',
                            'transparent' => false,
                        ),
                        array(
                            'id' => 'main_button_bg_color_hvr',
                            'type' => 'color',
                            'title' => esc_html__('Buttons Main BG Color On Hover', 'reviews'),
                            'desc' => esc_html__('Select background color for the buttons.', 'reviews'),
                            'default' => '#232323',
                            'transparent' => false,
                        ),
                        array(
                            'id' => 'main_button_font_color_hvr',
                            'type' => 'color',
                            'title' => esc_html__('Buttons Main Font Color On Hover', 'reviews'),
                            'desc' => esc_html__('Select font color for the buttons.', 'reviews'),
                            'default' => '#ffffff',
                            'transparent' => false,
                        ),
                        array(
                            'id' => 'pag_button_bg_color_active',
                            'type' => 'color',
                            'title' => esc_html__('Pagination Active Buttons BG Color', 'reviews'),
                            'desc' => esc_html__('Select background color of the active button on pagination.', 'reviews'),
                            'default' => '#454545',
                            'transparent' => false,
                        ),
                        array(
                            'id' => 'pag_button_font_color_active',
                            'type' => 'color',
                            'title' => esc_html__('Pagination Active Buttons Font Color', 'reviews'),
                            'desc' => esc_html__('Select font color of the active button on pagination.', 'reviews'),
                            'default' => '#ffffff',
                            'transparent' => false,
                        ),  
                        /*-------------------------TEXT FONT----------------------------*/
                        //Text font
                        array(
                            'id' => 'text_font',
                            'type' => 'select',
                            'title' => esc_html__('Text Font', 'reviews'),
                            'desc' => esc_html__('Select font for the regular text.', 'reviews'),
                            'options' => reviews_all_google_fonts(),
                            'default' => 'Open+Sans'
                        ),
                        array(
                            'id' => 'text_font_size',
                            'type' => 'text',
                            'title' => esc_html__('Text Font Size', 'reviews'),
                            'desc' => esc_html__('Input text font size.', 'reviews'),
                            'default' => '13px'
                        ),
                        array(
                            'id' => 'text_line_height',
                            'type' => 'text',
                            'title' => esc_html__('Text Line Height', 'reviews'),
                            'desc' => esc_html__('Input text line height.', 'reviews'),
                            'default' => '23px'
                        ),
                        /*-----------------TITLES-----------------------------*/
                        //Text font
                        array(
                            'id' => 'title_font',
                            'type' => 'select',
                            'title' => esc_html__('Title Font', 'reviews'),
                            'desc' => esc_html__('Select font for the title text.', 'reviews'),
                            'options' => reviews_all_google_fonts(),
                            'default' => 'Montserrat'
                        ),
                        array(
                            'id' => 'h1_font_size',
                            'type' => 'text',
                            'title' => esc_html__('Heading 1 Font Size', 'reviews'),
                            'desc' => esc_html__('Input heading 1 font size.', 'reviews'),
                            'default' => '38px'
                        ),
                        array(
                            'id' => 'h1_line_height',
                            'type' => 'text',
                            'title' => esc_html__('Heading 1 Line Height', 'reviews'),
                            'desc' => esc_html__('Input heading 1 line height.', 'reviews'),
                            'default' => '1.25'
                        ),
                        array(
                            'id' => 'h2_font_size',
                            'type' => 'text',
                            'title' => esc_html__('Heading 2 Font Size', 'reviews'),
                            'desc' => esc_html__('Input heading 2 font size.', 'reviews'),
                            'default' => '32px'
                        ),
                        array(
                            'id' => 'h2_line_height',
                            'type' => 'text',
                            'title' => esc_html__('Heading 2 Line Height', 'reviews'),
                            'desc' => esc_html__('Input heading 2 line height.', 'reviews'),
                            'default' => '1.25'
                        ),
                        array(
                            'id' => 'h3_font_size',
                            'type' => 'text',
                            'title' => esc_html__('Heading 3 Font Size', 'reviews'),
                            'desc' => esc_html__('Input heading 3 font size.', 'reviews'),
                            'default' => '28px'
                        ),
                        array(
                            'id' => 'h3_line_height',
                            'type' => 'text',
                            'title' => esc_html__('Heading 3 Line Height', 'reviews'),
                            'desc' => esc_html__('Input heading 3 line height.', 'reviews'),
                            'default' => '1.25'
                        ),
                        array(
                            'id' => 'h4_font_size',
                            'type' => 'text',
                            'title' => esc_html__('Heading 4 Font Size', 'reviews'),
                            'desc' => esc_html__('Input heading 4 font size.', 'reviews'),
                            'default' => '22px'
                        ),
                        array(
                            'id' => 'h4_line_height',
                            'type' => 'text',
                            'title' => esc_html__('Heading 4 Line Height', 'reviews'),
                            'desc' => esc_html__('Input heading 4 line height.', 'reviews'),
                            'default' => '1.25'
                        ),
                        array(
                            'id' => 'h5_font_size',
                            'type' => 'text',
                            'title' => esc_html__('Heading 5 Font Size', 'reviews'),
                            'desc' => esc_html__('Input heading 5 font size.', 'reviews'),
                            'default' => '18px'
                        ),
                        array(
                            'id' => 'h5_line_height',
                            'type' => 'text',
                            'title' => esc_html__('Heading 5 Line Height', 'reviews'),
                            'desc' => esc_html__('Input heading 5 line height.', 'reviews'),
                            'default' => '1.25'
                        ),
                        array(
                            'id' => 'h6_font_size',
                            'type' => 'text',
                            'title' => esc_html__('Heading 6 Font Size', 'reviews'),
                            'desc' => esc_html__('Input heading 6 font size.', 'reviews'),
                            'default' => '13px'
                        ),
                        array(
                            'id' => 'h6_line_height',
                            'type' => 'text',
                            'title' => esc_html__('Heading 6 Line Height', 'reviews'),
                            'desc' => esc_html__('Input heading 6 line height.', 'reviews'),
                            'default' => '1.25'
                        ),
                        /* -------------------MAIN BODY------------------------- */
                        //Body Background Image
                        array(
                            'id' => 'body_bg_image',
                            'type' => 'media',
                            'title' => esc_html__('Body Background Image', 'reviews'),
                            'desc' => esc_html__('Select image for the body.', 'reviews'),
                        ),
                        //Body Background Color
                        array(
                            'id' => 'body_bg_color',
                            'type' => 'color',
                            'title' => esc_html__('Body Background Color', 'reviews'),
                            'desc' => esc_html__('Select color for the body.', 'reviews'),
                            'transparent' => false,
                            'default' => '#f5f5f5'
                        ),
                        /* -------------------COPYRIGHTS------------------------- */
                        array(
                            'id' => 'copyrights_bg_color',
                            'type' => 'color',
                            'title' => esc_html__('Copyrights Background Color', 'reviews'),
                            'desc' => esc_html__('Select background color for the copyrights section.', 'reviews'),
                            'transparent' => false,
                            'default' => '#333'
                        ),
                        array(
                            'id' => 'copyrights_font_color',
                            'type' => 'color',
                            'title' => esc_html__('Copyrights Font Color', 'reviews'),
                            'desc' => esc_html__('Select font color for the copyrights section.', 'reviews'),
                            'transparent' => false,
                            'default' => '#ffffff'
                        ),
                        /* -------------------CTA------------------------- */
                        array(
                            'id' => 'cta_bg_color',
                            'type' => 'color',
                            'title' => esc_html__('Call To Action Background Color', 'reviews'),
                            'desc' => esc_html__('Select background color for the cal to action button on the review single page.', 'reviews'),
                            'transparent' => false,
                            'default' => '#9ACC55'
                        ),
                        array(
                            'id' => 'cta_font_color',
                            'type' => 'color',
                            'title' => esc_html__('Call To Action Font Color', 'reviews'),
                            'desc' => esc_html__('Select font color for the cal to action button on the review single page.', 'reviews'),
                            'transparent' => false,
                            'default' => '#ffffff'
                        ),
                        array(
                            'id' => 'cta_bg_color_hvr',
                            'type' => 'color',
                            'title' => esc_html__('Call To Action Background Color On Hover', 'reviews'),
                            'desc' => esc_html__('Select background color for the call to action button on the review single page on hover.', 'reviews'),
                            'transparent' => false,
                            'default' => '#232323'
                        ),
                        array(
                            'id' => 'cta_font_color_hvr',
                            'type' => 'color',
                            'title' => esc_html__('Call To Action Font Color On Hover', 'reviews'),
                            'desc' => esc_html__('Select font color for the call to action button on the review single page on hover.', 'reviews'),
                            'transparent' => false,
                            'default' => '#ffffff'
                        ),                        
                    )
                );  

                /**********************************************************************
                ***********************************************************************
                CONTACT PAGE SETTINGS
                **********************************************************************/
                
                $this->sections[] = array(
                    'title' => esc_html__('Register / Recover Page', 'reviews') ,
                    'icon' => '',
                    'desc' => esc_html__('Register / Recover page settings.', 'reviews'),
                    'fields' => array(
                        // Registrtion message subject
                        array(
                            'id' => 'registration_subject',
                            'type' => 'text',
                            'title' => esc_html__('Registration Message Subject', 'reviews') ,
                            'desc' => esc_html__('Type registration message subject.', 'reviews')
                        ) ,
                        // Registrtion message
                        array(
                            'id' => 'registration_message',
                            'type' => 'textarea',
                            'title' => esc_html__('Registration Message', 'reviews') ,
                            'desc' => esc_html__('Type registration message for confirming the link. Use %LINK% to place the link .', 'reviews')
                        ),
                        // Registrtion terms & conditions
                        array(
                            'id' => 'registration_terms',
                            'type' => 'editor',
                            'title' => esc_html__('Registration Terms & Conditions', 'reviews') ,
                            'desc' => esc_html__('Input terms & conditions for the registration page.', 'reviews')
                        ) ,                         
                        // Registration message sender name
                        array(
                            'id' => 'sender_name',
                            'type' => 'text',
                            'title' => esc_html__('Sender Name', 'reviews') ,
                            'desc' => esc_html__('Type name from who the registration message is sent.', 'reviews')
                        ) ,
                        // Registration message sender email address
                        array(
                            'id' => 'sender_email',
                            'type' => 'text',
                            'title' => esc_html__('Sender Email', 'reviews') ,
                            'desc' => esc_html__('Type email address from who the registration message is sent.', 'reviews')
                        ),

                        // Recover message subject
                        array(
                            'id' => 'recover_subject',
                            'type' => 'text',
                            'title' => esc_html__('Recover Password Message Subject', 'reviews') ,
                            'desc' => esc_html__('Type recover password subject', 'reviews')
                        ) , 
                        // Recover message
                        array(
                            'id' => 'recover_message',
                            'type' => 'textarea',
                            'title' => esc_html__('Recover Password Message', 'reviews') ,
                            'desc' => esc_html__('Type registration message for confirming the link. Use %LINK% to place link to recovery form', 'reviews')
                        ),                     
                    )
                );

                /**********************************************************************
                ***********************************************************************
                CONTACT PAGE SETTINGS
                **********************************************************************/
                
                $this->sections[] = array(
                    'title' => esc_html__('Contact Page', 'reviews') ,
                    'icon' => '',
                    'desc' => esc_html__('Contact page settings.', 'reviews'),
                    'fields' => array(
                        array(
                            'id' => 'contact_form_email',
                            'type' => 'text',
                            'title' => esc_html__('Contact Email', 'reviews') ,
                            'desc' => esc_html__('Input email where the messages should arive.', 'reviews'),
                        ),

                        array(
                            'id' => 'contact_map',
                            'type' => 'text',
                            'title' => esc_html__('Contact Map', 'reviews') ,
                            'desc' => esc_html__('Input google map link to embed. (Input link from the iframe embed code)', 'reviews'),
                        ),                        
                    )
                );

                /**********************************************************************
                ***********************************************************************
                FOOTER COPYRIGHTS
                **********************************************************************/
                
                $this->sections[] = array(
                    'title' => esc_html__('Copyrights', 'reviews') ,
                    'icon' => '',
                    'desc' => esc_html__('Copyrights settings.', 'reviews'),
                    'fields' => array(
                        array(
                            'id' => 'copyrights',
                            'type' => 'text',
                            'title' => esc_html__('Copyrights', 'reviews') ,
                            'desc' => esc_html__('Input copyrights text.', 'reviews'),
                        ),
                        //Facebook Top Bar Link
                        array(
                            'id' => 'copyrights-facebook',
                            'type' => 'text',
                            'title' => esc_html__('Facebook Link', 'reviews') ,
                            'desc' => esc_html__('Input link to your facebook page', 'reviews')
                        ),
                        //Twitter Top Bar Link
                        array(
                            'id' => 'copyrights-twitter',
                            'type' => 'text',
                            'title' => esc_html__('Twitter Link', 'reviews') ,
                            'desc' => esc_html__('Input link to your twitter page', 'reviews')
                        ),
                        //Google Top Bar Link
                        array(
                            'id' => 'copyrights-google',
                            'type' => 'text',
                            'title' => esc_html__('Google Link', 'reviews') ,
                            'desc' => esc_html__('Input link to your google page', 'reviews')
                        ),
                        //Linkedin Top Bar Link
                        array(
                            'id' => 'copyrights-linkedin',
                            'type' => 'text',
                            'title' => esc_html__('Linkedin Link', 'reviews') ,
                            'desc' => esc_html__('Input link to your linkedin page', 'reviews')
                        ),
                        //Tumblr Top Bar Link
                        array(
                            'id' => 'copyrights-tumblr',
                            'type' => 'text',
                            'title' => esc_html__('Tumblr Link', 'reviews') ,
                            'desc' => esc_html__('Input link to your tumblr page', 'reviews')
                        ),
                        array(
                            'id' => 'copyrights-instagram',
                            'type' => 'text',
                            'title' => esc_html__('Instagram Link', 'reviews') ,
                            'desc' => esc_html__('Input link to your instagram page', 'reviews')
                        ),
                        array(
                            'id' => 'copyrights-youtube',
                            'type' => 'text',
                            'title' => esc_html__('YouTube Link', 'reviews') ,
                            'desc' => esc_html__('Input link to your youtube page', 'reviews')
                        ),
                    )
                );                

            }

            /**
             * All the possible arguments for Redux.
             * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
             * */
            public function setArguments() {

                $theme = wp_get_theme(); // For use with some settings. Not necessary.

                $this->args = array(
                    // TYPICAL -> Change these values as you need/desire
                    'opt_name'             => 'reviews_options',
                    // This is where your data is stored in the database and also becomes your global variable name.
                    'display_name'         => $theme->get( 'Name' ),
                    // Name that appears at the top of your panel
                    'display_version'      => $theme->get( 'Version' ),
                    // Version that appears at the top of your panel
                    'menu_type'            => 'menu',
                    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                    'allow_sub_menu'       => true,
                    // Show the sections below the admin menu item or not
                    'menu_title'           => esc_html__( 'Reviews WP', 'reviews' ),
                    'page_title'           => esc_html__( 'Reviews WP', 'reviews' ),
                    // You will need to generate a Google API key to use this feature.
                    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                    'google_api_key'       => '',
                    // Set it you want google fonts to update weekly. A google_api_key value is required.
                    'google_update_weekly' => false,
                    // Must be defined to add google fonts to the typography module
                    'async_typography'     => true,
                    // Use a asynchronous font on the front end or font string
                    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                    'admin_bar'            => true,
                    // Show the panel pages on the admin bar
                    'admin_bar_icon'     => 'dashicons-portfolio',
                    // Choose an icon for the admin bar menu
                    'admin_bar_priority' => 50,
                    // Choose an priority for the admin bar menu
                    'global_variable'      => '',
                    // Set a different name for your global variable other than the opt_name
                    'dev_mode'             => false,
                    // Show the time the page took to load, etc
                    'update_notice'        => true,
                    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
                    'customizer'           => true,
                    // Enable basic customizer support
                    //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                    //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                    // OPTIONAL -> Give you extra features
                    'page_priority'        => null,
                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                    'page_parent'          => 'themes.php',
                    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                    'page_permissions'     => 'manage_options',
                    // Permissions needed to access the options panel.
                    // Specify a custom URL to an icon
                    'last_tab'             => '',
                    // Force your panel to always open to a specific tab (by id)
                    'page_icon'            => 'icon-themes',
                    // Icon displayed in the admin panel next to your menu_title
                    'page_slug'            => '_options',
                    // Page slug used to denote the panel
                    'save_defaults'        => true,
                    // On load save the defaults to DB before user clicks save or not
                    'default_show'         => false,
                    // If true, shows the default value next to each field that is not the default value.
                    'default_mark'         => '',
                    // What to print by the field's title if the value shown is default. Suggested: *
                    'show_import_export'   => true,
                    // Shows the Import/Export panel when not used as a field.

                    // CAREFUL -> These options are for advanced use only
                    'transient_time'       => 60 * MINUTE_IN_SECONDS,
                    'output'               => true,
                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                    'output_tag'           => true,
                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                    'database'             => '',
                    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                    'system_info'          => false,
                    // REMOVE

                    // HINTS
                    'hints'                => array(
                        'icon'          => 'icon-question-sign',
                        'icon_position' => 'right',
                        'icon_color'    => 'lightgray',
                        'icon_size'     => 'normal',
                        'tip_style'     => array(
                            'color'   => 'light',
                            'shadow'  => true,
                            'rounded' => false,
                            'style'   => '',
                        ),
                        'tip_position'  => array(
                            'my' => 'top left',
                            'at' => 'bottom right',
                        ),
                        'tip_effect'    => array(
                            'show' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'mouseover',
                            ),
                            'hide' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'click mouseleave',
                            ),
                        ),
                    )
                );


            }

        }

        global $reviews_opts;
        $reviews_opts = new Reviews_Options();
        } else {
        echo "The class named Reviews_Options has already been called. <strong>Developers, you need to prefix this class with your company name or you'll run into problems!</strong>";
    }