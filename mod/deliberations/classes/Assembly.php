<?php

class Assembly extends ElggObject{
    
    function assemblies_get_next_assembly($group) {
	$options = array('types' => 'object',
			 'subtypes' => 'assembly',
			 'limit' => 1,
			 'container_guid' => $group->guid,
			 'metadata_name_value_pairs' => array(
						array('name' => 'date',
							'value' => time(),
							'operand' => '>=')
						),
			 'order_by_metadata' => array('name' => 'date',
						      'direction' => 'ASC')
			);
	$assemblies = elgg_get_entities_from_metadata($options);

	if (count($assemblies))
		return $assemblies[0];
	else
		return false;

}
  
}	