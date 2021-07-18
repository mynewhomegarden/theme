<div class="col-md-3">
	<div class="widget white-block clearfix">
		<ul class="list-unstyled ordered-list">
			<?php
			$reviews_show_author = reviews_get_option( 'reviews_show_author' );
			if( $reviews_show_author == 'yes' ):
			?>
				<li class="reviews-avatar">
					<a href="<?php echo esc_url( add_query_arg( array( 'post_type' => 'review' ), get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ); ?>">
						<?php echo get_avatar( get_the_author_meta('ID'), 50 ) ?>
					</a>
					<?php esc_html_e( 'By ', 'reviews' ) ?><a href="<?php echo esc_url( add_query_arg( array( 'post_type' => 'review' ), get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ); ?>"> <?php echo get_the_author_meta('display_name'); ?></a>
				</li>
			<?php endif; ?>
			<li>
				<?php esc_html_e( 'Category:', 'reviews' ) ?>
				<span class="value"><?php echo reviews_review_category(); ?></span>
			</li>
			<li>
				<?php esc_html_e( 'Author Ratings:', 'reviews' ) ?>
				<span class="value author-ratings">
					<?php 
						$author_average = get_post_meta( get_the_ID(), 'author_average', true );
						reviews_rating_display( $author_average );
					?>
				</span>
			</li>
			<?php if( comments_open() ): ?>
			<li>
				<?php esc_html_e( 'User Ratings:', 'reviews' ) ?>
				<span class="value user-ratings">
					<?php reviews_rating_display( $user_average );?>
				</span>
			</li>
			<li>
				<?php esc_html_e( 'Reviews:', 'reviews' ) ?>
				<span class="value">
					<?php
					$reviews_count = reviews_display_count_reviews( get_the_ID() );
					echo  $reviews_count.' '.( $reviews_count == 1 ? esc_html__( 'user review', 'reviews' ) : esc_html__( 'user reviews', 'reviews' ) );
					?>
				</span>
			</li>
			<?php endif;?>
			<li>
				<?php esc_html_e( 'Created:', 'reviews' ) ?>
				<span class="value"><?php the_time( get_option( 'date_format' ) ) ?></span>
			</li>
		</ul>
		<?php
		$review_cta_text = reviews_get_option( 'reviews_cta_text' );
		$review_cta_link = get_post_meta( get_the_ID(), 'review_cta_link', true );
		if( !empty( $review_cta_link ) ){
			echo '<a href="'.esc_attr( $review_cta_link ).'" class="review-cta btn" target="_blank" rel="nofollow"><strong>'.$review_cta_text.'</strong></a>';
		}
		?>
	</div>

	<?php
	$reviews_wtb = get_post_meta( get_the_ID(), 'reviews_wtb' );
	if( !empty( $reviews_wtb ) ){
		?>
		<div class="widget white-block clearfix">
			<div class="widget-title-wrap">
				<h5 class="widget-title">
					<i class="fa fa-angle-double-right"></i><?php esc_html_e( 'Where To Buy', 'reviews' ) ?>
				</h5>
			</div>
			<ul class="list-unstyled reviews-wtb">
				<?php
				foreach( $reviews_wtb as $reviews_wtb_item ){
					?>
					<li>
						<a title="<?php echo esc_attr( $reviews_wtb_item['review_wtb_store_name'] ); ?>" href="<?php echo esc_url( $reviews_wtb_item['review_wtb_store_link'] ) ?>" class="store-logo" target="_blank">
							<?php echo wp_get_attachment_image( $reviews_wtb_item['review_wtb_store_logo'], 'full' ); ?>
						</a>

						<div class="clearfix">
							<?php
							$review_wtb_price = $reviews_wtb_item['review_wtb_price'];
							$review_wtb_sale_price = $reviews_wtb_item['review_wtb_sale_price'];
							if( !empty( $review_wtb_sale_price ) ){
								echo '<div class="pull-left price">'.$review_wtb_sale_price.'<span>'.$review_wtb_price.'</span></div>';
							}
							else{
								echo '<div class="pull-left price">'.$review_wtb_price.'</div>';	
							}

							$review_wtb_product_link = $reviews_wtb_item['review_wtb_product_link'];
							if( !empty( $review_wtb_product_link ) ){
								echo '<div class="pull-right price">
									<a href="'.esc_url( $review_wtb_product_link ).'" class="visit-store" target="_blank" rel="nofollow">'.__( 'Visit', 'reviews' ).' <i class="fa fa-external-link"></i></a>
								</div>';	
							}
							?>
						</div>
					</li>
					<?php
				}
				?>
			</ul>
		</div>
		<?php
	}
	?>
	<?php
	$enable_share = reviews_get_option( 'enable_share' );
	if( $enable_share == 'yes' ):
	?>
		<div class="widget white-block clearfix">
			<div class="widget-title-wrap">
				<h5 class="widget-title">
					<i class="fa fa-angle-double-right"></i><?php esc_html_e( 'Share Review', 'reviews' ) ?>
				</h5>
			</div>				
			<?php get_template_part( 'includes/share' ) ?>
		</div>
	<?php endif; ?>


	<?php
	$similar_reviews_num = reviews_get_option( 'similar_reviews_num' );
	if( !empty( $similar_reviews_num ) && $similar_reviews_num > 0 ):
		$args = array(
			'post_type' => 'review',
			'posts_per_page' => $similar_reviews_num,
			'post__not_in' => array( get_the_ID() ),
			'post_status' => 'publish',
			'orderby' => 'rand'
		);
		$reviews_categories = get_the_terms( get_the_ID(), 'review-category' );
		if( !empty( $reviews_categories ) ){
			$cats = array();
			foreach( $reviews_categories as $reviews_category ){
				if( $reviews_category->parent == 0 ){
					$cats[] = $reviews_category->slug;	
				}
			}
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'review-category',
					'field' => 'slug',
					'terms' => $cats
				)
			);
		}
		
		$similar = new WP_Query( $args );
		if( $similar->have_posts() ):
		?>
			<div class="widget white-block clearfix">
				<div class="widget-title-wrap">
					<h5 class="widget-title">
						<i class="fa fa-angle-double-right"></i><?php esc_html_e( 'Similar Products', 'reviews' ) ?>
					</h5>
				</div>
				<ul class="list-unstyled similar-reviews">
					<?php
					while( $similar->have_posts() ){
						$similar->the_post();
						?>
						<li>
							<?php if( has_post_thumbnail() ): ?>
								<a href="<?php the_permalink() ?>" class="no-margin">
									<div class="embed-responsive embed-responsive-16by9">
										<?php 
										add_filter( 'wp_get_attachment_image_attributes', 'reviews_lazy_load_product_images');
										the_post_thumbnail( 'reviews-box-thumb', array( 'class' => 'embed-responsive-item' ) ); 
										remove_filter( 'wp_get_attachment_image_attributes', 'reviews_lazy_load_product_images');
										?>
									</div>
									<div class="ratings clearfix">
										<?php echo reviews_calculate_ratings(); ?>
									</div>
								</a>
							<?php else: ?>
								<div class="ratings clearfix">
									<?php echo reviews_calculate_ratings(); ?>
								</div>
							<?php endif; ?>
							<a href="<?php the_permalink() ?>" class="text-center">
								<h6><?php the_title(); ?></h6>
							</a>
						</li>
						<?php
					}
					?>
				</ul>
			</div>
		<?php endif; 
		wp_reset_postdata();
	endif;
	?>

	<?php get_sidebar( 'review' ); ?>
</div>