<?php
/**
 * Codes to serve the admin page.
 *
 * @package Wp-slide-show
 * @since 1.0.0
 */

namespace Rtcamp\Wpslideshow\Controllers;

defined( 'ABSPATH' ) || exit;
require_once WPSS_MODEL_PATH . 'class-admin-model.php';
use Rtcamp\Wpslideshow\Models\Admin_Model as Admin;
/**
 * Admin Slideshow.
 */
class Admin_Slideshow {

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
		add_image_size( 'wpss-slideshow', 300, 300, false );
		add_action( 'init', array( $this, 'wpss_admin_init_action' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'wpss_admin_style' ) );
		add_action( 'wp_ajax_save_slider_image_postion', array( $this, 'wpss_change_slider_postions' ) );
		add_action( 'wp_ajax_nopriv_save_slider_image_postion', array( $this, 'wpss_change_slider_postions' ) );
		add_action( 'wp_ajax_delete_slider_image', array( $this, 'wpss_delete_image_slider' ) );
		add_action( 'wp_ajax_nopriv_delete_slider_image', array( $this, 'wpss_delete_image_slider' ) );
		$this->model = new Admin();
	}

	/**
	 * Admin page callback link added.
	 */
	public function wpss_admin_init_action() {
		/** Registers the UI for "Wp-slide-show" page linked from the admin end
		 * wp-admin menu
		 */
		add_action(
			'admin_menu',
			function() use ( &$page_hook_suffix ) {
				$page_hook_suffix = add_menu_page( 'Wp Slide Show', 'Wp Slide Show', 'publish_posts', 'wpss-slide-show', array( $this, 'wpss_settings_page' ), 'dashicons-heart' );
			}
		);
	}

	/**
	 * Admin initial actions are performed here.
	 */
	public function wpss_settings_page() {
		$validation_messages = array();
		$success_message     = '';

		if ( isset( $_POST['slidesettings'] ) ) {
			// Check nonce for security.
			if ( ! wp_verify_nonce( wp_unslash( $_POST['slideshowsettings'] ), 'wpss_nonce' ) ) {
				return;
			}

			if ( isset( $_FILES['photos']['name'] ) && empty( $_FILES['photos']['name'][0] ) ) {
				$validation_messages[] = __( 'Please Upload Photo.' );
			}

			// Save the Images on table if there are no validation errors.
			if ( empty( $validation_messages ) ) {

				require_once ABSPATH . 'wp-admin/includes/image.php';
				require_once ABSPATH . 'wp-admin/includes/file.php';
				require_once ABSPATH . 'wp-admin/includes/media.php';
				$uploaded_images = isset( $_FILES['photos'] ) ? wp_unslash( $_FILES['photos'] ) : array();
				$uploaded_names  = isset( $_FILES['photos']['name'] ) ? wp_unslash( $_FILES['photos']['name'] ) : array();

				if ( empty( $uploaded_images ) ) {
					$validation_messages[] = __( 'Please Upload Photo.' );
				} else {
					$get_position = $this->model->wpss_get_count();
					foreach ( $uploaded_names as $key_index => $names ) {
						$check_valid_image = file_is_valid_image( $uploaded_images['tmp_name'][ $key_index ] );
						if ( $check_valid_image ) {
							$photo           = array(
								'name'      => $names,
								'full_path' => $uploaded_images['full_path'][ $key_index ],
								'type'      => $uploaded_images['type'][ $key_index ],
								'tmp_name'  => $uploaded_images['tmp_name'][ $key_index ],
								'error'     => $uploaded_images['error'][ $key_index ],
								'size'      => $uploaded_images['size'][ $key_index ],
							);
							$_FILES          = array( 'file_upload' => $photo );
							$photo_attach_id = media_handle_upload( 'file_upload', 0 );
							if ( is_wp_error( $photo_attach_id ) ) {
								$error_string          = $photo_attach_id->get_error_message();
								$validation_messages[] = $error_string;
							} else {
								$position      = ++$get_position;
								$get_photo_url = wp_get_attachment_url( $photo_attach_id );
								$this->model->wpss_save_slides( $get_photo_url, $position, $photo_attach_id );
								$success_message = __( 'Images uploaded successfully.', 'wpss_slideshow' );
							}
						}
					}
				}
			}
		}
		$all_images = $this->model->wpss_get_images();
		require_once WPSS_VIEW_ADMIN_PATH . 'wpss-admin-settings.php';
		$out = wpss_admin_settings( $validation_messages, $success_message, $all_images );
		return $out;
	}

	/**
	 * Updated the changed positions of the slider images.
	 */
	public function wpss_change_slider_postions() {
		// Check for nonce security.
		if ( ! wp_verify_nonce( wp_unslash( $_POST['nonce'] ), 'wpss-ajax-nonce' ) ) {
			return;
		}

		$changedposition = wp_unslash( $_POST['changedposition'] );
		if ( ! empty( $changedposition ) ) {
			foreach ( $changedposition as $get_position => $id ) {
				$position = ++$get_position;
				$this->model->wpss_update_image( $position, $id );
			}
			wp_send_json_success( 'Sliders updated successfully.' );
		}
		wp_die();
	}

	/**
	 * Delete the image from the slider
	 */
	public function wpss_delete_image_slider() {
		// Check for nonce security.
		if ( ! wp_verify_nonce( wp_unslash( $_POST['nonce'] ), 'wpss-ajax-nonce' ) ) {
			return;
		}
		$image_id  = sanitize_text_field( wp_unslash( $_POST['id_val'] ) );
		$attach_id = sanitize_text_field( wp_unslash( $_POST['attachid'] ) );
		if ( ! empty( $image_id ) ) {
			$this->model->wpss_delete_image( $image_id );
			wp_delete_attachment( $attach_id );
			wp_send_json_success( 'Image Deleted successfully.' );
		}
		wp_die();
	}

	/**
	 * Admin page script and style added.
	 */
	public function wpss_admin_style() {
		wp_enqueue_style( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css', array(), WPSS_PLUGIN_VERSION );
		wp_register_style( 'wpss_admin_style', WPSS_CSS_PATH . 'style.css', array(), WPSS_PLUGIN_VERSION );
		wp_enqueue_style( 'wpss_admin_style' );
		wp_register_style( 'wpss_image_uploader', WPSS_CSS_PATH . 'image-uploader.css', array(), WPSS_PLUGIN_VERSION );
		wp_enqueue_style( 'wpss_image_uploader' );

		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_register_script( 'wpss_image_uploader_js', WPSS_JS_PATH . 'image-uploader.js', array(), WPSS_PLUGIN_VERSION, true );
		wp_enqueue_script( 'wpss_image_uploader_js', array( 'jquery' ), array(), WPSS_PLUGIN_VERSION, true );
		wp_register_script( 'wpss-javascript', WPSS_JS_PATH . 'wpss-javascript.js', array(), WPSS_PLUGIN_VERSION, true );
		wp_enqueue_script( 'wpss-javascript', array( 'jquery' ), array(), WPSS_PLUGIN_VERSION, true );
		wp_localize_script(
			'wpss-javascript',
			'slideshow_ajax_var',
			array(
				'url'   => admin_url( 'admin-ajax.php' ),
				'nonce' => wp_create_nonce( 'wpss-ajax-nonce' ),
			)
		);
	}

}
