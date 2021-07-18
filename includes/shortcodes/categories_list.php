<?php
function reviews_categories_func( $atts, $content ){
	extract( shortcode_atts( array(
		'categories' => '',
		'num_subs' => '',
		'link_to_subcats' => 'no'
	), $atts ) );

	global $reviews_slugs;

	$permalink = reviews_get_permalink_by_tpl( 'page-tpl_search' );
	if( $link_to_subcats == 'yes' ){
		$permalink_cats = reviews_get_permalink_by_tpl( 'page-tpl_all_categories' );
	}

	if( empty( $categories ) ){
		$categories = get_terms( 'review-category', array( 'parent' => 0, 'hide_empty' => false ) );
	}
	else{
		$categories = explode(",", $categories);
		$categories = get_terms( 'review-category', array( 'include' => $categories, 'hide_empty' => false ) );
	}

	ob_start();
	?>
	<div class="row category-list">
		<?php
        $counter = 0;		
		foreach( $categories as $category ){
            if( $counter == 3 ){
                echo '</div><div class="row category-list">';
                $counter = 0;
            }
            $counter++;			
			$term_meta = get_option( "taxonomy_".$category->term_id );
			$value = !empty( $term_meta['category_icon'] ) ? $term_meta['category_icon'] : '';

			$has_children = false;
			if( $link_to_subcats == 'yes' ){
				$children = get_terms( 'review-category', array( 'hide_empty' => false, 'number' => $num_subs, 'parent' => $category->term_id ) );
				if( !empty( $children ) ){
					$has_children = true;
				}
			}
			?>
			<div class="col-sm-4">
				<div class="category-item clearfix">
					<a rel="nofollow" href="<?php echo esc_url( add_query_arg( array( $reviews_slugs['review-category'] => $category->slug ), $has_children ? $permalink_cats : $permalink ) ); ?>" title="<?php echo esc_attr( $category->name ); ?>" class="leading-category clearfix">
						<i class="fa fa-<?php echo esc_attr( $value ); ?>"></i> <?php echo !empty( $value ) ? '<span class="category-lead-bg"></span>' : '' ?> <?php echo $category->name; ?>
					</a>
					<?php 
					if( $link_to_subcats == 'yes' && $has_children ){
						reviews_display_children_all_cat( 'review-category', $children, $permalink, $permalink_cats, $num_subs );
					}
					else{
						reviews_display_children( 'review-category', $category->term_id, $permalink, $num_subs );
					}
					?>
			  	</div>
			</div>
			<?php
		}
		?>
	</div>
	<?php
	$content = ob_get_contents();
	ob_end_clean();

	return $content;
}

add_shortcode( 'categories_list', 'reviews_categories_func' );

function reviews_categories_list_params(){
	return array(
		array(
			"type" => "multidropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Categories","reviews"),
			"param_name" => "categories",
			"value" => reviews_get_taxonomy_list( 'review-category', 'left' ),
			"description" => esc_html__("Select parent categories to show.","reviews")
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Number Of Subcategories","reviews"),
			"param_name" => "num_subs",
			"value" => '',
			"description" => esc_html__("Input number of subcategories to show under each category. Input 0 For all.","reviews")
		),
		array(
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => esc_html__("Link To Subcategories","reviews"),
			"param_name" => "link_to_subcats",
			"value" => array(
				esc_html__( 'No', 'reviews' ) => 'no',
				esc_html__( 'Yes', 'reviews' ) => 'yes',
			),
			"description" => esc_html__("If this is set to yes then if category has subcategories link will go there instead on filter reviews.","reviews")
		),
	);
}

function techna_map_shortcodes(){
if( function_exists( 'vc_map' ) ){
	vc_map( array(
	   "name" => esc_html__("Reviews Categories", 'reviews'),
	   "base" => "categories_list",
	   "category" => esc_html__('Content', 'reviews'),
	   "params" => reviews_categories_list_params()
	) );
}
}

add_action('init', 'techna_map_shortcodes', 20 );
?>