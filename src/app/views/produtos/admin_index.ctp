<div class="produtos index">
<h2><?php __('Produtos');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Página %page% de %pages%, exibindo %current% registro no total de %count%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('código');?></th>
	<th><?php echo $paginator->sort('categoria');?></th>
	<th><?php echo $paginator->sort('Produto');?></th>
	<!-- <th><?php //echo $paginator->sort('descricao');?></th> -->
	<th><?php echo $paginator->sort('valor de mercado');?></th>
	<th class="actions"><?php __('Ações');?></th>
</tr>
<?php
$i = 0;
foreach ($produtos as $produto):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $produto['Produto']['id']; ?>
		</td>
		<td>
			<?php echo $produto['Categoria']['titulo_categoria']; ?>
		</td>
		<td>
			<?php echo $produto['Produto']['titulo_produto']; ?>
		</td>
		<!--<td>
			<?php //echo $produto['Produto']['descricao']; ?>
		</td>-->
		<td>
			<?php echo $produto['Produto']['valor_mercado']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Ver', true), array('action'=>'view', $produto['Produto']['id'])); ?>
			<?php echo $html->link(__('Editar', true), array('action'=>'edit', $produto['Produto']['id'])); ?>
			<?php echo $html->link(__('Imagens', true), array('controller'=>'produto_images', 'action' => 'index', $produto['Produto']['id'])); ?>
			<?php echo $html->link(__('Apagar', true), array('action'=>'delete', $produto['Produto']['id']), null, sprintf(__('Tem certeza que deseja apagar este produto?', true), $produto['Produto']['id'])); ?>
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
		<li><?php echo $html->link(__('Novo Produto', true), array('action'=>'add')); ?></li>
	</ul>
</div>
