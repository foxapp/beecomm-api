<?php
function beecomm_add_settings_page() {
	add_options_page( 'Beecomm API settings page', 'Beecomm API', 'manage_options', 'beecomm_api', 'beecomm_render_plugin_settings_page' );
}
add_action( 'admin_menu', 'beecomm_add_settings_page' );

function beecomm_render_plugin_settings_page() {
	require_once __DIR__ .'/beecomm-api-settings.php';
}

function beecomm_register_settings() {
	register_setting( 'beecomm_api_options', 'beecomm_api_options', 'beecomm_api_options_validate' );
	add_settings_section( 'api_settings', 'API Settings', 'beecomm_plugin_section_text', 'beecomm_api' );

	add_settings_field( 'beecomm_plugin_setting_api_client_id', 'Client ID', 'beecomm_plugin_setting_api_client_id', 'beecomm_api', 'api_settings' );
	add_settings_field( 'beecomm_plugin_setting_api_client_secret', 'Client Secret', 'beecomm_plugin_setting_api_client_secret', 'beecomm_api', 'api_settings' );
	add_settings_field( 'beecomm_plugin_setting_api_send_to_printer', 'Send to printer', 'beecomm_plugin_setting_api_send_to_printer', 'beecomm_api', 'api_settings' );
	add_settings_field( 'beecomm_plugin_setting_api_show_debug', 'Debug', 'beecomm_plugin_setting_api_show_debug', 'beecomm_api', 'api_settings' );
	add_settings_field( 'beecomm_plugin_setting_api_send_notification_to_admin', 'Send Notification to Admin<br><small>for each success/fail transaction</small>', 'beecomm_plugin_setting_api_send_notification_to_admin', 'beecomm_api', 'api_settings' );
}
add_action( 'admin_init', 'beecomm_register_settings' );

/*
function beecomm_plugin_settings_link($links) {
	$settings_link = '<a href="options-general.php?page=beecomm_api">Settings</a>';
	array_unshift($links, $settings_link);
	return $links;
}
$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'beecomm_plugin_settings_link' );

*/
function beecomm_api_options_validate( $input ) {
	//$newinput['api_key'] = trim( $input['api_key'] );
	//if ( ! preg_match( '/^[a-z0-9]{32}$/i', $newinput['api_key'] ) ) {
	//	$newinput['api_key'] = '';
	//}

	return $input;
}
function beecomm_plugin_section_text() {
	echo '<p>Here you can set all the options for Beecomm API Connection</p>';
}

function beecomm_plugin_setting_api_client_id() {
	$options = get_option( 'beecomm_api_options' );
	echo "<input id='beecomm_plugin_setting_api_client_id' style='min-width:600px' name='beecomm_api_options[client_id]' type='text' value='".esc_attr( $options['client_id'] )."' />";
}

function beecomm_plugin_setting_api_client_secret() {
	$options = get_option( 'beecomm_api_options' );
	echo "<input id='beecomm_plugin_setting_api_client_secret' style='min-width:600px' name='beecomm_api_options[client_secret]' type='text' value='".esc_attr( $options['client_secret'] )."' />";
}

function beecomm_plugin_setting_api_show_debug() {
	$options = get_option( 'beecomm_api_options' );
	echo "<input id='beecomm_plugin_setting_api_show_debug' name='beecomm_api_options[api_show_debug]' type='checkbox' ".checked( esc_attr( $options['api_show_debug'] ), 1 , false)." value='1' />";
}

function beecomm_plugin_setting_api_send_to_printer() {
	$options = get_option( 'beecomm_api_options' );
	echo "<input id='beecomm_plugin_setting_api_send_to_printer' name='beecomm_api_options[api_send_to_printer]' type='checkbox' ".checked( esc_attr( $options['api_send_to_printer'] ), 1 , false)." value='1' />";
}

function beecomm_plugin_setting_api_send_notification_to_admin() {
	$options = get_option( 'beecomm_api_options' );
	echo "<input id='beecomm_plugin_setting_api_send_notification_to_admin' name='beecomm_api_options[api_send_notification_to_admin]' type='checkbox' ".checked( esc_attr( $options['api_send_notification_to_admin'] ), 1 , false)." value='1' />";
}