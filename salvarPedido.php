<?php			// SALVA PEDIDO NO BANCO LOCAL 
include ("Cabecalho.php");

$nPedidoArray = array();
$numero = array();
$operacao = $_POST['operacao'];

$resultado = ibase_query($conexao,"select numero_pedido from avec8501");

$escolhaCliente = $_SESSION['escolhaCliente']; 
$dataEmissao = date('d.m.y');

$trans = $_SESSION['codTrans'];
$descGeral = $_SESSION['descGeral'];
$tab = $_SESSION['codTab'];
$frete = $_SESSION['frete'];
$valorTfinal = $_SESSION['valorTfinal'];
$local = $_SESSION['local'];
$representante = $_SESSION['codRepresentante'];
$obs = strtoupper($_POST['obs']);
$endereco = strtoupper($_POST['endereco']);
$numeroEnd = strtoupper($_POST['numero']);
$compEnd = strtoupper($_POST['complemento']);
$bairro = strtoupper($_POST['bairro']);
$cidade = strtoupper($_POST['cidade']);
$estado = strtoupper($_POST['estado']);
$cep = $_POST['cep'];
$contato = $_POST['contato'];
$fone1 = $_POST['fone1'];
$fone2 = $_POST['fone2'];
$email = $_POST['email'];
$emailNFE = $_POST['emailNFE'];
$contato = $_POST['contato'];
$oc = $_SESSION['oc'];



if ((empty($endereco) && $_POST['enderecoV']==0) || (empty($numeroEnd) && $_POST['numeroV']==0) || (empty($emailNFE) && $_POST['emailNFEV']==0) || (empty($cidade) && $_POST['cidadeV']==0) || (empty($estado) && $_POST['estadoV']==0) || (empty($cep) && $_POST['cepV']==0) || (empty($bairro) && $_POST['bairroV']==0) || (empty($fone1) && $_POST['fone1V']==0) || !isset($_SESSION['oc'])) {
	header('Location: Confirmacao.php?error=true');
}else {


if (empty($descGeral)) {
	$descGeral = 0;
}

while ($nPedido = ibase_fetch_assoc($resultado)) {
	array_push($nPedidoArray, $nPedido["NUMERO_PEDIDO"]);
}

$nPedidoArray = max($nPedidoArray)+1;							// $nPedidoArray é o maior produto registrado


//	SALVA PEDIDO
$avec8501 = ibase_query($conexao,"insert into avec8501 (NUMERO_PEDIDO, CODIGO_CLIENTE, DATA_EMISSAO, DESCONTO_GERAL, OPERACAO, TABELA_VENCIMENTO, FRETE, VALOR_TOTAL, VELOCAL, FOVENDEDORAUX, ENTREGUE, CODIG_TRANSPORTADORA, NUMERO_O_COM, DATA_ENTREGA, AUX2) values ($nPedidoArray, '$escolhaCliente', '$dataEmissao', '$descGeral', '$operacao', '$tab', '$frete', '$valorTfinal', '0$local', '$representante', '$obs', '$trans', '$oc', '$dataEmissao', '1')");


for($x = 0; $x < count($_SESSION['cesta']); $x++) {
	$produto = $_SESSION['cesta'][$x];
	$quantidade = $_SESSION['quant'][$x];
	$valorU = $_SESSION['valorU'][$x];
	$desconto = $_SESSION['desc'][$x];
	$ipi = $_SESSION['ipiProduto'][$x];
	$icms = $_SESSION['icmsProduto'][$x];
	$valorT = $_SESSION['valorT'][$x];
	$item = $x + 1;

$com = ibase_query($conexao,"select g.comissao from avec85it i
left outer join acec1101 p on (p.codigo = i.codigo)
left outer join acec1201 g on (g.codigo = p.grcodigosubgrupo)
where i.cod = '$item' AND i.codigo = '$produto' and i.numero_pedido = '$nPedidoArray'");

while ($comissao = ibase_fetch_assoc($com)) {
	$comissaoaux = $comissao['comissao'];
}
if (empty($comissaoaux)||$comissaoaux == NULL) {
	$comissaoaux = 0;
}


	// SLAVA ITENS DO PEDIDO
$avec85it = ibase_query($conexao,"insert into avec85it (CODIGO, COD, NUMERO_PEDIDO, VALOR, QUANTIDADE, DESCONTO, IPI, ICMS, DATA_EMISSAO, TOTAL_UNIT, VEITCOMISSAOAUX) values ('$produto','$item',$nPedidoArray,'$valorU','$quantidade','$desconto','$ipi','$icms', '$dataEmissao','$valorT','$comissaoaux')");
}
//$avec85it = ibase_query($conexao,"insert into avec85it (CODIGO, COD, NUMERO_PEDIDO, VALOR, QUANTIDADE, DESCONTO, IPI, ICMS, DATA_EMISSAO, TOTAL_UNIT, VEITCOMISSAOAUX) values ('$produto','$item',$nPedidoArray,'$valorU','$quantidade','$desconto','$ipi','$icms','$dataEmissao','$valorT','$comissaoaux')");


if (!empty($_POST['endereco'])) {
	$augc0301 = ibase_query($conexao,"update augc0301 set CLENDERECO = '$endereco' where CODIGO_CLIENTE = '$escolhaCliente'");
}
if (!empty($_POST['complemento'])) {
	$augc0301 = ibase_query($conexao,"update augc0301 set CLENDCOMPLEMENTO = '$compEnd' where CODIGO_CLIENTE = '$escolhaCliente'");
}
if (!empty($_POST['numero'])) {
	$augc0301 = ibase_query($conexao,"update augc0301 set CLENDNUMERO = '$numeroEnd' where CODIGO_CLIENTE = '$escolhaCliente'");
}
if (!empty($_POST['bairro'])) {
	$augc0301 = ibase_query($conexao,"update augc0301 set BAIRRO = '$bairro' where CODIGO_CLIENTE = '$escolhaCliente'");
}
if (!empty($_POST['cidade'])) {
	$augc0301 = ibase_query($conexao,"update augc0301 set CIDADE = '$cidade' where CODIGO_CLIENTE = '$escolhaCliente'");
}
if (!empty($_POST['estado'])) {
	$augc0301 = ibase_query($conexao,"update augc0301 set ESTADO = '$estado' where CODIGO_CLIENTE = '$escolhaCliente'");
}
if (!empty($_POST['cep'])) {
	$augc0301 = ibase_query($conexao,"update augc0301 set CEP = '$cep' where CODIGO_CLIENTE = '$escolhaCliente'");
}
if (!empty($_POST['email'])) {
	$augc0301 = ibase_query($conexao,"update augc0301 set EMAIL = '$email' where CODIGO_CLIENTE = '$escolhaCliente'");
}
if (!empty($_POST['emailNFE'])) {
	$augc0301 = ibase_query($conexao,"update augc0301 set EMAILCOMERCIAL = '$emailNFE' where CODIGO_CLIENTE = '$escolhaCliente'");
}
if (!empty($_POST['fone1'])) {
	$augc0301 = ibase_query($conexao,"update augc0301 set TELEFONE1 = '$fone1' where CODIGO_CLIENTE = '$escolhaCliente'");
}
if (!empty($_POST['fone2'])) {
	$augc0301 = ibase_query($conexao,"update augc0301 set TELEFONE2 = '$fone2' where CODIGO_CLIENTE = '$escolhaCliente'");
}
if (!empty($_POST['contato'])) {
	$augc0301 = ibase_query($conexao,"update augc0301 set CONTATO = '$contato' where CODIGO_CLIENTE = '$escolhaCliente'");
}

header('Location: ConsPedidos.php?pedido=true');
}
?>