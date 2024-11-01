=== WP247 Extension Notification Server ===
Contributors: wescleveland
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=RM26LBV2K6NAU
Tags: extension, plugin, theme, notice, notification, message
Requires at least: 4.0
Requires PHP: 5.6.31
Tested up to: 4.9.1
Stable tag: 1.0.1
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Provides the ability for WordPress extension developers to send notification messages to their users

== Description ==

= OVERVIEW =

The strength of WordPress is in it's ability to be customized through the use of extensions (plugins and themes).

The **WP247 Extension Notification System** provides a standard interface for WordPress extension developers to communicate important information about their extension to their extension users.

The *Settings* page provides you with complete control over which extensions the **WP247 Extension Notification System** will communicate with and which notices will continue to be displayed.

= NOTICES =

The **WP247 Extension Notification System** will display notices until they are dismissed. The extension developer assigns one of three dismissibility types to each notice they send:

- **None** indicates that the notice is not dismissible. The *dismiss* button will not appear.
- **Temporary** indicates that the notice will be temporarily dismissed when you click the *dismiss* button. Once dismissed, the notice will not appear until the next time the Admin page is refreshed.
- **Permanent** indicates that the notice will be permanently dismissed when you click the *dismiss* button. Once dismissed, the notice will not appear again.

Regardless of the dimissibility setting chosen by the extension developer, you can permanently dismiss any notice by clicking the *Permanently Dismiss* link at the lower right of the notice or by checking the checkbox next to the notice title in the **WP247 Extension Notification System**'s *Settings* section.

= SETTINGS =

The **WP247 Extension Notification Server** Settings page is where you tell the **WP247 Extension Notification Server** about your extension and notices.

**Extension**

The *Extension* section is where you identify your extension. This information will also be used in your extension's code (see the API help topic for more information) when polled by the **WP247 Extension Notification Client** plugin to see which extensions are participating in Extension Notifications. The *Extension* settings are:

- *Extension Name*: The name your extension is known as.
- *Extension Id*: The slug used by your extension. This should match the directory name your extension get installed into.
- *Extension Type*: The type of extention (Plugin or Theme).
- *Server URL*: The URL that will respond to the **WP247 Extension Notification Client** plugin's notice update inquiries.
- *Frequency*: How often should the **WP247 Extension Notification Client** plugin's inquire about new notice updates. 

**Notice**

The *Notice* section is where you compose the notification message that is to be distributed to your extension's users. The *Notice* settings are:

- *Status* indicates whether or not the notice should currently be distributed when the **WP247 Extension Notification Client** plugin inquires about any notice updates.
- *Notice Title*: The title of your notice. This will appear on the first line when the notice is displayed.
- *Notice Type*: The type of notice. This will determine where the notice appears and what color the side border will be.
- *Dismissability*: Whether or not the notice is dismissible and if so, temporarily or permanently. Regardless of this setting, the WP247 Extension Notification Client plugin will allow the client site to permanently dismiss any notice.
- *Duration*: Identifies how long should this notice be displayed to the client.
- *Notice Content*: The message you desire to send.

=API=

In order to use the **WP247 Extension Notification System** you must first configure your extension information. This will then be used in your extension to tell the **WP247 Extension Notification System** that your extension is participting in extension notifications.

You will then need to modify your extension so that it reaponds to the *wp247xns_client_extension_poll* filter.

First, you must modify your extension to tell WordPress that you are responding to the *wp247xns_client_extension_poll* filter:

`add_filter( "wp247xns_client_extension_poll_{extension_type}_{extension_id}", "my_routine" );`

Then you must create a function in your extension to respond to the filter:

`function my_routine( $extensions ) {
   return array(
             "name"        => "Your Extension name",
             "id"          => "your-extension-id",
             "type"        => "plugin",
             "version"     => "",          // your extension's version number (not required)
             "server_url"  => "http://your-extension-wordpress-url/wp-admin/admin-ajax.php",
             "frequency"   => "1 day",     // (not required) defaults to "1 day"
          );
}`

That's it. The **WP247 Extension Notification System** will take care of the rest!

= Co-requisite =

One final note. In order for your users to receive your notices, they must have installed and activated the **WP247 Extension Notification Client** plugin. You may want to prompt your users to install and activate this plugin if it is not active at the time your extension is loaded. For your convenience, we have provided a standardized method for accomplishing this.

First, copy the */wp-content/plugins/wp247-extension-notification-server/admin/wp247xns-client-corequisite-notice* folder to your extension's Admin folder.

Next, modify your extension to instantiate the **WP247XNS_Client_Corequisite_Notice** class. Something like:

`require_once 'wp247xns-client-corequisite-notice/wp247xns-client-corequisite-notice.php';
$my_wp247xns_client_corequisite_notice
	= new WP247XNS_Client_Corequisite_Notice( 'Your extension name' );`

The **WP247XNS_Client_Corequisite_Notice** class constructor takes from one to three parameters:

`WP247XNS_Client_Corequisite_Notice(
	$extension_name,
	$nag_frequency = '30 days',
	$text_domain = 'wp247xns-client-corequisite-notice'
);`

This will result in a notice being displayed to your extension's users when either the **WP247 Extension Notification Client** plugin is not activated or your particular extension is not enabled to participate in the **WP247 Extension Notification System**. They will be able to dismiss the nottice, but it will be re-displayed after the nag frequency has passed.

= Privacy Policy =

Rest assured that the **WP247 Extension Notification System** does not capture any information about your site and does not send any information about your site when servers are polled for new notices.

In addition, the **WP247 Extension Notification System** does not capture any information from the client's site.

== Installation ==

In the WordPress backend:

- Go to Plugins->Add New
- Search for the plugin '**WP247 Extension Notification Server**'
- Click the "Install" button
- Click on "Activate"

That's it. You're now ready to build and send extension notification messages.

== Screenshots ==

1. Extension Notification Server Settings - Extension
2. Extension Notification Server Settings - Notice
3. Extension Notification Server Help - Overview
4. Extension Notification Server Help - Notices
5. Extension Notification Server Help - Settings
6. Extension Notification Server Help - API
7. Extension Notification Server Help - Co-requisite
8. Extension Notification Server Help - Privacy Policy

== Changelog ==

= 1.0.1 =
Fix Settings API bug

= 1.0 =
Initial release

== Upgrade Notice ==

= 1.0 =
Initial release