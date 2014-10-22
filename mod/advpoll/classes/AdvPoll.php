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

class AdvPoll extends ElggObject {

	protected function initializeAttributes() {
        parent::initializeAttributes();
        $this->attributes['subtype'] = 'advpoll';
    }

    /**
     * Returns all possible candidates for a poll in an array. Each candidate is an Elgg
     * entity.
     *
     * @param ElggEntity $poll  A poll entity.
     * @return array  An array of candidates.
     */
    private function getCandidates() {
    	$options = array(
    			'relationship' => 'poll_choice',
    			'relationship_guid' => $this->guid,
    			'inverse_relationship' => TRUE,
    			'order_by_metadata' => array('name'=>'display_order','direction'=>'ASC'),
    			'limit' => 0,
    	);
    	return elgg_get_entities_from_relationship($options);
    }
    
    /**
     *  Get an array of all poll choices guids.
     *
     *  @param $poll  The poll the choices of which we want.
     *  @return an array containing a relation between the choice text and
     *  the choice guid.
     */
    public function getCandidatesArray() {
    	$choices = $this->getCandidates();
    	$responses = array();
    	if ($choices) {
    		foreach($choices as $choice) {
    			$label = $choice->text;
    			// force numbers to be strings
    			$responses["$label" . ' '] = $choice->guid;
    		}
    	}
    	return $responses;
    }
    
    /**
     * Save a list of choices in a poll. For each choice, an ElggObject is created,
     * and related to the poll as an Elgg relationship.
     *
     * @param $poll  A poll entity.
     * @param $choices  A collections of strings.
     */
    public function addCandidates($choices) {
    	$i = 0;
    	if ($choices) {
    		foreach($choices as $choice) {
    			$poll_choice = new ElggObject();
    			$poll_choice->subtype = "poll_choice";
    			$poll_choice->text = $choice;
    			$poll_choice->display_order = $i*10;
    			$poll_choice->access_id = $this->access_id;
    			$poll_choice->save();
    			add_entity_relationship($poll_choice->guid, 'poll_choice', $this->guid);
    			$i += 1;
    		}
    	}
    }
    
    /**
     * Removes all choices associated with a poll.
     *
     * @param $poll  A poll entity.
     */
    public function deleteCandidates() {
    	$choices = $this->getCandidates();
    	if ($choices) {
    		foreach($choices as $choice) {
    			$choice->delete();
    		}
    	}
    }
    
    /**
     * Replaces the current set of polls choices for a new one.
     *
     * @param $poll  A poll entity.
     * @param $new_choices  A collection of strings.
     */
    public function replaceCandidates($new_choices) {
    	$this->deleteCandidates();
    	$this->addCandidates($new_choices);
    }
    
    /**
     * Returns the electoral roll of the election, that is, how many users
     * can vote in it at the present moment.
     * 
     * @return int.  Returns the maximum number of potential voters
     * for this poll, or -1 if the poll is public and an electoral roll
     * doesn't make sense.
     */
    public function getElectoralRollCount() {
    	$previous_ignore_access = elgg_set_ignore_access(true);
    	$access_vote_id = $this->access_vote_id;
    	$electoral_roll = 0;
    	switch ($access_vote_id) {
    		case ACCESS_FRIENDS:
    			$owner_guid = $this->owner_guid;
    			$options =array (
    					'type' => 'user',
    					'relationship' => 'friend',
    					'relationship_guid' => $owner_guid,
    					'count' => true
    			);
    			// Curiously, the user has no access, but her friends have.
    			$electoral_roll = elgg_get_entities_from_relationship($options);
    			break;
    		case ACCESS_PRIVATE:
    			$electoral_roll = 1;
    			break;
    		case ACCESS_LOGGED_IN:
    			$electoral_roll = elgg_get_entities(array(
    			'type' => 'user',
    			'count' => true
    			));
    			break;
    		case ACCESS_PUBLIC:
    			$electoral_roll = -1;
    			break;
    		default: // group
    			$electoral_roll = get_group_members($this->container_guid, 0, 0, 0, true);
    		break;
    	}
    	elgg_set_ignore_access($previous_ignore_access);
    	return $electoral_roll;
    }
}
?>
