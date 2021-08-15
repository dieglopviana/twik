<div class="auctions index">
<h2><?php __('Leilões');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Página %page% de %pages%, exibindo %current% no total de %count%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('produto_id');?></th>
	<th><?php echo $paginator->sort('data_inicio');?></th>
	<th><?php echo $paginator->sort('tempo_cronometro');?></th>
	<th><?php echo $paginator->sort('valor_inicial');?></th>
	<th><?php echo $paginator->sort('valor_lance');?></th>
    <th><?php echo $paginator->sort('destaque');?></th>
	<th><?php echo $paginator->sort('Status Cronômetro');?></th>
	<th><?php echo $paginator->sort('Status Leilão');?></th>
	<th><?php echo $paginator->sort('arrematado');?></th>
	<!--<th><?php //echo $paginator->sort('created');?></th>
	<th><?php //echo $paginator->sort('modified');?></th>-->
	<th class="actions"><?php __('Ações');?></th>
</tr>
<?php
$i = 0;
foreach ($auctions as $auction):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $auction['Auction']['id']; ?>
		</td>
		<td>
			<?php echo $auction['Produto']['titulo_produto']; ?>
		</td>
		<td>
			<?php echo $formatacao->dataHora(strtotime($auction['Auction']['data_inicio']), true); ?>
		</td>
		<td>
			<?php echo $auction['Auction']['tempo_cronometro']; ?>
		</td>
		<td>
			<?php echo $auction['Auction']['valor_inicial']; ?>
		</td>
		<td>
			<?php echo $auction['Auction']['valor_lance']; ?>
		</td>
        <td>
			<?php if ($auction['Auction']['destaque'] == 1) echo "Sim"; else echo "Não"; ?>
		</td>
		<td>
			<?php if ($auction['Auction']['status_cronometro'] == 1) echo "Ativado"; else echo "desativado"; ?>
		</td>
		<td>
			<?php if ($auction['Auction']['status_auction'] == 1) echo "Ativado"; else echo "desativado"; ?>
		</td>
		<td>
			<?php if ($auction['Auction']['arrematado'] == 1) echo "Sim"; else echo "Não"; ?>
		</td>
		<!--<td>
			<?php //echo $auction['Auction']['created']; ?>
		</td>
		<td>
			<?php //echo $auction['Auction']['modified']; ?>
		</td>-->
		<td class="actions">
			<?php echo $html->link(__('Ver', true), array('action'=>'view', $auction['Auction']['id'])); ?>
			<?php echo $html->link(__('Editar', true), array('action'=>'edit', $auction['Auction']['id'])); ?>
			<?php echo $html->link(__('Apagar', true), array('action'=>'delete', $auction['Auction']['id']), null, sprintf(__('Deseja mesmo apagar esse leilão?', true), $auction['Auction']['id'])); ?>
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
		<li><?php echo $html->link(__('Novo Leilão', true), array('action'=>'add')); ?></li>
	</ul>
</div>