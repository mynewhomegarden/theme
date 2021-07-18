<?php
function reviews_mega_menu_reviews_func( $atts, $content ){
	extract( shortcode_atts( array(
		'category' => '',
		'categories_title' => '',
		'number_of_reviews' => '4',
		'rows' => 1,
		'orderby' => '',
		'order' => '',
	), $atts ) );

	switch( $orderby ){
		case 'date' : 
			if( $order == 'ASC' ){
				$title2 = esc_html__( 'Oldest Reviews', 'reviews' );
			}
			else{
				$title2 = esc_html__( 'Latest Reviews', 'reviews' );	
			}
			break;
		case 'author_average' : 
			if( $order == 'ASC' ){
				$title2 = esc_html__( 'Worst Author Rated', 'reviews' );
			}
			else{
				$title2 = esc_html__( 'Best Author Rated', 'reviews' );	
			}
			break;
		case 'user_average' : 
			if( $order == 'ASC' ){
				$title2 = esc_html__( 'Worst User Rated', 'reviews' );
			}
			else{
				$title2 = esc_html__( 'Best User Rated', 'reviews' );	
			}
			break;
		case 'review_clicks' : 
			if( $order == 'ASC' ){
				$title2 = esc_html__( 'The Least Read', 'reviews' );
			}
			else{
				$title2 = esc_html__( 'Top Most Read', 'reviews' );	
			}
			break;			
	}

	$content = '';
	if( !empty( $category ) ){
		$navigation = '<ul class="nav nav-tabs" role="tablist">';
		$panels = '<div class="tab-content">';
		$first = true;
		$categories = explode( ',', $category );
		foreach( $categories as $category ){
			$category = get_term_by( 'slug', $category, 'review-category' );
			if( !empty( $category ) && !is_wp_error( $category ) ){
				$navigation .= '<li role="presentation" class="'.( $first ? 'active' : '' ).'"><a href="#'.esc_attr( $category->slug ).'" aria-controls="'.esc_attr( $category->slug ).'" role="tab" data-toggle="tab">'.$category->name.'</a></li>';

				$args = array(
					'post_status' => 'publish',
					'posts_per_page' => $number_of_reviews,
					'tax_query' => array(
						array(
							'taxonomy' => 'review-category',
							'field' => 'slug',
							'terms' => $category
						)
					),
					'orderby' => $orderby,
					'order' => $order
				);
				if( $orderby !== 'date' ){
					$args['orderby'] = 'meta_value_num';
					$args['meta_key'] = $orderby;
				}
				$posts = new WP_Query( $args );	
				
				ob_start();
				if( $posts->have_posts() ){
					?>
					<div role="tabpanel" class="tab-pane fade <?php echo  $first ? esc_attr( 'in active' ) : '' ?>" id="<?php echo esc_attr( $category->slug ) ?>">
						<ul class="list-unstyled list-inline similar-reviews clearfix">
						<?php
						while( $posts->have_posts() ){
							$posts->the_post();
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
					<?php
					$first = false;
				}
				$panels .= ob_get_contents();
				ob_end_clean();
			}
			wp_reset_postdata();
		}
		$navigation .= '</ul>';
		$panels .= '</div>';

		$rnd = reviews_random_string();
		$style_css = '<style>
			.'.$rnd.' .similar-reviews li{ 
				width: '.( 100 / ceil( $number_of_reviews / $rows ) ).'%;  
			}

			@media only screen and (max-width: 1170px){
				.'.$rnd.' .similar-reviews li{
					width: 33%;
				}
			}			

			@media only screen and (max-width: 990px){
				.'.$rnd.' .similar-reviews li{
					width: 50%;
				}
			}

			@media only screen and (max-width: 768px){
				.'.$rnd.' .similar-reviews li{
					width: 50%;
				}
			}

			@media only screen and (max-width: 400px){
				.'.$rnd.' .similar-reviews li{
					width: 100%;
				}
			}			
		</style>';

		return reviews_shortcode_style( $style_css ).'<div class="row mega_menu_category '.esc_attr( $rnd ).'"><div class="col-sm-3"><h5 class="mega_menu_category_title category_title_margin">'.$categories_title.'</h5>'.$navigation.'</div><div class="col-sm-9"><h5 class="mega_menu_category_title">&nbsp;'.$title2.'</h5>'.$panels.'</div></div>';

	}

	return $content;
}

add_shortcode( 'mega_menu_reviews', 'reviews_mega_menu_reviews_func' );

function reviews_mega_menu_reviews_params(){
	return array(
		array(
			"type" => "multidropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Category","reviews"),
			"param_name" => "category",
			"value" => reviews_get_taxonomy_list( 'review-category', 'left', 'slug' ),
			"description" => esc_html__("Select parent categories to show.","reviews")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Number Of Reviews","reviews"),
			"param_name" => "number_of_reviews",
			"value" => '',
			"description" => esc_html__("Input how many reviews to display from this category.","reviews")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Categories Title","reviews"),
			"param_name" => "categories_title",
			"value" => '',
			"description" => esc_html__("Input title for the categories list.","reviews")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Number Of Rows","reviews"),
			"param_name" => "rows",
			"value" => '',
			"description" => esc_html__("Input in how many rows to display results.","reviews")
		),		
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Order By","reviews"),
			"param_name" => "orderby",
			"value" => array(
				esc_html__( 'Date added', 'reviews' ) => 'date',
				esc_html__( 'Average author rate', 'reviews' ) => 'author_average',
				esc_html__( 'Users average rate', 'reviews' ) => 'user_average',
				esc_html__( 'Number of visits', 'reviews' ) => 'review_clicks',
			),
			"description" => esc_html__("Select orderby parametar.","reviews")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Order ","reviews"),
			"param_name" => "order",
			"value" => array(
				esc_html__( 'Ascending', 'reviews' ) => 'ASC',
				esc_html__( 'Descending', 'reviews' ) => 'DESC',
			),
			"description" => esc_html__("Select order parametar.","reviews")
		),			
	);
}

?>