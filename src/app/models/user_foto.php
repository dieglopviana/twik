<?php
class UserFoto extends AppModel {

	var $name = 'UserFoto';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	var $actsAs = array(
		'ImageUpload' => array(
			'image' => array(
				'required' 			  => true,
				'directory'           => 'img/imagens_users/',
				'allowed_mime'        => array('image/jpeg', 'image/pjpeg', 'image/gif', 'image/png'),
				'allowed_extension'   => array('.jpg', '.jpeg', '.png', '.gif'),
				'allowed_size'        => 716800,
				'random_filename'     => true,
				'image' => array(
					'create_thumb'    => true,
					'thumb_directory' => 'img/imagens_users/thumbs/',
					'thumb_width'     => 24,
					'thumb_height'    => 24,
					'create_max'      => true,
					'max_directory'   => 'img/imagens_users/max/',
					'max_width'       => 150,
					'max_height'      => 150
				)
			)
		),
		'containable'
	);		

}
?>