<?php
	/**********************************************************************
	***********************************************************************
	REVIEWS COMMENTS
	**********************************************************************/	
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ( 'Please do not load this page directly. Thanks!' );
	if ( post_password_required() ) {
		return;
	}

	/* THIS IS CHANGED IF WE ARE ON REVIEWS SINGLE AND USER HAS ALREADY REVIEWED IT */
	global $can_review, $rate_criterias;
	$can_review = true;
	if( is_singular( 'review' ) ){
		if( !is_user_logged_in() ){
			$reviews_force_login = reviews_get_option( 'reviews_force_login' );
			if( $reviews_force_login == 'yes' ){
				$can_review = false;
				$message = esc_html__( 'You must be logged in to post reviews. Login ', 'reviews' ).'<a href="'.esc_url( reviews_get_permalink_by_tpl( 'page-tpl_register_login' ) ).'">'.esc_html__( 'here', 'reviews' ).'</a>';
			}
		}
		else if( is_user_logged_in() ){
			$reviews_count = get_comments(array(
				'post_id' => get_the_ID(),
				'user_id' => get_current_user_id()
			));

			if( count( $reviews_count ) > 0 ){
				$can_review = false;
				$message = esc_html__( 'You already reviewed this product/service.', 'reviews' );
			}
			else if( $post->post_author == get_current_user_id() ){
				$can_review = false;
				$message = esc_html__( 'You are not allowed to review your own product/service review.', 'reviews' );
			}
		}
		$criterias = get_post_meta( get_the_ID(), 'reviews_score' );
		$rate_criterias = array();
		if( !empty( $criterias ) ){
			foreach( $criterias as $criteria ){
				$rate_criterias[] = $criteria['review_criteria'];
			}
		}		
	}

?>
<?php if ( comments_open() ) :?>
	<?php if( have_comments() ): ?>
		<div class="white-block">
			<div class="content-inner">			
				<!-- title -->
				<div class="widget-title-wrap">
					<h5 class="widget-title">
						<?php if( is_singular( 'review' ) ): ?>
							<?php comments_number( esc_html__( 'No User Reviews', 'reviews' ), esc_html__( '1 User Review', 'reviews' ), esc_html__( '% User Reviews', 'reviews' ) ); ?>
						<?php else: ?>
							<?php comments_number( esc_html__( 'No Comments', 'reviews' ), esc_html__( '1 Comment', 'reviews' ), esc_html__( '% Comments', 'reviews' ) ); ?>
						<?php endif; ?>
					</h5>
				</div>
				<!--.title -->
			
				<!-- comments -->
				<div class="comment-content comments">
					<?php if( have_comments() ):?>
						<?php wp_list_comments( array(
							'type' => 'comment',
							'callback' => 'reviews_comments',
							'end-callback' => 'reviews_end_comments',
							'style' => 'div'
						)); ?>
					<?php endif; ?>
				</div>
				<!-- .comments -->
		
			</div>	
		</div>
		<!-- comments pagination -->
		<?php
			$comment_links = paginate_comments_links( 
				array(
					'echo' => false,
					'prev_next' => false,
					'separator' => ' ',
				) 
			);
		?>
		<?php if( !empty( $comment_links ) ): ?>
			<div class="comments-pagination-wrap">
				<div class="pagination">
					<?php echo $comment_links; ?>
				</div>
			</div>
		<?php endif; ?>
		<!-- .comments pagination -->
	<?php endif; ?>
	<?php if( $can_review ): ?>
		<div class="white-block">
			<div class="content-inner">	
				<!-- leave comment form -->
				<!-- title -->
				<div class="widget-title-wrap">
					<h5 class="widget-title">
						<?php if( is_singular( 'review' ) ): ?>
							<?php esc_html_e( 'Leave Review', 'reviews' ); ?>
						<?php else: ?>
							<?php esc_html_e( 'Leave Comment', 'reviews' ); ?>
						<?php endif; ?>
					</h5>
				</div>
				<!--.title -->
				<?php
				$ratings = '';
				if( is_singular( 'review' ) ){
					$ratings = '<p class="comment-review">
			    		<label>'.esc_html__( 'Add Review', 'reviews' ).'</label>
			    		<input type="hidden" id="review" name="review" value=""/>
			    		<ul class="list-unstyled ordered-list">';					
					$criterias = get_post_meta( get_the_ID(), 'reviews_score' );
					if( !empty( $criterias ) ){
						foreach( $criterias as $criteria ){
							$ratings .= '<li>
								'.$criteria['review_criteria'].'
								<span class="value user-ratings">
									<i class="fa fa-star-o" title="'.esc_html__( 'Very Bad', 'reviews' ).'"></i>
									<i class="fa fa-star-o" title="'.esc_html__( 'Bad', 'reviews' ).'"></i>
									<i class="fa fa-star-o" title="'.esc_html__( 'Good', 'reviews' ).'"></i>
									<i class="fa fa-star-o" title="'.esc_html__( 'Very Good', 'reviews' ).'"></i>
									<i class="fa fa-star-o" title="'.esc_html__( 'Excellent', 'reviews' ).'"></i>
								</span>
							</li>';
						}
					}

					$ratings .= '</ul></p>';

				}
				else{
					echo '<input type="hidden" id="review" name="review" value="-1"/>';
				}
				?>
				<div id="contact_form">
					<?php
						$comments_args = array(
							'label_submit'	=>	is_singular( 'review' ) ? esc_html__( 'Send Review', 'reviews' ) : esc_html__( 'Send Comment', 'reviews' ),
							'title_reply'	=>	'',
							'fields'		=>	apply_filters( 'comment_form_default_fields', array(
													'author' => '<div class="form-group has-feedback">
																	<label for="name">'.esc_html__( 'Your Name', 'reviews' ).'</label>
																	<input type="text" class="form-control" id="name" name="author">
																</div>',
													'email'	 => '<div class="form-group has-feedback">
																	<label for="email">'.esc_html__( 'Your Email', 'reviews' ).'</label>
																	<input type="email" class="form-control" id="email" name="email">
																</div>'
												)),
							'comment_field'	=>	'<div class="form-group has-feedback">
													'.$ratings.'
													<label for="message">'.esc_html__( 'Your Comment', 'reviews' ).'</label>
													<textarea rows="10" cols="100" class="form-control" id="message" name="comment"></textarea>															
												</div>',
							'cancel_reply_link' => esc_html__( 'or cancel reply', 'reviews' ),
							'comment_notes_after' => '',
							'comment_notes_before' => ''
						);
						comment_form( $comments_args );	
					?>
				</div>
				<!-- content -->
				<!-- .leave comment form -->
			</div>
		</div>
	<?php else: ?>
		<div class="white-block">
			<div class="content-inner">	
				<?php echo  $message; ?>
			</div>
		</div>
	<?php endif; ?>

<?php endif; ?>