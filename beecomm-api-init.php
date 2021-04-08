<?php
use BeecommApi\Adapter\BeecommInit;

ini_set('display_errors',1);
defined( 'ABSPATH' ) or die( 'No script kiddies please!');
/**
 * Plugin Name: WooCommerce connection to Beecomm API
 * Plugin URI: https://github.com/foxapp/beecomm-api
 * Description: Connection between WooCommerce orders and Beecomm API Server(to printer).
 * Version: 1.0
 * Author: Ion Enache
 * Author URI: https://www.foxapp.net
 */

include_once __DIR__ . '/adapter/beecomm-api.php';
include_once __DIR__ . '/adapter/beecomm-api-integration.php';
include_once __DIR__ . '/adapter/beecomm-api-transactions.php';
include_once __DIR__ . '/adapter/beecomm-api-func.php';

add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'salcode_add_plugin_page_settings_link');
function salcode_add_plugin_page_settings_link( $links ) {
	$links[] = '<a href="' . admin_url( 'options-general.php?page=beecomm_api' ) . '">' . __('Settings') . '</a>';
	return $links;
}

add_action('woocommerce_thankyou', 'beecomm_connect_api_to_order', 3, 1);

if(!function_exists('beecomm_connect_api_to_order')){
	function beecomm_connect_api_to_order(){
		$options = get_option( 'beecomm_api_options' );
		$client_id = $options['client_id'];
		$client_secret = $options['client_secret'];
		if ( !empty($client_id) && !empty($client_secret) ){
			var_dump('starting from here!');
			$connection_to_api = new BeecommInit($client_id, $client_secret);
		}
	}
}