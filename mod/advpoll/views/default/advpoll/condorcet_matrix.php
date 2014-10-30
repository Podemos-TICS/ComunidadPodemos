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

$matriz = elgg_extract('matriz', $vars, array());
$candidates = elgg_extract('candidates', $vars, array());


echo '<div>';
echo '<br>';
echo "<table class='condorcet-papeleta-table'>";
echo "<thead class='condorcet-thead'><tr class='condorcet-tr'>";
echo "<th class='condorcet-th'>";
$texto .= elgg_echo('advpoll:condorcet:info');
$texto .= elgg_view_icon('info');

$direccion = "http://es.wikipedia.org/wiki/M%C3%A9todo_de_Condorcet";
echo elgg_view('output/url',array(
	'text' => $texto ,
	'href' => $direccion,
	)) . "</th>";
foreach ($candidates as $candidate) {
	echo "<th class='condorcet-th'>" . elgg_echo('advpoll:condorcet:legend:candidate') . "$candidate</th>";
}
echo "</tr></thead><tbody>";
$i = 0;
$j = 0;
foreach ($matriz as $fila) {
	echo "<tr class='condorcet-tr'>";
	echo "<th class='condorcet-th'>" . elgg_echo('advpoll:condorcet:legend:candidate') . "$candidates[$i]</th>";
	
	foreach($fila as $elemento){
		if ($matriz[$i][$j] === $matriz[$j][$i]) {
			echo "<td class='condorcet-td'>" . $elemento . '</td>';
		} else {
			if ($matriz[$i][$j] < $matriz[$j][$i]) {
				echo "<td class='condorcet-td  rojo'>" . $elemento . '</td>';
			} else {
				if ($matriz[$i][$j] > $matriz[$j][$i]) {
					echo "<td class='condorcet-td  verde'>" . $elemento . '</td>';
				}
			}
		}
	$j++;
	}
	$j = 0;
	$i++;
	echo '</tr>';
}

echo "</tbody></table>";
echo '</div>';



