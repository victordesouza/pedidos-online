<?php
include("FuncoesBanco.php");

$nome = $_POST['nome'];
$_SESSION['nomeCliente'] = $nome;
$senha = md5($_POST['password']);

if ($nome == NULL || $senha == NULL){
	header('Location: Login.php?error=true');
}
$resultado = mysqli_query($conexao, "select * from AUGC0501 f where f.fousuario = '$nome' and f.fovendedorregistro = '$senha'");
$linha = mysqli_fetch_assoc($resultado);

if ($linha == null) {
	header('Location: Login.php?error=true');
}else{
	$_SESSION['logado'] = "logado";
	$_SESSION['codRepresentante'] = $linha["fcod"];
	header('Location: ConsPedidos.php',TRUE,307);
}
?>
