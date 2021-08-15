<div class="produtos view">
<h2><?php  __('Produto');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Código'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $produto['Produto']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Categoria'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $produto['Categoria']['titulo_categoria']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Titulo Produto'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $produto['Produto']['titulo_produto']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Valor de Mercado'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $produto['Produto']['valor_mercado']; ?>
			&nbsp;
		</dd>
        <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Descricao'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $produto['Produto']['descricao']; ?>
			&nbsp;
		</dd>
		<!--<dt<?php //if ($i % 2 == 0) echo $class;?>><?php //__('Criado'); ?></dt>
		<dd<?php //if ($i++ % 2 == 0) echo $class;?>>
			<?php //echo $produto['Produto']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php //if ($i % 2 == 0) echo $class;?>><?php //__('Modifiicado'); ?></dt>
		<dd<?php //if ($i++ % 2 == 0) echo $class;?>>
			<?php //echo $produto['Produto']['modified']; ?>
			&nbsp;
		</dd>-->
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Editar Produto', true), array('action'=>'edit', $produto['Produto']['id'])); ?> </li>
		<li><?php echo $html->link(__('Apagar Produto', true), array('action'=>'delete', $produto['Produto']['id']), null, sprintf(__('Deseja mesmo apagar este produto?', true), $produto['Produto']['id'])); ?> </li>
		<li><?php echo $html->link(__('Listar Produtos', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('Novo Produto', true), array('action'=>'add')); ?> </li>
	</ul>
</div>
