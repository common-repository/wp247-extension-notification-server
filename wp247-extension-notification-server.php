<?php
/*
	Plugin Name: WP247 Extension Notification Server
	Version: 1.0.1
	Description: Provides the ability for extension developers to send notification messages to their extension users - This is the server (Extension Developer's) side plugin
	Tags: extension, plugin, theme, notice, notification, message
	Author: wp247
	Author URI: http://wp247.net/
	Text domain: wp247-extension-notification-server
	Uses: weDevs Settings API wrapper class from http://tareq.weDevs.com Tareq's Planet
*/

// Don't allow direct execution
defined( 'ABSPATH' ) or die( 'Forbidden' );

// Set to true to get debug array listed at the bottom of the html body
defined( 'WP247XNS_SERVER_DEBUG' ) or define( 'WP247XNS_SERVER_DEBUG', false );

if ( !defined( 'WP247XNS_SERVER_VERSION' ) )
{
	define( 'WP247XNS_SERVER_VERSION', 1.0 );


	if ( !is_plugin_active( 'wp247-extension-notification-server-pro/wp247-extension-notification-server-pro.php' ) )
	{
		define( 'WP247XNS_SERVER_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
		define( 'WP247XNS_SERVER_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		define( 'WP247XNS_SERVER_PLUGIN_NAME', 'WP247 Extension Notification Server' );
		define( 'WP247XNS_SERVER_PLUGIN_ID', basename( dirname( __FILE__ ) ) );
		define( 'WP247XNS_SERVER_PLUGIN_TEXT_DOMAIN', WP247XNS_SERVER_PLUGIN_ID );
		if ( is_admin() )
		{
			require_once WP247XNS_SERVER_PLUGIN_PATH . 'admin/wp247-extension-notification-server-admin.php';
		}
	
	}

}