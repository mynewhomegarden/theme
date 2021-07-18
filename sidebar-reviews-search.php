<?php
if ( is_active_sidebar( 'reviews-search' ) ){
	echo '<div class="col-sm-3">';
		dynamic_sidebar( 'reviews-search' );
	echo '</div>';
}
?>