<div class="users index">
<h2><?php __('Usuários');?></h2>
<?php 
	  if($session->check('Message.flash')){ ?> 
       	 <fieldset>
         	<div class="showErrorMessage">
           		<span class="txtErrorMessage"><?php $session->flash('flash', array('div' => false)); ?></span>
         	</div>
         </fieldset>
<?php } ?>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Página %page% de %pages%, mostrando %current% registros no total de %count%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('Código');?></th>
	<th><?php echo $paginator->sort('Nome');?></th>
	<th><?php echo $paginator->sort('Email');?></th>
	<th><?php echo $paginator->sort('Username');?></th>
	<th><?php echo $paginator->sort('Telefone');?></th>
	<th><?php echo $paginator->sort('status');?></th>
	<th><?php echo $paginator->sort('admin');?></th>
    <th><?php echo $paginator->sort('Lances');?></th>
	<th class="actions"><?php __('Ações');?></th>
</tr>
<?php
$i = 0;
foreach ($users as $user):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $user['User']['id']; ?>
		</td>
		<td>
			<?php echo $user['User']['nome_user']; ?>
		</td>
		<td>
			<?php echo $user['User']['email_user']; ?>
		</td>
		<td>
			<?php echo $user['User']['username']; ?>
		</td>
		<td>
			(<?php echo $user['User']['ddd']; ?>) <?php echo $user['User']['telefone']; ?>
		</td>
		<td>
			<?php if ($user['User']['status'] == 1) echo "Ativado"; else echo "Desativado"; ?>
		</td>
		<td>
			<?php if ($user['User']['admin'] == 0) echo "Não"; else echo "Sim"; ?>
		</td>
        <td>
			<?php echo $user['UserBid']['quantidade']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Ver', true), array('action'=>'view', $user['User']['id'])); ?>
			<?php echo $html->link(__('Editar', true), array('action'=>'edit', $user['User']['id'])); ?>
			<?php echo $html->link(__('Apagar', true), array('action'=>'delete', $user['User']['id']), null, sprintf(__('Deseja mesmo apagar este usuário?', true), $user['User']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('anterior', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('próximo', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Novo Usuário', true), array('action'=>'add')); ?></li>
	</ul>
</div>
