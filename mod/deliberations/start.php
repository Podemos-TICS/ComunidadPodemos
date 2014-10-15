<?php
/****
*
*
***/
elgg_register_event_handler('init', 'system', 'deliberations_init');

/**
 * Init deliberations plugin.
 */
function deliberations_init() {

	// add to the main css
	//elgg_extend_view('css/elgg', 'deliberations/css');

	// notifications
	register_notification_object('object', 'deliberations', elgg_echo('deliberations:newpost'));
	elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'deliberations_notify_message');

	// handler for link to assembly menu item
	//elgg_register_plugin_hook_handler('crud:decision:view_buttons', 'view_buttons', 'assemblies_decision_view_buttons');

	// Add group option
	add_group_tool_option('deliberations', elgg_echo('deliberations:enabledeliberations'), false);
	
	elgg_extend_view('groups/profile/summary','deliberations/group_module'); 

	// add a deliberations widget
	elgg_register_widget_type('deliberations', elgg_echo('deliberations'), 
	
	// register actions
	$action_path = elgg_get_plugins_path() . 'deliberations/actions/deliberations';
	elgg_register_action("deliberations/vote", "$action_path/vote.php");
}