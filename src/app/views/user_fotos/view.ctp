<div class="userFotos view">
<h2><?php  __('UserFoto');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userFoto['UserFoto']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('User Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userFoto['UserFoto']['user_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Imagem'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userFoto['UserFoto']['imagem']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userFoto['UserFoto']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $userFoto['UserFoto']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit UserFoto', true), array('action'=>'edit', $userFoto['UserFoto']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete UserFoto', true), array('action'=>'delete', $userFoto['UserFoto']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $userFoto['UserFoto']['id'])); ?> </li>
		<li><?php echo $html->link(__('List UserFotos', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New UserFoto', true), array('action'=>'add')); ?> </li>
	</ul>
</div>
