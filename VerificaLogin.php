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

$qySenha = ibase_query($conexao, "select f.fovendedorregistro,fcod from augc0501 f where upper(f.fousuario) = upper('$nome') and f.fovendedorregistro <> 'NULL'"); 	

while($SenhaArray = ibase_fetch_assoc($qySenha)) {
	$cont ++;
	if($password == $SenhaArray["FOVENDEDORREGISTRO"]){
		$_SESSION['codRepresentante'] = $SenhaArray["FCOD"];
		header('Location: ConsPedidos.php',TRUE,307); 
	}else {
		header('Location: Login.php?error=true');
	}		

}

if ($cont == 0) {
header('Location: Login.php?error=true');
}
/*05889*/
?>
