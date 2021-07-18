<?php

/*
	Template Name: All Categories
*/
get_header();
the_post();
?>
<section>
	<div class="container">
		<?php
		$review_category = isset( $_GET['review-category'] ) ? $_GET['review-category'] : '';
		if( empty( $review_category ) ){
			echo do_shortcode( '[categories_list categories="" num_subs="0" link_to_subcats="'.reviews_get_option( 'all_cats_sublinks' ).'"][/categories_list]' );
		}
		else{
			$term = get_term_by( 'slug', $_GET['review-category'], 'review-category' );
			if( !empty($term) ){
				echo '<div class="all-subcategories">';
					echo do_shortcode( '[categories_list categories="'.$term->term_id.'" num_subs="0" link_to_subcats="'.reviews_get_option( 'all_cats_sublinks' ).'"][/categories_list]' );	
				echo '</div>';
			}
		}
		?>
	</div>
</section>
<?php get_footer(); ?>