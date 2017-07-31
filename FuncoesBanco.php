<?php 	//CONEXAO COM BANCO LOCAL E MUDAN�A DE CODIFICA��O PARA ISO-8859_1
session_start();
header("Content-Type: text/html; charset=iso-8859-1");
date_default_timezone_set('America/Sao_Paulo');
$user = "dbpedidos";
$pass = "waytoweb1996";

$banco = "dbpedidos";
$host = "dbpedidos.mysql.dbaas.com.br";


$conexao = mysqli_connect($host, $user, $pass, $banco);

if (!isset($_SESSION['logado'])) {
  header("Location: index.php");
}

?>
