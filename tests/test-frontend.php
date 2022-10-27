<?php
/**
 * Class SampleTest
 *
 * @package Wp_Slideshow
 */
require_once __DIR__ . '/../wpss-config/constants.php';
require_once WPSS_CONTROLLER_PATH . 'class-frontend-slideshow.php';
require_once WPSS_MODEL_PATH . 'class-frontend-model.php';
/**
 * Sample test case.
 */
class Wpss_Front_Plugin_Test extends WP_UnitTestCase {

	/**
	 * Shortcode functions test.
	 */
	public function test_shortcode_registered() {
		global $shortcode_tags;
		$this->assertArrayHasKey('myslideshow',$shortcode_tags);
	}

	public function test_shortcode() {
		$front= new Rtcamp\Wpslideshow\Controllers\Frontend_Slideshow();
		$out = do_shortcode( '[myslideshow]' );
		$this->assertNotEmpty($out);
	}
}