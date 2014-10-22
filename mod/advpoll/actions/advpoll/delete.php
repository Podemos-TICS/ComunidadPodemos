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

elgg_load_library('advpoll:model');
$guid = get_input('guid');

$poll = get_entity($guid);
$poll_type = $poll->poll_type;
$container = get_entity($poll->container_guid);

if ($poll->canEdit()) {
	if ($poll_type == 'normal') {
		$choices = $poll->getCandidatesArray();
		foreach ($choices as $vote_guid) {
			$vote = get_entity($vote_guid);
			if ($vote->delete()) {
				system_message(elgg_echo('advpoll:candidate:delete:success'));	
			} else {
				register_error(elgg_echo('advpoll:candidate:delete:fail'));
			}
		}
	}
	if ($poll->delete()) {
		system_message(elgg_echo('advpoll:delete:success'));
		if (elgg_instanceof($container, 'group')) {
			forward("advpoll/group/$container->guid/all");
		} else {
			forward("advpoll/owner/$container->username");
		}
	}
} else {
	register_error(elgg_echo('advpoll:delete:notsuccess'));
}
forward(REFERER);
