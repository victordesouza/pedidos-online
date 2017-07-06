<?php 	//CONEXAO COM BANCO LOCAL E MUDANÇA DE CODIFICAÇÃO PARA ISO-8859_1
session_start();
header("Content-Type: text/html; charset=ISO8859_1");

//=========================================================================
//Conexao banco firebird 1.5 Magazin Estofados

$user = "SYSDBA";
$pass = "masterkey";

$hostnameCyber = "localhost:c:\jobs\cybersul\databases\DADOSADM.FDB";

$conexao = ibase_connect($hostnameCyber, $user, $pass,'ISO8859_1');

if (!isset($_SESSION['codRepresentante'])) {
	header('Location: Login.php');
}
?>