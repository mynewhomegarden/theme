<?php
/*
	Template Name: Page Contact
*/
get_header();
the_post();
?>

<section>
	<div class="container">
		<div class="white-block">
			<?php
// 			$contact_map = reviews_get_option( 'contact_map' );
			if( !empty( $contact_map ) ){
				?>
				<div class="embed-responsive embed-responsive-16by9">
					<iframe src="<?php echo esc_url( $contact_map ) ?>" class="embed-responsive-item"></iframe>
				</div>
				<?php
			}
			?>
			<div class="content-inner">

				<?php 
				$content = get_the_content();
				if( !empty( $content ) ){
					echo '<div class="contact-page-content-wrap">'.apply_filters( 'the_content', $content ).'</div>';
				}
				?>

				<form id="comment-form" class="comment-form contact-form">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group has-feedback">
								<label for="name"><?php esc_html_e( 'Your name', 'reviews' ) ?> *</label>
								<input type="text" class="form-control name" id="name" name="name" />
							</div>
							<div class="form-group has-feedback">
								<label for="email"><?php esc_html_e( 'Your email', 'reviews' ) ?> *</label>
								<input type="text" class="form-control email" id="email" name="email" />
							</div>
							<div class="form-group has-feedback">
								<label for="subject"><?php esc_html_e( 'Message subject', 'reviews' ) ?> *</label>
								<input type="text" class="form-control subject" id="subject" name="subject" />
							</div>
							<div class="form-group has-feedback">
								<label for="phone"><?php esc_html_e( 'Telephone number', 'reviews' ) ?></label>
								<input type="text" class="form-control phone" id="phone" name="phone" />
							</div>
							<p class="form-submit">
								<a href="javascript:;" class="send-contact btn"><?php esc_html_e( 'Send Message', 'reviews' ) ?> </a>
							</p>
							<div class="send_result"></div>							
						</div>
						<div class="col-sm-6">
							<div class="form-group has-feedback">
								<label for="subject"><?php esc_html_e( 'Your message', 'reviews' ) ?> *</label>
								<textarea rows="10" cols="100" class="form-control message" id="message" name="message"></textarea>															
							</div>						
						</div>
					</div>
				</form>	
			</div>					
		</div>
	</div>
</section>
<?php get_footer(); ?>