<?php
	foreach($cidades as $cidade):
?>
		<option value="<?php echo $cidade['Cidade']['id']; ?>"><?php echo $cidade['Cidade']['cidade']; ?></option>
<?php			
	endforeach; 
?>