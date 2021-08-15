<?php
class ProdutoImage extends AppModel {

	var $name = 'ProdutoImage';
	/*var $validate = array(
		'image' => array('notempty')
	);*/

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Produto' => array(
			'className' => 'Produto',
			'foreignKey' => 'produto_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	var $actsAs = array(
		'ImageUpload' => array(
			'image' => array(
				'required' 			  => true,
				'directory'           => 'img/imagens_produtos/',
				'allowed_mime'        => array('image/jpeg', 'image/pjpeg', 'image/gif', 'image/png'),
				'allowed_extension'   => array('.jpg', '.jpeg', '.png', '.gif'),
				'allowed_size'        => 2000000,
				'random_filename'     => true,
				'image' => array(
					'create_thumb'    => true,
					'thumb_directory' => 'img/imagens_produtos/thumbs/',
					'thumb_width'     => 150,
					'thumb_height'    => 150,
					'create_max'      => true,
					'max_directory'   => 'img/imagens_produtos/max/',
					'max_width'       => 300,
					'max_height'      => 300
				)
			)
		),
		'containable'
	);	

}
?>