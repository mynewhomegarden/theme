<?php
/*
	Template Name: Register & Login
*/
session_start();
if( is_user_logged_in() ){
	wp_redirect( home_url( '/' ) );
}

$user_confirmed = false;
if( isset( $_GET['confirmation_hash'] ) && isset( $_GET['username'] ) ){
	$confirmation_hash = esc_sql( $_GET['confirmation_hash'] );
	$username = esc_sql( $_GET['username'] );
	$user = get_user_by( 'login', $username );
	if( $user ){
		$confirmation_hash_db = get_user_meta( $user->ID, 'confirmation_hash', true );
		if( $confirmation_hash_db == $confirmation_hash ){
			update_user_meta( $user->ID, 'user_active_status', 'active' );
			delete_user_meta( $user->ID, 'confirmation_hash' );
			$user_confirmed = true;
		}
	}
}
get_header();
the_post();

?>

<section>
	<div class="container">
		<div class="white-block">
			<div class="content-inner">
				<div class="row">

					<?php
					if( $user_confirmed ){
						?>
						<div class="alert alert-success">
							<?php esc_html_e( 'You have successfully confirmed your email address and now you can log in.', 'reviews' ) ?>
						</div>
						<?php
					}
					?>

					<?php if(get_option('users_can_register')): ?>
						<div class="col-sm-6">
							<h3 class="post-title"><?php esc_html_e( 'Register', 'reviews' ) ?></h3>
					
							<form method="post" action="<?php echo reviews_get_permalink_by_tpl( 'page-tpl_register_login' ); ?>">
								<div class="form-group has-feedback">
									<label for="username"><?php esc_html_e( 'Username *', 'reviews' ) ?></label>
									<input type="text" class="form-control" id="username" name="username"/>
								</div>
								<div class="form-group has-feedback">
								<label for="email"><?php esc_html_e( 'Email *', 'reviews' ) ?></label>
									<input type="text" class="form-control" id="email" name="email"/>
								</div>
								<div class="form-group has-feedback">
									<label for="password"><?php esc_html_e( 'Password *', 'reviews' ) ?></label>
									<input type="password" class="form-control" id="password" name="password"/>
								</div>
								<div class="form-group has-feedback">
									<label for="repeat_password"><?php esc_html_e( 'Repeat Password *', 'reviews' ) ?></label>
									<input type="password" class="form-control" id="repeat_password" name="repeat_password"  />
								</div>
								<?php
								$registration_terms = reviews_get_option( 'registration_terms' );
								if( !empty( $registration_terms ) ):
								?>
								<div class="form-group has-feedback">
									<label><?php esc_html_e( 'Terms & Conditions', 'reviews' ) ?></label>
									<div class="terms-wrap">
										<?php echo apply_filters( 'the_content', $registration_terms ); ?>
									</div>
									<input type="checkbox" id="terms" name="terms" />
									<label for="terms"><?php esc_html_e( 'I accept terms & conditions', 'reviews' ) ?></label>
								</div>
								<?php endif; ?>
								<input type="text" class="hidden" name="captcha">							
								<div class="send_result"></div>
								<?php wp_nonce_field('register','register_field'); ?>
								<input type="hidden" value="register" name="action" />
								<div class="clearfix">
									<p class="form-submit register-actions">
										<a href="javascript:;" class="submit-form btn"><?php esc_html_e( 'Register', 'reviews' ) ?> </a>									
									</p>
		                            <?php
		                            if( function_exists( 'sc_render_login_form_social_connect' ) ){
		                                sc_render_login_form_social_connect();
		                            }
		                            ?>
		                        </div>
							</form>						
						</div>
					<?php endif; ?>
					<div class="col-sm-6">
						<h3 class="post-title"><?php esc_html_e( 'Login', 'reviews' ) ?></h3>
				
						<form method="post" action="<?php echo reviews_get_permalink_by_tpl( 'page-tpl_register_login' ); ?>">
							<div class="form-group has-feedback">
								<label for="username"><?php esc_html_e( 'Username *', 'reviews' ) ?></label>
								<input type="text" class="form-control" id="username" name="username"/>
							</div>
							<div class="form-group has-feedback">
								<label for="password"><?php esc_html_e( 'Password *', 'reviews' ) ?></label>
								<input type="password" class="form-control" id="password" name="password"/>
							</div>
							<div class="form-group has-feedback clearfix">
								<div class="pull-left">
									<input type="checkbox" id="remember_me" name="remember_me"/>
									<label for="remember_me"><?php esc_html_e( 'Remember Me', 'reviews' ) ?></label>
								</div>
								<div class="pull-right">
									<a href="<?php echo reviews_get_permalink_by_tpl( 'page-tpl_forgot_password' ) ?>">
										<?php esc_html_e( 'Lost Password?', 'reviews' ); ?>
									</a>
								</div>
							</div>
							<div class="send_result"></div>
							<?php wp_nonce_field('login','login_field'); ?>
							<input type="hidden" value="login" name="action" />
							<input type="hidden" value="<?php echo !empty( $_SERVER["HTTP_REFERER"] ) ? esc_url( $_SERVER["HTTP_REFERER"] ) : '' ?>" name="referer" />
							<p class="form-submit">
								<a href="javascript:;" class="submit-form btn"><?php esc_html_e( 'Log In', 'reviews' ) ?> </a>
							</p>
						</form>						
					</div>
				</div>
			</div>					
		</div>
	</div>
</section>
<?php get_footer(); ?>