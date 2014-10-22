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

$desc = get_input('description');
$path = get_input('path');
$tags = string_to_tag_array(get_input('tags'));
$access_id = get_input('access_id');
$guid = intval(get_input('guid'));
$access_vote_id = get_input('access_vote_id');
$can_change_vote = get_input('can_change_vote');
$poll_closed = get_input('poll_closed');
$poll = get_entity($guid);
$start_date = get_input('start_date');
$end_date = get_input('end_date');

if (!$end_date) {
	$end_date = time() + 31536000 ;	
}

if (!$start_date) {
	$start_date = time();	
}

if ($start_date > $end_date) {
	register_error(elgg_echo('advpoll:error:wrong_dates'));
} else {
	// write to database	
	$poll->description = $desc;
	$poll->path = $path;
	$poll->access_id = $access_id;
	$poll->tags = $tags;
	$poll->guid = $guid;
	$poll->end_date = $end_date;
	$poll->start_date = $start_date;
	$poll->access_vote_id = $access_vote_id;
	$poll->can_change_vote = $can_change_vote;
	
	$guid2 = $poll->save();
	
	if ($guid2){
		system_message(elgg_echo('advpoll:saved'));
		forward($poll->getURL());
	}
	else {
		register_error(elgg_echo('advpoll:error:save'));
		forward(REFERER); // REFERER is a global variable that defines the previous page
	}
}
