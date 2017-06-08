<?php 							// TRATA E ARMAZENA OS DADOS DE CADA LINHA (ITENS DE PEDIDO)
include("ConectaBanco.php");
session_start();

if ($_POST['valorU'] == 0 || empty($_POST['valorU'])) {
	header('Location: NvPedido.php?error=true');
}else{

$_SESSION['itensAtivos'] ++;

$nProduto = $_POST['nProduto']; 
$quant = $_POST['quant'];
$valorU = $_POST['valorU'];
$desc = $_POST['desc'];
$descProduto = $_POST['descProduto'];
$ipi = $_POST['ipi'];
$icms = $_POST['icms'];

if (empty($desc)) {
	$desc = 0;
	$desc2 = 0;
}
$desc2 = $desc;
$desc = (1 - ($desc/100));

$ipiT = $desc * $valorU * $quant;

if (!empty($_SESSION['cesta']) && isset($_SESSION['cesta']) && !empty($_SESSION['quant']) && isset($_SESSION['quant'])) {		
	array_push($_SESSION['ipiT'],$ipiT);
	array_push($_SESSION['descProduto'], $descProduto);
	array_push($_SESSION['ipiProduto'], $ipi);
	array_push($_SESSION['icmsProduto'], $icms);
	array_push($_SESSION['cesta'], $nProduto);	
	array_push($_SESSION['quant'], $quant);
	array_push($_SESSION['valorU'], $valorU);
	if ($_SESSION['local'] == 1) {
		$valorT = $valorU * $quant * $desc * (1 + ($ipi/100)) * (1 + ($icms/100));
	}else $valorT = $valorU * $quant * $desc;
	array_push($_SESSION['valorT'], $valorT);
	array_push($_SESSION['desc'],$desc2);

	header("Location: NvPedido.php");
}else{
$cesta = array();
$quantArray = array();
$valorUarray = array();
$valorTarray = array();
$descArray = array();
$descProdutoArray = array();
$ipiArray = array();
$icmsArray = array();
$ipiTarray = array();

array_push($ipiTarray, $ipiT);
array_push($ipiArray,$ipi);
array_push($icmsArray,$icms);
array_push($descProdutoArray,$descProduto);
array_push($cesta,$nProduto);
array_push($quantArray, $quant);
array_push($valorUarray, $valorU);
if ($_SESSION['local'] == 1) {
		$valorT = $valorU * $quant * $desc * (1 + ($ipi/100)) * (1 + ($icms/100));
	}else $valorT = $valorU * $quant * $desc;
array_push($valorTarray, $valorT);

array_push($descArray,$desc2);

$_SESSION['descProduto'] = $descProdutoArray;
$_SESSION['cesta'] = $cesta;
$_SESSION['quant'] = $quantArray;
$_SESSION['valorU'] = $valorUarray;
$_SESSION['valorT'] = $valorTarray;
$_SESSION['desc'] = $descArray;
$_SESSION['ipiProduto'] = $ipiArray;
$_SESSION['icmsProduto'] = $icmsArray;
$_SESSION['ipiT'] = $ipiTarray;

header("Location: NvPedido.php");
}
}
?>