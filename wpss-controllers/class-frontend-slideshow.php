<?php
/**
 * Code to serve shortcode on front end.
 *
 * @package Wp-slide-show
 * @since 1.0.0
 */

namespace Rtcamp\Wpslideshow\Controllers;

defined( 'ABSPATH' ) || exit;
require_once WPSS_MODEL_PATH . 'class-frontend-model.php';
use Rtcamp\Wpslideshow\Models\Frontend_Model as front;
/**
 * Frontend Slideshow.
 */
class Frontend_Slideshow {

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
		add_action( 'wp_enqueue_scripts', array( $this, 'wpss_frontend_style' ) );
		add_shortcode( 'myslideshow', array( $this, 'wpss_slide_show' ) );
		$this->model = new front();
	}

	/**
	 * Enqueue the scripts or styles to display slideshow frontend.
	 */
	public function wpss_frontend_style() {
		wp_register_style( 'wpss_skitter_style', WPSS_CSS_PATH . 'skitter.css', array(), WPSS_PLUGIN_VERSION );
		wp_enqueue_style( 'wpss_skitter_style' );

		wp_enqueue_script( 'jquery' );
		wp_register_script( 'wpss_easing_js', WPSS_JS_PATH . 'jquery-easing.js', array(), WPSS_PLUGIN_VERSION, true );
		wp_enqueue_script( 'wpss_easing_js', array( 'jquery' ), array(), WPSS_PLUGIN_VERSION, true );
		wp_register_script( 'wpss_skitter_js', WPSS_JS_PATH . 'jquery.skitter.min.js', array(), WPSS_PLUGIN_VERSION, true );
		wp_enqueue_script( 'wpss_skitter_js', array( 'jquery' ), array(), WPSS_PLUGIN_VERSION, true );
	}

	/**
	 * Get the slides added on admin and show it on shortcode myslideshow.
	 */
	public function wpss_slide_show() {
		$all_images = $this->model->wpss_get_images();
		require_once WPSS_VIEW_FRONT_PATH . 'wpss-slideshow.php';
		$out = wpss_slide_show( $all_images );
		return $out;
	}

}
