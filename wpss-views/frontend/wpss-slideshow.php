<?php
/**
 * Codes to serve the slideshow on frontend.
 *
 * @package Wp-slide-show
 * @since 1.0.0
 */

if ( ! function_exists( 'wpss_slide_show' ) ) {
	/**
	 * Functions return view for setting
	 *
	 * @param array $sliders Loop sliders and create slideshow.
	 */
	function wpss_slide_show( $sliders ) {
		ob_start();
		?>
		<div class="skitter skitter-large with-dots">
			<?php
			if ( ! empty( $sliders ) ) {
				?>
			<ul>
				<?php
				foreach ( $sliders as $image ) {
					?>
				<li>
					<a href="javascript:void(0);">
						<img src="<?php echo $image->image_url; ?>" class="cut wpssslides" />
					</a>
				</li>
				<?php } ?>
			</ul>
			<?php } ?>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery('.skitter-large').skitter({
					preview: true,
					animation:'paralell',
				});
			});
		</script>
		<?php
		return ob_get_clean();
	}
}
