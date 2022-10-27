<?php
/**
 * Add the dependent packages and iniate it to serve.
 *
 * @package Wp-slide-show
 * @since 1.0.0
 */

namespace Rtcamp\Wpslideshow;

defined( 'ABSPATH' ) || exit;

/**
 * Registers the needed classes.
 */
class Autoload_Packages {
	use Common_Method_Trait;
	/**
	 * A map of all the dependencies.
	 *
	 * @var array
	 */
	protected $dependencies;

	/**
	 * The constructor.
	 */
	public function __construct() {
		$this->dependencies = array();
		if ( is_admin() ) {
			add_action( 'enqueue_block_editor_assets', array( $this, 'register_gutenberg_block_js' ) );
			$this->admin_register_dependencies();
		} else {
			$this->frontend_register_dependencies();
		}
	}

	/**
	 * Get class and check is it stored on array else return error.
	 *
	 * @since 1.0.0
	 *
	 * @param array $class Class values set on array.
	 */
	public function get( $class ) {
		if ( ! isset( $this->dependencies[ $class ] ) ) {
			$this->class_missing( $class );
			return;
		}
		return $this->dependencies[ $class ];
	}

	/**
	 * Registering dependencies backend.
	 */
	private function admin_register_dependencies() {
		require_once WPSS_CONTROLLER_PATH . 'class-admin-slideshow.php';
		$this->dependencies[ Controllers\Admin_Slideshow::class ] = new Controllers\Admin_Slideshow();
		$this->get( Controllers\Admin_Slideshow::class );

		require_once WPSS_MODEL_PATH . 'class-admin-model.php';
		$this->dependencies[ Models\Admin_Model::class ] = new Models\Admin_Model();
		$this->get( Models\Admin_Model::class );
	}

	/**
	 * Registering dependencies frontend.
	 */
	private function frontend_register_dependencies() {
		require_once WPSS_CONTROLLER_PATH . 'class-frontend-slideshow.php';
		$this->dependencies[ Controllers\Frontend_Slideshow::class ] = new Controllers\Frontend_Slideshow();
		$this->get( Controllers\Frontend_Slideshow::class );

		require_once WPSS_MODEL_PATH . 'class-frontend-model.php';
		$this->dependencies[ Models\Frontend_Model::class ] = new Models\Frontend_Model();
		$this->get( Models\Frontend_Model::class );
	}

	/**
	 * Register gutenberg block.
	 */
	public function register_gutenberg_block_js() {
		wp_enqueue_script( 'wpss-custom-block', WPSS_JS_PATH . 'wpss-custom-block.js', array( 'wp-blocks', 'wp-i18n', 'wp-editor' ), true, false );
	}

}
return new Autoload_Packages();
