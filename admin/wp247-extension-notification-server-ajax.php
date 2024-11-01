<?php
/*
	Plugin Name: WP247 Plugin Notification Server AJAX Processing
	Version: 1.0
	Description: Provides the ability for plugin developers to send notification messages to their plugin users

	Tags: plugin, notice, notification, message
	Author: Wes Cleveland
	Author URI: http://wp247.net/
*/

// Don't allow direct execution
defined( 'ABSPATH' ) or die( 'Forbidden' );

global $wpdb;

// Die if we don't have all required parameters
if ( !isset( $_POST[ 'id' ] ) or !isset( $_POST[ 'version' ] ) )
	wp_die();

$request_slug = $_POST[ 'id' ];
$request_version = $_POST[ 'version' ];
$request_last_notification = isset( $_POST[ 'since' ] ) ? $_POST[ 'since' ] : '';

// Die if slug is invalid format
if ( $request_slug != sanitize_title_with_dashes( $request_slug ) )
	wp_die();

$today_gmt = gmdate( 'Y-m-d' );
$now_gmt = gmdate( 'Y-m-d H:i:s' );

$return = array( 'response' => 'OK' );
// Get Plugin meta for the specified plugin slug
$extension = get_option( 'wp247xns_server_extension', array() );
$notice = get_option( 'wp247xns_server_notice', array() );

if ( empty( $extension ) or !isset( $extension[ 'extension_slug' ] ) or $request_slug != $extension[ 'extension_slug' ] )
	$return[ 'response' ] = '404';
else
{
	extract( $extension, EXTR_OVERWRITE );
	extract( $notice, EXTR_OVERWRITE );

	$return[ 'server-url' ] = $server_url;
	$return[ 'frequency' ] = $frequency;
	$return[ 'timestamp' ] = $now_gmt;
	$return[ 'reset' ] = false;

	$return[ 'notices' ] = array();

	if ( 'active' != $status or $expiration_date < $today_gmt  )
	{
		$return[ 'reset' ] = true;
	}
	else if ( empty( $request_last_notification ) or $request_last_notification <= $last_update_time )
	{
		$return[ 'reset' ] = true;
		$return[ 'notices' ][]
			= array( 'function'		=> 'add'
					,'id'			=> sanitize_title_with_dashes( $notice_title )
					,'title'		=> $notice_title
					,'type'			=> $notice_type
					,'dismiss'		=> $dismiss
					,'content'		=> $content
					,'date'			=> substr( $last_update_time, 0, 10 )
					,'expires'		=> $expiration_date
				);
	}
}

ob_clean();
echo json_encode( $return );
wp_die();