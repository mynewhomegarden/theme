<?php
function reviews_latest_blogs_func( $atts, $content ){
	extract( shortcode_atts( array(
		'number' => '3',
	), $atts ) );

	ob_start();
	?>
	<div class="row">
		<?php
		$blogs = new WP_Query(array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'posts_per_page' => $number,
		));
		$counter = 0;
		if( $blogs->have_posts() ){
			while( $blogs->have_posts() ){
				$blogs->the_post();
				if( $counter == 3 ){
					echo '</div><div class="row">';
					$counter = 0;
				}
				$counter++;
				$post_format = get_post_format();
				$has_media = reviews_has_media();
				?>
				<div class="col-sm-4">
					<div <?php post_class( 'blog-item white-block blog-element' ) ?>>
						<?php if( $has_media ): ?>
							<div class="blog-media">
								<?php
								$image_size = 'reviews-box-thumb';
								?>
								<?php 
								add_filter( 'wp_get_attachment_image_attributes', 'reviews_lazy_load_product_images');
								include( reviews_load_path( 'media/media'.( !empty( $post_format ) ? '-'.$post_format : '' ).'.php' ) ); 
								remove_filter( 'wp_get_attachment_image_attributes', 'reviews_lazy_load_product_images');
								?>
							</div>
						<?php endif; ?>
						<div class="content-inner">

							<div class="blog-title-wrap">
								<p class="post-meta clearfix">
									<?php esc_html_e( 'By ', 'reviews' ); ?>
									<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
										<?php echo get_the_author_meta('display_name') ?>
									</a>
									<?php esc_html_e( ' in ', 'reviews' ) ?>
									<?php echo reviews_the_category(); ?>
									<span class="pull-right">
									<?php the_time( get_option( 'date_format' ) ); ?>
									</span>
								</p>							
								<a href="<?php the_permalink(); ?>" class="blog-title">
									<h5><?php the_title(); ?></h5>
								</a>
							</div>

						</div>							
					</div>
				</div>
				<?php
			}
		}
		?>
	</div>
	<?php
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

add_shortcode( 'latest_blogs', 'reviews_latest_blogs_func' );

function reviews_latest_blogs_params(){
	return array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Number Of Blogs","reviews"),
			"param_name" => "number",
			"value" => '',
			"description" => esc_html__("Input number of the latest blogs to show.","reviews")
		),		
	);
}

if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => esc_html__("Latest Blogs", 'reviews'),
	   "base" => "latest_blogs",
	   "category" => esc_html__('Content', 'reviews'),
	   "params" => reviews_latest_blogs_params()
	) );
}
?>