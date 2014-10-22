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
$poll_closed = $poll->poll_closed;
$poll_type = $poll->poll_type;
$user_guid = elgg_get_logged_in_user_guid();
$audit = $poll->audit;
$end_date = $poll->end_date;
$start_date = $poll->start_date;
$show_results = $poll->show_results;
$can_change_vote = $poll->can_change_vote;

$acceso_lectura = $poll->access_id;
$access_vote = $poll->access_vote_id;
$acceso_col = get_access_array($user_guid);

if (!in_array($acceso_lectura, $acceso_col)) {
	forward(REFERER);
} else {	
	// Esto de abajo sirve para que aparezca en el menu lateral las opciones
	// de grupo y de usuario al que pertenece la votación
	$container_guid = $poll->container_guid;
	$container = get_entity($container_guid);
	
	if (elgg_instanceof($container, 'group')) {
		elgg_push_breadcrumb($container->name, "advpoll/group/$container->guid/");
	} else {
		elgg_push_breadcrumb($container->name, "advpoll/owner/$container->username");
	}
	elgg_push_breadcrumb($poll->title);
	
	elgg_set_page_owner_guid($container->getGUID());
	elgg_register_title_button('advpoll', 'new');
	$title = $poll->title;
	
	$content = elgg_view_entity($poll, array('full_view' => true));
	if (user_has_voted($user_guid, $guid) &&
			is_poll_on_date($poll) && in_array($access_vote, $acceso_col) &&
			$can_change_vote == 'yes') {
		$content .= elgg_view('input/button', array(
			'class' => 'pulsa-que-se-expande',
			'value' => elgg_echo('advpoll:condorcet:pulsar:cambio'),
		));
		
	}
	
	if ($audit == 'yes' && ($show_results == 'yes' or !is_poll_on_date($poll))) {
		$content .= elgg_view('input/button', array('class' => 'expandable-results', 'value' => elgg_echo('advpoll:condorcet:audit:mostrar'))); 
	}
	
	if ($poll_type == 'condorcet') {
		if (is_poll_on_date($poll) && in_array($access_vote, $acceso_col)) {
			$content .= elgg_view_form('advpoll/condorcet_vote' , array() , array(
				'guid' => $guid,
				));
		}	
		if ($show_results == 'yes' or !is_poll_on_date($poll)) {
			$content .= elgg_view('advpoll/condorcet_results', array(
				'guid' => $guid
			));
		}
	} else { // normal
		if (is_poll_on_date($poll) && in_array($access_vote, $acceso_col)) {
			$content .= elgg_view_form('advpoll/vote' , array() , array(
				'guid' => $guid,
				));
		
		}
		if ($show_results == 'yes' or !is_poll_on_date($poll)) {
			$content .= elgg_view('advpoll/results', array(
			'advpoll' => $poll
			));
		}
	}
	
	$content .= elgg_view_comments($poll);
	$body = elgg_view_layout('content', array(
		'title' => $title,
		'content' => $content,
		'filter' => '',
		));
		
	echo elgg_view_page('', $body);
}
	
?>
<script>
$(".expandable-results").click(function () {
if ($(".audit-extendible").is(":hidden")) {
$(".audit-extendible").slideDown("slow");
} else {
$(".audit-extendible").hide();
}
});

$(".pulsa-que-se-expande").click(function () {
		if ($(".parrafo-extendible").is(":hidden")) {
			$(".parrafo-extendible").slideDown("slow");
		} else {
			$(".parrafo-extendible").hide();
	}
});
	$(function() {
		$( "#ordenable" ).sortable();
		$( "#ordenable" ).disableSelection();
	});
	</script>


 
