<?php
/**
 * Trait used as common helper to serve.
 *
 * @package Wp-slide-show
 * @since 1.0.0
 */

namespace Rtcamp\Wpslideshow;

trait Common_Method_Trait {
	/**
	 * If class is missing, add an admin notice.
	 */
	/**
	 * Error message will be added to $message.
	 *
	 * @var string $message is to hold the error message .
	 */
	protected static $message;

	/**
	 * If class is not loaded show up error.
	 *
	 * @since 1.0.0
	 *
	 * @param string $class Failed to load class name will be sent.
	 */
	protected function class_missing( $class ) {
		self::$message = $class;
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			error_log(  // phpcs:ignore
				esc_html__( 'Your installation of Wpslideshow is incomplete.', 'wpslideshow' )
			);
		}

		add_action(
			'admin_notices',
			function() {
				?>
				<div class="notice notice-error">
					<p>
						<?php
						printf(
							/* translators: 1: to show the error class */
							esc_html__( 'Your installation of Wpslideshow is incomplete the class is , %s is not found', 'wpslideshow' ),
							esc_html( self::$message )
						);
						?>
					</p>
				</div>
				<?php
			}
		);
	}
}
