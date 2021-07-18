<?php
	
	/* HEADER */
	$top_bar_bg_color = reviews_get_option( 'top_bar_bg_color' );
	$top_bar_font = reviews_get_option( 'top_bar_font' );
	$link_font_color = reviews_get_option( 'link_font_color' );

	/* NAVIGATION */
	$navigation_bg_color = reviews_get_option( 'navigation_bg_color' );
	$navigation_font_color = reviews_get_option( 'navigation_font_color' );
	$navigation_font = reviews_get_option( 'navigation_font' );
	$navigation_font_size = reviews_get_option( 'navigation_font_size' );

	/* BREADCRUMBS */
	$breadcrumbs_bg_color = reviews_get_option( 'breadcrumbs_bg_color' );
	$breadcrumbs_font_color = reviews_get_option( 'breadcrumbs_font_color' );

	/* BUTTONS */
	$main_button_bg_color = reviews_get_option( 'main_button_bg_color' );
	$main_button_font_color = reviews_get_option( 'main_button_font_color' );
	$main_button_bg_color_hvr = reviews_get_option( 'main_button_bg_color_hvr' );
	$main_button_font_color_hvr = reviews_get_option( 'main_button_font_color_hvr' );
	$pag_button_bg_color_active = reviews_get_option( 'pag_button_bg_color_active' );
	$pag_button_font_color_active = reviews_get_option( 'pag_button_font_color_active' );

	/* TEXT */
	$text_font = reviews_get_option( 'text_font' );
	$text_font_size = reviews_get_option( 'text_font_size' );
	$text_line_height = reviews_get_option( 'text_line_height' );

	$title_font = reviews_get_option( 'title_font' );
	$h1_font_size = reviews_get_option( 'h1_font_size' );
	$h1_line_height = reviews_get_option( 'h1_line_height' );
	$h2_font_size = reviews_get_option( 'h2_font_size' );
	$h2_line_height = reviews_get_option( 'h2_line_height' );
	$h3_font_size = reviews_get_option( 'h3_font_size' );
	$h3_line_height = reviews_get_option( 'h3_line_height' );
	$h4_font_size = reviews_get_option( 'h4_font_size' );
	$h4_line_height = reviews_get_option( 'h4_line_height' );
	$h5_font_size = reviews_get_option( 'h5_font_size' );
	$h5_line_height = reviews_get_option( 'h5_line_height' );
	$h6_font_size = reviews_get_option( 'h6_font_size' );
	$h6_line_height = reviews_get_option( 'h6_line_height' );

	/* BODY */
	$body_bg_image = reviews_get_option( 'body_bg_image' );
	if( !empty( $body_bg_image['url'] ) ){
		$body_bg_image = $body_bg_image['url'];
	}
	else{
		$body_bg_image = '';
	}
	$body_bg_color = reviews_get_option( 'body_bg_color' );

	/* COPYRIGHTS */
	$copyrights_bg_color = reviews_get_option( 'copyrights_bg_color' );
	$copyrights_font_color = reviews_get_option( 'copyrights_font_color' );

	/* CTA */
	$cta_bg_color = reviews_get_option( 'cta_bg_color' );
	$cta_font_color = reviews_get_option( 'cta_font_color' );
	$cta_bg_color_hvr = reviews_get_option( 'cta_bg_color_hvr' );
	$cta_font_color_hvr = reviews_get_option( 'cta_font_color_hvr' );

?>
.top-bar{
	background: <?php echo  $top_bar_bg_color; ?>;
}

.top-bar,
.top-bar a,
.top-bar a:visited{
	color: <?php echo  $top_bar_font ?>;
}

.navigation-bar{
	background: <?php echo  $navigation_bg_color ?>;
}

.navigation-bar{
	background: <?php echo  $navigation_bg_color ?>;
}

.navbar-toggle,
#navigation .nav.navbar-nav > li > a,
#navigation .nav.navbar-nav > li.open > a,
#navigation .nav.navbar-nav > li > a:hover,
#navigation .nav.navbar-nav > li > a:focus ,
#navigation .nav.navbar-nav > li > a:active,
#navigation .nav.navbar-nav > li.current > a,
#navigation .navbar-nav > li.current-menu-parent > a, 
#navigation .navbar-nav > li.current-menu-ancestor > a, 
#navigation  .navbar-nav > li.current-menu-item  > a{
	color: <?php echo  $navigation_font_color ?>;
}

.nav.navbar-nav li a{
	font-family: "<?php echo str_replace( '+', ' ', $navigation_font ) ?>", sans-serif;
	<?php 
	if( $navigation_font == 'Montserrat' ){
		echo 'font-weight: 600;';
	}
	?>
	font-size: <?php echo  $navigation_font_size ?>;
}

table th,
.tagcloud a, .btn, a.btn,
.pagination a,
.pagination a:visited,
.pagination a:focus,
.pagination a:visited,
.big-search a.submit-live-form,
.sticky-wrap,
.form-submit #submit,
.alert-success,
.nav-tabs > li > a:hover,
.nav-tabs>li.active>a, .nav-tabs>li.active>a:hover, .nav-tabs>li.active>a:focus,
.category-lead-bg{
	background: <?php echo  $main_button_bg_color ?>;
	color: <?php echo  $main_button_font_color; ?>;
}

.leading-category .fa{
	border-color: <?php echo  $main_button_font_color; ?>;
	color: <?php echo  $main_button_font_color; ?>;
}

a, a:hover, a:focus, a:active, a:visited{
	color: <?php echo $link_font_color ?>;
}

a.grey:hover,
.section-title i,
.blog-title:hover h4, .blog-title:hover h5,
.fake-thumb-holder .post-format,
.comment-reply-link:hover{
	color: <?php echo  $main_button_bg_color ?>;
}

.pagination a:hover,
.tagcloud a:hover, .tagcloud a:focus, .tagcloud a:active,
.btn:hover, .btn:focus, .btn:active{
	background: <?php echo  $main_button_bg_color_hvr ?>;
	color: <?php echo  $main_button_font_color_hvr; ?>;
}

.pagination > span{
	background: <?php echo  $pag_button_bg_color_active ?>;
	color: <?php echo  $pag_button_font_color_active; ?>;
}

/* BODY */
body[class*=" "]{
	background-color: <?php echo  $body_bg_color ?>;
	background-image: url( <?php echo  $body_bg_image ?> );
	font-family: "<?php echo str_replace( '+', " ", $text_font ) ?>", sans-serif;
	font-size: <?php echo  $text_font_size ?>;
	line-height: <?php echo  $text_line_height ?>;
}

h1,h2,h3,h4,h5,h6{
	font-family: "<?php echo str_replace( '+', " ", $title_font ) ?>", sans-serif;
}

h1{
	font-size: <?php echo  $h1_font_size ?>;
	line-height: <?php echo  $h1_line_height ?>;
}

h2{
	font-size: <?php echo  $h2_font_size ?>;
	line-height: <?php echo  $h2_line_height ?>;
}

h3{
	font-size: <?php echo  $h3_font_size ?>;
	line-height: <?php echo  $h3_line_height ?>;
}

h4{
	font-size: <?php echo  $h4_font_size ?>;
	line-height: <?php echo  $h4_line_height ?>;
}

h5{
	font-size: <?php echo  $h5_font_size ?>;
	line-height: <?php echo  $h5_line_height ?>;
}

h6{
	font-size: <?php echo  $h6_font_size ?>;
	line-height: <?php echo  $h6_line_height ?>;
}

.copyrights{
	background: <?php echo  $copyrights_bg_color ?>;
	color: <?php echo  $copyrights_font_color; ?>;
}

.copyrights .copyrights-share{
	color: <?php echo  $copyrights_font_color ?>;
}

.mega_menu_dropdown .nav-tabs > li.active > a, 
.mega_menu_dropdown .nav-tabs > li.active > a:hover, 
.mega_menu_dropdown .nav-tabs > li.active > a:focus,
.mega_menu_dropdown ul.nav.nav-tabs li,
.mega_menu_dropdown ul.nav.nav-tabs li li,
.mega_menu_dropdown .nav-tabs > li > a,
.mega_menu_dropdown .tab-content{
	background: none;
}

a.review-cta.btn,
a.review-cta.btn:active,
a.review-cta.btn:visited,
a.review-cta.btn:focus{
	background: <?php echo  $cta_bg_color ?>;
	color: <?php echo  $cta_font_color ?>;
}

a.review-cta.btn:hover{
	background: <?php echo  $cta_bg_color_hvr ?>;
	color: <?php echo  $cta_font_color_hvr ?>;
}

.breadcrumbs{
	background: <?php echo  $breadcrumbs_bg_color ?>;
	color: <?php echo  $breadcrumbs_font_color ?>;
}