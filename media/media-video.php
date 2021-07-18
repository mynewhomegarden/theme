<?php
if( !isset( $image_size ) ){
	$image_size = 'post-thumbnail';
}
?>
<div class="embed-responsive embed-responsive-16by9">
	<?php
	$post_meta = get_post_custom();
	$post_id = get_the_ID();
	$video = get_post_meta( $post_id, 'video', true );
	$video_type = get_post_meta( $post_id, 'video_type', true );
	if( !empty( $video ) ){
		if( $video_type == 'self'){
			?>
			<video controls class="embed-responsive-item">
				<source src="<?php echo esc_url( $video ); ?>" type="video/ogg">
				<?php esc_html_e( 'Your browser does not support the video tag.', 'reviews' ) ?>;
			</video>
			<?php
		}
		else{
			?>
			<iframe src="<?php echo esc_url( reviews_parse_video_url( $video ) ); ?>" class="embed-responsive-item"></iframe>
			<?php
		}
	}
	else{
		the_post_thumbnail( $image_size, array( 'class' => 'embed-responsive-item' ) );
	}
	?>
</div>