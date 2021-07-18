<?php
/*
	Template Name: Search Page
*/
get_header();
the_post();

global $reviews_slugs;

$reviews_listing_style = reviews_get_option( 'reviews_listing_style' );

$review_category = isset( $_GET[$reviews_slugs['review-category']] ) ? esc_sql( $_GET[$reviews_slugs['review-category']] ) : '';
$review_tag = isset( $_GET[$reviews_slugs['review-tag']] ) ? esc_sql( $_GET[$reviews_slugs['review-tag']] ) : '';
$keyword = isset( $_GET[$reviews_slugs['keyword']] ) ? esc_sql( $_GET[$reviews_slugs['keyword']] ) : '';
$sort = isset( $_GET[$reviews_slugs['sort']] ) ? esc_sql( $_GET[$reviews_slugs['sort']] ) : '';

$base_permalink = reviews_get_permalink_by_tpl( 'page-tpl_search' ) ;
$permalink = reviews_get_permalink_by_tpl( 'page-tpl_search' ) ;

$args = array(
	'post_type' => 'review',
	'post_status' => 'publish',
	'posts_per_page' => reviews_get_option( 'reviews_per_page' ),
	'tax_query' => array(
		'relation' => 'AND'
	),
	'meta_query' => array(
		'relation' => 'OR'
	)
);

$category_ancestors = array();
if( !empty( $review_category ) ){
	$permalink = add_query_arg( array( $reviews_slugs['review-category'] => $review_category ), $permalink );	
	$args['tax_query'][] = array(
		'taxonomy' => 'review-category',
		'field'    => 'slug',
		'terms'    => $review_category,
	);
	$term = get_term_by( 'slug', $review_category, 'review-category' );
	$description = $term->description;
	$category_ancestors[] = $term->term_id;
    while ( $term->parent != 0 ){
        $term  = get_term_by( 'id', $term->parent, 'review-category' );
        $category_ancestors[] = $term->term_id;
    }
}

if( !empty( $review_tag ) ){
	$permalink = add_query_arg( array( $reviews_slugs['review-tag'] => $review_tag ), $permalink );
	$args['tax_query'][] = array(
		'taxonomy' => 'review-tag',
		'field'    => 'slug',
		'terms'    => $review_tag,
	);
}

if( !empty( $keyword ) ){
	$permalink = add_query_arg( array( $reviews_slugs['keyword'] => $keyword ), $permalink );
	$args['s'] = $keyword;
}

if( !empty( $sort ) ){
	$sort_array = explode( "-", $sort );
	$args['order'] = $sort_array[1];
	if( $sort_array[0] == 'title' || $sort_array[0] == 'date' ){
		$args['orderby'] = $sort_array[0];
	}
	else if ( $sort_array[0] == 'user_average' ){
		$args['orderby'] = array(
			'user_average'			=> $sort_array[1],
			'user_ratings_count'	=> $sort_array[1]
		);
		$args['meta_query'] = array(
			'relation'    => 'AND',
			'user_average' => array(
				'key'     => 'user_average',
				'compare' => 'EXISTS',
			),
			'user_ratings_count' => array(
				'key'     => 'user_ratings_count',
				'compare' => 'EXISTS',
			),
		);	
	}
	else{
		$args['orderby'] = 'meta_value_num';
		$args['meta_key'] = $sort_array[0];
		if( $args['meta_key'] == 'clicks' ){
			$args['meta_key'] = 'review_clicks';
		}
	}
}

$cur_page = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; //get curent page
$args['paged'] = $cur_page;
$reviews = new WP_Query( $args );
$page_links_total =  $reviews->max_num_pages;
$pagination = paginate_links( 
	array(
		'prev_next' => true,
		'end_size' => 2,
		'mid_size' => 2,
		'total' => $page_links_total,
		'current' => $cur_page,	
		'prev_next' => false
	)
);	

$item_width = is_active_sidebar( 'reviews-search' ) ? 6 : 4;
?>

<section class="search-filter">
	<div class="container">
		<div class="row">
			<div class="col-sm-4">
				<div class="widget white-block clearfix">

					<div class="widget-title-wrap">
						<h5 class="widget-title">
							<i class="fa fa-angle-double-right"></i><?php esc_html_e( 'Filter By Keyword', 'reviews' ); ?>
						</h5>
					</div>
	            	<form method="get" action="<?php echo esc_url( $base_permalink ) ?>">
						<input type="text" class="form-control" name="<?php echo esc_attr( $reviews_slugs['keyword'] ); ?>" value="<?php echo esc_attr( $keyword ) ?>" placeholder="<?php esc_attr_e( 'Type term and hit enter...', 'reviews' ); ?>">		                
		            </form>

				</div>			
			</div>
			<div class="col-sm-4">

				<div class="widget white-block clearfix">

					<div class="widget-title-wrap">
						<h5 class="widget-title">
							<i class="fa fa-angle-double-right"></i><?php esc_html_e( 'Filter By Category', 'reviews' );?>
						</h5>
					</div>
	            	<form method="get" action="<?php echo esc_url( $base_permalink ) ?>">
		                <select name="<?php echo esc_attr( $reviews_slugs['review-category'] ); ?>" id="review-category" class="form-control">
		                	<option value=""><?php esc_html_e( 'All Categories', 'reviews' ) ?></option>
		                	<?php reviews_display_categories_filter( $category_ancestors, $permalink ) ?>
		                </select>
		            </form>

				</div>			
			</div>
			<div class="col-sm-4">
				<div class="widget white-block clearfix">

					<div class="widget-title-wrap">
						<h5 class="widget-title">
							<i class="fa fa-angle-double-right"></i><?php esc_html_e( 'Sort Reviews', 'reviews' );?>
						</h5>
					</div>
	            	<form method="get" action="<?php echo esc_url( $base_permalink ) ?>">
		                <select name="<?php echo esc_attr( $reviews_slugs['sort'] ); ?>" id="sort" class="form-control">
		                	<option value=""><?php esc_html_e( '- Select -', 'reviews' ) ?></option>
		                	<option value="author_average-desc" <?php echo $sort == 'author_average-desc' ? esc_attr( 'selected="selected"' ) : '' ?>><?php esc_html_e( 'Author Ratings (highest first)', 'reviews' ) ?></option>
		                	<option value="author_average-asc" <?php echo $sort == 'author_average-asc' ? esc_attr( 'selected="selected"' ) : '' ?>><?php esc_html_e( 'Author Ratings (lowest first)', 'reviews' ) ?></option>
		                	<option value="user_average-desc" <?php echo $sort == 'user_average-desc' ? esc_attr( 'selected="selected"' ) : '' ?>><?php esc_html_e( 'User Ratings (highest first)', 'reviews' ) ?></option>
		                	<option value="user_average-asc" <?php echo $sort == 'user_average-asc' ? esc_attr( 'selected="selected"' ) : '' ?>><?php esc_html_e( 'User Ratings (lowest first)', 'reviews' ) ?></option>				                	
		                	<option value="date-desc" <?php echo $sort == 'date-desc' ? esc_attr( 'selected="selected"' ) : '' ?>><?php esc_html_e( 'Date (newest first)', 'reviews' ) ?></option>
		                	<option value="date-asc" <?php echo $sort == 'date-asc' ? esc_attr( 'selected="selected"' ) : '' ?>><?php esc_html_e( 'Date (oldest first)', 'reviews' ) ?></option>
		                	<option value="title-desc" <?php echo $sort == 'title-desc' ? esc_attr( 'selected="selected"' ) : '' ?>><?php esc_html_e( 'Title (descending)', 'reviews' ) ?></option>
		                	<option value="title-asc" <?php echo $sort == 'title-asc' ? esc_attr( 'selected="selected"' ) : '' ?>><?php esc_html_e( 'Title (ascending)', 'reviews' ) ?></option>
		                	<option value="clicks-desc" <?php echo $sort == 'clicks-desc' ? esc_attr( 'selected="selected"' ) : '' ?>><?php esc_html_e( 'Visits (descending)', 'reviews' ) ?></option>
		                	<option value="clicks-asc" <?php echo $sort == 'clicks-asc' ? esc_attr( 'selected="selected"' ) : '' ?>><?php esc_html_e( 'Visits (ascending)', 'reviews' ) ?></option>
		                </select>
		                <?php if( !empty( $review_category ) ): ?>
		                	<input type="hidden" name="<?php echo esc_attr( $reviews_slugs['review-category'] ); ?>" value="<?php echo esc_attr( $review_category ) ?>">	
		                <?php endif; ?>
		                <?php if( !empty( $review_tag ) ): ?>
		                	<input type="hidden" name="<?php echo esc_attr( $reviews_slugs['review-tag'] ); ?>" value="<?php echo esc_attr( $review_tag ) ?>">	
		                <?php endif; ?>
		                <?php if( !empty( $keyword ) ): ?>
		                	<input type="hidden" name="<?php echo esc_attr( $reviews_slugs['keyword'] ); ?>" value="<?php echo esc_attr( $keyword ) ?>">	
		                <?php endif; ?>			                
		            </form>				
					
				</div>			
			</div>
		</div>
		<div class="row">
			<div class="col-sm-<?php echo is_active_sidebar( 'reviews-search' ) ? esc_attr( '9' ) : esc_attr( '12' ) ?>">
				<?php
				if( !empty( $description ) ){
					?>
					<div class="white-block">
						<div class="content-inner category-description">
							<?php echo $description ?>
						</div>
					</div>
					<?php
				}
				?>			
				<?php if( $reviews->have_posts() ): ?>
					<div class="row <?php echo $reviews_listing_style == 'masonry' ? 'masonry' : '' ?>">
						<?php
						$counter = 0;
						while( $reviews->have_posts() ){
							if( $counter == ( 12 / $item_width ) && $reviews_listing_style == 'grid' ){
								$counter = 0;
								echo '</div><div class="row">';
							}
							$counter++;
							$reviews->the_post();
							echo '<div class="col-sm-'.esc_attr( $item_width ).' masonry-item">';
								 include( reviews_load_path( 'includes/review-box.php' ) );
							echo '</div>';
						}
						?>
					</div>
					<?php if( !empty( $pagination ) ): ?>
						<div class="pagination">
							<?php echo  $pagination; ?>
						</div>	
					<?php endif; ?>
				<?php else: ?>
					<div class="widget white-block">
						<?php esc_html_e( 'No reviews found to match your search criteria', 'reviews' ); ?>
					</div>
				<?php endif; ?>			
			</div>

			<?php get_sidebar( 'reviews-search' ); ?>
		</div>
	</div>
</section>
<?php get_footer(); ?>