<div class="auctions view">
<h2><?php  __($auction['Produto']['titulo_produto']);?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<!--<dt<?php //if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php //if ($i++ % 2 == 0) echo $class;?>>
			<?php //echo $auction['Auction']['id']; ?>
			&nbsp;
		</dd>-->
		<!--<dt<?php //if ($i % 2 == 0) echo $class;?>><?php __('Produto Id'); ?></dt>
		<dd<?php //if ($i++ % 2 == 0) echo $class;?>>
			<?php //echo $auction['Auction']['produto_id']; ?>
			&nbsp;
		</dd>-->
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Início'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $formatacao->dataHora(strtotime($auction['Auction']['data_inicio'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Cronômetro'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $auction['Auction']['tempo_cronometro']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Valor Inicial'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $formatacao->moeda($auction['Auction']['valor_inicial']); ?>
			&nbsp;
		</dd>
        <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Palavras chaves'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $auction['Auction']['busca']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Valor do Lance'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $formatacao->moeda($auction['Auction']['valor_lance']) . " (" . $formatacao->moedaPorExtenso($auction['Auction']['valor_lance']) . ")"; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Cronômetro'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php if($auction['Auction']['status_cronometro'] == 1){ __('Ativo'); } else __('Desativado');  ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Status do Leilão'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php if($auction['Auction']['status_auction'] == 1){ __('Ativo'); } else __('Desativado'); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Arrematado'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php if($auction['Auction']['arrematado'] == 0){ __('Não'); } else __('Sim'); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Criado'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $formatacao->dataHora(strtotime($auction['Auction']['created'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modificado'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $formatacao->dataHora(strtotime($auction['Auction']['modified'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Editar Leilão', true), array('action'=>'edit', $auction['Auction']['id'])); ?> </li>
		<li><?php echo $html->link(__('Apagar Leilão', true), array('action'=>'delete', $auction['Auction']['id']), null, sprintf(__('Deseja mesmo apagar esse leilão?', true), $auction['Auction']['id'])); ?> </li>
		<li><?php echo $html->link(__('Listar Leilão', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('Novo Leilão', true), array('action'=>'add')); ?> </li>
	</ul>
</div>