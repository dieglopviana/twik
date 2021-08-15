<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Twik -  Área administrativa</title>
<?php echo $html->css('page_home'); ?>
<?php echo $html->css('admin'); ?>
<?php 
if(strstr($_SERVER['HTTP_USER_AGENT'], 'MSIE')){
	$item_menu = "style='margin-left: 0px; margin-top: 5px;'";
} else {
	$item_menu = '';	
}
?>
</head>
<body>

<div id="geral">
	<div id="topo">
    	<div id="logo">
        	<a href="/" title="twik">
		    	<?php echo $html->image('/img/logo.gif', array('width' => 213, 'height' => 131, 'alt' => 'twik', 'border' => 0) ); ?>
          	</a>
        </div>
       	<div id="espaco_topo"></div>
       	<div id="menu_admin">
        	<ul class="menu">
            	<li class="menu_admin"><a href="/admin">Home</a></li>
                <li class="menu_admin2">
                	<a href="/admin/auctions">Leilões</a>
                    <ul> 	
                    	<li class="magic">&nbsp;</li>
                        <li class="magic2">&nbsp;</li>
                        <li class="item_menu" <? echo $item_menu; ?>><a href="/admin/auctions">&raquo; gerenciar leilões</a></li>
                        <li class="item_menu" <? echo $item_menu; ?>><a href="/admin/auctions/add">&raquo; adicionar leilão</a></li>
                    	<li class="item_menu" <? echo $item_menu; ?>><a href="/admin/arrematados">&raquo; arrematados</a></li>
                    </ul>
                </li>
                <li class="menu_admin2">
                	<a href="/admin/produtos">Produtos</a>
                    <ul> 	
                    	<li class="magic">&nbsp;</li>
                        <li class="magic2">&nbsp;</li>
                        <li class="item_menu" <? echo $item_menu; ?>><a href="/admin/produtos">&raquo; gerenciar produtos</a></li>
                        <li class="item_menu" <? echo $item_menu; ?>><a href="/admin/produtos/add">&raquo; adicionar produto</a></li>
                        <li class="item_menu" <? echo $item_menu; ?>><a href="/admin/categorias">&raquo; gerenciar categorias</a></li>
                        <li class="item_menu" <? echo $item_menu; ?>><a href="/admin/categorias/add">&raquo; adicionar categoria</a></li>
                        
                    </ul>
                </li>
                <li class="menu_admin2">
                	<a href="/admin/users">Usuários</a>
                    <ul> 	
                    	<li class="magic">&nbsp;</li>
                        <li class="magic2">&nbsp;</li>
                        <li class="item_menu" <? echo $item_menu; ?>><a href="/admin/users">&raquo; gerenciar usuário</a></li>
                        <li class="item_menu" <? echo $item_menu; ?>><a href="/admin/users/add">&raquo; adicionar usuário</a></li>                        
                    </ul>
                </li>
                <li class="menu_admin2">
                	<a href="/">Configuração</a>
                    <ul> 	
                    	<li class="magic">&nbsp;</li>
                        <li class="magic2">&nbsp;</li>
                        <li class="item_menu" <? echo $item_menu; ?>><a href="/admin/pages">&raquo; gerenciar páginas</a></li>
                    </ul>
                </li>
                <li class="menu_admin2"><a href="/">Ver site</a></li>
                <li class="menu_admin2"><a href="/users/logout">Sair</a></li>
            </ul>
        </div>
    </div>
    <div id="content">
    	<? echo $content_for_layout; ?>
    </div>
</div>

</body>
</html>
