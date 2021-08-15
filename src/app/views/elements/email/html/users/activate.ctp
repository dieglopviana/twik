<p>Olá <?php echo $data['User']['nome_user'];?>,</p>

<p>Você está recebendo este email porque fez um cadastro em nosso site.
Para acessar sua conta e participar de leilões, por favor clique no link abaixo e valide seu cadastro:</p>

<p>
    <a href="http://localhost:8056/users/activate/<?php echo $data['User']['key']; ?>" title="Ative seu cadastro">
        Clique aqui para ativar seu cadastro...
    </a>
</p>

<p>Para seu registro, seguem os detalhes do seu cadastro:<br />
Login: <?php echo $data['User']['username'];?><br />
Senha: <?php echo $data['User']['senha'];?><br />
</p>

<p>Boa sorte!</p>

<p>Obrigado<br/></p>

<p>Se você não se cadastrou em nosso site, por favor contate o administrador através do 
formulário de contato, confirmando esse fato.</p>
