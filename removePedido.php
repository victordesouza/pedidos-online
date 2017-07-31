<?php 				// REMOVE ITEM DO PEDIDO
session_start();
$_SESSION['itensAtivos'] --;

$escolha = $_POST['escolha'];  // posicao do vetor a ser removida
$ultimo = count($_SESSION['cesta']);
$ultimoQuant = count($_SESSION['quant']);
$ultimovalorU = count($_SESSION['valorU']);
$ultimovalorT = count($_SESSION['valorT']);
$ultimoDescProduto = count($_SESSION['descProduto']);
$ultimoDesc = count($_SESSION['desc']);
$ultimoCoisa1 = count($_SESSION['coisa1']);
$ultimoCoisa2 = count($_SESSION['coisa2']);
$ultimoIPI = count($_SESSION['ipiT']);

unset($_SESSION['ipiT'][$escolha]);
$_SESSION['ipiT'] = array_values($_SESSION['ipiT']);

unset($_SESSION['cesta'][$escolha]);
$_SESSION['cesta'] = array_values($_SESSION['cesta']);

unset($_SESSION['quant'][$escolha]);
$_SESSION['quant'] = array_values($_SESSION['quant']);

unset($_SESSION['valorU'][$escolha]);
$_SESSION['valorU'] = array_values($_SESSION['valorU']);

unset($_SESSION['valorT'][$escolha]);
$_SESSION['valorT'] = array_values($_SESSION['valorT']);

unset($_SESSION['descProduto'][$escolha]);
$_SESSION['descProduto'] = array_values($_SESSION['descProduto']);

unset($_SESSION['desc'][$escolha]);
$_SESSION['desc'] = array_values($_SESSION['desc']);

unset($_SESSION['coisa1'][$escolha]);
$_SESSION['coisa1'] = array_values($_SESSION['coisa1']);

unset($_SESSION['coisa2'][$escolha]);
$_SESSION['coisa2'] = array_values($_SESSION['coisa2']);

header("Location: NvPedido.php");

?>
