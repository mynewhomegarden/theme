<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<!-- ==================================================================================================================================
TOP BAR
======================================================================================================================================= -->

<?php
$show_top_bar = reviews_get_option( 'show_top_bar' );
if( $show_top_bar == 'yes' ):
?>
<section class="top-bar">
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<?php
				$top_bar_message = reviews_get_option( 'top_bar_message' );
				if( !empty( $top_bar_message ) ){
					echo '<p class="no-margin">'.$top_bar_message.'</p>';
				}
				?>
			</div>		
			<div class="col-sm-6">
				<div class="account-action text-right">
					<?php
					if( is_user_logged_in() ){
						?>
						<a href="<?php echo get_edit_user_link(); ?>">
							<i class="fa fa-user animation"></i>
							<?php esc_html_e( 'My Account', 'reviews' ) ?>
						</a>
						<a href="<?php echo esc_url( wp_logout_url( home_url( '/' ) ) ); ?>">
							<i class="fa fa-sign-out animation"></i>
							<?php esc_html_e( 'Log Out', 'reviews' ) ?>
						</a>						
						<?php
					}
					else{
						?>
						<a href="<?php echo reviews_get_permalink_by_tpl( 'page-tpl_register_login' ) ?>">
							<i class="fa fa-user animation"></i>
							<?php esc_html_e( 'Register', 'reviews' ) ?>
						</a>
						<a href="<?php echo reviews_get_permalink_by_tpl( 'page-tpl_register_login' ) ?>">
							<i class="fa fa-sign-in animation"></i>
							<?php esc_html_e( 'Log In', 'reviews' ) ?>
						</a>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>

<section class="navigation-bar">
	<div class="container">
		<div class="flex-wrap">
			<div class="pull-left">
				<?php
				$site_logo = reviews_get_option( 'site_logo' );
				if( !empty( $site_logo['url'] ) ):
				?>			
					<a href="<?php echo esc_url( home_url( '/' ) ) ?>" class="logo">
						<img class="img-responsve" src="<?php echo esc_url( $site_logo['url'] ) ?>" alt="" height="<?php echo esc_attr( $site_logo['height'] ) ?>" width="<?php echo esc_attr( $site_logo['width'] ) ?>"/>
					</a>
				<?php
				endif;
				?>			
			</div>
			<div class="pull-right">
				<button class="navbar-toggle button-white menu" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only"><?php esc_html_e( 'Toggle navigation', 'reviews' ) ?></span>
					<i class="fa fa-bars fa-2x"></i>
				</button>
			</div>
			<div class="pull-right small-centered">
				<div id="navigation">
					<div class="navbar navbar-default" role="navigation">
						<div class="collapse navbar-collapse">
							<?php
							if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ 'top-navigation' ] ) ) {
								wp_nav_menu( array(
									'theme_location'  	=> 'top-navigation',
									'menu_class'        => 'nav navbar-nav',
									'container'			=> false,
									'echo'          	=> true,
									'items_wrap'        => '<ul class="%2$s">%3$s</ul>',
									'walker' 			=> new reviews_walker
								) );
							}
							?>
						</div>
					</div>
				</div>			
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
</section>

<?php
$breadcrumbs = reviews_breadcrumbs();
if( !empty( $breadcrumbs ) ):
global $reviews_slugs;
?>
<section class="breadcrumbs white-block">
	<div class="container">
		<div class="clearfix">
			<div class="pull-left">
				<?php echo  $breadcrumbs; ?>
			</div>
			<div class="pull-right">
				<?php
				if( get_page_template_slug() !== 'page-tpl_search.php' ){
					?>
					<form action="<?php echo esc_url( reviews_get_permalink_by_tpl( 'page-tpl_search' ) ) ?>" class="quick-search" autocomplete="off">
						<input type="text" name="<?php echo esc_attr( $reviews_slugs['keyword'] ) ?>" class="form-control" placeholder="<?php esc_attr_e( 'Type term to search...', 'reviews' ) ?>">
						<div class="quick_search_result"></div>
					</form>
					<?php
				}
				?>
			</div>
		</div>
	</div>
</section>
<?php elseif( is_home() && is_front_page() ): ?>
	<div class="breadcrumbs-dummy"></div>
<?php endif; ?>