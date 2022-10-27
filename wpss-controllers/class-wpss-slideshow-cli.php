<?php
/**
 * Codes to serve the wp cli for plugin.
 *
 * @package Wp-slide-show
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;
require_once WPSS_MODEL_PATH . 'class-admin-model.php';
use Rtcamp\Wpslideshow\Models\Admin_Model as Admin;
/**
 * Admin Slideshow.
 */
class Wpss_Slideshow_Cli {
	/**
	 * Initialize model inside the model object.
	 *
	 * @var $model will have the object of adminmodel.
	 */
	protected $model = '';

	/**
	 * The constructor.
	 */
	public function __construct() {
		$this->model = new Admin();
	}
	/**
	 * Create slideshow from the folder Images.
	 */
	public function create_slideshow() {
		WP_CLI::log( 'Setting the images for the sliders…' );
		$get_sliders = WPSS_IMAGE_PATH . 'sliders';
		WP_CLI::log( 'You can add more images on this path ' . $get_sliders . '' );
		$get_files = list_files( $get_sliders );
		if ( ! empty( $get_files ) ) {
			$get_position = $this->model->wpss_get_count();
			foreach ( $get_files as $getfile ) {
				$check_valid_image = file_is_valid_image( $getfile );
				if ( $check_valid_image ) {
					$filename        = wp_basename( $getfile );
					$photo           = array(
						'name'     => $filename,
						'tmp_name' => $getfile,
					);
					$photo_attach_id = media_handle_sideload( $photo, 0 );
					$position        = ++$get_position;
					$get_photo_url   = wp_get_attachment_url( $photo_attach_id );
					$this->model->wpss_save_slides( $get_photo_url, $position, $photo_attach_id );
				}
			}
			WP_CLI::success( 'Done!' );
		} else {
			WP_CLI::error( 'No files found to upload the images' );
		}
	}

}
