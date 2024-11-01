<?php
// Don't allow direct execution
defined( 'ABSPATH' ) or die( 'Forbidden' );

function wp247_extension_notification_server_admin_help( $caller )
{
	$extension = get_option( 'wp247xns_server_extension', array() );

	$help = array();
	
	// Overview
	$help[]
		= array(
			 'title'	=> $caller->__( 'Overview' )
			,'id'		=> 'wp247xns_server_help_overview'
			,'content'	=> array(
								 $caller->__( 'The strength of WordPress&#174; is in it\'s ability to be customized through the use of extensions (plugins and themes).' )
								,$caller->__( 'The <strong>WP247 Extension Notification System</strong> provides a standard interface for WordPress&#174; extension developers to communicate important information about their extension to their extension users.' )
								,$caller->__( 'The <strong>Settings</strong> page provides you with the ability to build a notice to be sent to your extension users.' )
							)
		);

	// Notices
	$help[]
		= array(
			 'title'	=> $caller->__( 'Notices' )
			,'id'		=> 'wp247xns_server_help_notices'
			,'content'	=> array(
								 $caller->__( 'The <strong>WP247 Extension Notification System</strong> will display notices until they are dismissed. The you can assign one of three dismissibility types to each notice you send:' )
								,'<ul>'
								,'<li>' . $caller->__( '<strong>None</strong> indicates that the notice is not dismissible. The <i>dismiss</i> button will not appear.' ) . '</li>'
								,'<li>' . $caller->__( '<strong>Temporary</strong> indicates that the notice will be temporarily dismissed when you click the <i>dismiss</i> button. Once dismissed, the notice will not appear until the next time the Admin page is refreshed.' ) . '</li>'
								,'<li>' . $caller->__( '<strong>Permanent</strong> indicates that the notice will be permanently dismissed when you click the <i>dismiss</i> button. Once dismissed, the notice will not appear again.' ) . '</li>'
								,'</ul>'
								,$caller->__( 'Regardless of the dimissibility setting you choose, the end user can permanently dismiss any notice by clicking the <i>Permanently Dismiss</i> link at the lower right of the notice or by checking the checkbox next to the notice title in the <strong>WP247 Extension Notification Client</strong>\'s <strong>Settings</strong> section.' )
							)
		);

	// Settings
	$help[]
		= array(
			 'title'	=> $caller->__( 'Settings' )
			,'id'		=> 'wp247xns_server_help_settings'
			,'content'	=> array(
								 $caller->__( 'The <strong>WP247 Extension Notification Server</strong> <strong><i>Settings</i></strong> page is where you tell the <strong>WP247 Extension Notification Server</strong> about your extension and notices.' )
								,'<h3>' . $caller->__( 'Extension' ) . '</h3>'
								,$caller->__( 'The <strong><i>Extension</i></strong> section is where you identify your extension. This information will also be used in your extension\'s code (see the <strong>API</strong> help topic for more information) when polled by the <strong>WP247 Extension Notification Client</strong> plugin to see which extensions are participating in Extension Notifications. The <strong><i>Extension</i></strong> settings are:' )
								,'<ul>'
								,'<li>' . $caller->__( '<strong>Extension Name</strong>: The name your extension is known as.' ) . '</li>'
								,'<li>' . $caller->__( '<strong>Extension Id</strong>: The slug used by your extension. This should match the directory name your extension get installed into.' ) . '</li>'
								,'<li>' . $caller->__( '<strong>Extension Type</strong>: The type of extention (Plugin or Theme).' ) . '</li>'
								,'<li>' . $caller->__( '<strong>Server URL</strong>: The URL that will respond to the <strong>WP247 Extension Notification Client</strong> plugin\'s notice update inquiries.' ) . '</li>'
								,'<li>' . $caller->__( '<strong>Frequency</strong>: How often should the <strong>WP247 Extension Notification Client</strong> plugin\'s inquire about new notice updates. ' ) . '</li>'
								,'</ul>'
								,'<h3>' . $caller->__( 'Notice' ) . '</h3>'
								,$caller->__( 'The <strong><i>Notice</i></strong> section is where you compose the notification message that is to be distributed to your extension\'s users. The <strong><i>Notice</i></strong> settings are:' )
								,'<ul>'
								,'<li>' . $caller->__( '<strong>Status</strong> indicates whether or not the notice should currently be distributed when the <strong>WP247 Extension Notification Client</strong> plugin inquires about any notice updates.' ) . '</li>'
								,'<li>' . $caller->__( '<strong>Notice Title</strong>: The title of your notice. This will appear on the first line when the notice is displayed.' ) . '</li>'
								,'<li>' . $caller->__( '<strong>Notice Type</strong>: The type of notice. This will determine where the notice appears and what color the side border will be.' ) . '</li>'
								,'<li>' . $caller->__( '<strong>Dismissability</strong>: Whether or not the notice is dismissible and if so, temporarily or permanently. Regardless of this setting, the <strong>WP247 Extension Notification Client</strong> plugin will allow the client site to permanently dismiss any notice.' ) . '</li>'
								,'<li>' . $caller->__( '<strong>Duration</strong>: Identifies how long should this notice be displayed to the client.' ) . '</li>'
								,'<li>' . $caller->__( '<strong>Notice Content</strong>: The message you desire to send.' ) . '</li>'
								,'</ul>'
							)
		);

	// API
	$api_content = array(
							 $caller->__( 'In order to use the <strong>WP247 Extension Notification System</strong> you must first configure your extension information. This will then be used in your extension to tell the <strong>WP247 Extension Notification System</strong> that your extension is participting in extension notifications.' )
							,$caller->__( 'You will then need to modify your extension so that it reaponds to the <strong>wp247xns_client_extension_poll</strong> filter.' )
						);
	if ( isset( $extension[ 'extension_name' ] ) and !empty( $extension[ 'extension_name' ] )
	 and isset( $extension[ 'extension_slug' ] ) and !empty( $extension[ 'extension_slug' ] )
	 and isset( $extension[ 'extension_type' ] ) and !empty( $extension[ 'extension_type' ] )
	 and isset( $extension[ 'server_url' ] ) and !empty( $extension[ 'server_url' ] )
	 and isset( $extension[ 'frequency' ] )
	)
	{
		$api_content[] = $caller->__( 'First, you must modify your extension to tell WordPress&#174; that you are responding to the <strong>wp247xns_client_extension_poll</strong> filter:' );
		$api_content[] = '<pre class="wp247sapi-code">add_filter( "wp247xns_client_extension_poll_'.$extension[ 'extension_type' ].'_'.$extension[ 'extension_slug' ].'", "' . $caller->__( 'my_routine' ) . '" );</pre>';
		$api_content[] = $caller->__( 'Then you must create a function in your extension to respond to the filter:' );
		$api_content[] = '<pre class="wp247sapi-code">function ' . $caller->__( 'my_routine' ) . '( $extensions ) {
    return array(
                "name"        => "' . $extension[ 'extension_name' ] . '",
                "id"          => "' . $extension[ 'extension_slug' ] . '",
                "type"        => "' . $extension[ 'extension_type' ] . '",
                "version"     => "",  // ' . $caller->__( '(not required) your extension\'s version number' ) . '
                "server_url"  => "' . $extension[ 'server_url' ] . '",
                "frequency"   => "' . $extension[ 'frequency' ] . '",
            );
}</pre>';
		$api_content[] = $caller->__( 'That\'s it. The <strong>WP247 Extension Notification System</strong> will take care of the rest!' );
	}
	else
	{
		$api_content[] = $caller->__( 'Further instructions will appear here once you\'ve completed the extension information on the <strong>Settings</strong> page.' );
	}

	$help[]
		= array(
				 'title'	=> $caller->__( 'API' )
				,'id'		=> 'wp247xns_server_help_api'
				,'content'	=> $api_content
		);

	// Co-requisite Plugin
	$help[]
		= array(
				 'title'	=> $caller->__( 'Co-requisite' )
				,'id'		=> 'wp247xns_server_help_corequisite'
				,'content'	=> array(
									 $caller->__( 'One final note. In order for your users to receive your notices, they must have installed and activated the <strong>WP247 Extension Notification Client</strong> plugin. You may want to prompt your users to install and activate this plugin if it is not active at the time your extension is loaded. For your convenience, we have provided a standardized method for accomplishing this.' )
									,$caller->__( 'First, copy the <i>'.substr(WP247XNS_SERVER_PLUGIN_ADMIN_PATH,strlen(ABSPATH)-1).'wp247xns-client-corequisite-notice</i> folder to your extension\'s Admin folder.' )
									,$caller->__( 'Next, modify your extension to instantiate the <strong>WP247XNS_Client_Corequisite_Notice</strong> class. Something like:' )
									,'<pre class="wp247sapi-code">require_once \'wp247xns-client-corequisite-notice/wp247xns-client-corequisite-notice.php\';
$my_wp247xns_client_corequisite_notice
	= new WP247XNS_Client_Corequisite_Notice( \'Your extension name\' );</pre>'
									,$caller->__( 'The <strong>WP247XNS_Client_Corequisite_Notice</strong> class constructor takes from one to three parameters:' )
									,'<pre class="wp247sapi-code">WP247XNS_Client_Corequisite_Notice(
	$extension_name,
	$nag_frequency = \'30 days\',
	$text_domain = \'wp247xns-client-corequisite-notice\'
);</pre>'
									,$caller->__( 'This will result in a notice being displayed to your extension\'s users when either the <strong>WP247 Extension Notification Client</strong> plugin is not activated or your particular extension is not enabled to participate in the <strong>WP247 Extension Notification System</strong>. They will be able to dismiss the nottice, but it will be re-displayed after the nag frequency has passed.' )
								)
		);

	$help[]
		= array(
			 'title'	=> $caller->__( 'Privacy Policy' )
			,'id'		=> 'wp247xns_server_help_privacy_policy'
			,'content'	=> array(
								 $caller->__( 'Rest assured that the <strong>WP247 Extension Notification System</strong> does not capture any information about your site and does not send any information about your site when servers are polled for new notices.' )
								,$caller->__( 'In addition, the <strong>WP247 Extension Notification System</strong> does not capture any information from the client\'s site.' )
							)
		);

	return $help;
}