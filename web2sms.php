<?php
/**
Plugin Name: WEB2SMS for WooCommerce
Description: send SMS on order status change & abandoned carts
Version: 1.0.0
Author: Web2sms development team
Author URI: https://www.web2sms.ro
License: GPLv2
*/

require_once 'wc-web2sms.php';
require_once 'wc-web2sms_install.php';

/**
 * Initialize plugin
 */
function web2smsInit() {
    // Add custom action links
    add_filter('plugin_action_links_'.plugin_basename( __FILE__ ),'web2smsActionLinks');
    function web2smsActionLinks( $links ) {
        $plugin_links = array(
            '<a href="' . admin_url('admin.php?page=wc-settings&tab=settings_tab_web2sms') . '">' . __( 'Settings', 'netopiapayments' ) . '</a>',
        );
    return array_merge($plugin_links, $links);
    }
}
add_action('admin_enqueue_scripts', 'web2smsInit', 0);

/**  
 * Define Css & JavaScript for plugin
*/
function web2smsEnqueueScripts() {
    wp_enqueue_script('web2sms-toastr', plugin_dir_url(__FILE__) . 'js/toastr.min.js',array(), '2.1.3' ,true);
    wp_enqueue_script('web2sms-script', plugins_url('js/web2sms.js', __FILE__), array(), '1.0.1', true );
    wp_localize_script('web2sms-script', 'web2sms_data', array('plugin_url' => web2smsGetAbsoulutFilePath()));
    wp_enqueue_style('web2sms-css', plugin_dir_url(__FILE__) . 'css/web2sms.css',array(),'1.0.0');
    wp_enqueue_style('web2sms-toastr-css', plugin_dir_url(__FILE__) . 'css/toastr.min.css',array(), '2.1.3');
}
add_action('admin_enqueue_scripts', 'web2smsEnqueueScripts');

function web2smsGetAbsoulutFilePath() {
    // Get the absolute path to the plugin directory
    $plugin_dir_path = plugin_dir_path(__FILE__);
    
    // Get the absolute path to the WordPress installation directory
    $wordpress_dir_path = realpath(ABSPATH . '..');
    
    // Remove the WordPress installation directory from the plugin directory path
    $plugin_dir_path = str_replace($wordpress_dir_path, '', $plugin_dir_path);
    
    // Remove the leading directory separator
    $plugin_dir_path = ltrim($plugin_dir_path, '/');
    
    // Remove the first directory name (which is the site directory name)
    $plugin_dir_path = preg_replace('/^[^\/]+\//', '../', $plugin_dir_path);

    return $plugin_dir_path;
}