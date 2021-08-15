<?
$host = "db";
$user = "root";
$pass = "root";
$db = "twik";

$conexao = @mysql_connect($host,$user,$pass);

    if(!$conexao)

         die("Nao foi possivel conectar no servidor MySQL. Erro: " . mysql_error());

    mysql_select_db($db) or die("Nao foi possivel usar o banco de dados. Erro: " . mysql_error());

?>
