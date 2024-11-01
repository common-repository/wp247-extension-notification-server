<?php
// Don't allow direct execution
defined( 'ABSPATH' ) or die ( 'Forbidden' );

function wp247_extension_notification_server_admin_sections( $caller ) {
	global $wp247_mobile_detect;
	$sections = array(
		array(
			'id' => 'wp247xns_server_extension',
			'title' => $caller->__( 'Extension' ),
			'desc' => ''
		),
		array(
			'id' => 'wp247xns_server_notice',
			'title' => $caller->__( 'Notice' ),
			'desc' => ''
		),
	);
	return $sections;
}
?>