<?php
if ( is_active_sidebar( 'bottom-1' ) || is_active_sidebar( 'bottom-2' ) || is_active_sidebar( 'bottom-3' ) || is_active_sidebar( 'bottom-4' ) ){
	?>
	<section class="footer_widget_section">
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<?php
					if( is_active_sidebar( 'bottom-1' ) ){
						dynamic_sidebar( 'bottom-1' );
					}
					?>
				</div>
				<div class="col-md-3">
					<?php
					if( is_active_sidebar( 'bottom-2' ) ){
						dynamic_sidebar( 'bottom-2' );
					}
					?>
				</div>
				<div class="col-md-3">
					<?php
					if( is_active_sidebar( 'bottom-3' ) ){
						dynamic_sidebar( 'bottom-3' );
					}
					?>
				</div>
				<div class="col-md-3">
					<?php
					if( is_active_sidebar( 'bottom-4' ) ){
						dynamic_sidebar( 'bottom-4' );
					}
					?>
				</div>				
			</div>
		</div>
	</section>
	<?php
}
?>