<div class="categorias view">
<h2><?php  __('Categoria');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Código'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $categoria['Categoria']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Titulo categoria'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $categoria['Categoria']['titulo_categoria']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Criado em'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $categoria['Categoria']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modificado em'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $categoria['Categoria']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Editar Categoria', true), array('action'=>'edit', $categoria['Categoria']['id'])); ?> </li>
		<li><?php echo $html->link(__('Apagar Categoria', true), array('action'=>'delete', $categoria['Categoria']['id']), null, sprintf(__('Tem certeza que quer apagar esta categoria?', true), $categoria['Categoria']['id'])); ?> </li>
		<li><?php echo $html->link(__('Listar Categorias', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('Nova Categoria', true), array('action'=>'add')); ?> </li>
	</ul>
</div>
