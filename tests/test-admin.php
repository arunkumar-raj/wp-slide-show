<?php
/**
 * Class SampleTest
 *
 * @package Wp_Slideshow
 */
require_once __DIR__ . '/../wpss-config/constants.php';
require_once WPSS_CONTROLLER_PATH . 'class-admin-slideshow.php';
require_once WPSS_MODEL_PATH . 'class-admin-model.php';
/**
 * Sample test case.
 */
class Wpss_Admin_Plugin_Test extends WP_Ajax_UnitTestCase {

	/**
	 * Admin functions test.
	 */
	public function test_model_functions() {
		$model= new Rtcamp\Wpslideshow\Models\Admin_Model();
		$table_count = $model->wpss_get_count();
		$this->assertIsString( $table_count );
		$image_val = $model->wpss_get_images();
		$this->assertIsArray( $image_val );
	}

	public function test_slider_positions () {
        global $_POST;
		$admin= new Rtcamp\Wpslideshow\Controllers\Admin_Slideshow();
		$this->_setRole( 'administrator' );
		$this->assertTrue( is_admin() );
        $_POST[ 'changedposition' ] = array('2' => '5', '3' => '2');
        $_POST[ 'nonce' ] = wp_create_nonce( 'wpss-ajax-nonce' );
        ob_start();
		try {
			add_action( 'wp_ajax_save_slider_image_postion', array( $admin, 'wpss_change_slider_postions' ) );
			add_action( 'wp_ajax_nopriv_save_slider_image_postion', array( $admin, 'wpss_change_slider_postions' ) );
			$this->setExpectedException('WPAjaxDieContinueException');
			$this->_handleAjax( 'save_slider_image_postion' );
		} catch ( WPAjaxDieContinueException $e ) {
			// We expected this, do nothing.
		}
		$this->assertTrue(isset($e));
        $response = json_decode($this->_last_response, true );
		$this->assertEquals('1', $response['success']);
		$this->assertEquals('Sliders updated successfully.', $response['data']);
		wp_die();
    }

	public function test_image_delete () {
        global $_POST;
		$admin= new Rtcamp\Wpslideshow\Controllers\Admin_Slideshow();
		$this->_setRole( 'administrator' );
		$this->assertTrue( is_admin() );
        $_POST[ 'id_val' ] = '12';
		$_POST[ 'attachid' ] = '12';
        $_POST[ 'nonce' ] = wp_create_nonce( 'wpss-ajax-nonce' );
        ob_start();
		try {
			add_action( 'wp_ajax_delete_slider_image', array( $admin, 'wpss_delete_image_slider' ) );
			add_action( 'wp_ajax_nopriv_delete_slider_image', array( $admin, 'wpss_delete_image_slider' ) );
			$this->setExpectedException('WPAjaxDieContinueException');
			$this->_handleAjax( 'delete_slider_image' );
		} catch ( WPAjaxDieContinueException $e ) {
			// We expected this, do nothing.
		}
		$this->assertTrue(isset($e));
        $response = json_decode($this->_last_response, true );
		$this->assertEquals('1', $response['success']);
		$this->assertEquals('Image Deleted successfully.', $response['data']);
		wp_die();
    }

}
