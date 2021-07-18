<form role="search" method="get" class="searchform" action="<?php echo esc_url( site_url('/') ); ?>">
	<div class="reviews-form">
		<input type="text" value="" name="s" class="form-control" placeholder="<?php esc_attr_e( 'Search for...', 'reviews' ); ?>">
		<input type="hidden" name="post_type" value="post" />
		<a class="btn btn-default submit_form"><i class="fa fa-search"></i></a>
	</div>
</form>