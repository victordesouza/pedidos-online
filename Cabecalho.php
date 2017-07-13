<?php include("ConectaBanco.php");   // SCRIPTS JS JQUERY PARA MASCARAS DE FORMS?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="ISO8859_1"/>
  <link rel="stylesheet" type="text/css" href="css/cabecalho.css">       
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
  <script src="js/jquery-1.2.6.pack.js" type="text/javascript"></script>
  <script src="js/jquery.maskedinput-1.1.4.pack.js" type="text/javascript" /></script>
  <script type="text/javascript">
  $(document).ready(function(){$("#cnpj").mask("99.999.999/9999-99");});
  $(document).ready(function(){$("#cpf").mask("999.999.999-99");});
  $(document).ready(function(){$("#cep").mask("99.999-999");});
  </script>
</head>

<body style="position: relative;">
<?php

if (isset($_SESSION['nomeCliente'])) {
	$nome = $_SESSION['nomeCliente'];
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<ul>
  <li><a class="active"><img style="width: 100%;" src="magazin.png"></a></li>
  <br>
  <li><a href="ConsPedidos.php">Meus Pedidos</a></li>
  <li><a href="NvPedido.php?zerar=true">Novo Pedido</a></li>
  <li><a href="addCliente.php">Add Cliente</a></li>
</ul>

<div class="texto" >