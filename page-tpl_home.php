<?php
/*
	Template Name: Home Page
*/

get_header();
the_post();
$permalink = reviews_get_permalink_by_tpl( 'page-tpl_search' );
$slider = '';

global $reviews_slugs;

for( $i=1; $i<=10; $i++ ){
	$image_data = reviews_get_option( 'home_bs_img_'.$i );
	if( !empty( $image_data['url'] ) ){
		$slider .= '<li><img data-src="'.esc_url( $image_data['url'] ).'" src="'.get_template_directory_uri().'/images/holder.jpg" class="reviews-lazy-load big-slider" width="'.esc_attr( $image_data['width'] ).'" height="'.esc_attr( $image_data['height'] ).'" alt=""></li>';
	}
}
?>

<?php if( !empty( $slider ) ): ?>
	<section class="big-search">
		<ul class="list-unstyled big-search-slider">
			<?php echo  $slider; ?>
		</ul>
		<div class="big-search-overlay"></div>
		<div class="container">
			<h1><?php echo reviews_get_option( 'home_bs_title' ); ?></h1>
			<h2><?php echo reviews_get_option( 'home_bs_subtitle' ) ?></h2>		
			<form method="get" action="<?php echo esc_url( $permalink ) ?>" autocomplete="off" class="quick-search">
				<input type="text" name="<?php echo esc_attr( $reviews_slugs['keyword'] ); ?>" id="keyword" value="" />
				<a href="javascript:;" class="submit-live-form">
					<?php esc_html_e( 'Search', 'reviews' ) ?>
				</a>
				<div class="quick_search_result"></div>
			</form>
		</div>
	</section>
<?php else: ?>
	<div class="big-search-dummy"></div>
<?php endif; ?>

<section>
	<div class="container">
		<?php the_content(); ?>
	</div>
</section>

<?php get_footer(); ?>