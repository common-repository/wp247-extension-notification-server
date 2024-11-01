<?php
/*
	Extension Name: WP247 Extension Notification Server Pro - Admin Functions
	Version: 1.0
	Description: Provides the ability for extension developers to send notification messages to their extension users

	Tags: extension, notice, notification, message
	Author: wp247
	Author URI: http://wp247.net/
*/

// Don't allow direct execution
defined( 'ABSPATH' ) or die( 'Forbidden' );

if ( !class_exists( 'WP247XNS_Server' ) )
{
	define( 'WP247XNS_SERVER_PLUGIN_ADMIN_PATH', plugin_dir_path( __FILE__ ) );
	require_once WP247XNS_SERVER_PLUGIN_ADMIN_PATH . '/wp247-settings-api/wp247-settings-api.php';
	
	/**
	 * WP247XNS_Server Class
	 *
	 * Provides all.
	 *
	 * @return void
	 */
	class WP247XNS_Server extends WP247_settings_API_2
	{

		/**
		 * WP247XNS Corequisite Notice
		 */
		private $wp247xns_client_corequisite_notice;

		/**
		 * Class constructor
		 *
		 * Prepare each instance for use - should only happen once.
		 *
		 * @return void
		 */
		function __construct()
		{
			$this->add_action( 'init', 'do_action_init' );
			parent::__construct();
		}

		/**
		 * Do WordPress 'init' action
		 *
		 * Prepare for AJAX requests and setup for manage options pages.
		 *
		 * @return void
		 */
		function do_action_init()
		{
			if ( is_admin() )
			{
				$this->add_action( 'wp_ajax_wp247xns_server_inquire', 'do_action_wp_ajax_wp247xns_server_inquire' );
				$this->add_action( 'wp_ajax_nopriv_wp247xns_server_inquire', 'do_action_wp_ajax_wp247xns_server_inquire' );
				$this->add_filter( 'wp247xns_client_extension_poll_plugin_'.WP247XNS_SERVER_PLUGIN_ID, 'do_filter_wp247xns_client_extension_poll' );
				if ( current_user_can( 'manage_options' ) )
				{
					require_once WP247XNS_SERVER_PLUGIN_ADMIN_PATH . '/wp247xns-client-corequisite-notice/wp247xns-client-corequisite-notice.php';
					$this->wp247xns_client_corequisite_notice = new WP247XNS_Client_Corequisite_Notice( WP247XNS_SERVER_PLUGIN_NAME, '7 days' );
				}
			}
		}

		/**
		 * Returns the Admin Menu
		 *
		 * @return void
		 */
		function get_settings_admin_menu()
		{
			require_once WP247XNS_SERVER_PLUGIN_ADMIN_PATH . 'wp247-extension-notification-server-admin-menu.php';
			return wp247_extension_notification_server_admin_menu( $this );
		}

		/**
		 * Returns the Admin Help
		 *
		 * @return void
		 */
		function get_settings_admin_help()
		{
			require_once WP247XNS_SERVER_PLUGIN_ADMIN_PATH . 'wp247-extension-notification-server-admin-help.php';
			return wp247_extension_notification_server_admin_help( $this );
		}

		/**
		 * Returns the Admin Help Sidebar
		 *
		 * @return void
		 */
		function get_settings_admin_help_sidebar()
		{
			require_once WP247XNS_SERVER_PLUGIN_ADMIN_PATH . 'wp247-extension-notification-server-admin-help-sidebar.php';
			return wp247_extension_notification_server_admin_help_sidebar( $this );
		}

		/**
		 * Returns all the settings sections
		 *
		 * @return array settings sections
		 */
		function get_settings_sections()
		{
			require_once WP247XNS_SERVER_PLUGIN_ADMIN_PATH . 'wp247-extension-notification-server-admin-sections.php';
			return wp247_extension_notification_server_admin_sections( $this );
		}

		/**
		 * Returns all the settings fields
		 *
		 * @return array settings fields
		 */
		function get_settings_fields()
		{
			require_once WP247XNS_SERVER_PLUGIN_ADMIN_PATH . 'wp247-extension-notification-server-admin-fields.php';
			return wp247_extension_notification_server_admin_fields( $this );
		}

		/**
		 * Returns all the settings infobar
		 *
		 * @return array settings infobar
		 */
		function get_settings_infobar()
		{
			require_once WP247XNS_SERVER_PLUGIN_ADMIN_PATH . 'wp247-extension-notification-server-admin-infobar.php';
			return wp247_extension_notification_server_admin_infobar( $this );
		}

		/**
		 * Returns the infobar width
		 *
		 * @return integer infobar width
		 */
		function get_infobar_width()
		{
			require_once WP247XNS_SERVER_PLUGIN_ADMIN_PATH . 'wp247-extension-notification-server-admin-infobar.php';
			return wp247_extension_notification_server_admin_infobar_width();
		}

		/**
		 * Enqueue scripts and styles
		 */
		function enqueue_scripts()
		{
			wp_enqueue_style( 'wp247xns-server-admin-style', plugins_url( 'wp247-extension-notification-server-admin.css', __FILE__ ) );
			wp_enqueue_script( 'wp247xns-server-admin-script', plugins_url( 'wp247-extension-notification-server-admin.js', __FILE__ ), array( 'jquery' ) );
		}

		/**
		 * Returns the head scripts and styles
		 *
		 * @return string head scripts and styles
		 * @return array  head scripts and styles
		 */
		function get_head_scripts()
		{
			return array( '<style> .wp247sapi-form input.indent { margin-left: 32px; } .wp247sapi-actions.indent { margin-left: 58px; }</style>' );
		}

		/**
		 * Get Notification Extension default meta data
		 *
		 * @return array containing extension default meta values
		 */
		function get_extension_default_meta()
		{
			return array(
						 'status'			=> 'active'
						,'extension_name'	=> ''
						,'extension_slug'	=> ''
						,'extension_type'	=> 'plugin'
						,'server_url'		=> $this->get_default_server_url()
						,'frequency'		=> '1 day'
					);
		}

		/**
		 * Get Notification Notice default meta data
		 *
		 * @return array containing notice default meta values
		 */
		function get_notice_default_meta()
		{
			return array(
						 'title'			=> ''
						,'notice_slug'		=> 'only-notice'
						,'reset'			=> 'no'
						,'priority'			=> ''
						,'duration'			=> '30 days'
						,'notice_type'		=> 'info'
						,'dismiss'			=> 'perm'
						,'content'			=> ''
						,'date'				=> ''
						,'expiration_date'	=> ''
					);
		}

		/**
		 * Get default server url
		 *
		 * @return url default server url
		 */
		function get_default_server_url()
		{
			return admin_url( 'admin-ajax.php' );
		}

		/**
		 * Handle the wp247xns_inquire AJAX request
		 *
		 * @return void ( issues wp_die() - so technically does not return )
		 */
		function do_action_wp_ajax_wp247xns_server_inquire()
		{
			include WP247XNS_SERVER_PLUGIN_ADMIN_PATH . 'wp247-extension-notification-server-ajax.php';
		}

		/**
		 * Add WordPress Actions
		 *
		 * @return void
		 */
		private function add_action( $action, $function, $priority = null, $args = null )
		{
			$func = array( $this, $function );
			if ( is_null( $args ) and is_null( $priority ) ) add_action( $action, $func );
			else if ( is_null( $args ) ) add_action( $action, $func, $priority );
			else add_action( $action, $func, $priority, $args );
		}

		/**
		 * Add WordPress Filters
		 *
		 * @return void
		 */
		private function add_filter( $filter, $function, $priority = null, $args = null )
		{
			$func = array( $this, $function );
			if ( is_null( $args ) and is_null( $priority ) ) add_action( $filter, $func );
			else if ( is_null( $args ) ) add_action( $filter, $func, $priority );
			else add_action( $filter, $func, $priority, $args );
		}

		/*
		 * Tell WP247 Extension Notification Client about us
		 *
		 * @param  array extensions
		 *
		 * @return array extensions
		 */
		function do_filter_wp247xns_client_extension_poll( $extensions )
		{
			return array(
						 'id'			=> WP247XNS_SERVER_PLUGIN_ID
						,'version'		=> WP247XNS_SERVER_VERSION
						,'name'			=> 'WP247 Extension Notification Server'
						,'type'			=> 'plugin'
						,'server_url'	=> 'http://wp247.net/wp-admin/admin-ajax.php'
						,'frequency'	=> '1 day'
					);
		}

		/**
		 * Return localized string
		 *
		 * @return string
		 */
		function __( $string )
		{
			return __( $string, WP247XNS_SERVER_PLUGIN_TEXT_DOMAIN );
		}

		/**
		 * Outpue localized string
		 *
		 * @return void
		 */
		function _e( $string )
		{
			_e( $string, WP247XNS_SERVER_PLUGIN_TEXT_DOMAIN );
		}

	}

	global $wp247xns_server; $wp247xns_server = new WP247XNS_Server();
}