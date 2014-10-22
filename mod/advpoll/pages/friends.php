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

$title = elgg_echo('advpoll:title');
$page_owner = elgg_get_logged_in_user_entity();

elgg_push_breadcrumb($page_owner->name, "advpoll/friends/" . $page_owner->name);
elgg_push_breadcrumb(elgg_echo('friends'));
//get all polls order by date
$content = list_user_friends_objects($page_owner->guid, 'advpoll', 5, false);

elgg_register_title_button('advpoll', 'new');
$filters = elgg_view('advpoll/filters', array(
	'filter_context' => 'friends',
	'context' => 'advpoll'
	));

// llama a la vista 'content' del core registrada en el archivo
// views/default/pages/layout/content.php
$body = elgg_view_layout('content', array(
	'content' => $content,
	'title' => $title,
	'filter' => $filters,
	'filter_context' => 'friends',
	'sidebar' => ''
));


echo elgg_view_page($title, $body);
