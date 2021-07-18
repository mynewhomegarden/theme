<?php
/*  */
if( !function_exists('reviews_edit_panel') ){
function reviews_edit_panel(){
	if (!current_user_can('moderate_comments') ) {
		add_menu_page( esc_html__( 'Reviews', 'reviews' ), esc_html__( 'Reviews', 'reviews' ), 'read', 'reviews', 'reviews_edit_panel_callback' );
	}
}
add_action( 'admin_menu', 'reviews_edit_panel' );
}

if( !function_exists('reviews_listing_reviews') ){
function reviews_listing_reviews(){
$per_page = 20;
$page = !empty( $_GET['paged'] ) ? $_GET['paged'] : 1;

$args = array(
	'user_id' 	=> get_current_user_id(),
	'number' 	=> $per_page,
   	'paged'		=> $page,
	'meta_query' => array(
		'relation' => 'AND',
		array(
			'key' 		=> 'review',
			'compare' 	=> 'EXISTS'
		),
	)
);

if( !empty( $_GET['s'] ) ){
	$args['search'] = $_GET['s'];
}

$comments_query = new WP_Comment_Query;
$comments = $comments_query->query( $args );
$max_num = $comments_query->query( array( 'count' => 1 ) );
$max_pages = ceil( $max_num / $per_page );

$pagination = paginate_links( 
	array(
		'base'        	=> '%_%',
		'format'      	=> '?paged=%#%',
		'prev_next' 	=> true,
		'end_size' 		=> 2,
		'mid_size' 		=> 2,
		'total' 		=> $max_pages,
		'current' 		=> $page,	
		'prev_next' 	=> false
	)
);

?>
<div class="wrap">
	<h1 class="wp-heading-inline"><?php esc_html_e( 'Your reviews', 'reviews' ) ?></h1>

	<form id="comments-form" method="get">

		<div class="tablenav top">
			<div class="alignleft actions bulkactions">
				<label for="bulk-action-selector-top" class="screen-reader-text"><?php esc_html_e( 'Select bulk action', 'reviews' ) ?></label>
				<select name="action" id="bulk-action-selector-top">
					<option value="-1"><?php esc_html_e( 'Bulk Actions', 'reviews' ) ?></option>
					<option value="delete"><?php esc_html_e( 'Delete', 'reviews' ) ?></option>
				</select>
				<input class="button action" value="<?php esc_attr_e( 'Apply', 'reviews' ) ?>" type="submit">
			</div>

			<p class="search-box">
				<label class="screen-reader-text" for="comment-search-input"><?php esc_html_e( 'Search Reviews:', 'reviews' ) ?></label>
				<input name="s" value="" type="search">
				<input class="button" value="Search Comments" type="submit">
				<input type="hidden" value="reviews" name="page">
			</p>

			<br class="clear">
		</div>

		<table class="wp-list-table widefat fixed striped comments">
			<thead>
				<tr>
					<td id="cb" class="manage-column column-cb check-column">
						<label class="screen-reader-text" for="cb-select-all-1"><?php esc_html_e( 'Select All', 'reviews' ) ?></label>
						<input id="cb-select-all-1" type="checkbox">
					</td>
					<th class="manage-column column-response"><?php esc_html_e( 'Status', 'reviews' ) ?></th>
					<th class="manage-column column-comment"><?php esc_html_e( 'Review', 'reviews' ) ?></th>
					<th class="manage-column column-response"><?php esc_html_e( 'Review Of', 'reviews' ) ?></th>
					<th class="manage-column column-date"><?php esc_html_e( 'Submitted On', 'reviews' ) ?></th>
				</tr>
			</thead>
			<tbody>
				<?php

				if ( $comments ) {
					foreach ( $comments as $comment ) {
						?>
						<tr id="comment-<?php echo esc_attr( $comment->comment_ID ) ?>">
							<th scope="row" class="check-column">
								<label class="screen-reader-text" for="cb-select-<?php echo esc_attr( $comment->comment_ID ) ?>"><?php esc_html_e( 'Select comment', 'reviews' ) ?></label>
								<input id="cb-select-<?php echo esc_attr( $comment->comment_ID ) ?>" name="delete_reviews[]" value="<?php echo esc_attr( $comment->comment_ID ) ?>" type="checkbox">
							</th>
							<td>
								<?php echo $comment->comment_approved == 1 ? esc_html__('Approved', 'reviews') : esc_html__( 'Pending', 'reviews' ) ?>
							</td>
							<td>
								<p><?php echo $comment->comment_content ?></p>
								<div class="row-actions">
									<a href="<?php echo esc_url( add_query_arg( array( 'action' => 'edit', 'review_id' => $comment->comment_ID ) ) ) ?>"><?php esc_html_e( 'Edit', 'reviews' ) ?></a> | 
									<a href="<?php echo esc_url( add_query_arg( array( 'action' => 'delete', 'review_id' => $comment->comment_ID ) ) ) ?>"><?php esc_html_e( 'Delete', 'reviews' ) ?></a>
								</div>
							</td>
							<td>
								<div class="response-links">
									<a href="<?php echo get_the_permalink( $comment->comment_post_ID ) ?>" class="comments-edit-item-link" target="_blank"><?php echo get_the_title( $comment->comment_post_ID ) ?></a>
								</div>
							</td>
							<td>
								<div class="submitted-on">
									<?php echo sprintf( '%1$s at %2$s', get_comment_date( 'Y/m/d', $comment ), get_comment_date( 'g:i a', $comment ) ); ?>
								</div>
							</td>
						</tr>
						<?php
					}
				}
				else{
					?>
					<td colspan="4"><?php esc_html_e( 'No reviews found', 'reviews' ) ?></td>
					<?php
				}	
				?>
			</tbody>
		</table>
		<div class="reviews-pagination">
			<?php echo $pagination; ?>
		</div>		
	</form>
</div>
<?php

}
}

if( !function_exists('reviews_edit_panel_callback') ){
function reviews_edit_panel_callback(){
/* if deletition is required */
if( !empty( $_GET['action'] ) && $_GET['action'] == 'delete' ){
	if( !empty( $_GET['review_id'] ) ){
		$delete_reviews = array( $_GET['review_id'] );
	}
	else{
		$delete_reviews = $_GET['delete_reviews'];
	}
	foreach( $delete_reviews as $review_id ){
		$comment = get_comment( $review_id );
		if( $comment->user_id == get_current_user_id() ){
			wp_delete_comment( $review_id );
		}
	}
}
/* if we are on edit screen */
if( !empty( $_GET['action'] ) && $_GET['action'] == 'edit' ){
	$review_id = $_GET['review_id'];
	$comment = get_comment( $review_id );
	if( $comment->user_id == get_current_user_id() ):
		if( !empty( $_POST['review_id'] ) ){
			$allow_empty = reviews_get_option( 'allow_empty_review' );
			if( ( !empty( $_POST['comment_content'] ) || $allow_empty == 'yes' ) && $_POST['review_id'] == $review_id )	{
				wp_update_comment(array(
					'comment_ID' 		=> $review_id,
					'comment_content'	=> $_POST['comment_content']
				));
				$comment->comment_content = $_POST['comment_content'];
				echo '<div class="updated"><p>' . esc_html__( 'Review updated', 'reviews' ) . '</p></div>';
			}
			else if( empty( $_POST['comment_content'] ) ){
				echo '<div class="error"><p>' . esc_html__( 'Empty review content', 'reviews' ) . '</p></div>';
			}
		}		
		?>
		<div class="wrap">
			<h1 class="wp-heading-inline"><?php esc_html_e( 'Edit Review', 'reviews' ) ?></h1>
			<br /><br />
			<form id="commentform" method="post">
				<div class="flex-wrap">
					<div class="flex-left">
						<textarea name="comment_content" class="widefat"><?php echo $comment->comment_content; ?></textarea>
						<br/><br/>
						<input name="save" class="button button-primary button-large" id="publish" value="<?php esc_attr_e( 'Update', 'reviews' ) ?>" type="submit">
					</div>
					<div class="flex-right">
						<?php
						$reviews_scores = get_post_meta( $comment->comment_post_ID, 'reviews_score' );
						if( !empty( $reviews_scores ) ){
							$reviews = explode( ',', get_comment_meta( $comment->comment_ID, 'review', true ) );
							$counter = 1;
							?>
							<ul class="ordered-list">
							<?php
							foreach( $reviews_scores as $reviews_score ){
								$temp = explode( '|', $reviews[$counter-1] );
								$grade = $temp[1];
								?>
								<li>
									<input type="hidden" name="criteria[<?php echo esc_attr( $counter ) ?>]" value="<?php echo esc_attr( $grade ) ?>"/>
									<div class="review-label"><?php echo $reviews_score['review_criteria']; ?></div>
									<span class="value user-ratings">
										<?php
										for( $k=1; $k<=5; $k++ ){
											echo '<i class="fa fa-star'.( $k > $grade ? esc_attr( '-o' ) : esc_attr( ' clicked' ) ).'"></i>';
										}
										?>
									</span>
								</li>
								<?php
								$counter++;
							}
							?>
							</ul>
							<input type="hidden" value="<?php echo esc_attr( $comment->comment_post_ID ) ?>" name="review_post_id">
							<?php
						}				
						?>
					</div>
					<input type="hidden" value="<?php echo esc_attr( $review_id ) ?>" name="review_id">
					<input type="hidden" value="reviews" name="page">
				</div>
			</form>
		</div>
		<?php
	endif;
}
else{
	reviews_listing_reviews();
}
}
}
?>