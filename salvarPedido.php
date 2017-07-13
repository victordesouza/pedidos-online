<?php			// SALVA PEDIDO NO BANCO LOCAL
include ("ConectaBanco.php");

$nPedidoArray = array();
$numero = array();
$operacao = $_POST['operacao'];

$resultado = mysqli_query($conexao,"select numero_pedido from AVEC8501");

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

while ($nPedido = mysqli_fetch_assoc($resultado)) {
	array_push($nPedidoArray, $nPedido["numero_pedido"]);
}

$nPedidoArray = max($nPedidoArray)+1;							// $nPedidoArray � o maior produto registrado


//	SALVA PEDIDO
$avec8501 = mysqli_query($conexao,"insert into AVEC8501 (numero_pedido, codigo_cliente, data_emissao, desconto_geral,
operacao, tabela_vencimento, frete, valor_total, velocal, fovendedoraux, entregue, codig_transportadora, numero_o_com,
data_entrega, aux2) values ($nPedidoArray, '$escolhaCliente', '$dataEmissao', '$descGeral', '$operacao', '$tab',
'$frete', '$valorTfinal', '0$local', '$representante', '$obs', '$trans', '$oc', '$dataEmissao', '1')");


for($x = 0; $x < count($_SESSION['cesta']); $x++) {
	$produto = $_SESSION['cesta'][$x];
	$quantidade = $_SESSION['quant'][$x];
	$valorU = $_SESSION['valorU'][$x];
	$desconto = $_SESSION['desc'][$x];
	$ipi = $_SESSION['ipiProduto'][$x];
	$icms = $_SESSION['icmsProduto'][$x];
	$valorT = $_SESSION['valorT'][$x];
	$item = $x + 1;

$com = mysqli_query($conexao,"select g.comissao from AVEC85IT i
left outer join ACEC1101 p on (p.codigo = i.codigo)
left outer join ACEC1201 g on (g.codigo = p.grcodigosubgrupo)
where i.cod = '$item' AND i.codigo = '$produto' and i.numero_pedido = '$nPedidoArray'");

while ($comissao = mysqli_fetch_assoc($com)) {
	$comissaoaux = $comissao['comissao'];
}
if (empty($comissaoaux)||$comissaoaux == NULL) {
	$comissaoaux = 0;
}


	// SLAVA ITENS DO PEDIDO
$avec85it = mysqli_query($conexao,"insert into AVEC85IT (codigo, cod, numero_pedido, valor,
quantidade, desconto, ipi, icms, data_emissao, total_unit, veitcomissaoaux) values ('$produto',
'$item',$nPedidoArray,'$valorU','$quantidade','$desconto','$ipi','$icms', '$dataEmissao','$valorT','$comissaoaux')");
}
//$avec85it = mysqli_query($conexao,"insert into avec85it (CODIGO, COD, NUMERO_PEDIDO, VALOR, QUANTIDADE, DESCONTO, IPI, ICMS, DATA_EMISSAO, TOTAL_UNIT, VEITCOMISSAOAUX) values ('$produto','$item',$nPedidoArray,'$valorU','$quantidade','$desconto','$ipi','$icms','$dataEmissao','$valorT','$comissaoaux')");


if (!empty($_POST['endereco'])) {
	$AUGC0301 = mysqli_query($conexao,"update AUGC0301 set clendereco = '$endereco' where codigo_cliente = '$escolhaCliente'");
}
if (!empty($_POST['complemento'])) {
	$AUGC0301 = mysqli_query($conexao,"update AUGC0301 set clendcomplemento = '$compEnd' where codigo_cliente = '$escolhaCliente'");
}
if (!empty($_POST['numero'])) {
	$AUGC0301 = mysqli_query($conexao,"update AUGC0301 set clendnumero = '$numeroEnd' where codigo_cliente = '$escolhaCliente'");
}
if (!empty($_POST['bairro'])) {
	$AUGC0301 = mysqli_query($conexao,"update AUGC0301 set bairro = '$bairro' where codigo_cliente = '$escolhaCliente'");
}
if (!empty($_POST['cidade'])) {
	$AUGC0301 = mysqli_query($conexao,"update AUGC0301 set cidade = '$cidade' where codigo_cliente = '$escolhaCliente'");
}
if (!empty($_POST['estado'])) {
	$AUGC0301 = mysqli_query($conexao,"update AUGC0301 set estado = '$estado' where codigo_cliente = '$escolhaCliente'");
}
if (!empty($_POST['cep'])) {
	$AUGC0301 = mysqli_query($conexao,"update AUGC0301 set cep = '$cep' where codigo_cliente = '$escolhaCliente'");
}
if (!empty($_POST['email'])) {
	$AUGC0301 = mysqli_query($conexao,"update AUGC0301 set email = '$email' where codigo_cliente = '$escolhaCliente'");
}
if (!empty($_POST['emailNFE'])) {
	$AUGC0301 = mysqli_query($conexao,"update AUGC0301 set emailcomercial = '$emailNFE' where codigo_cliente = '$escolhaCliente'");
}
if (!empty($_POST['fone1'])) {
	$AUGC0301 = mysqli_query($conexao,"update AUGC0301 set telefone1 = '$fone1' where codigo_cliente = '$escolhaCliente'");
}
if (!empty($_POST['fone2'])) {
	$AUGC0301 = mysqli_query($conexao,"update AUGC0301 set telefone2 = '$fone2' where codigo_cliente = '$escolhaCliente'");
}
if (!empty($_POST['contato'])) {
	$AUGC0301 = mysqli_query($conexao,"update AUGC0301 set contato = '$contato' where codigo_cliente = '$escolhaCliente'");
}

header('Location: ConsPedidos.php?pedido=true');
}
?>
