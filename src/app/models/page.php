<?php
class Page extends appModel{
	
	var $name = 'Page';
	
	var	$validate = array(
		/* CONTATO */
		'nome' => array(
			'notempty' => array(
				'rule' => 'notempty',
				'message' => 'Digite seu nome!'
			),
			'minLenght' => array(
				'rule' => array('minLenght', 4),
				'message' => 'Digite seu nome completo!'
			)
		),
		'email' => array(
			'email' => array(
				'rule' => 'email',
				'message' => 'Digite seu email corretamente!'
			)
		),
		'mensagem' => array(
			'notempty' => array(
				'rule' => 'notempty',
				'message' => 'Digite sua mensagem!'
			)
		),
		/* FORM ADD E EDIT PÁGINAS */
		'name' => array(
			'notempty' => array(
				'rule' => 'notempty',
				'message' => 'Digite o nome da página'
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'Já existe um cadastro com esse nome. Por favor, digite outro!'
			)
		),
		'titulo' => array(
			'notempty' => array(
				'rule' => 'notempty',
				'message' => 'Digite o titulo da página'
			)
		),
		'link' => array(
			'notempty' => array(
				'rule' => 'notempty',
				'message' => 'Digite o link da página'
			)
		),
		'content' => array(
			'notempty' => array(
				'rule' => 'notempty',
				'message' => 'Insira o conteúdo da página'
			)
		)
	);
}
?>