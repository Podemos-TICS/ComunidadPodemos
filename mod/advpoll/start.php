<?php
/**
 * Polls plugin for elgg-1.8
 * Copyright 2012 Lorea, DRY Team
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 */

elgg_register_event_handler('init', 'system', 'advpoll_init');

/*
 * Init polls plugin
 */
function advpoll_init() {
	// Register classes
	elgg_register_entity_type('object', 'advpoll');
	add_subtype('object', 'advpoll', 'AdvPoll');

	// Register actions
	$action_path = elgg_get_plugins_path() . 'advpoll/actions/advpoll';
	elgg_register_action('advpoll/save', "$action_path/save.php");
	elgg_register_action('advpoll/vote', "$action_path/vote.php");
	elgg_register_action('advpoll/condorcet_vote', "$action_path/vote.php");
	elgg_register_action('advpoll/edit', "$action_path/edit.php");
	elgg_register_action('advpoll/delete', "$action_path/delete.php");
	
	// Es recomendable usar como nombre el mismo que el de la vista de la accion
	// como primer termino, antes registrándola de este modo
	// elgg_register_action('advpoll/save', "$base_dir/save.php");
	// no tiraba

	// Extend the main CSS file
	elgg_extend_view('css/elgg', 'advpoll/css');

	// Add a menu item to the main site menu
	$item = new ElggMenuItem('polls', elgg_echo('advpoll:menu'), 'advpoll/all');
	// Register menu
	elgg_register_menu_item('site', $item);
	// Register page handlers
	elgg_register_page_handler('advpoll', 'advpoll_page_handler');
	// Register URL addresses handler
	elgg_register_entity_url_handler('object', 'advpoll', 'advpoll_url_handler');
	// Register external libraries
	elgg_register_library('advpoll:model', elgg_get_plugins_path() . 'advpoll/lib/model.php');
	// Groups module
	add_group_tool_option('polls', elgg_echo('advpoll:groups:enablepolls'), true);
	elgg_extend_view('groups/tool_latest', 'advpoll/group_module');
	// Javascript libraries for graphics
	$url = elgg_get_site_url() . "mod/advpoll/lib/js/highcharts.js";
	$url2 = elgg_get_site_url() . "mod/advpoll/lib/js/kinetic-v3.9.4.min.js";
	
	elgg_register_js('highcharts', $url, 'footer', 20000);
	elgg_register_js('kinetic', $url2, 'head', 30000);
	elgg_register_js('grafo-schulze', elgg_get_site_url() . "mod/advpoll/lib/js/grafo-schulze.js", 'head', 40000);
	
	// Register plugin hooks handlers
	elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'advpoll_owner_block_menu');
	
}

/**
 * Dispatches polls pages.
 * URLs take the form of
 *  TODO: add this when names are fixed
 *
 * @param array $page
 * @return bool
 */
function advpoll_page_handler($page)
{
	$base_dir = elgg_get_plugins_path() . 'advpoll/pages/';
	
	elgg_push_breadcrumb(elgg_echo('polls'), 'addpoll/all');
	switch ($page[0]){
		case "all":
			include $base_dir . 'all.php';
			break;
		case "edit":
			set_input('guid', $page[1]);
			include $base_dir . 'edit.php';
			break;
		case "new":
			set_input('container_guid', $page[1]);
			include $base_dir . 'new.php';
			break;
		case "view":
			set_input('guid', $page[1]);
			include $base_dir . 'view.php';
			break;
		case "friends":
			include $base_dir . 'friends.php';
			break;
		case "owner":
			include $base_dir . 'owner.php';
			break;
		case "current":
			set_input('context', $page[0]);
			include $base_dir . 'list.php';
			break;
		case "ended":
			set_input('context', $page[0]);
			include $base_dir . 'list.php';
			break;
		case "not_initiated":
			set_input('context', $page[0]);
			include $base_dir . 'list.php';
			break;
		case "help":
			switch ($page[1]) {
				case "condorcet":
					include $base_dir . 'condorcet_help.php';
					break;
			}
			break;			
		case "group":
			set_input('guid', $page[1]);
			set_input('group_context', $page[2]);
			//if ($page[2] == 'all') {
				include $base_dir . 'group.php';
			//}
			//if ($page[2] == 'cerradas'){
			//	include $base_dir . 'group_cerradas.php';
			//} else {
			//	include $base_dir . 'group_activas.php';
			//}
			break;
				
	}
	
	return true;
}

/**
 * Format and return the URL for polls.
 *
 * @param ElggObject $entity poll object
 * @return string URL of blog.
 */
function advpoll_url_handler($entity) {
	$title = elgg_get_friendly_title($entity->title);
	return "advpoll/view/$entity->guid/$title";
}

/**
 * Add a menu item to an ownerblock
 */
function advpoll_owner_block_menu($hook, $type, $return, $params) {
	if (elgg_instanceof($params['entity'], 'user')) {
		$url = "advpoll/owner/{$params['entity']->username}";
		$item = new ElggMenuItem('polls', elgg_echo('polls'), $url);
		$return[] = $item;
	} else {
		if ($params['entity']->bookmarks_enable != 'no') {
			$url = "advpoll/group/{$params['entity']->guid}/all";
			$item = new ElggMenuItem('polls', elgg_echo('advpoll:group'), $url);
			$return[] = $item;
		}
	}

	return $return;
}
