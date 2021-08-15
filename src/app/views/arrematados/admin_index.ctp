<div class="arrematados index">
<h2><?php __('Arrematados');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Página %page% de %pages%, exibindo %current% registros no total de %count%.', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('Cód. Leilão');?></th>
	<th><?php echo $paginator->sort('Cód. Usuário');?></th>
	<th><?php echo $paginator->sort('Depoimento');?></th>
	<th class="actions"><?php __('Ações');?></th>
</tr>
<?php
$i = 0;
foreach ($arrematados as $arrematado):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td style="vertical-align: middle;">
			<?php echo $html->link($arrematado['Arrematado']['auction_id'], array('controller' => 'auctions', 'action' => 'view', $arrematado['Arrematado']['auction_id'])); ?>
		</td>
		<td style="vertical-align: middle;">
			<?php echo $html->link($arrematado['Arrematado']['user_id'], array('controller' => 'users', 'action' => 'view', $arrematado['Arrematado']['user_id'])); ?>
		</td>
		<td style="vertical-align: middle;">
			<?php echo $arrematado['Arrematado']['depoimento']; ?>
		</td>
		<td class="actions" style="vertical-align: middle;">
			<?php echo $html->link(__('Ver', true), array('action'=>'view', $arrematado['Arrematado']['id'])); ?>
			<?php echo $html->link(__('Depoimento', true), array('action'=>'edit', $arrematado['Arrematado']['id'])); ?>
			<?php echo $html->link(__('Apagar', true), array('action'=>'delete', $arrematado['Arrematado']['id']), null, sprintf(__('Deseja mesmo apagar esse registro?', true), $arrematado['Arrematado']['id'])); ?>
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
<!--
<div class="actions">
	<ul>
		<li><?php //echo $html->link(__('New Arrematado', true), array('action'=>'add')); ?></li>
		<li><?php //echo $html->link(__('List History Bids', true), array('controller'=> 'history_bids', 'action'=>'index')); ?> </li>
		<li><?php //echo $html->link(__('New History Bid', true), array('controller'=> 'history_bids', 'action'=>'add')); ?> </li>
	</ul>
</div>
-->