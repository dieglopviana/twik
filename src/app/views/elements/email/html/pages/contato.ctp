<p>Contato enviado pelo site TWIK. Os dados de quem enviou segue a seguir:</p>

<p>Nome: <?php echo $data['Page']['nome']; ?></p>

<p>Email: <?php echo $data['Page']['email']; ?></p>

<p>Assunto: <?php echo $data['Page']['assunto']; ?></p>

<p>Mensagem:<br />
<?php echo nl2br($data['Page']['mensagem']); ?></p>
