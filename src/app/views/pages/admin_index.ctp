<div class="pages index">
<h2><?php __('Páginas');?></h2>
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
'format' => __('Página %page% de %pages%, exibindo %current% registros no total de %count%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('Código');?></th>
	<th><?php echo $paginator->sort('Nome');?></th>
	<th><?php echo $paginator->sort('Título');?></th>
	<th><?php echo $paginator->sort('Link');?></th>
	<th><?php echo $paginator->sort('Topo');?></th>
	<th><?php echo $paginator->sort('Rodapé');?></th>
	<th class="actions"><?php __('Ações');?></th>
</tr>
<?php
$i = 0;
foreach ($pages as $page):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $page['Page']['id']; ?>
		</td>
		<td>
			<?php echo $page['Page']['name']; ?>
		</td>
		<td>
			<?php echo $page['Page']['titulo']; ?>
		</td>
		<td>
			<?php echo $page['Page']['link']; ?>
		</td>
		<td>
			<?php echo $page['Page']['top_show']; ?>
		</td>
		<td>
			<?php echo $page['Page']['bottom_show']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Ver', true), array('action'=>'view', $page['Page']['id'])); ?>
			<?php echo $html->link(__('Editar', true), array('action'=>'edit', $page['Page']['id'])); ?>
			<?php echo $html->link(__('Apagar', true), array('action'=>'delete', $page['Page']['id']), null, sprintf(__('Dseja mesmo apagar esta página?', true), $page['Page']['id'])); ?>
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
		<li><?php echo $html->link(__('Nova Página', true), array('action'=>'add')); ?></li>
	</ul>
</div>
