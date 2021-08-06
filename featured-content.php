<?php
/*
Plugin Name: PSC Featured Content
Description: Feature posts or pages with thumbnails, excepts and metadata using shortcodes.
Version: 0.1
Author: Photosynthesis Communications
Author URI: https://www.photosynthesis.ca
*/

if ( !defined( 'WPINC' ) ) {
	die;
}

define( 'PSC_FC_FILE', __FILE__ );
define( 'PSC_FC_PATH', plugin_dir_path( __FILE__ ) );

include_once( PSC_FC_PATH . 'featured-content-class.php' );

PSC_Featured_Content::get_instance();

?>
