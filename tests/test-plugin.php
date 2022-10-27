<?php
/**
 * Class SampleTest
 *
 * @package Wp_Slideshow
 */
require_once __DIR__ . '/../wpss-config/constants.php';
require_once __DIR__ . '/../wpss-controllers/class-admin-slideshow.php';
/**
 * Sample test case.
 */
class Wpss_Plugin_Test extends WP_UnitTestCase {

	/**
	 * Admin functions test.
	 */
	
	public function test_files() {
		$this->assertFileExists( WPSS_CONTROLLER_PATH . 'class-admin-slideshow.php' );
		$this->assertFileExists( WPSS_CONTROLLER_PATH . 'class-frontend-slideshow.php' );
		$this->assertFileExists( WPSS_CONTROLLER_PATH . 'class-wpss-slideshow-cli.php' );
		$this->assertFileExists( WPSS_MODEL_PATH . 'class-admin-model.php' );
		$this->assertFileExists( WPSS_MODEL_PATH . 'class-frontend-model.php' );
		$this->assertFileExists( WPSS_VIEW_ADMIN_PATH . 'wpss-admin-settings.php' );
		$this->assertFileExists( WPSS_VIEW_FRONT_PATH . 'wpss-slideshow.php' );
	}

	public function test_methods_admin() {
		$admin = new Rtcamp\Wpslideshow\Controllers\Admin_Slideshow();
		$this->assertTrue(
			method_exists($admin, 'wpss_admin_init_action'), 
			'Class does not have method myFunction'
		);

		$this->assertTrue(
			method_exists($admin, 'wpss_settings_page'), 
			'Class does not have method myFunction'
		);
		$this->assertTrue(
			method_exists($admin, 'wpss_change_slider_postions'), 
			'Class does not have method myFunction'
		);

		$this->assertTrue(
			method_exists($admin, 'wpss_delete_image_slider'), 
			'Class does not have method myFunction'
		);

		$this->assertTrue(
			method_exists($admin, 'wpss_admin_style'), 
			'Class does not have method myFunction'
		);
	}

	public function test_methods_front() {
		$front = new Rtcamp\Wpslideshow\Controllers\Frontend_Slideshow();
		$this->assertTrue(
			method_exists($front, 'wpss_frontend_style'), 
			'Class does not have method myFunction'
		);

		$this->assertTrue(
			method_exists($front, 'wpss_slide_show'), 
			'Class does not have method myFunction'
		);
	}
}
