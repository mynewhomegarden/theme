<?php
function reviews_func( $atts, $content ){
	extract( shortcode_atts( array(
		'number' => '3',
		'style' => '1',
		'source' => '',
		'review_ids' => '',
		'categories' => '',
		'slider' => 'no'
	), $atts ) );
	$permalink = reviews_get_permalink_by_tpl( 'page-tpl_search' );

	$args = array();
	if( empty( $review_ids ) ){
		switch( $source ){
			case 'top-rated-author' :
				$args = array(
					'orderby' => array( 'meta_value_num' => 'DESC', 'date' => 'DESC' ),
					'meta_key' => 'author_average'
				);
				break;
			case 'top-rated-users' :
				$args = array(
					'orderby' => array(
						'user_average'			=> 'DESC',
						'user_ratings_count'	=> 'DESC'
					),
					'meta_query' => array(
						'relation'    => 'AND',
						'user_average' => array(
							'key'     => 'user_average',
							'compare' => 'EXISTS',
						),
						'user_ratings_count' => array(
							'key'     => 'user_ratings_count',
							'compare' => 'EXISTS',
						),
					)
				);
				break;
			case 'most-rated-users' :
				$args = array(
					'orderby' => array( 'meta_value_num' => 'DESC', 'date' => 'DESC' ),
					'meta_key' => 'user_ratings_count'
				);
				break;
			case 'random':
				$args = array(
					'orderby' => 'rand'
				);		
				break;	
		}
		$args['posts_per_page'] = $number;
	}
	else{
		$args['post__in'] = explode( ',', $review_ids );
		$args['orderby'] = 'post__in';
	}
	

	ob_start();
	?>
		<div class="<?php echo $slider == 'yes' ? esc_attr('reviews-slider') : esc_attr('row') ?>" data-items="<?php echo $style == '1' ? esc_attr( 3 ) : esc_attr( 2 ) ?>">
			<?php
			$args['post_type'] = 'review';
			$args['post_status'] = 'publish';

			if( !empty( $categories ) ){
				$categories = explode( ',', $categories );
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'review-category',
						'field' => 'term_id',
						'terms' => $categories
					)
				);
			}
			$reviews = new WP_Query( $args );
			$counter = 0;
			if( $reviews->have_posts() ){
				while( $reviews->have_posts() ){
					$reviews->the_post();
					if( $slider == 'no' ){
						if( ( $counter == 3 && $style == 1 ) || ( $counter == 2 && $style == 2 ) ){
							echo '</div><div class="row">';
							$counter = 0;
						}
						$counter++;
					}
					?>
					<?php if( $slider == 'no' ): ?>
						<div class="col-sm-<?php echo $style == '1' ? esc_attr( '4' ) : esc_attr( '6' ) ?>">
					<?php endif; ?>
						<?php include( reviews_load_path( 'includes/review-box'.( $style == '1' ? '' : '-alt' ).'.php' ) ); ?>
					<?php if( $slider == 'no' ): ?>
						</div>
					<?php endif; ?>
					<?php
				}
			}

			wp_reset_postdata();
			?>
		</div>
	<?php
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

add_shortcode( 'reviews', 'reviews_func' );

function reviews_params(){
	return array(
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Number Of Reviews","reviews"),
			"param_name" => "number",
			"value" => '',
			"description" => esc_html__("Input number of the latest reviews to show.","reviews")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Style","reviews"),
			"param_name" => "style",
			"value" => array(
				esc_html__( 'Top Media', 'reviews' ) => '1',
				esc_html__( 'Side Media', 'reviews' ) => '2'
			),
			"description" => esc_html__("Select reviews box style.","reviews")
		),
		array(
			"type" => "multidropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("From Category","reviews"),
			"param_name" => "categories",
			"value" => reviews_get_taxonomy_list( 'review-category', 'left', 'ids', '' ),
			"description" => esc_html__("Filter by categories.","reviews")
		),		
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Reviews Source","reviews"),
			"param_name" => "source",
			"value" => array(
				esc_html__( 'Latest', 'reviews' ) => 'latest',
				esc_html__( 'Top Rated By Author', 'reviews' ) => 'top-rated-author',
				esc_html__( 'Top Rated By Users', 'reviews' ) => 'top-rated-users',
				esc_html__( 'Most Reviews', 'reviews' ) => 'most-rated-users',
				esc_html__( 'Random', 'reviews' ) => 'random',
			),
			"description" => esc_html__("Select reviews source.","reviews")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Reviews By ID ( Overrides field above )","reviews"),
			"param_name" => "review_ids",
			"value" => '',
			"description" => esc_html__("Input comma separated list of reviews to display and it will be used instead value from the field above.","reviews")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Use Slider","reviews"),
			"param_name" => "slider",
			"value" => array(
				esc_html__( 'No', 'reviews' ) => 'no',
				esc_html__( 'Yes', 'reviews' ) => 'yes',
			),
			"description" => esc_html__("Enable or disable usage of the slider.","reviews")
		),
	);
}

function reviews_map_reviews(){
if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => esc_html__("Reviews", 'reviews'),
	   "base" => "reviews",
	   "category" => esc_html__('Content', 'reviews'),
	   "params" => reviews_params()
	) );
}
}
add_action('init', 'reviews_map_reviews', 20 );
?>