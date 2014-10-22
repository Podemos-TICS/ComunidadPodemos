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
$guid = elgg_extract('guid', $vars, '');
$poll = get_entity($guid);
$candidates = $poll->getCandidatesArray();
$owner_guid = elgg_get_logged_in_user_guid();

if (user_has_voted($owner_guid, $guid)) {
	echo '<div class=\'parrafo-extendible\'>';
}
?>
<br>
<h3><?php echo elgg_echo('advpoll:candidate:vote'); ?></h3><br />
<?php
echo elgg_view('input/radio', array(
	'name' => 'response', 
	'options' => $candidates,
));
echo elgg_view('input/hidden', array(
	'name' => 'guid',
	'value' => $guid
));
echo elgg_view('input/hidden', array(
	'name' => 'owner_guid',
	'value' => $owner_guid,
));
echo '<br>';	
echo elgg_view('input/submit', array('value' => elgg_echo("vote")));
if (user_has_voted($owner_guid, $guid)) {
	echo '</div>';
}
?>
