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
 * Admin Model.
 */
class Admin_Model {

	/**
	 * Total count of images in the table.
	 */
	public function wpss_get_count() {
		global $wpdb;
		$count_query  = 'select count(*) from ' . WPSS_SLIDESHOW_TBL;
		$get_position = $wpdb->get_var( $count_query );
		return $get_position;
	}

	/**
	 * Save Slider images in to the table.
	 */
	public function wpss_save_slides( $get_photo_url, $position, $photo_attach_id ) {
		global $wpdb;
		$wpdb->insert(
			WPSS_SLIDESHOW_TBL,
			array(
				'image_url'     => $get_photo_url,
				'position'      => $position,
				'attachment_id' => $photo_attach_id,
			)
		);
	}

	/**
	 * Get all images on the table
	 */
	public function wpss_get_images() {
		global $wpdb;
		$all_images = $wpdb->get_results( 'SELECT * FROM ' . WPSS_SLIDESHOW_TBL . ' order by position ASC' );
		return $all_images;
	}

	/**
	 * Update image positions
	 */
	public function wpss_update_image( $position, $id ) {
		global $wpdb;
		$wpdb->update( WPSS_SLIDESHOW_TBL, array( 'position' => $position ), array( 'id' => $id ) );
	}

	/**
	 * Delete images
	 */
	public function wpss_delete_image( $image_id ) {
		global $wpdb;
		$wpdb->delete( WPSS_SLIDESHOW_TBL, array( 'id' => $image_id ) );
	}
}
