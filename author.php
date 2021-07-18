<?php
get_header();
$is_reviews = !empty( $_GET['post_type'] ) ? true : false;
?>
<section>
	<div class="container">
		<div class="row <?php echo $is_reviews ? esc_attr( 'masonry' ) : '' ?>">
			<?php
			if( !$is_reviews ){
				echo '<div class="col-sm-9">';
			}
			if( have_posts() ){
				while( have_posts() ){
					the_post();
					if( $is_reviews ){
						echo '<div class="col-sm-4 masonry-item">';
							include( reviews_load_path( 'includes/review-box.php' ) );
						echo '</div>';
					}
					else{
						include( reviews_load_path( 'includes/blog-list.php' ) );
					}
				}
			}
			if( !$is_reviews ){
				echo '</div>';
				echo '<div class="col-sm-3">';
					get_sidebar();
				echo '</div>';
			}
			?>
		</div>
	</div>
</section>
<?php
get_footer();
?>