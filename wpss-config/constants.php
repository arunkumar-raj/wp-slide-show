<?php
/**
 * Define constants for the plugin.
 *
 * @package Wp-slide-show
 * @since 1.0.0
 */

global $wpdb;
define( 'WPSS_PLUGIN_VERSION', '1.0.0' );
/*============== Assets paths ==============*/
define( 'WPSS_JS_PATH', WPSS_PLUGIN_URL . 'wpss-assets/js/' );
define( 'WPSS_CSS_PATH', WPSS_PLUGIN_URL . 'wpss-assets/css/' );
define( 'WPSS_IMAGE_PATH', WPSS_ABSPATH . 'wpss-assets/images/' );

/*============== File paths ==============*/
define( 'WPSS_MODEL_PATH', WPSS_ABSPATH . 'wpss-models/' );
define( 'WPSS_CONTROLLER_PATH', WPSS_ABSPATH . 'wpss-controllers/' );

define( 'WPSS_VIEW_ADMIN_PATH', WPSS_ABSPATH . 'wpss-views/adminend/' );
define( 'WPSS_VIEW_FRONT_PATH', WPSS_ABSPATH . 'wpss-views/frontend/' );


/*============== Table constants ==============*/
define( 'WPSS_SLIDESHOW_TBL', $wpdb->prefix . 'wpss_slideshow_tbl' );
