<?php
/*=============================
	DEFAULT BLOG LISTING PAGE
=============================*/
get_header();
global $wp_query;

$cur_page = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; //get curent page
$page_links_total =  $wp_query->max_num_pages;
$pagination = paginate_links( 
	array(
		'base' => esc_url( add_query_arg( 'paged', '%#%' ) ),
		'prev_next' => true,
		'end_size' => 2,
		'mid_size' => 2,
		'total' => $page_links_total,
		'current' => $cur_page,	
		'prev_next' => false
	)
);	
?>
<section>
	<div class="container">
		<div class="row">
			<div class="col-md-9">
			<?php
				if( have_posts() ){
					$counter = 0;
					while( have_posts() ){
						the_post(); 
						include( reviews_load_path( 'includes/blog-list.php' ) );
					}
				}
				else{
					?>
					<!-- 404 -->
					<div class="widget white-block">
						<div class="widget-title-wrap">
							<h5 class="widget-title">
								<?php esc_html_e( 'Nothing Found', 'reviews' ) ?>
							</h5>
						</div>							
						<p><?php esc_html_e( 'Sorry but we could not find anything which resembles you search criteria. Try again.', 'reviews' ) ?></p>
						<?php get_search_form(); ?>
					</div>
					<!--.404 -->
					<?php
				}
				?>
				<?php
					if( !empty( $pagination ) ): ?>
						<div class="pagination">
							<?php echo  $pagination; ?>
						</div>	
					<?php
					endif;
				?>				
			</div>	
			<div class="col-md-3">
				<?php get_sidebar(); ?>
			</div>
		</div>		
	</div>
</section>

<?php wp_reset_postdata(); ?>
<?php get_footer(); ?>