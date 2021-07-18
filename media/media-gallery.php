<?php
if( !isset( $image_size ) ){
	$image_size = 'post-thumbnail';
}
?>
<div class="embed-responsive embed-responsive-16by9">
	<?php
		$post_meta = get_post_custom();
		$gallery_images = get_post_meta( get_the_ID(), 'gallery_images' );
		if( !empty( $gallery_images ) ){
			?>
			<ul class="list-unstyled post-slider embed-responsive-item">
				<?php
				foreach( $gallery_images as $image_id ){
					echo '<li>'.wp_get_attachment_image( $image_id, $image_size, 0, array( 'class' => 'embed-responsive-item' ) ).'</li>';
				}
				?>
			</ul>
			<?php
		}
		else{
			the_post_thumbnail( $image_size, array( 'class' => 'embed-responsive-item' ) );
		}
	?>
</div>