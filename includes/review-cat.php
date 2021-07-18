<?php

/* Custom Meta For Taxonomies */


/* Adding New */
/* icon meta */
if( !function_exists('reviews_category_icon_add') ){
function reviews_category_icon_add() {
	echo '
	<div class="form-field">
		<label for="term_meta[category_icon]">'.esc_html__( 'Icon:', 'reviews' ).'</label>
		<div class="category-icon-prev" style="font-size: 50px;"></div>
		<select name="term_meta[category_icon]" id="category_icon"> 
			'.reviews_icons_list( '' ).'
		</select>
		<p class="description">'.esc_html__( 'Select icon for the code category','reviews' ).'</p>
	</div>
	<div class="form-field">
		<label>'.esc_html__( 'Review Criterias:', 'reviews' ).'</label>
		<input type="text" name="term_meta[review_criteria][]" class="first-criteria">
		<a href="javascript:;" class="add-criteria button">'.esc_html__( 'Add New', 'reviews' ).'</a>
		<p class="description">'.esc_html__( 'Input criterias which will review receive once this category is selected.','reviews' ).'</p>
	</div>
	';
}
add_action( 'review-category_add_form_fields', 'reviews_category_icon_add', 10, 2 );
}

/* Editing */
if( !function_exists('reviews_category_icon_edit') ){
function reviews_category_icon_edit( $term ) {
	$t_id = $term->term_id;
	$term_meta = get_option( "taxonomy_$t_id" );
	
	$value = !empty( $term_meta['category_icon'] ) ? $term_meta['category_icon'] : '';
	$criterias = !empty( $term_meta['review_criteria'] ) ? $term_meta['review_criteria'] : '';
	?>
	<table class="form-table">
		<tbody>
			<tr class="form-field">
				<th scope="row">
					<label for="term_meta[category_icon]"><?php esc_html_e( 'Icon', 'reviews' ); ?></label>
				</th>
				<td>
					<select name="term_meta[category_icon]" id="category_icon"> 
						<?php echo reviews_icons_list( $value ); ?>
					</select>
					<p class="description"><?php esc_html_e( 'Select icon for the code category', 'reviews' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">				
				<th scope="row">
					<label><?php esc_html_e( 'Review Criterias', 'reviews' ); ?></label>
				</th>
				<td>
					<input type="text" name="term_meta[review_criteria][]" class="first-criteria" value="<?php echo !empty( $criterias ) ? $criterias[0] : '' ?>">
					<?php
					if( !empty( $criterias ) ){
						for( $i=1; $i<sizeof( $criterias ); $i++ ){
							echo '<div class="criteria-wrap"><input type="text" name="term_meta[review_criteria][]" value="'.esc_attr( $criterias[$i] ).'"><a href="javascript:;" class="remove-criteria button">X</a></div>';
						}
					}
					?>
					<a href="javascript:;" class="add-criteria button"><?php esc_html_e( 'Add New', 'reviews' ); ?></a>
					<p class="description"><?php esc_html_e( 'Input criterias which will review receive once this category is selected', 'reviews' ); ?></p>
				</td>				
			</tr>
		</tbody>
	</table>
	<?php
}
add_action( 'review-category_edit_form_fields', 'reviews_category_icon_edit', 10, 2 );
}

/* Save It */
if( !function_exists('reviews_category_icon_save') ){
function reviews_category_icon_save( $term_id ) {
	if ( isset( $_POST['term_meta'] ) ) {
		$t_id = $term_id;
		$term_meta = get_option( "taxonomy_$t_id" );
		$cat_keys = array_keys( $_POST['term_meta'] );
		foreach ( $cat_keys as $key ) {
			if ( !empty ( $_POST['term_meta'][$key] ) ) {
				$term_meta[$key] = $_POST['term_meta'][$key];
			}
			else{
				$term_meta[$key] = '';
			}
		}
		update_option( "taxonomy_$t_id", $term_meta );
	}
}  
add_action( 'edited_review-category', 'reviews_category_icon_save', 10, 2 );  
add_action( 'create_review-category', 'reviews_category_icon_save', 10, 2 );
}

/* Delete meta */
if( !function_exists('reviews_category_icon_delete') ){
function reviews_category_icon_delete( $term_id ) {
	delete_option( "taxonomy_$term_id" );
}  
add_action( 'delete_review-category', 'reviews_category_icon_delete', 10, 2 );
}

/* Add icon column */
if( !function_exists('reviews_category_column') ){
function reviews_category_column( $columns ) {
    $new_columns = array(
        'cb' => '<input type="checkbox" />',
        'name' => esc_html__('Name', 'reviews'),
		'description' => esc_html__('Description', 'reviews'),
        'slug' => esc_html__( 'Slug', 'reviews' ),
        'posts' => esc_html__( 'Codes', 'reviews' ),
		'icon' => esc_html__( 'Icon', 'reviews' )
        );
    return $new_columns;
}
add_filter("manage_edit-review-category_columns", 'reviews_category_column'); 
}

if( !function_exists('reviews_populate_category_column') ){
function reviews_populate_category_column( $out, $column_name, $label_id ){
    switch ( $column_name ) {
        case 'icon': 
			$term_meta = get_option( "taxonomy_$label_id" );
			$value = !empty( $term_meta['category_icon'] ) ? $term_meta['category_icon'] : '';

            $out .= '<div style="width: 20px; height: 20px;"><i class="fa fa-'.esc_attr( $value ).'"></i></div>';
            break;
 
        default:
            break;
    }
    return $out; 
}
add_filter("manage_review-category_custom_column", 'reviews_populate_category_column', 10, 3);
}

if( !function_exists('reviews_category_criterias') ){
function reviews_category_criterias(){
	$term_meta = get_option( "taxonomy_".$_POST['term_id'] );
	$criterias = !empty( $term_meta['review_criteria'] ) ? $term_meta['review_criteria'] : array();

	echo json_encode( $criterias );
	die();
}
add_action('wp_ajax_category_criterias', 'reviews_category_criterias');
add_action('wp_ajax_nopriv_category_criterias', 'reviews_category_criterias');
}
?>