<?php

/*
Plugin Name: WEB2SMS for WooCommerce
Description: send SMS on order status change & abandoned carts
Version: 1.0.0
Author: Web2sms development team
Author URI: https://www.web2sms.ro
License: GPLv2
*/

// Include web2sms with WooCommerce
/**
 * Define Web2sms Option to pluin
 */
include_once( 'wc-web2sms.php' );
include_once( 'wc-web2sms_install.php');
function web2sms_init() {
	/**
	 * Thicbox for Popup
	 */
	add_thickbox();

	// Add custom action links
	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'netopia_action_links' );
	function netopia_action_links( $links ) {
		$plugin_links = array(
			'<a href="' . admin_url( 'admin.php?page=wc-settings&tab=settings_tab_web2sms' ) . '">' . __( 'Settings', 'netopiapayments' ) . '</a>',
		);
		return array_merge( $plugin_links, $links );
	}
}
add_action( 'admin_enqueue_scripts', 'web2sms_init', 0 );

/**  
 * plugin directory URL to JavaScript
*/
function web2sms_enqueue_scripts() {
	wp_enqueue_script( 'web2sms-toastr', plugin_dir_url( __FILE__ ) . 'js/toastr.min.js',array(),'2.1.3' ,true);
    wp_enqueue_script( 'web2sms-script', plugins_url( 'js/web2sms.js', __FILE__ ), array(), '1.0.0', true );
    wp_localize_script( 'web2sms-script', 'web2sms_data', array(
        'plugin_url' => web2sms_getAbsoulutFilePath(),
    ) );
	wp_enqueue_style( 'web2sms-css', plugin_dir_url( __FILE__ ) . 'css/web2sms.css',array(),'1.0.0');
	wp_enqueue_style( 'web2sms-toastr-css', plugin_dir_url( __FILE__ ) . 'css/toastr.min.css',array(),'2.1.3');
}
add_action( 'admin_enqueue_scripts', 'web2sms_enqueue_scripts' );

function web2sms_getAbsoulutFilePath() {
	// Get the absolute path to the plugin directory
	$plugin_dir_path = plugin_dir_path( __FILE__ );

	// Get the absolute path to the WordPress installation directory
	$wordpress_dir_path = realpath( ABSPATH . '..' );

	// Remove the WordPress installation directory from the plugin directory path
	$plugin_dir_path = str_replace( $wordpress_dir_path, '', $plugin_dir_path );

	// Remove the leading directory separator
	$plugin_dir_path = ltrim( $plugin_dir_path, '/' );

	// Remove the first directory name (which is the site directory name)
	$plugin_dir_path = preg_replace( '/^[^\/]+\//', '', $plugin_dir_path );

	return $plugin_dir_path;
}