<?php
// Don't allow direct execution
defined( 'ABSPATH' ) or die ( 'Forbidden' );

function wp247_extension_notification_server_admin_fields( $caller ) {

	global $wp247xns_server_notices;
	
	$settings_fields = array(
		'wp247xns_server_extension' => array(
			array(
				'name' => 'extension_name',
				'label' => $caller->__( 'Name' ),
				'type' => 'text',
				'size' => 'regular',
				),
			array(
				'name' => 'extension_slug',
				'label' => $caller->__( 'ID' ),
				'desc' => $caller->__( 'This should be the slug that matches your extension\'s directory name.' ) . '<br/>',
				'type' => 'text',
				'size' => 'regular',
				),
			array(
				'name' => 'extension_type',
				'label' => $caller->__( 'Type' ),
				'type' => 'select',
				'options' => array( 'plugin' => $caller->__( 'Plugin' ), 'theme' => $caller->__( 'Theme' ) ),
				),
			array(
				'name' => 'server_url',
				'label' => $caller->__( 'Server URL' ),
				'desc' => $caller->__( 'The URL where notice check requests will be handled.' ) . $caller->__( 'Default: ' ) . $caller->get_default_server_url(),
				'type' => 'text',
				'size' => 'regular',
				'default' => $caller->get_default_server_url(),
				),
			array(
				'name' => 'frequency',
				'label' => $caller->__( 'Inquiry Frequency' ),
				'desc' => $caller->__( 'The frequency which your server will be called to check for new notices.' ),
				'type' => 'text',
				'size' => 'regular',
				'default' => '1 day',
				'sanitize_callback' =>
					function ( $option_value, $option_slug )
					{
						if ( empty( $option_value ) ) $option_value = '1 day';
						else if ( false == strtotime( $option_value, 0 ) or strtotime( $option_value, 0 ) > strtotime( '1 year', 0 ) )
						{
							$option_value = '1 day';
						}
						return $option_value;
					}
				),
			),
		'wp247xns_server_notice' => array(
			array(
				'name' => 'status',
				'label' => $caller->__( 'Status' ),
				'type' => 'select',
				'options' => array( 'active' => $caller->__( 'Active' ), 'inactive' => $caller->__( 'Inactive' ) ),
				),
			array(
				'name' => 'notice_title',
				'label' => $caller->__( 'Title' ),
				'type' => 'text',
				'size' => 'regular',
				),
			array(
				'name' => 'notice_type',
				'label' => $caller->__( 'Type' ),
				'type' => 'select',
				'options' => array(
								 'info' => $caller->__( 'Informatioin (blue bar)' )
								,'success' => $caller->__( 'Success (green bar)' )
								,'warning' => $caller->__( 'Warning (yellow bar)' )
								,'error' => $caller->__( 'Error (red bar)' )
								,'nag' => $caller->__( 'Nag (use with restraint)' )
								),
				'default' => 'info',
				),
			array(
				'name' => 'dismiss',
				'label' => $caller->__( 'Dismissability' ),
				'type' => 'select',
				'options' => array(
								 'none' => $caller->__( 'None' )
								,'temp' => $caller->__( 'Temporary' )
								,'perm' => $caller->__( 'Permenant' )
								),
				'default' => 'perm',
				),
			array(
				'name' => 'duration',
				'label' => $caller->__( 'Duration' ),
				'desc' => '<p>' . $caller->__( 'How long should this notice be in effect? This can be an actual date or some period of time to be added to the current date/time. E.g. "8 hours" or "2 days".' ) . '</p><p>' . $caller->__( 'Default: "30 days".' ) . '</p>',
				'type' => 'text',
				'size' => 'regular',
				'default' => '30 days',
				'sanitize_callback' =>
					function ( $option_value, $option_slug )
					{
						if ( empty( $option_value ) ) $option_value = '30 days';
						else if ( false == strtotime( $option_value, 0 ) or strtotime( $option_value, 0 ) > strtotime( '1 year', 0 ) )
						{
							$option_value = '30 days';
						}
						return $option_value;
					}
				),
			array(
				'name' => 'expiration_date',
				'label' => 'Expiration',
				'intro' => $caller->__( 'This notice will expire on:' ),
				'type' => 'text',
				'size' => 'small',
				'default' => gmdate( 'Y-m-d', strtotime( '30 days' ) ),
				'options' => array( 'readonly' => true ),
				'sanitize_callback' =>
					function ( $caller, $option_value, $option_slug )
					{
						$duration = ( isset( $_POST[ 'wp247xns_server_settings' ][ 'duration' ] ) and !empty( $_POST[ 'wp247xns_server_settings' ][ 'duration' ] ) ) ? $_POST[ 'wp247xns_server_settings' ][ 'duration' ] : '30 days';
						$expire = strtotime( $duration, 0 );
						if ( $expire < strtotime( '2010/01/01' ) ) $expire = strtotime( $duration );
						$option_value = gmdate( 'Y-m-d', $expire );
						return $option_value;
					}
				),
			array(
				'name' => 'content',
				'label' => $caller->__( 'Content' ),
				'type' => 'wysiwyg',
				'size' => '100%',
				),
			array(
				'name' => 'preview_button',
				'type' => 'html',
				'desc' => '<button class="button button-primary wp247xns-server-notice-preview-button">'.$caller->__( 'Preview Notice' ).'</button>'
				),
			),
	);

	return $settings_fields;
}
?>