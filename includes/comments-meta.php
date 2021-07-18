<?php

if( !function_exists('reviews_verify_comment_meta_data') ){
function reviews_verify_comment_meta_data( $commentdata ) {
	$post_type = get_post_type( $commentdata['comment_post_ID'] );
   	if ( empty( $_POST['review'] ) && $post_type == 'review' ){
        wp_die( esc_html__( 'Error: please fill the required field (review).', 'reviews' ) );
    }
    else if( $post_type == 'review' ){
    	$reviews = explode( ',', $_POST['review'] );
    	$reviews_criteria = get_post_meta( $commentdata['comment_post_ID'], 'reviews_score' );
    	if( count( $reviews ) < count( $reviews_criteria ) ){
    		wp_die( esc_html__( 'Error: please rate all criterias.', 'reviews' ) );
    	}

    }
	return $commentdata;
}
add_filter( 'preprocess_comment', 'reviews_verify_comment_meta_data' );
}

if( !function_exists( 'reviews_filter_comment_actions' ) ){
function comment_row_actions( $actions, $comment ){
	$post_type = get_post_type( $comment->comment_post_ID );
	if( $post_type == 'review' ){
		unset( $actions['reply'] );
	}

	return $actions;
}
add_filter( 'comment_row_actions', 'comment_row_actions', 10, 2 );
}

if( !function_exists('reviews_change_review_status') ){
function reviews_change_review_status( $approved, $commentdata ){
	$post_type = get_post_type( $commentdata['comment_post_ID'] );
	if( $post_type == 'review' ){
		$reviews_must_be_approved = reviews_get_option( 'reviews_must_be_approved' );
		if( $reviews_must_be_approved == 'yes' ){
			$approved = 0;
		}
		else{
			$approved = 1;
		}
	}

	return $approved;
}
add_filter( 'pre_comment_approved' , 'reviews_change_review_status' , '99', 2 );
}

if( !function_exists('reviews_save_comment_meta_data') ){
function reviews_save_comment_meta_data( $comment_id, $comment_approved ) {
	$comment = get_comment( $comment_id ); 
	$post_type = get_post_type( $comment->comment_post_ID );
	if( $post_type == 'review' && isset( $_POST[ 'review' ] ) && $_POST[ 'review' ] !== '-1' ){
		add_comment_meta( $comment_id, 'review', $_POST['review'] );
		if( $comment_approved == 1 ){
			reviews_calculate_average_rating( $comment->comment_post_ID );
		}
	}
}
add_action( 'comment_post', 'reviews_save_comment_meta_data', 10, 2 );
}

if( !function_exists('reviews_delete_comment') ){
function reviews_delete_comment( $comment_id ) {
	delete_comment_meta( $comment_id, 'review' );
	$comment = get_comment( $comment_id );
	reviews_calculate_average_rating( $comment->comment_post_ID );
}
add_action( 'delete_comment', 'reviews_delete_comment' );
}


if( !function_exists('reviews_comment_add_meta_box') ){
function reviews_comment_add_meta_box( $comment ){
	$post_type = get_post_type( $comment->comment_post_ID );
	if( $post_type == 'review' ){
		add_meta_box( 'review-values', esc_html__( 'Review Scores', 'reviews' ), 'reviews_comment_populate_meta', 'comment', 'normal', 'high' );
	}
}
add_action( 'add_meta_boxes_comment', 'reviews_comment_add_meta_box' );
}

if( !function_exists('reviews_comment_populate_meta') ){
function reviews_comment_populate_meta( $comment ){
	$reviews_scores = get_post_meta( $comment->comment_post_ID, 'reviews_score' );
	if( !empty( $reviews_scores ) ){
		$reviews = explode( ',', get_comment_meta( $comment->comment_ID, 'review', true ) );
		$counter = 1;
		?>
		<ul class="reviews-edit">
		<?php
		foreach( $reviews_scores as $reviews_score ){
			?>
			<li>
				<div class="review-label"><?php echo $reviews_score['review_criteria']; ?></div>
				<select name="criteria[<?php echo esc_attr( $counter ) ?>]">
					<?php
					$selected = '';
					if( !empty( $reviews[$counter-1] ) ){
						$temp = explode( '|', $reviews[$counter-1] );
						$selected = $temp[1];
					}
					for( $k=1; $k<=5; $k++ ){
						echo '<option value="'.$k.'" '.( $k == $selected ? 'selected="selected"' : '' ).'>'.$k.'</option>';
					}
					?>
				</select>
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

 <?php
}
}

if( !function_exists('comment_edit_function') ){
function comment_edit_function( $comment_id ){
    if( isset( $_POST['criteria'] ) ){
    	$review = array();
    	foreach( $_POST['criteria'] as $key => $value ){
    		$review[] = $key.'|'.$value;
    	}
		update_comment_meta( $comment_id, 'review', join( ',', $review ) );
		reviews_calculate_average_rating( $_POST['review_post_id'] );
    }
}
add_action( 'edit_comment', 'comment_edit_function' );
}

if( !function_exists('reviews_on_comment_approve') ){
function reviews_on_comment_approve( $comment_ID ){
	$comment = get_comment( $comment_ID ); 
	$post_type = get_post_type( $comment->comment_post_ID );
	if( $post_type == 'review' ){
    	reviews_calculate_average_rating( $comment->comment_post_ID );
    }
}
add_action('wp_set_comment_status', 'reviews_on_comment_approve');
}
?>