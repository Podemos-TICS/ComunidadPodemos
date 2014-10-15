<?php
/**
 * View for proposal object
 *
 * @package Proposals
 *
 * @uses $vars['entity']    The proposal object
 * @uses $vars['full_view'] Whether to display the full view
 */

echo elgg_view('crud/object', $vars);

if (elgg_extract('full_view', $vars, FALSE)) {
	
	$entity = elgg_extract('entity', $vars, FALSE);

	$options = array('guid' => $entity->guid, 'annotation_name' => 'votes', 'limit' => 0);
	$annotations = elgg_get_annotations($options);

	if ($annotations) {
		echo elgg_view_annotation_list($annotations);
	}
}
