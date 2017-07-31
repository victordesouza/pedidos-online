<?php
include("Cabecalho.php");

$tipo = strtoupper($_POST['tipoCliente']);
$nome = strtoupper($_POST['nome']);
$cnpjoucpf = preg_replace("/[^0-9\s]/", "", $_POST['cnpjoucpf']);
$contato = strtoupper($_POST['contato']);
$endereco = strtoupper($_POST['endereco']);
$complemento = strtoupper($_POST['complemento']);
$numero = $_POST['numero'];
$bairro = strtoupper($_POST['bairro']);
$cidade = strtoupper($_POST['cidade']);
$estado = $_POST['estado'];
$cep = preg_replace("/[^0-9\s]/", "", $_POST['cep']); 
$email = $_POST['email'];
$emailNFE = $_POST['emailNFE'];
$fone1 = $_POST['fone1'];
$fone2 = $_POST['fone2'];
$local = $_POST['local'];

/*echo $nome;
echo $tipo;
echo $cnpjoucpf;
echo $cep;
echo $emailNFE;
echo $fone1;
echo $estado;*/


if (empty($nome)||empty($cnpjoucpf)||empty($endereco)||empty($numero)||empty($bairro)||empty($cidade)||empty($estado)||empty($cep)||empty($emailNFE)||empty($fone1)||$local==0) {
	header('Location: addCliente.php?error=true');
}

$codCl = mysqli_query($conexao,"select max(CODIGO_CLIENTE) as MAXIMO from AUGC0301");
while ($cod = mysqli_fetch_assoc($codCl)) {
	if(substr($cod['MAXIMO'], 0, 1) == 'a'){
		$a = (substr($cod['MAXIMO'], 1, 4)+1);
		$codCliente = 'a'.$a;
	}
	else if ($cod['MAXIMO'] == '99999') {
		$codCliente = 'a1';
	}else{$codCliente = $cod['MAXIMO'] + 1;}
}
echo $codCliente;
$augc0301 = mysqli_query($conexao,"insert into AUGC0301 (CODIGO_CLIENTE,NOME, BAIRRO, CIDADE, ESTADO, CEP, TELEFONE1, TELEFONE2, PESSOA_FISICAOUJURIDICA, CGC_CNPJ, CONTATO, LOCAL_EMPRESA, EMAIL, CLENDERECO, CLENDCOMPLEMENTO, CLENDNUMERO, EMAILCOMERCIAL) values ('$codCliente','$nome', '$bairro', '$cidade', '$estado', '$cep', '$fone1', '$fone2', '$tipo', '$cnpjoucpf', '$contato', '$local', '$email', '$endereco', '$complemento', '$numero', '$emailNFE')");

header('Location: ConsPedidos.php?cliente=true');


?>