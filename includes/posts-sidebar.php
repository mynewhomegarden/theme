<div class="col-md-3">
	<?php
	$enable_share = reviews_get_option( 'enable_share' );
	if( $enable_share == 'yes' ):
	?>
	<div class="widget white-block clearfix">
		<div class="widget-title-wrap">
			<h5 class="widget-title">
				<i class="fa fa-angle-double-right"></i><?php esc_html_e( 'Share Post', 'reviews' ) ?>
			</h5>
		</div>				
		<?php get_template_part( 'includes/share' ) ?>
	</div>
	<?php endif; ?>

	<?php get_sidebar(); ?>
</div>