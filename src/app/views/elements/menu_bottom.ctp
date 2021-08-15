<?php $pages = $this->requestAction('/pages/getpages/bottom'); ?>
<div id="menu_rodape">
	<ul class="margin_rodape">
	<?php foreach($pages as $page):?>
    			<li class="lista_rodape">
					<strong><?php echo $html->link($page['Page']['name'], array('controller' => 'pages', 'action' => 'view', $page['Page']['link'])); ?></strong>
                </li>
                <li class="lista_rodape">|</li>
    <?php endforeach;?>
		<li class="lista_rodape"><strong><?php echo $html->link('contato', '/contato'); ?></strong></li>
    </ul>
</div>