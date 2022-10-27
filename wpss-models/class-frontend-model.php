<?php
/**
 * Codes to serve the admin page.
 *
 * @package Wp-slide-show
 * @since 1.0.0
 */

namespace Rtcamp\Wpslideshow\Models;

defined( 'ABSPATH' ) || exit;

/**
 * Front end Model.
 */
class Frontend_Model {
	/**
	 * Get all images on the table
	 */
	public function wpss_get_images() {
		global $wpdb;
		$all_images = $wpdb->get_results( 'SELECT * FROM ' . WPSS_SLIDESHOW_TBL . ' order by position ASC' );
		return $all_images;
	}
}