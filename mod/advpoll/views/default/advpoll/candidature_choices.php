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

$choices = elgg_extract('choices', $vars, array());


echo '<h5>' . elgg_echo('advpoll:candidates') . '</h5>';

echo "<div><ul class='choices_ul'>";

foreach($choices as $choice){	
	$entity = get_entity($choice);
        $user = get_user_by_username($entity->text);
        $img = elgg_view('output/img', array(
            'src' => $user->getIconURL('small'),
            'alt' => $user->name,
            'style' => 'vertical-align: middle; margin-bottom: 3px',
        ));
        $link = elgg_view('output/url', array(
            'text' => "$user->name (@$user->username)",
            'href' => $user->getURL(),
        ));
	echo "<li>$img $link - $user->briefdescription</li>";
}
echo "</ul></div>";
