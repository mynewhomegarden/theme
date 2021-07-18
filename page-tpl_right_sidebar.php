<?php
/*
	Template Name: Right Sidebar
*/
get_header();
the_post();
?>

<section>
	<div class="container">
		<div class="row">
			<div class="col-sm-9">
				<div class="white-block">
					<?php if( has_post_thumbnail() ): ?>
						<div class="embed-responsive embed-responsive-16by9">
							<?php
							add_filter( 'wp_get_attachment_image_attributes', 'reviews_lazy_load_product_images');
							the_post_thumbnail( 'post-thumbnail', array( 'class' => 'embed-responsive-item' ) ); 
							remove_filter( 'wp_get_attachment_image_attributes', 'reviews_lazy_load_product_images');
							?>
						</div>
					<?php endif; ?>
					<div class="content-inner">
						<h3 class="post-title"><?php the_title() ?></h3>
						<hr />
						<div class="post-content">
							<?php the_content(); ?>
							<div class="clearfix"></div>
						</div>						
					</div>					
				</div>
				
				<?php comments_template( '', true ) ?>
				
			</div>
			<div class="col-sm-3">
				<?php get_sidebar( 'right' ) ?>
			</div>			
		</div>
	</div>
</section>
<?php get_footer(); ?>