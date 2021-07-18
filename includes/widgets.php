<?php

class Reviews_Widget_Posts extends WP_Widget {

	function __construct() {
		parent::__construct('custom_posts', __('Reviews Recent Posts','reviews'), array('description' =>__('Display recent posts','reviews') ));
	}

	function widget($args, $instance) {
		extract($args);
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '' ) );
		
		$title = esc_attr( $instance['title'] );
		$text = esc_attr( $instance['text'] );		

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Posts', 'reviews' );
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;

		if ( ! $number ){
			$number = 5;
		}
		
		?>
		<?php echo  $before_widget; ?>
		<?php 
		if ( $title ){
			echo  $before_title . $title . $after_title; 
		}
		?>
		
		<?php
		$r = new WP_Query( apply_filters( 'widget_posts_args', array(
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		) ) );

		if ($r->have_posts()):
		?>
			<ul class="list-unstyled">
			<?php 
			while ( $r->have_posts() ) : 
				$r->the_post();
				include( reviews_load_path( 'includes/widget-loop.php' ) );
			endwhile; ?>
			</ul>
		<?php
		endif;
		?>
		
		<?php echo  $after_widget; wp_reset_postdata(); ?>
<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = (int) $new_instance['number'];

		return $instance;
	}

	function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
?>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'reviews' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Number of posts to show:', 'reviews' ); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" size="3" /></p>
<?php
	}
}


class Reviews_Widget_Recent_Comments extends WP_Widget {

	function __construct() {
		parent::__construct('reviews_recent_comments', __('Reviews Recent Comments','reviews'), array('description' =>__('Display recent comments','reviews') ));
	}

	function widget( $args, $instance ) {
		global $comments, $comment;
		extract( $args );
		$output = '';
		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Comments', 'reviews' );
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number )
			$number = 5;
		$comments = get_comments( apply_filters( 'widget_comments_args', array(
			'number'      => $number,
			'status'      => 'approve',
			'post_status' => 'publish'
		) ) );

		$output .= $before_widget;
		if ( $title )
			$output .= $before_title . $title . $after_title;

		$output .= '<ul class="list-unstyled no-top-padding">';
		if ( $comments ) {

			foreach ( (array) $comments as $comment) {
				$comment_text = get_comment_text( $comment->comment_ID );
				if( strlen( $comment_text ) > 40 ){
					$comment_text = substr( $comment_text, 0, 40 );
					$comment_text = substr( $comment_text, 0, strripos( $comment_text, " "  ) );
					$comment_text .= "...";
				}
				
				$output .=  '<li>
								<div class="widget-image-thumb">
									'.get_avatar( $comment, 60 ).'
								</div>
								
								<div class="widget-text">
									'.get_comment_author_link().'
									<a href="' . esc_url( get_comment_link($comment->comment_ID) ) . '" class="grey">' .$comment_text. '</a>
								</div>
								<div class="clearfix"></div>
							</li>';
			}
		}
		$output .= '</ul>';
		$output .= $after_widget;

		echo  $output;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['number'] = absint( $new_instance['number'] );
		return $instance;
	}

	function form( $instance ) {
		$title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
?>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:', 'reviews' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

		<p><label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Number of comments to show:', 'reviews' ); ?></label>
		<input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" size="3" /></p>
<?php
	}
}
class Reviews_Top_Authors extends WP_Widget{
	function __construct() {
		parent::__construct('widget_top_author', __('Reviews Top Author','reviews'), array('description' =>__('Adds list of top authors.','reviews') ));
	}

	function widget($args, $instance) {
		global $wpdb;
		/** This filter is documented in wp-includes/default-widgets.php */
		$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$instance['count'] = apply_filters( 'widget_title', empty( $instance['count'] ) ? '5' : $instance['count'], $instance, $this->id_base );

		echo  $args['before_widget'];
		
		$authors = $wpdb->get_results( 
			$wpdb->prepare( 
				"SELECT users.ID, COUNT( posts.ID ) AS post_count FROM {$wpdb->users} AS users RIGHT JOIN {$wpdb->posts} AS posts ON posts.post_author = users.ID WHERE posts.post_type='review' AND posts.post_status='publish' GROUP BY users.ID ORDER BY post_count DESC LIMIT %d",
				$instance['count']
			)
		);
		
		if ( !empty($instance['title']) ){
			echo  $args['before_title'] . $instance['title'] . $args['after_title'];
		}
		if( !empty( $authors ) ){
			echo '<ul class="list-unstyled no-top-padding">';
			foreach( $authors as $author ){
				echo    '<li class="top-authors">
							<div class="widget-image-thumb">
								'.get_avatar( $author->ID, 50 ).'
							</div>
							
							<div class="widget-text">
								<a href="'.esc_url( get_author_posts_url( $author->ID ) ).'">
									'.get_the_author_meta( 'display_name', $author->ID ).'
								</a>
								<p class="grey">'.__( 'Wrote ', 'reviews' ).' '.$author->post_count.' '.__( 'reviews', 'reviews' ).'</p>
							</div>
							<div class="clearfix"></div>
						</li>';				
			}
			echo '</ul>';
		}
		echo  $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
		$instance['count'] = strip_tags( stripslashes($new_instance['count']) );
		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$count = isset( $instance['count'] ) ? $instance['count'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php _e('Title:', 'reviews') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('count') ); ?>"><?php _e('Count:', 'reviews') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('count') ); ?>" name="<?php echo esc_attr( $this->get_field_name('count') ); ?>" value="<?php echo esc_attr( $count ); ?>" />
		</p>		
		<?php
	}
}

class Reviews_Social extends WP_Widget{
	function __construct() {
		parent::__construct('widget_social', __('Reviews Social Follow','reviews'), array('description' =>__('Adds list of the social icons.','reviews') ));
	}

	function widget($args, $instance) {
		/** This filter is documented in wp-includes/default-widgets.php */
		$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$facebook = !empty( $instance['facebook'] ) ? '<a href="'.esc_url( $instance['facebook'] ).'" target="_blank" class="btn"><span class="fa fa-facebook"></span></a>' : '';
		$twitter = !empty( $instance['twitter'] ) ? '<a href="'.esc_url( $instance['twitter'] ).'" target="_blank" class="btn"><span class="fa fa-twitter"></span></a>' : '';
		$google = !empty( $instance['google'] ) ? '<a href="'.esc_url( $instance['google'] ).'" target="_blank" class="btn"><span class="fa fa-google"></span></a>' : '';
		$linkedin = !empty( $instance['linkedin'] ) ? '<a href="'.esc_url( $instance['linkedin'] ).'" target="_blank" class="btn"><span class="fa fa-linkedin"></span></a>' : '';
		$pinterest = !empty( $instance['pinterest'] ) ? '<a href="'.esc_url( $instance['pinterest'] ).'" target="_blank" class="btn"><span class="fa fa-pinterest"></span></a>' : '';
		$youtube = !empty( $instance['youtube'] ) ? '<a href="'.esc_url( $instance['youtube'] ).'" target="_blank" class="btn"><span class="fa fa-youtube"></span></a>' : '';
		$flickr = !empty( $instance['flickr'] ) ? '<a href="'.esc_url( $instance['flickr'] ).'" target="_blank" class="btn"><span class="fa fa-flickr"></span></a>' : '';
		$behance = !empty( $instance['behance'] ) ? '<a href="'.esc_url( $instance['behance'] ).'" target="_blank" class="btn"><span class="fa fa-behance"></span></a>' : '';

		echo  $args['before_widget'];
		
		if ( !empty($instance['title']) ){
			echo  $args['before_title'] . $instance['title'] . $args['after_title'];
		}
		echo '<div class="widget-social">';
			echo  $facebook.$twitter.$google.$linkedin.$pinterest.$youtube.$flickr.$behance;
		echo '</div>';
		echo  $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
		$instance['facebook'] = strip_tags( stripslashes($new_instance['facebook']) );
		$instance['twitter'] = strip_tags( stripslashes($new_instance['twitter']) );
		$instance['google'] = strip_tags( stripslashes($new_instance['google']) );
		$instance['linkedin'] = strip_tags( stripslashes($new_instance['linkedin']) );
		$instance['pinterest'] = strip_tags( stripslashes($new_instance['pinterest']) );
		$instance['youtube'] = strip_tags( stripslashes($new_instance['youtube']) );
		$instance['flickr'] = strip_tags( stripslashes($new_instance['flickr']) );
		$instance['behance'] = strip_tags( stripslashes($new_instance['behance']) );
		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$facebook = isset( $instance['facebook'] ) ? $instance['facebook'] : '';
		$twitter = isset( $instance['twitter'] ) ? $instance['twitter'] : '';
		$google = isset( $instance['google'] ) ? $instance['google'] : '';
		$linkedin = isset( $instance['linkedin'] ) ? $instance['linkedin'] : '';
		$pinterest = isset( $instance['pinterest'] ) ? $instance['pinterest'] : '';
		$youtube = isset( $instance['youtube'] ) ? $instance['youtube'] : '';
		$flickr = isset( $instance['flickr'] ) ? $instance['flickr'] : '';
		$behance = isset( $instance['behance'] ) ? $instance['behance'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php _e('Title:', 'reviews') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('facebook') ); ?>"><?php _e('Facebook:', 'reviews') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('facebook') ); ?>" name="<?php echo esc_attr( $this->get_field_name('facebook') ); ?>" value="<?php echo esc_url( $facebook ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('twitter') ); ?>"><?php _e('Twitter:', 'reviews') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('twitter') ); ?>" name="<?php echo esc_attr( $this->get_field_name('twitter') ); ?>" value="<?php echo esc_url( $twitter ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('google') ); ?>"><?php _e('Google +:', 'reviews') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('google') ); ?>" name="<?php echo esc_attr( $this->get_field_name('google') ); ?>" value="<?php echo esc_url( $google ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('linkedin') ); ?>"><?php _e('Linkedin:', 'reviews') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('linkedin') ); ?>" name="<?php echo esc_attr( $this->get_field_name('linkedin') ); ?>" value="<?php echo esc_url( $linkedin ); ?>" />
		</p>			
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('youtube') ); ?>"><?php _e('YouTube:', 'reviews') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('youtube') ); ?>" name="<?php echo esc_attr( $this->get_field_name('youtube') ); ?>" value="<?php echo esc_url( $youtube ); ?>" />
		</p>		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('pinterest') ); ?>"><?php _e('Pinterest:', 'reviews') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('pinterest') ); ?>" name="<?php echo esc_attr( $this->get_field_name('pinterest') ); ?>" value="<?php echo esc_attr( $pinterest ); ?>" />
		</p>		
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('flickr') ); ?>"><?php _e('Flickr:', 'reviews') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('flickr') ); ?>" name="<?php echo esc_attr( $this->get_field_name('flickr') ); ?>" value="<?php echo esc_attr( $flickr ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('behance') ); ?>"><?php _e('Behance:', 'reviews') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('behance') ); ?>" name="<?php echo esc_attr( $this->get_field_name('behance') ); ?>" value="<?php echo esc_attr( $behance ); ?>" />
		</p>			
		<?php
	}
}

class Reviews_Subscribe extends WP_Widget{
	function __construct() {
		parent::__construct('widget_subscribe', __('Reviews Subscribe','reviews'), array('description' =>__('Adds subscribe form in the sidebar.','reviews') ));
	}

	function widget($args, $instance) {
		/** This filter is documented in wp-includes/default-widgets.php */
		$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

		echo  $args['before_widget'];
		
		if ( !empty($instance['title']) ){
			echo  $args['before_title'] . $instance['title'] . $args['after_title'];
		}
		echo '<div class="subscribe-form">
				<div class="reviews-form">
					<input type="text" class="form-control email" placeholder="'.esc_attr__( 'Input email here...', 'reviews' ).'">
					<a href="javascript:;" class="btn btn-default subscribe"><i class="fa fa-rss"></i></a>
				</div>
				<div class="sub_result"></div>
			  </div>';
		echo  $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php _e('Title:', 'reviews') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr( $title ); ?>" />
		</p>	
		<?php
	}
}

class Reviews extends WP_Widget{
	function __construct() {
		parent::__construct('widget_reviews', __('Reviews','reviews'), array('description' =>__('Add reviews to the widget.','reviews') ));
	}

	function widget($args, $instance) {
		/** This filter is documented in wp-includes/default-widgets.php */
		$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$instance['number'] = empty( $instance['number'] ) ? 5 : $instance['number'];
		$instance['orderby'] = $instance['orderby'];

		$reviews_args = array(
			'post_type' => 'review',
			'post_status' => 'publish',
			'posts_per_page' => $instance['number'],
			'order' => 'DESC',
		);

		if( !empty( $instance['orderby'] ) ){
			if( $instance['orderby'] == 'title' ){
				$reviews_args['orderby'] = 'title';
				$reviews_args['order'] = 'ASC';
			}
			else if ( $instance['orderby'] == 'user_average' ){
				$reviews_args['orderby'] = array(
					'user_average'			=> 'DESC',
					'user_ratings_count'	=> 'DESC'
				);
				$reviews_args['meta_query'] = array(
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
				$reviews_args['orderby'] = 'meta_value_num';
				$reviews_args['meta_key'] = $instance['orderby'];
			}
		}

		if( !empty( $instance['categories'] ) ){
			$reviews_args['tax_query'] = array(
				array(
					'taxonomy' => 'review-category',
					'terms'    => $instance['categories'],
				)
			);
		}

		echo  $args['before_widget'];
		
		if ( !empty($instance['title']) ){
			echo  $args['before_title'] . $instance['title'] . $args['after_title'];
		}
		$reviews = new WP_Query( $reviews_args );
		if( $reviews->have_posts() ){
			echo '<ul class="list-unstyled no-top-padding">';
			while( $reviews->have_posts() ){
				$reviews->the_post();
				add_filter( 'wp_get_attachment_image_attributes', 'reviews_lazy_load_product_images');
				$image = wp_get_attachment_image( get_post_thumbnail_id( get_the_ID() ), 'reviews-widget-thumb', false, array( 'class' => 'img-responsive' ) );
				remove_filter( 'wp_get_attachment_image_attributes', 'reviews_lazy_load_product_images');
				switch( $instance['orderby'] ){
					case '': 
						$subtitle = '<i class="fa fa-calendar-o"></i>'.get_the_time( get_option( 'date_format' ) ); 
						break;
					case 'author_average': 
						$author_average = get_post_meta( get_the_ID(), 'author_average', true );
						ob_start();
						reviews_rating_display( $author_average );
						$subtitle = '<span class="author-ratings">'.ob_get_contents().'</span>';
						ob_end_clean();
						break;
					case 'user_average': 
						$user_average = get_post_meta( get_the_ID(), 'user_average', true );
						ob_start();
						reviews_rating_display( $user_average );
						$subtitle = '<span class="user-ratings">'.ob_get_contents().'</span>';
						ob_end_clean();
						break;
					case 'user_ratings_count':
						$user_ratings_count = get_post_meta( get_the_ID(), 'user_ratings_count', true );
						$subtitle = '<i class="fa fa-users"></i>'.$user_ratings_count;
						break;
					case 'title': 
						$subtitle = '<i class="fa fa-calendar-o"></i>'.get_the_time( get_option( 'date_format' ) );
						break;
					case 'review_clicks': 
						$subtitle = '<i class="fa fa-calendar-o"></i>'.get_the_time( get_option( 'date_format' ) );
						break;						
				}
				if( !empty( $image ) ){
					$image = '<div class="widget-image-thumb"><a href="'.get_permalink().'">'.$image.'</a></div>';
				}
				echo    '<li class="top-authors">
							'.$image.'							
							<div class="widget-text">
								<a href="'.get_permalink().'">
									'.get_the_title().'
								</a>
								<p class="grey">'.$subtitle.'</p>
							</div>
							<div class="clearfix"></div>
						</li>';				
			}
			echo '</ul>';
		}
		wp_reset_postdata();
		echo  $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
		$instance['number'] = $new_instance['number'];
		$instance['orderby'] = $new_instance['orderby'];
		$instance['categories'] = $new_instance['categories'];
		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$number = isset( $instance['number'] ) ? $instance['number'] : '';
		$orderby = isset( $instance['orderby'] ) ? $instance['orderby'] : '';
		$categories = isset( $instance['categories'] ) ? $instance['categories'] : array();
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php _e('Title:', 'reviews') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('number') ); ?>"><?php _e('Number:', 'reviews') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('number') ); ?>" name="<?php echo esc_attr( $this->get_field_name('number') ); ?>" value="<?php echo esc_attr( $number ); ?>" />
		</p>		
		<p>
			<label for="source"><?php _e('Order By:', 'reviews') ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id('orderby') ); ?>" name="<?php echo esc_attr( $this->get_field_name('orderby') ); ?>" class="widefat">
				<option value="" <?php echo empty( $orderby ) ? esc_attr( 'selected="selected"' ) : '' ?>><?php _e( 'Latest', 'reviews' ) ?></option>
				<option value="author_average" <?php echo $orderby == 'author_average' ? esc_attr( 'selected="selected"' ) : '' ?>><?php _e( 'Author Ratings', 'reviews' ) ?></option>
				<option value="user_average" <?php echo $orderby == 'user_average' ? esc_attr( 'selected="selected"' ) : '' ?>><?php _e( 'Users Ratings', 'reviews' ) ?></option>
				<option value="user_ratings_count" <?php echo $orderby == 'user_ratings_count' ? esc_attr( 'selected="selected"' ) : '' ?>><?php _e( 'Most User Rated', 'reviews' ) ?></option>
				<option value="title" <?php echo $orderby == 'title' ? esc_attr( 'selected="selected"' ) : '' ?>><?php _e( 'Title', 'reviews' ) ?></option>
				<option value="review_clicks" <?php echo $orderby == 'review_clicks' ? esc_attr( 'selected="selected"' ) : '' ?>><?php _e( 'Visits', 'reviews' ) ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('categories') ); ?>"><?php _e('Filter BY Categories:', 'reviews') ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id('categories') ); ?>" name="<?php echo esc_attr( $this->get_field_name('categories') ); ?>[]" multiple>
				<?php
				$reviews_categories = get_terms( 'review-category' );
				if( !empty( $reviews_categories ) ){
					foreach( $reviews_categories as $reviews_category ){
						echo '<option value="'.esc_attr( $reviews_category->term_id ).'" '.( in_array( $reviews_category->term_id, $categories ) ? 'selected="selected"' : '' ).'>'.$reviews_category->name.'</option>';
					}
				}
				?>
			</select>
		</p>
		<?php
	}
}


class Reviews_Categories extends WP_Widget{
	function __construct() {
		parent::__construct('widget_reviews_categories', __('Reviews Categories','reviews'), array('description' =>__('Display Reviews Categories.','reviews') ));
	}

	function widget($args, $instance) {
		/** This filter is documented in wp-includes/default-widgets.php */
		$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$instance['categories'] = empty( $instance['categories'] ) ? array() : (array)$instance['categories'];

		echo  $args['before_widget'];
		$permalink = reviews_get_permalink_by_tpl( 'page-tpl_search' );
		
		if ( !empty($instance['title']) ){
			echo  $args['before_title'] . $instance['title'] . $args['after_title'];
		}
		if( !empty( $instance['categories'] ) ){
			echo '<ul class="list-unstyled category-list">';
			foreach( $instance['categories'] as $category_id ){
				$term_meta = get_option( "taxonomy_$category_id" );
				$value = !empty( $term_meta['category_icon'] ) ? $term_meta['category_icon'] : '';		
				$term = get_term_by( 'id', $category_id, 'review-category' );
				if( $term ){
					echo '<li>
							<span class="icon '.esc_attr( $value ).'"></span>
							<a rel="nofollow" href="'.( esc_url( add_query_arg( array( 'review-category' => $term->slug ), $permalink ) ) ).'">
								'.$term->name.'
								<span class="badge pull-right">
									'.$term->count.'
								</span>
							</a>
						  </li>';				
				}
			}
			echo '</ul>';
		}
		wp_reset_postdata();
		echo  $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
		$instance['categories'] = $new_instance['categories'];
		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$categories = isset( $instance['categories'] ) ? (array)$instance['categories'] : array();
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php _e('Title:', 'reviews') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('categories') ); ?>"><?php _e('Categories:', 'reviews') ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id('categories') ); ?>" name="<?php echo esc_attr( $this->get_field_name('categories') ); ?>[]" multiple>
				<?php
				$reviews_categories = get_terms( 'review-category' );
				if( !empty( $reviews_categories ) ){
					foreach( $reviews_categories as $reviews_category ){
						echo '<option value="'.esc_attr( $reviews_category->term_id ).'" '.( in_array( $reviews_category->term_id, $categories ) ? 'selected="selected"' : '' ).'>'.$reviews_category->name.'</option>';
					}
				}
				?>
			</select>
		</p>
		<?php
	}
}

class Reviews_Banner extends WP_Widget{
	function __construct() {
		parent::__construct('widget_reviews_banner', __('Reviews Banner','reviews'), array('description' =>__('Display Reviews Banners.','reviews') ));
	}

	function widget($args, $instance) {
		/** This filter is documented in wp-includes/default-widgets.php */
		$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$instance['link'] = empty( $instance['link'] ) ? '' : $instance['link'];
		$instance['image'] = empty( $instance['image'] ) ? '' : $instance['image'];

		echo  $args['before_widget'];
		
		if ( !empty($instance['title']) ){
			echo  $args['before_title'] . $instance['title'] . $args['after_title'];
		}
		add_filter( 'wp_get_attachment_image_attributes', 'reviews_lazy_load_product_images');
		echo '<a href="'.esc_attr( $instance['link'] ).'" target="_blank">'.wp_get_attachment_image( $instance['image'], 'full' ).'</a>';
		add_filter( 'wp_get_attachment_image_attributes', 'reviews_lazy_load_product_images');
		echo  $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( stripslashes($new_instance['title']) );
		$instance['image'] = $new_instance['image'];
		$instance['link'] = $new_instance['link'];
		return $instance;
	}

	function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$link = empty( $instance['link'] ) ? '' : $instance['link'];
		$image = empty( $instance['image'] ) ? '' : $instance['image'];
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php _e('Title:', 'reviews') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('link') ); ?>"><?php _e('Links:', 'reviews') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('link') ); ?>" name="<?php echo esc_attr( $this->get_field_name('link') ); ?>" value="<?php echo esc_attr( $link ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('image') ); ?>"><?php _e('Image ID:', 'reviews') ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id('image') ); ?>" name="<?php echo esc_attr( $this->get_field_name('image') ); ?>" value="<?php echo esc_attr( $image ); ?>" />
		</p>
		<?php
	}
}

function custom_widgets_init() {
	if ( !is_blog_installed() ){
		return;
	}	
	/* register new ones */
	register_widget('Reviews_Widget_Posts');
	register_widget('Reviews_Widget_Recent_Comments');
	register_widget('Reviews_Top_Authors');
	register_widget('Reviews_Social');
	register_widget('Reviews_Subscribe');
	register_widget('Reviews');
	register_widget('Reviews_Categories');
	register_widget('Reviews_Banner');
}

add_action('widgets_init', 'custom_widgets_init', 1);
?>