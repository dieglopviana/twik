<div class="userFotos index">
<h2><?php __('UserFotos');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('user_id');?></th>
	<th><?php echo $paginator->sort('imagem');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('modified');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($userFotos as $userFoto):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $userFoto['UserFoto']['id']; ?>
		</td>
		<td>
			<?php echo $userFoto['UserFoto']['user_id']; ?>
		</td>
		<td>
			<?php echo $userFoto['UserFoto']['imagem']; ?>
		</td>
		<td>
			<?php echo $userFoto['UserFoto']['created']; ?>
		</td>
		<td>
			<?php echo $userFoto['UserFoto']['modified']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $userFoto['UserFoto']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $userFoto['UserFoto']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $userFoto['UserFoto']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $userFoto['UserFoto']['id'])); ?>
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
		<li><?php echo $html->link(__('New UserFoto', true), array('action'=>'add')); ?></li>
	</ul>
</div>
