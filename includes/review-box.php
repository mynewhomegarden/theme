<div class="reviews-box white-block">
	<div class="blog-media">
		<a href="<?php the_permalink() ?>">
			<?php
			add_filter( 'wp_get_attachment_image_attributes', 'reviews_lazy_load_product_images');
			the_post_thumbnail( 'reviews-box-thumb', array( 'class' => 'embed-responsive-item', 'sizes' => '(min-width: 414px) and (max-width: 768px) 768px, 360px' ) );
			remove_filter( 'wp_get_attachment_image_attributes', 'reviews_lazy_load_product_images');
			$post_id = get_the_ID();
			?>
		</a>
	</div>
	<div class="content-inner">
		<div class="ratings clearfix">
			<?php echo reviews_calculate_ratings(); ?>
		</div>

		<a href="<?php the_permalink() ?>" class="blog-title">
			<h5><?php the_title() ?></h5>
		</a>

		<?php the_excerpt(); ?>

		<div class="avatar">
			<div class="clearfix">	
				<?php
				$reviews_show_author = reviews_get_option( 'reviews_show_author' );
				if( $reviews_show_author == 'yes' ):
				?>
					<div class="pull-left">				
						<?php
						echo get_avatar( get_the_author_meta('ID'), 25 );
						$direction = reviews_get_option( 'direction' );
						if( $direction == 'ltr' ){
							esc_html_e( 'By ', 'reviews' );
						}
						?>
						<a href="<?php echo esc_url( add_query_arg( array( 'post_type' => 'review' ), get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ) ?>">
							<?php echo get_the_author_meta( 'display_name' ); ?>						
						</a>
						<?php
						if( $direction == 'rtl' ){
							esc_html_e( ' By', 'reviews' );
						}
						?>
					</div>
				<?php  endif;?>
				<div class="pull-<?php echo $reviews_show_author == 'yes' ? esc_attr( 'right') : esc_attr( 'left' ) ?> reviews-box-cat">
					<?php reviews_review_category(); ?>
				</div>
			</div>
		</div>			
	</div>
</div>