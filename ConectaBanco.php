<?php 	//CONEXAO COM BANCO LOCAL E MUDAN�A DE CODIFICA��O PARA ISO-8859_1
session_start();
header("Content-Type: text/html; charset=iso-8859-1");
$user = "rocaza_novo";
$pass = "magazin2017";

$banco = "rocaza_pedidos";
$host = "cpanel0191.hospedagemdesites.ws";

$conexao = mysqli_connect($host, $user, $pass, $banco);
?>
