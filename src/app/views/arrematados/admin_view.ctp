<div class="arrematados view">
<h2><?php  __('Arrematado');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Cód. Leilão'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($arrematado['Arrematado']['auction_id'], array('controller' => 'auctions', 'action' => 'view', $arrematado['Arrematado']['auction_id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Cód. Usuário'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($arrematado['Arrematado']['user_id'], array('controller' => 'users', 'action' => 'view', $arrematado['Arrematado']['user_id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Depoimento'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $arrematado['Arrematado']['depoimento']; ?>
			&nbsp;
		</dd>
        <!--
        <dt<?php //if ($i % 2 == 0) echo $class;?>>
        	<a href="javascript:Void(0);" onclick="">Exibir histórico</a>
        </dt>
		<dd<?php //if ($i++ % 2 == 0) echo $class;?>>
			&nbsp;
		</dd>
        -->
	</dl>
</div>

<!--
<div id="historyBids">
	<table class="cake" cellpadding="0" cellpadding="0">
    	<tr>
        	<th>Usuário</th>
        	<th>Valor</th>
        	<th>Data</th>
        </tr>
	<?php
		/*$i = 0;
		foreach($arrematado['HistoryBid'] as $historico):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
	?>
			<tr<?php echo $class;?>>
            	<td><?php echo $historico['User']['username']; ?></td>
                <td><?php echo 'R$ ' . $formatacao->formataMoeda($historico['HistoryBid']['valor']); ?></td>
                <td><?php echo $formatacao->dataHora($historico['HistoryBid']['created']); ?></td>
            </tr>		
	<?
		endforeach; */
	?>
	</table>
</div>
-->

<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Editar depoimento', true), array('action'=>'edit', $arrematado['Arrematado']['id'])); ?> </li>
		<li><?php echo $html->link(__('Apagar', true), array('action'=>'delete', $arrematado['Arrematado']['id']), null, sprintf(__('Deseja mesmo apagar esse registro?', true), $arrematado['Arrematado']['id'])); ?> </li>
		<li><?php echo $html->link(__('Voltar', true), array('action'=>'index')); ?> </li>
		
	</ul>
</div>