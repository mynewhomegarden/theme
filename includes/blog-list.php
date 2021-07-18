<?php
$post_format = get_post_format();
$has_media = reviews_has_media();
?>
<div <?php post_class( 'blog-item white-block' ) ?>>

	<?php if( reviews_has_media() ): ?>
		<div class="blog-media">
			<?php
			add_filter( 'wp_get_attachment_image_attributes', 'reviews_lazy_load_product_images');
			include( reviews_load_path( 'media/media'.( !empty( $post_format ) ? '-'.$post_format : '' ).'.php' ) );
			remove_filter( 'wp_get_attachment_image_attributes', 'reviews_lazy_load_product_images');
			?>
		</div>
	<?php endif; ?>

	<?php if( is_sticky() ): ?>
		<div class="sticky-wrap">
			<i class="fa fa-thumb-tack sticky-pin"></i>
		</div>
	<?php endif; ?>							

	<div class="content-inner">

		<div class="blog-title-wrap">
			<?php
			$extra_class = '';
			$words = explode( " ", get_the_title() );
			foreach( $words as $word ){
				if( strlen( $word ) > 25 ){
					$extra_class = 'break-word';
				}
			}
			?>
			<a href="<?php the_permalink(); ?>" class="blog-title <?php echo esc_attr( $extra_class ); ?>">
				<h4><?php the_title(); ?></h4>
			</a>
			<ul class="post-meta list-unstyled list-inline">
				<li>
					<i class="fa fa-user"></i>
					<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
						<?php echo get_the_author_meta('display_name') ?>
					</a>
				</li>
				<li>
					<i class="fa fa-clock-o"></i>
					<?php the_time( get_option( 'date_format' ) ); ?>
				</li>
				<li>
					<i class="fa fa-folder-o"></i>
					<?php echo reviews_the_category(); ?>
				</li>
			</ul>
		</div>

		<?php the_excerpt() ?>

		<a href="<?php the_permalink(); ?>" class="btn">
			<?php esc_html_e( 'Continue reading', 'reviews' ) ?>
		</a>

	</div>
</div>