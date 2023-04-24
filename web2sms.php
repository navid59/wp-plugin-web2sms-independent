<?php

/*
Plugin Name: WEB2SMS for WooCommerce
Plugin URI: https://www.web2sms.ro
Description: send SMS on order status change & abandoned carts
Author: Web2sms
Version: 1.0
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

	wp_enqueue_script( 'web2smsjs', plugin_dir_url( __FILE__ ) . 'js/web2sms.js',array('jquery'),'1.0.2' ,true);
	wp_enqueue_script( 'web2smsjstoastr', plugin_dir_url( __FILE__ ) . 'js/toastr.min.js',array(),'1.0.1' ,true);
	wp_enqueue_style( 'web2smscss', plugin_dir_url( __FILE__ ) . 'css/web2sms.css',array(),'1.0.1' ,false);
	wp_enqueue_style( 'web2smscsstoastr', plugin_dir_url( __FILE__ ) . 'css/toastr.min.css',array(),'1.0.1' ,false);
}
add_action( 'admin_enqueue_scripts', 'web2sms_init', 0 );