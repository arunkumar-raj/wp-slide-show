<?php
/**
 * Auto load the files for the plugin.
 *
 * @package Wp-slide-show
 * @since 1.0.0
 */

namespace Rtcamp\Wpslideshow;

defined( 'ABSPATH' ) || exit;

/**
 * Autoloader class.
 */
class Autoloader {

	/**
	 * Require the autoloader and return the result.
	 *
	 * If the autoloader is not present, let's log the failure and display a nice admin notice.
	 *
	 * @return boolean
	 */
	public static function init() {
		$autoloader = __DIR__ . '/class-autoload-packages.php';

		if ( ! is_readable( $autoloader ) ) {
			self::missing_autoloader();
			return false;
		}

		require_once __DIR__ . '/common-method.php';
		$autoloader_result = require $autoloader;
		if ( ! $autoloader_result ) {
			return false;
		}
		self::create_table_for_slideshow();
		return $autoloader_result;
	}

	/**
	 * If the autoloader is missing, add an admin notice.
	 */
	protected static function missing_autoloader() {
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
						echo esc_html__( 'Your installation of Wpslideshow is incomplete.', 'wpslideshow' );
						?>
					</p>
				</div>
				<?php
			}
		);
	}

	/**
	 * Create Table if not exists to save the slideshow images.
	 */
	protected static function create_table_for_slideshow() {
		global $wpdb;
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		$tablename       = WPSS_SLIDESHOW_TBL;
		$main_sql_create = 'CREATE TABLE IF NOT EXISTS ' . $tablename . '(
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			image_url TEXT NOT NULL,
			position INT NOT NULL DEFAULT 0,
			attachment_id INT NOT NULL DEFAULT 0,			
			date TIMESTAMP
		)';
		maybe_create_table( $wpdb->prefix . $tablename, $main_sql_create );
	}

}
