<div class="categorias index">
<h2><?php __('Categorias');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Pagina %page% de %pages%, mostrando %current% registro no total de %count%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('codigo');?></th>
	<th><?php echo $paginator->sort('titulo da categoria');?></th>
	<th><?php echo $paginator->sort('criado');?></th>
	<th><?php echo $paginator->sort('modificado');?></th>
	<th class="actions"><?php __('Ações');?></th>
</tr>
<?php
$i = 0;
foreach ($categorias as $categoria):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $categoria['Categoria']['id']; ?>
		</td>
		<td>
			<?php echo $categoria['Categoria']['titulo_categoria']; ?>
		</td>
		<td>
			<?php echo $categoria['Categoria']['created']; ?>
		</td>
		<td>
			<?php echo $categoria['Categoria']['modified']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Ver', true), array('action'=>'view', $categoria['Categoria']['id'])); ?>
			<?php echo $html->link(__('Editar', true), array('action'=>'edit', $categoria['Categoria']['id'])); ?>
			<?php echo $html->link(__('Apagar', true), array('action'=>'delete', $categoria['Categoria']['id']), null, sprintf(__('Tem certeza que quer apagar esta categoria?', true), $categoria['Categoria']['id'])); ?>
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
		<li><?php echo $html->link(__('Nova Categoria', true), array('action'=>'add')); ?></li>
	</ul>
</div>
