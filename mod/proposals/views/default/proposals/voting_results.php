<?php

	$entity = elgg_extract('entity', $vars, FALSE);

	$options = array('guid' => $entity->guid, 'annotation_name' => 'votes');
	$annotations = elgg_get_annotations($options);

	if ($annotations) {
		echo elgg_view_annotation_list($annotations);
		echo elgg_view('output/url', array(
			'text' => elgg_echo('more'),
			'href' => $entity->getURL(),
		));
	} else {
		echo elgg_echo('proposals:votes:no_comments');
	}
