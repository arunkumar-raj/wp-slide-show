<?php
/**
 * Codes to serve the admin page.
 *
 * @package Wp-slide-show
 * @since 1.0.0
 */

if ( ! function_exists( 'wpss_admin_settings' ) ) {
	/**
	 * Functions return view for setting
	 *
	 * @param array  $validation_messages Shows the error on the form request.
	 *
	 * @param string $success_message on update success message to the user.
	 *
	 * @param array  $all_images All saved images in the Database.
	 */
	function wpss_admin_settings( $validation_messages, $success_message, $all_images ) {
		?>
		<div class="container light-style flex-grow-1 container-p-y wpss_admin_settings">

			<h4 class="font-weight-bold py-3 mb-4">Wp Slideshow Settings</h4>
			<form method="POST" name="wpss-uploader" id="wpss-uploader" enctype="multipart/form-data">
				<?php wp_nonce_field( 'wpss_nonce', 'slideshowsettings' ); ?>
				<input type="hidden" name="slidesettings" value="1">
				<div class="card wpss-card overflow-hidden">
					<?php
					if ( ! empty( $validation_messages ) ) {
						foreach ( $validation_messages as $validation_message ) {
							?>
							<div class="alert alert-danger" role="alert">
								<?php esc_html_e( $validation_message ); ?>
							</div>
							<?php
						}
					}

					// Display the success message.
					if ( strlen( $success_message ) > 0 ) {
						?>
						<div class="alert alert-success" role="alert">
						<?php esc_html_e( $success_message ); ?>
						</div>
						<?php
					}
					?>
					<div class="row no-gutters row-bordered row-border-light">
						<div class="col-md-12">
							<div class="card-body media align-items-center">
								<div class="media-body ml-4">
									<div class="input-images"></div>
									<div class="text-light small mt-1">Allowed JPG, GIF or PNG.</div>
								</div>
							</div>
							<hr class="border-light m-0">
						</div>
					</div>
				</div>

				<div class="text-right mt-3">
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>
			</form>
			<?php
			if ( ! empty( $all_images ) ) {
				?>
			<div class="card wpss-card overflow-hidden">
				<div class="wpss-sortable"></div>
				<ul id="sortable">
				<?php
				foreach ( $all_images as $image ) {
					$get_attachment = wp_get_attachment_image( $image->attachment_id, 'wpss-slideshow', true, array( 'class' => 'sliders' ) );
					?>
					<li id="<?php echo esc_attr( $image->id ); ?>" class="ui-state-default">
						<a href="javascript:void(0);" class="wpssicon_anchor" data-id="<?php echo esc_attr( $image->id ); ?>" data-attachid="<?php echo esc_attr( $image->attachment_id ); ?>">
							<span class="wpssicon">x</span>
						</a>
						<?php echo $get_attachment; ?>
					</li>
				<?php } ?>
				</ul>
			</div>
			<?php } ?>
		</div>
		<?php
	}
}
