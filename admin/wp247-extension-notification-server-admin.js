/*
 * wp247 Extension Notification System Server Javascript
*/
jQuery( document ).ready( function($)
{
	// Handle Preview Notice request
	$('body').append('<div id="wp247xns_server_notice_preview_blackout"></div>');
	$('body').append('<div id="wp247xns_server_notice_preview_dialog"><div id="wp247xns_server_notice_preview_close"><span class="dashicons dashicons-no"></span></div><div class="clear"></div><div id="wp247xns_server_notice_preview_content"></div></div>');
	$('button.wp247xns-server-notice-preview-button').click( function() {
		var content = $("#wp247xns_server_notice-content_ifr").contents().find(".wp247xns_server_notice-content").html();
		var title = $("input[name='wp247xns_server_notice[notice_title]']").val();
		var type = $("select[name='wp247xns_server_notice[notice_type]']").val();
		if ( 'nag' == type ) type = 'update-nag';
		else type = 'notice-' + type;
		$('#wp247xns_server_notice_preview_content').html( '<div class="notice '+type+'"><div><h3>'+title+'</h3><p>'+content+'</p></div><div class="clear"></div><p style="width: 100%; text-align: right;"><a><span class="dashicons-before dashicons-dismiss">Permenantly Dismiss</span></a></p></div>' );
		$('#wp247xns_server_notice_preview_blackout').fadeIn();
		$('#wp247xns_server_notice_preview_dialog').fadeIn();
		return false;
	});

	$('body').on('click', '#wp247xns_server_notice_preview_close, #wp247xns_server_notice_preview_blackout, #wp247xns_server_notice_preview_content .dashicons-dismiss',  function() {
		$('#wp247xns_server_notice_preview_dialog').fadeOut();
		$('#wp247xns_server_notice_preview_blackout').fadeOut();
	});

} );