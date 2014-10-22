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

$group = elgg_get_page_owner_entity();

if ($group->polls_enable == "no") {
	return true;
}

$all_link = elgg_view('output/url', array(
	'href' => "advpoll/group/$group->guid/all",
	'text' => elgg_echo('link:view:all'),
	'is_trusted' => true,
));

elgg_push_context('widgets');
$options = array(
	'type' => 'object',
	'subtype' => 'advpoll',
	'container_guid' => $group->guid,
	'limit' => 6,
	'full_view' => false,
	'pagination' => false,
);



$content = elgg_list_entities($options);

elgg_pop_context();

if (!$content) {
	$content = '<p>' . elgg_echo('advpoll:none') . '</p>';
}

$new_link = elgg_view('output/url', array(
	'href' => "advpoll/new/$group->guid",
	'text' => elgg_echo('advpoll:new'),
	'is_trusted' => true,
));

echo elgg_view('groups/profile/module', array(
	'title' => elgg_echo('advpoll:group'),
	'content' => $content,
	'all_link' => $all_link,
	'add_link' => $new_link,
));
