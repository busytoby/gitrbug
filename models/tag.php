<?php
class Tag extends AppModel {

	var $name = 'Tag';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Peer' => array(
			'className' => 'Peer',
			'foreignKey' => 'entity_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>