<style type="text/css">
.error-message{ margin-left: 0px; }
</style>
<div class="userFotos form">
<?php echo $form->create('UserFoto', array('type' => 'file', 'url' => '/user_fotos/edit'));?>
	<fieldset>
 		<legend><?php __('Insira sua foto');?></legend>
		<div id="quadro_upload">
        	<div id="avatar_g">
            	<?php
        			if($session->read('Auth.UserFoto.image') != ''){ 
						echo $html->image('/img/imagens_users/max/' . $session->read('Auth.UserFoto.image'), array(
							'width' => 150, 
							'height' => 150,
							'border' => 0));
					} else { 
						echo $html->image('/img/no_avatar_g.gif', array('alt' => 'avatar'));
          			}
        		?>
            </div>
            <div id="form_upload">
            	<div id="envie_sua_foto">
                	<strong>envie sua foto</strong>
                </div>
                <div id="btn_procurar">
                	<?php echo $form->input('image', array('label' => false, 'type' => 'file', 'div' => false)); ?>
                </div>
                <div id="max_file_size">
                	Tamanho máximo de 700k, JPG, GIF, PNG.
                </div>
            </div>
        </div>
        <div id="quadro_btn_continuar" style="width: 630px; height: 95px; border-top: 2px solid #f1f2ed; margin: 30px 0;">
        	<div id="btn_continar" style="margin: 25px 0 25px 220px;">
            	<input name="button" type="image" id="continuar" src="/img/continuar.gif" />
            </div>
        </div>
	</fieldset>
</div>
