<div class="users_arrematados">
	<table class="cake" border="0" cellspacing="0" cellpadding="0">
    	<tr>
        	<th>Código do Leilão</th>
            <th>Produto arrematado</th>
            <th>Valor</th>
            <th>Último lance</th>
        </tr>
	<?php
		if (!empty($arrematados)){
			
			$i = 0;
			foreach($arrematados as $arrematado):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = ' class="altrow"';
				}
	?>
				<tr<?php echo $class;?>>
                	<td><?php echo $arrematado['Auction']['id']; ?></td>
                    <td><?php echo $arrematado['Produto']['titulo_produto']; ?></td>
                    <td><?php echo 'R$ ' . $formatacao->formataMoeda($arrematado['HistoryBid']['valor']); ?></td>
                    <td><?php echo $formatacao->dataHora($arrematado['HistoryBid']['created']); ?></td>
                </tr>
    <?php		
			endforeach;
			
		} else {
	?>
    		<tr>
            	<td colspan="4" align="center"><strong>Nenhum leilão arrematado ainda</strong></td>
            </tr>
    <?php 
		}
	?>
    </table>
</div>
<div class="actions">
	<ul class="margin_rodape">
		<li class="lista_rodape"><strong><?php echo $html->link('Voltar', array('action' => 'index')); ?></strong></li>
	</ul>
</div>