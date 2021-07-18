<li>
	<div class="widget-image-thumb">
		<a href="<?php the_permalink(); ?>">
			<?php
			if( has_post_thumbnail() ){
				add_filter( 'wp_get_attachment_image_attributes', 'reviews_lazy_load_product_images');
				the_post_thumbnail( 'thumbnail' );
				remove_filter( 'wp_get_attachment_image_attributes', 'reviews_lazy_load_product_images');
			}else{
				$post_format = get_post_format();
				?>
				<div class="fake-thumb-wrap">
					<div class="post-format post-format-<?php echo !empty( $post_format ) ? $post_format : 'standard'; ?>"></div>
				</div>
				<?php
			}							
			?>
		</a>
	</div>
	<div class="widget-text">
		<a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
		<ul class="list-unstyled list-inline post-meta grey">
			<li>
				<i class="fa fa-clock-o"></i> <?php the_time( get_option( 'date_format' ) ) ?>
			</li>
			<li>
				<i class="fa fa-comment-o"></i><?php comments_number( esc_html__( '0', 'reviews' ), esc_html__( '1', 'reviews' ), esc_html__( '%', 'reviews' ) ); ?>
			</li>								
		</ul>
	</div>
	<div class="clearfix"></div>
</li>