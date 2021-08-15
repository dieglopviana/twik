<div class="produtoImages index">
<h2><?php __($produto['Produto']['titulo_produto']);?></h2>
<p>
<?php
//echo $paginator->counter(array('format' => __('Página %page% de %pages%, exibindo %current% registro no total de %count%', true)));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<!--<th><?php //echo $paginator->sort('id');?></th>
	<th><?php //echo $paginator->sort('produto_id');?></th>-->
	<th><?php echo $paginator->sort('imagem');?></th>
	<!--<th><?php //echo $paginator->sort('created');?></th>
	<th><?php //echo $paginator->sort('modified');?></th>-->
	<th class="actions"><?php __('Ações');?></th>
</tr>
<?php
$i = 0;
foreach ($produtoImages as $produtoImage):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<!--<td>
			<?php //echo $produtoImage['ProdutoImage']['id']; ?>
		</td>
		<td>
			<?php //echo $produtoImage['ProdutoImage']['produto_id']; ?>
		</td>-->
		<td>
			<?php echo $html->image('/img/imagens_produtos/thumbs/' . $produtoImage['ProdutoImage']['image']); ?>
		</td>
		<!--<td>
			<?php //echo $produtoImage['ProdutoImage']['created']; ?>
		</td>
		<td>
			<?php //echo $produtoImage['ProdutoImage']['modified']; ?>
		</td>-->
		<td class="actions">
			<?php //echo $html->link(__('View', true), array('action'=>'view', $produtoImage['ProdutoImage']['id'])); ?>
			<?php //echo $html->link(__('Edit', true), array('action'=>'edit', $produtoImage['ProdutoImage']['id'])); ?>
			<?php echo $html->link(__('Apagar', true), array('action'=>'delete', $produtoImage['ProdutoImage']['id']), null, sprintf(__('Deseja mesmo apagar essa imagem?', true), $produtoImage['ProdutoImage']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('<< Voltar', true), array('controller' => 'produtos', 'action' => 'index')); ?></li>
		<li><?php echo $html->link(__('Nova Imagem', true), array('action'=>'add/' . $produto['Produto']['id'])); ?></li>
	</ul>
</div>