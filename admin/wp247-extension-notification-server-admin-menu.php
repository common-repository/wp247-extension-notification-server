<?php
// Don't allow direct execution
defined( 'ABSPATH' ) or die ( 'Forbidden' );

function wp247_extension_notification_server_admin_menu( $caller ) {
	return array( 'page_title'		=> $caller->__( 'WP247 Extension Notification Server' )
				, 'menu_title'		=> $caller->__( 'Extension Notifications' )
				, 'capability'		=> 'manage_options'
				, 'menu_slug'		=> 'wp247xns_server_options'
				, 'page_link'		=> 'http://wp247.net/wp247-extension-notification-system'
				, 'doc_link'		=> 'http://wordpress.org/plugins/wp247-extension-notification-server'
				, 'review_link'		=> 'http://wordpress.org/support/view/plugin-reviews/wp247-extension-notification-server'
				, 'support_link'	=> 'http://wordpress.org/support/plugin/wp247-extension-notification-server'
//				, 'parent_slug'		=> ''
				, 'icon'			=> 'dashicons-share-alt2'
				, 'position'		=> 30
				);
}
?>