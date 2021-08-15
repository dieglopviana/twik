<p>Olá <?php echo $data['User']['nome_user'];?>,</p>

<p>Esta é apenas uma notificação de que sua senha foi alterada.</p>

<p>Seus dados de acesso agora são:<br />
Login: <?php echo $data['User']['username'];?><br />
Senha: <?php echo $data['User']['senha'];?>
</p>

<p>Acesse agora mesmo o <a href="http://localhost:8056/">twik</a> e adquira produtos com preços
absurdamente baixos</p>

<p>Muito obrgado <?php echo $data['User']['nome_user']; ?><br/></p>

<p>Se você não se cadastrou em nosso site e muito menos alterou sua senha, por favor avise
o administrador do sistema pelo formulário de contato em nosso site</p>
