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

// once elgg_view stops throwing all sorts of junk into $vars, we can use extract()
elgg_load_library('advpoll:model');
elgg_load_js('kinetic');
elgg_load_js('grafo-schulze');
$guid = elgg_extract('guid', $vars, '');
$poll = get_entity($guid);
$candidates = $poll->getCandidatesArray();
$abcd = 65;
$audit = $poll->audit;
$show_results = $poll->show_results;
$can_change_vote = $poll->can_change_vote;

// Prepare first letters for the legend
foreach ($candidates as $candidate) {
	$abecedario[] = chr($abcd);
	$abcd++;
}

$candidates_condorcet = array_keys($candidates);
// get all votes
$condorcet = elgg_get_annotations(array(
	'type' => 'object',
	'subtype' => 'advpoll',
	'guid' => $guid,
	'annotation_name' => 'vote_condorcet',
	'limit' => 0,
));
$n_votes = count($condorcet);

$i = 0;
echo "<br>";

if ($audit == 'yes' && ($show_results == 'yes' or !is_poll_on_date($poll))) {
		
	echo "<div class='audit-extendible'>";	
	
	foreach ($condorcet as $ballot_string){
		$papeleta_matriz = string_to_ballot_matrix($ballot_string->value);
		$papelota = get_ordered_candidates_from_annotation($ballot_string);
		$usuario_guid = $ballot_string->owner_guid;
		$usuario = get_entity($usuario_guid);
		$nombre = $usuario->name;
		echo "<h3  class='separador-punteado'>" . elgg_echo('advpoll:condorcet:candidates:elegidas:usuario') . $nombre . "</h3>";
		echo "<br>";
		echo "<ol class='papeleta-ol'>";
		
		foreach ($papelota as $candidate) {
			echo "<li>$candidate</li>";
			
		}
		
		echo "</ol>";
		echo "<h4>" . elgg_echo('advpoll:condorcet:candidates:elegidas:papeleta') .  $nombre . "</h4>";
		echo elgg_view('advpoll/condorcet_matrix', array('matriz' => $papeleta_matriz, 'candidates' => $abecedario));
		if ($i === 0) {
			$matriz_aux = $papeleta_matriz;
		} else {
			$matriz_aux = sum_matrices($matriz_aux, $papeleta_matriz);
		}
		$i++;
		
	}
	echo '</div>';
}

$d = schultze_pairwise_preferences($condorcet);
// Uncomment to test Schultze method using wikipedia's example
/*
$d = array(
		array(0,20,26,30,22),
		array(25,0,16,33,18),
		array(19,29,0,17,24),
		array(15,12,28,0,14),
		array(23,27,21,31,0)
);
*/

echo '<br>';
echo "<h2>" . elgg_echo('advpoll:condorcet:results:final') . "</h2>";

// Show number of votes and quorum
$electoral_roll = $poll->getElectoralRollCount();
if ($electoral_roll >= 0) {
	echo "<p>".elgg_echo('advpoll:quorum_count', array($n_votes, $electoral_roll,
			round($n_votes/$electoral_roll*100, 1)))."</p>";
} else {
	echo "<p>".elgg_echo('advpoll:vote_count', array($n_votes))."</p>";
}

echo elgg_view('advpoll/condorcet_matrix', array('matriz' => $d, 'candidates' => $abecedario));

$p = schultze_strongest_path_strengths($d);
echo elgg_view('advpoll/condorcet_matrix', array('matriz' => $p, 'candidates' => $abecedario));
$winners = schultze_winner($p);
if (count($winners) == 1) {
	echo "<h4>".elgg_echo('advpoll:one_winner').$candidates_condorcet[$winners[0]]."</h4>";
} else {
	echo "<h4>".elgg_echo('advpoll:many_winners');
	$i=0;
	foreach ($winners as $winner) {
		if ($i!=0)
			echo ", ";
		echo $candidates_condorcet[$winner];
		$i++;
	}
	echo "</h4>";
}
$abc = 65;
echo "<br><h3>" . elgg_echo('advpoll:condorcet:leyenda') . "</h3><br>";
echo '<ul><br>';
	foreach ($candidates_condorcet as $candidate){	
		echo "<li><b>" . elgg_echo('advpoll:condorcet:legend:candidate') . chr($abc) . ': </b>' . "$candidate</li><br>";
		$abc++;
	}
	
echo '</ul>';
$abc = 65;		


?>	Prueba grafo condorcet
		
	<script type="text/javascript">
		var polls = [ <?php foreach ($d as $linea){
			echo "[" . '"' . chr($abc) . '", ';
			foreach ($linea as $punt) {
				echo $punt . ', ';
			}
			echo '], ';
			$abc++;
		}
		?>
		];
		
	</script>



<div id="container"></div>
<script>
	
	var canvas = grafo_condorcet ('grafo', polls);

</script>

