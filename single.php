<?php
/*=============================
	DEFAULT SINGLE
=============================*/
get_header();
the_post();

$post_pages = wp_link_pages( 
	array(
		'before' => '',
		'after' => '',
		'link_before'      => '<span>',
		'link_after'       => '</span>',
		'next_or_number'   => 'number',
		'nextpagelink'     => esc_html__( '&raquo;', 'reviews' ),
		'previouspagelink' => esc_html__( '&laquo;', 'reviews' ),			
		'separator'        => ' ',
		'echo'			   => 0
	) 
);
?>
<section class="single-blog">
	<input type="hidden" name="post-id" value="<?php the_ID() ?>">
	<?php
if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
	$url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
	?> <div class="single_post_hero_image" style="background-image: url('<?php echo $url ?>');">
		<h1 class="post-title size-h3"><?php the_title() ?></h1>
	</div>
	<?php 
}
?>
	<div class="post-excerpt-container">
		<h3 class="post-excerpt size-h3"><?php echo get_the_excerpt() ?></h3>
	</div>
	<div class="container">
		
		<div class="row">
			<div class="col-md-9">
				<div class="single-item">
					<div class="content-inner">

						<div class="post-content clearfix">
							<?php the_content(); ?>							
						</div>
					</div>
				</div>
				<?php if( !empty( $post_pages ) ): ?>
					<div class="pagination">
						<?php echo $post_pages; ?>
					</div>
				<?php endif; ?>
			</div>			
		</div>
	</div>
	<div class="post_author_section_container">
		<dis class="post_author_section_container_inner">
			<div class="post_author_image_container">
				<div class="post_author_image_inner">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 100 ); ?>
				</div>
			</div>
			<div class="post_author_bio_container">
				<p class="post_author_title">WRITTEN BY</p>
				<p class="post_author_name"><?php echo get_the_author() ?><p/>
				<p class="post_author_bio"><?php echo get_the_author_meta('description') ?></p>
			</div>
		</div>
	</div>
</section>

<section class="more_posts_container">
	<h3>More Posts From My New Home Garden</h3>
	<div class="end_posts">
		<?php $the_query = new WP_Query( array(
			'posts_per_page' => 6,
		)); ?>
		<?php if ( $the_query->have_posts() ) : ?>
		<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

		<div class="end_post_container">
			<a href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail('medium'); ?>
			<h6><?php the_title(); ?></h6>
			<p><?php the_excerpt(); ?></p>
			</a>
		</div>
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?>
		<?php endif; ?>
	</div>
</section>


<?php get_footer(); ?>