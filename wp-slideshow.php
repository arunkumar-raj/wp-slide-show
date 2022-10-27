<?php
/**
 * Plugin Name
 *
 * @package     Wp-slide-show
 * @author      Arunkumar
 * @copyright   Arunkumar
 * @license     GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name: Wp-slide-show
 * Plugin URI:  https://example.com/plugin-name
 * Description: Create a slideshow to view the images on frontend.
 * Version:     1.0.0
 * Author:      Arunkumar
 * Author URI:  https://example.com
 * Text Domain: wpslideshow-slug
 * License:     GPL-2.0-or-later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

defined( 'ABSPATH' ) || exit;

define( 'WPSS_ABSPATH', dirname( __FILE__ ) . '/' );
define( 'WPSS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
require_once __DIR__ . '/wpss-config/constants.php';
require_once __DIR__ . '/wpss-config/class-autoloader.php';
if ( ! \Rtcamp\Wpslideshow\Autoloader::init() ) {
	return;
}
if ( defined( 'WP_CLI' ) && WP_CLI ) {
	require_once WPSS_CONTROLLER_PATH . 'class-wpss-slideshow-cli.php';
	WP_CLI::add_command( 'wpss-slide', 'Wpss_Slideshow_Cli' );
}
