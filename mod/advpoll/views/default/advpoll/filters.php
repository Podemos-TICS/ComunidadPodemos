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

/**
 * Main content filter
 *
 * Select between user, friends, and all content
 *
 * @uses $vars['filter_context']  Filter context: all, friends, mine
 * @uses $vars['filter_override'] HTML for overriding the default filter (override)
 * @uses $vars['context']         Page context (override)
 */

if (isset($vars['filter_override'])) {
	echo $vars['filter_override'];
	return true;
}

$context = elgg_extract('context', $vars, elgg_get_context());

if (elgg_is_logged_in() && $context) {
	$username = elgg_get_logged_in_user_entity()->username;
	$filter_context = elgg_extract('filter_context', $vars, 'all');

	// generate a list of default tabs
	$tabs = array(
		'current' => array(
			'text' => elgg_echo('advpoll:filters:current'),
			'href' => (isset($vars['current_link'])) ? $vars['current_link'] : "$context/current",
			'selected' => ($filter_context == 'current'),
			'priority' => 100,
		),
		'all' => array(
			'text' => elgg_echo('advpoll:filters:all'),
			'href' => (isset($vars['all_link'])) ? $vars['all_link'] : "$context/all",
			'selected' => ($filter_context == 'all'),
			'priority' => 200,
		),
		'owner' => array(
			'text' => elgg_echo('advpoll:filters:owner'),
			'href' => (isset($vars['owner_link'])) ? $vars['owner_link'] : "$context/owner/$username",
			'selected' => ($filter_context == 'owner'),
			'priority' => 300,
		),
		'friends' => array(
			'text' => elgg_echo('advpoll:filters:friends'),
			'href' => (isset($vars['friends_link'])) ? $vars['friends_link'] : "$context/friends/$username",
			'selected' => ($filter_context == 'friends'),
			'priority' => 400,
		),
		'ended' => array(
			'text' => elgg_echo('advpoll:filters:ended'),
			'href' => (isset($vars['ended_link'])) ? $vars['ended_link'] : "$context/ended",
			'selected' => ($filter_context == 'ended'),
			'priority' => 500,
		),
		'not_initiated' => array(
			'text' => elgg_echo('advpoll:filters:not_initiated'),
			'href' => (isset($vars['not_initiated_link'])) ? $vars['not_initiated_link'] : "$context/not_initiated",
			'selected' => ($filter_context == 'not_initiated'),
			'priority' => 600,
		),
			);
	
	foreach ($tabs as $name => $tab) {
		$tab['name'] = $name;
		
		elgg_register_menu_item('filter', $tab);
	}

	echo elgg_view_menu('filter', array('sort_by' => 'priority', 'class' => 'elgg-menu-hz'));
}
