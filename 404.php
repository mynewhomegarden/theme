<?php
get_header();
?>
<section>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="white-block content-inner text-center">
					<h1 class="big-title"><?php esc_html_e( '404', 'reviews' ) ?></h1>
					<h2 class="post-title"><?php esc_html_e( 'Page not found', 'reviews' ) ?></h2>
					<div class="post-content">
						<p><?php esc_html_e( 'Page you are looking for is no longer available. Use search form bellow to find what you are looking for', 'reviews' ) ?></p>
						<?php get_search_form(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
get_footer();
?>