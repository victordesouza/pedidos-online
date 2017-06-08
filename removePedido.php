<?php 				// REMOVE ITEM DO PEDIDO 
session_start();
$_SESSION['itensAtivos'] --;

$escolha = $_POST['escolha'];
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
$_SESSION['ipiT'][$escolha] = $_SESSION['ipiT'][$escolha+1];
unset($_SESSION['ipiT'][$ultimo-1]);

unset($_SESSION['cesta'][$escolha]);
$_SESSION['cesta'][$escolha] = $_SESSION['cesta'][$escolha+1];
unset($_SESSION['cesta'][$ultimo-1]);

unset($_SESSION['quant'][$escolha]);
$_SESSION['quant'][$escolha] = $_SESSION['quant'][$escolha+1];
unset($_SESSION['quant'][$ultimoQuant-1]);

unset($_SESSION['valorU'][$escolha]);
$_SESSION['valorU'][$escolha] = $_SESSION['valorU'][$escolha+1];
unset($_SESSION['valorU'][$ultimovalorU-1]);

unset($_SESSION['valorT'][$escolha]);
$_SESSION['valorT'][$escolha] = $_SESSION['valorT'][$escolha+1];
unset($_SESSION['valorT'][$ultimovalorT-1]);

unset($_SESSION['descProduto'][$escolha]);
$_SESSION['descProduto'][$escolha] = $_SESSION['descProduto'][$escolha+1];
unset($_SESSION['descProduto'][$ultimoDescProduto-1]);

unset($_SESSION['desc'][$escolha]);
$_SESSION['desc'][$escolha] = $_SESSION['desc'][$escolha+1];
unset($_SESSION['desc'][$ultimoDesc-1]);

unset($_SESSION['coisa1'][$escolha]);
$_SESSION['coisa1'][$escolha] = $_SESSION['coisa1'][$escolha+1];
unset($_SESSION['coisa1'][$ultimoCoisa1-1]);

unset($_SESSION['coisa2'][$escolha]);
$_SESSION['coisa2'][$escolha] = $_SESSION['coisa2'][$escolha+1];
unset($_SESSION['coisa2'][$ultimoCoisa2-1]);

header("Location: NvPedido.php");

?>