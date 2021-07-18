<?php
/*
	Template Name: Forgot Password
*/
if( is_user_logged_in() ){
	wp_redirect( home_url( '/' ) );
}

get_header();
the_post();

$hash = !empty( $_GET['hash'] ) ? $_GET['hash'] : '';

?>

<section>
	<div class="container">
		<div class="white-block">
			<div class="content-inner">
				<h3 class="post-title"><?php esc_html_e( 'Forgot password', 'reviews' ) ?></h3>
				<?php if( empty( $hash ) ): ?>
					<form method="post">
						<div class="form-group has-feedback">
							<label for="email"><?php esc_html_e( 'Email *', 'reviews' ) ?></label>
							<input type="text" class="form-control" id="email" name="email"/>
						</div>
						<div class="send_result"></div>
						<?php wp_nonce_field('recover','recover_field'); ?>
						<input type="hidden" value="recover" name="action" />
						<p class="form-submit">
							<a href="javascript:;" class="submit-form btn"><?php esc_html_e( 'Recover', 'reviews' ) ?> </a>
						</p>
					</form>	
				<?php else: ?>
					<form method="post">
						<div class="form-group has-feedback">
							<label for="new_password"><?php esc_html_e( 'New Password *', 'reviews' ) ?></label>
							<input type="password" class="form-control" id="new_password" name="new_password"/>
						</div>
						<div class="form-group has-feedback">
							<label for="new_password_repeat"><?php esc_html_e( 'New Password Repeat *', 'reviews' ) ?></label>
							<input type="password" class="form-control" id="new_password_repeat" name="new_password_repeat"/>
						</div>
						<div class="send_result"></div>
						<?php wp_nonce_field('recover','recover_field'); ?>
						<input type="hidden" value="recover_action" name="action" />
						<input type="hidden" value="<?php echo esc_attr( $_GET['user'] ) ?>" name="user" />
						<input type="hidden" value="<?php echo esc_attr( $_GET['hash'] ) ?>" name="hash" />
						<p class="form-submit">
							<a href="javascript:;" class="submit-form btn"><?php esc_html_e( 'Change Password', 'reviews' ) ?> </a>
						</p>
					</form>	
				<?php endif; ?>
			</div>					
		</div>
	</div>
</section>
<?php get_footer(); ?>