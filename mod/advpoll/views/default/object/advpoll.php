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
$poll = $vars['entity'];
$audit = $poll->audit;
$type = $poll->poll_type;
$title = $poll->title;
$desc = $poll->description;
$path = $poll->path;
$acces_id = $poll->access_id;
$owner_guid = $poll->owner_guid;
$container_guid = $poll->container_guid;
$tags = $poll->tags;
$choices = $poll->getCandidatesArray();
$full = elgg_extract('full_view', $vars, FALSE);
$owner =  $poll->getOwnerEntity();
$start_date = $poll->start_date;
$end_date = $poll->end_date;
$time = time();
$show_results = $poll->show_results;
$can_change_vote = $poll->can_change_vote;
if ($time < $end_date ) {
	$poll_comparison_end = 'lessthanend';
} else {
	if ($time >= $end_date ){
		$poll_comparison_end = 'morethanend';
	}
}

if ($time < $start_date) {
	$poll_comparison_start = 'lessthanstart';
}else {
	if ($time >= $start_date ){
		$poll_comparison_start = 'morethanstart';
	}
}


$entity_icon = elgg_view_entity_icon($poll, 'small');

$metadata = elgg_view_menu('entity', array(
	'entity' => $poll,
	'handler' => 'advpoll',
	'sort_by' => 'priority',
	'class' => 'elgg-menu-hz',
));


	
	$url = $poll->path;
	$display_text = $url;
	$excerpt = elgg_get_excerpt($poll->description);
	if ($excerpt) {
		$excerpt = " - $excerpt";
	}

	
	$link = elgg_get_site_url() . "profile/" . $owner->name ;
	$subtitle = elgg_echo('advpoll:owner');
	$subtitle .= elgg_view('output/url', array(
		'href' => $link,
		'text' => $owner->name,
	));
	
	
	
	$subtitle .= '<br>' . elgg_view('output/url', array(
		'href' => $poll->path,
		'text' => elgg_echo('advpoll:previous:discussion:link'),
	));

	$subtitle .= "<br>" . elgg_echo('advpoll:view:ended:' . $poll_comparison_end . ':' . $poll_comparison_start ) . ',';
	if ($poll_comparison_start == 'lessthanstart') {
		$subtitle .= elgg_echo('advpoll:view:time:from') . date('d - M - Y', $start_date) . ', ';
	} 
	if ($poll_comparison_end == 'lessthanend') {
		$subtitle .= elgg_echo('advpoll:view:time:to') .date('d - M - Y', $end_date);
	}
	$subtitle .= elgg_echo('advpoll:view:audit') . elgg_echo('option:' . $audit) . ',';
	$subtitle .= elgg_echo('advpoll:view:type') . elgg_echo('advpoll:type:' . $type) . ',';
	$subtitle .= elgg_echo('advpoll:view:show:results') . elgg_echo('advpoll:show:' . $show_results) . '.';
	$subtitle .= elgg_echo('advpoll:view:can:change:vote') . elgg_echo('advpoll:show:' . $can_change_vote) . '.';

	
	$content .= elgg_view('advpoll/choices', array('choices' => $choices));
	$params = array(
		'entity' => $poll,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'tags' => $tags,
		'content' => $content,
	);
	$params = $params + $vars;
	

if ($full) {
	$body = elgg_view('output/longtext', array('value' => $poll->description));
	$entity_icon = elgg_view_entity_icon($poll, 'small');
	$summary = elgg_view('object/elements/summary', $params);

	echo elgg_view('object/elements/full', array(
		'entity' => $poll,
		'title' => '',
		'icon' => $entity_icon,
		'summary' => $summary,
		'body' => $body,
	));

} else {
	$body = elgg_view('object/elements/summary', $params);
	
	echo elgg_view_image_block($entity_icon, $body);
}

