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

/**
 * Removes all annotation of a certain type from an entity that belong to a given user.
 * 
 * @param $annotation_name  A string with the name of the annotation's type to remove.
 * @param $entity_guid  The guid of the entity from which remove annotations.
 * @param $user_guid  The guid of the user the annotation from whom we want to remove.
 */
function remove_annotation_by_entity_guid_user_guid($annotation_name, $entity_guid, $user_guid){
	$entity = get_entity($entity_guid);
	$all_annotations = $entity->getAnnotations($annotation_name);
	foreach ($all_annotations as $annotation_entity){
		if ($annotation_entity->owner_guid == $user_guid &&
				$annotation_entity->entity_guid == $entity_guid){
			$annotation_id = $annotation_entity->id;
			elgg_delete_annotation_by_id($annotation_id);
			$return = TRUE;	
		} 
	}
	return $return;
}

/**
 * Initialize a vars array suitable for viewing a poll associated form
 * using elgg_view_form. If $poll is null the variable take default values,
 * if $poll is a poll entity, the resulting array is initialized using this
 * poll values. Also, this function use a sticky form called 'polls' to
 * update the vars array values.
 * 
 * @param $poll  A poll entity or null.
 */
function advpoll_init_vars($poll) {
	$container_guid = get_input('container_guid');
	$values = array(
		'title' => '',
		'description' => '',
		'access_id' => ACCESS_DEFAULT,
		'tags' => '',
		'container_guid' => $container_guid,
		'guid' => '',
		'entity' => $poll,
		'path' => 'http://',
		'poll_closed' => 'no',
		'audit' => 'no',
		'poll_type' => 'normal',
		'access_vote_id' => ACCESS_DEFAULT,
		'show_results' => 'no',
		'can_change_vote' => 'yes',
	);

	if ($poll) {
		foreach (array_keys($values) as $key) {
			if (isset($poll->$key)) {
				$values[$key] = $poll->$key;
			}
		}
		
	}
	if (elgg_is_sticky_form('polls')) {
		$sticky_values = elgg_get_sticky_values('polls');
		foreach ($sticky_values as $key => $value) {
			$values[$key] = $value;
		}
	}

	elgg_clear_sticky_form('polls');

	return $values;
}

/**
 * Return if a user has already cast a vote on a poll or not.
 * 
 * @param $user_guid  The user guid for whom we want to check if she has already voted.
 * @param $poll_guid  The poll guid that we want to check.
 * @return true if the user has voted on this poll, or false otherwise.
 */
function user_has_voted($user_guid, $poll_guid) {
	$poll = get_entity($poll_guid);
	$return = false;
	if ($poll->poll_type == 'normal') {
		$choices = $poll->getCandidatesArray();
		foreach ($choices as $choice_guid){
			$choice = get_entity($choice_guid);
			$votes = $choice->getAnnotations('vote');
			
			foreach ($votes as $vote) {
				if ($vote->owner_guid == $user_guid) {
					$return = true;
				}
			}
		}
	} else { // condorcet
		$votes = elgg_get_annotations(array(
				'type' => 'object',
				'subtype' => 'advpoll',
				'guid' => $poll_guid,
				'anotation_name' => 'vote_condorcet',
				'limit' => 0,
		));
		foreach ($votes as $vote){
			if ($vote->owner_guid == $user_guid){
				$return = true;
			}
		}		
	}
	return $return;
}

/**
 * Tells if a poll is open, that is that the actual time is between the poll's
 * starting time and ending time.
 *
 * @param ElggEntity $poll  A poll entity.
 * @return boolean  Returns true if the poll if open, or false otherwise.
 */
function is_poll_on_date($poll) {
	$on_date = false;
	$start = $poll->start_date;
	$end = $poll->end_date;
	$date = time();

	if ($end == 'no') {
		if ($start <= $date) {
			$on_date = true;
		}
	} else {
		if ($start<=$date && $date<$end) {
			$on_date = true;
		}
	}
	return $on_date;
}

/**
 * Returns all the polls in a collection that are in the specified state.
 * State can be one of:
 * - current: polls that are open to receive votes.
 * - not_initiated: polls that will be opened in the future.
 * - ended: polls that are already closed to receive new votes.
 * - all: all polls in the collection.
 *
 * @param array $polls  An array of poll entities.
 * @param string $state  A string indicated the wanted state.
 * @return array  Returns an array of all polls in $polls that are in $state state.
 */
function advpoll_get_polls_from_state($polls, $state) {
	$time = time();
	switch ($state) {
		case 'current':
			foreach ($polls as $poll) {
				if ($time < $poll->end_date && $time > $poll->start_date) {
					$result[] = $poll;
				}
			}
			break;
		case 'not_initiated':
			foreach ($polls as $poll) {
				if ($time < $poll->end_date && $time < $poll->start_date) {
					$result[] = $poll;
				}
			}
			break;
		case 'ended':
			foreach ($polls as $poll) {
				if ($time > $poll->end_date && $time > $poll->start_date) {
					$result[] = $poll;
				}
			}
			break;
		case 'all':
			$result = $polls;
			break;
	}
	return $result;
}


/*
 *  Specific functions concerning preferencial voting and Condorcet.
 */

/**
 * Tells if a candidate is preferred over another candidate in a concrete
 * preferential ballot.
 * 
 * @param string $candidate1  The first candidate.   
 * @param string $candidate2  The second candidate.
 * @param array $preferential_ballot  An array containing as values all candidates,
 * ordered by preference.
 * @return boolean  Returns true if candidate1 is preferred over candidate2 in this ballot,
 * false otherwise.
 */
function is_preferred_candidate($candidate1, $candidate2, $preferential_ballot) {
	$pos1 = array_search($candidate1, $preferential_ballot);
	$pos2 = array_search($candidate2, $preferential_ballot);

	return $pos1 < $pos2;
}

/**
 * For a candidate in a preferential system, returns an array indicating which others
 * candidates this candidate is preferred in a given ballot.
 * 
 * @param string $candidate  The candidate for whom we want to get the array.
 * @param array $preferential_ballot  The ballot we want to check.
 * @param array $candidates  An array containing all candidates in the poll's
 * original order.
 * @return array  An integer array of 1 and 0. In a given position there is a 1 if
 * the candidate is preferred over the candidate in this position (in the original
 * poll's order).
 */
function candidate_line($candidate, $preferential_ballot, $candidates) {
	$i = 0;
	foreach ($candidates as $c) {
		if (is_preferred_candidate($candidate, $c, $preferential_ballot)) {
			$line[$i] = 1;
		} else {
			$line[$i] = 0;
		}
		$i++;
	}
	return $line;
}

/**
 * Given a list of candidates and a ballot in a preferential poll,
 * this function calculates a matrix that indicates, for each candidate,
 * which other candidates it is preferred to.
 * 
 * @param array $candidate_array  An array containing all candidates in the poll's
 * original order as keys.
 * @param array $preferential_ballot  The ballot we want to check.
 * @return array ballot_matrix  A matrix that for each candidate, it contains a 1
 * if the candidate on the row is preferred over the candidate on the column, or 0
 * otherwise. See help/condorcet.
 */
function ballot_matrix($candidate_array, $preferential_ballot) {
	$candidates = array_keys($candidate_array);
	foreach ($candidates as $candidate) {
		$ballot_matrix[] = candidate_line($candidate, $preferential_ballot, $candidates);
	}
	return $ballot_matrix;
}

/**
 * Translates from a ballot matrix containing a preferential ballot information
 * to a string, in order to save it as an Elgg annotation.
 * 
 * @param array $ballot_matrix  A ballot matrix as obtaned from ballot_matrix()
 * @return string $string  A string with the same information.
 */
function ballot_matrix_to_string($ballot_matrix) {
	foreach ($ballot_matrix as $row) {
		$string_row[] = implode(" ", $row);
	}
	$string = implode(",", $string_row);
	return $string;
}

/**
 * Translates from a string containing information about a preferrential ballot
 * to its corresponding ballot matrix.
 * 
 * @param string $string  The string to translate, obtained from an Elgg annotation in the
 * preferential poll.
 * @return array  The original ballot matrix as returned by ballot_matrix()
 */
function string_to_ballot_matrix($string) {
	$matrix_rows = explode(",", $string);
	foreach ($matrix_rows as $string_row) {
		$matrix_row = explode(" ", $string_row);
		$ballot_matrix[] = $matrix_row;
	}
	return $ballot_matrix;
}

/**
 * Check that all rows of a matrix have the same length.
 * 
 * @param int $n  The supposed common length.
 * @param array $matrix  A matrix (array of arrays).
 * @return boolean  True if all rows of $matrix have $n length, false otherwise.
 */
function all_rows_n_length($n, $matrix) {
	foreach ($matrix as $row) {
		$cols = count($row);
		if ($col !== $n) {
			return false;
		}
	}
	return true;
}

/**
 * Sum two vectors component by component.
 * 
 * @param array $v1  First vector
 * @param array $v2  Second vector
 * @return array  The sum of v1 and v2
 */
function sum_vectors($v1, $v2) {
	$i = 0;
	foreach ($v1 as $num) {
		$v_sum[] = $num + $v[$i];
		$i++;
	}
	return $v_sum;
}	

/**
 * Sum two matrices component by component.
 * 
 * @param array $a  First matrix (array of arrays)
 * @param array $b  Second matrix
 * @return array  The sum of $a and $b, or null if they haven't the same dimension.
 */
function sum_matrices($a, $b) {
	$rows = count($a);
	$cols = count($a[0]);
	$sum = array_fill(0, $rows, array_fill(0, $cols, 0));
	
	for ($row=0; $row<$rows; $row++) {
		for ($col=0; $col<$cols; $col++) {
			$sum[$row][$col] = $a[$row][$col]+$b[$row][$col];
		}
	}
	return $sum;
} 

/**
 * Obtain an ordered list of candidates from an annotation
 * containing a ballot for a Condorcet method.
 * 
 * @param ElggAnnotation $annotation  An annotation containing a ballot.
 * @return array  A list of all candidates, ordered by preference.
 */
function get_ordered_candidates_from_annotation($annotation){
	// Extract the ballot and the list of candidates
	$poll = get_entity($annotation->entity_guid);
	$ballot = string_to_ballot_matrix($annotation->value);
	$candidates_array = $poll->getCandidatesArray();
	$candidates = array_keys($candidates_array);
	// Get a list of all candidates, ordered by given points	
	$i = 0;
	foreach ($ballot as $row) {
		$points = array_sum($row);
		$points_candidates_array[$points] = $candidates[$i];
		$i++;
	}
	krsort($points_candidates_array);
	foreach ($points_candidates_array as $candidate) {
		$ordered_candidates_array[] = $candidate;
	}
	return $ordered_candidates_array;
}

/**
 * Check if an array has at least two times the same value at some index.
 * 
 * @param array $array  An array of strings or integers.
 * @return boolean  Returns true if exists a value that appears two or more times
 * in the array, or false otherwise.
 */
function array_has_repeated_value($array) {
	$return = false;
	$freq = array_count_values($array);
	foreach ($freq as $num) {
		if ($num != 1)
			$return = true;
	}
	return $return;
}

/**
 * Calculates matrix of pairwise preferences for Schultze method.
 * 
 * @param array $ballots An array of strings. Each string is a ballot, in the
 * format that they are stored as ElggAnnotation.
 * @return array  The matrix of pairwise prefences. d[a][b] tells how many
 * voters prefer 'a' over 'b'.
 */
function schultze_pairwise_preferences($ballots) {
	$i = 0;
	foreach ($ballots as $ballot_string){
		$ballot_matrix = string_to_ballot_matrix($ballot_string->value);
		if ($i == 0) {
			$n_candidates = count($ballot_matrix);
			$d = array_fill(0, $n_candidates, array_fill(0, $n_candidates, 0));
		}
		$ordered_ballot = get_ordered_candidates_from_annotation($ballot_string);
		$d = sum_matrices($d, $ballot_matrix);
		$i++;
	}
	return $d;
}

/**
 * Computes the strongest path strengths matrix (p) from
 * the pairwise preferences matrix (d).
 * See http://en.wikipedia.org/wiki/Condorcet-Schulze_method
 * 
 * @param array $d  The pairwise preferences matrix: d[a][b] if the number of
 * voters that prefer 'a' over 'b'.
 * @return array  Returns the strongest path strengths matrix. 
 */
function schultze_strongest_path_strengths($d) {
	$C = count($d); // number of candidates
	// Initialize a CxC matrix.
	$p = array_fill(0, $C, array_fill(0, $C, 0));
	
	for ($i=0; $i<$C; $i++) {
		for ($j=0; $j<$C; $j++) {
			if ($i != $j) {
				if ($d[$i][$j] > $d[$j][$i])
					$p[$i][$j] = $d[$i][$j];
				else
					$p[$i][$j] = 0;
			}
		}
	}
	for ($i=0; $i<$C; $i++) {
		for ($j=0; $j<$C; $j++) {
			if ($i != $j) {
				for ($k=0; $k<$C; $k++) {
					if ($i != $k && $j != $k)
						$p[$j][$k] = max($p[$j][$k], min($p[$j][$i], $p[$i][$k]));
				}
			}
		}
	}
	return $p;
}

/**
 * Compute the winner or winners of the Schultze method,
 * given the strongest path strengths matrix. 
 * 
 * @param array $p  The strongest path strengths matrix obtained from
 * schultze_strongest_path_strengths().
 * @return array  Returns an array of all winners. If there is only one
 * winner, the array will have a length of 1. The array contains the
 * position that the winning candidate occupy in the $p matrix.
 */
function schultze_winner($p) {
	$C = count($p);
	$max_points=0;
	$row_points = array();
	$winners = array();

	for ($row=0; $row<$C; $row++) {
		$points = 0;
		for ($col=0; $col<$C; $col++) {
			if ($p[$row][$col]>$p[$col][$row])
				$points++;
		}
		if ($points > $max_points)
			$max_points = $points;
		$row_points[] = $points;
	}
	for ($row=0; $row<$C; $row++) {
		if ($row_points[$row] == $max_points)
			$winners[] = $row;
	}
	return $winners;
}

?>
