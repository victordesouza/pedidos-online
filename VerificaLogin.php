<?php 
include("Cabecalho.php");

$cont= 0;
$nome = $_POST['nome'];
$_SESSION['nomeCliente'] = $nome;

$password = $_POST['password'];
$SenhaArray = array();

if ($nome == NULL || $password == NULL){
	header('Location: Login.php?error=true');
}

$qySenha = ibase_query($conexao, "select f.fcod from augc0501 f where upper(f.fousuario) = upper('{$nome}') and f.fovendedorregistro = '{$password}'"); 	
$user = ibase_fetch_assoc($qySenha);  
if ($user == null) {
	header('Location: Login.php?error=true');
}else{
	$_SESSION['codRepresentante'] = $user["FCOD"];
	header('Location: ConsPedidos.php',TRUE,307); 
	
}
?>
