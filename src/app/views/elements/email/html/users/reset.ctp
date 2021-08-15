<p>Olá <?php echo $data['User']['nome_user'];?>,</p>

<p>Você solicitou uma nova senha, pois havia se esquecido da antiga. Como as
senhas cadastradas são criptografadas, não tem como recuperar a antiga, mas conforme 
solicitado, segue abaixo seus dados de acesso.</p>

<p>Seus dados de acesso são:<br />
Login: <?php echo $data['User']['username'];?><br />
Senha: <?php echo $data['User']['senha'];?>
</p>

<p>Por favor, assim que você conseguir efetuar o login, fique a vontade para alterar sua senha.</p>

<p>Acesse agora mesmo o <a href="http://localhost:8056/">twik</a> e adquira produtos com preços
absurdamente baixos</p>

<p>Muito obrgado <?php echo $data['User']['nome_user'];?><br/></p>

<p>Se você não se cadastrou em nosso site e muito menos solicitou uma nova senha, por favor avise
o administrador do sistema pelo formulário de contato em nosso site</p>
