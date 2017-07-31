<?php			// TELA QUE APLICA DESCONTOS SUCESSIVOS EM TERMOS DE PORCENTAGEM
include("Cabecalho.php");?>
<div class="tabelaDesc">
<h2 align="center">Calcula Índice</h2>
<form action="" method="post">
<?php
$vInicial = 100;
if (isset($_POST['d1'])) {
$d = array();
	
	$d1 = $_POST['d1']/100;
	$d2 = $_POST['d2']/100;	
	$d3 = $_POST['d3']/100;
	$d4 = $_POST['d4']/100;
	$d5 = $_POST['d5']/100;
	$d6 = $_POST['d6']/100;
	$d['0'] = $d1;
	$d['1'] = $d2;	
	$d['2'] = $d3;
	$d['3'] = $d4;
	$d['4'] = $d5;
	$d['5'] = $d6;

$vFinal = 0;
$ini = 100;
for ($i=0; $i <5 ; $i++) { 
	$vFinal = $vFinal + ($ini*$d[$i]);
	$ini = $ini - ($ini*$d[$i]);
}}
?>

<table style="border-width:2px;border-style:double;" width="90%">
	<tr style="border:1px solid #999">
		<th style="text-align: center;border:1px solid #999">Valor :</th>
		<td height="30px" style="text-align: center"><input style="background-color: #f5f5f5;" id="desconto" type="number" name="vInicial" value='100' readonly="">%</td>
	</tr>
	<tr style="border:1px solid #999">
		<th width="50%" style="border:1px solid #999">Desconto 1:</th>
		<td style="text-align: center" height="30px"><input value="<?php if(isset($_POST['d1'])){echo $d1*100;}?>" id="desconto" type="number" name="d1">%</td>
	</tr>
	<tr style="border:1px solid #999">
		<th width="33%" style="border:1px solid #999">Desconto 2:</th>
		<td height="30px" style="text-align: center"><input value="<?php if(isset($_POST['d2'])){echo $d2*100;}?>" id="desconto" type="number" name="d2">%</td>
	</tr>
	<tr style="border:1px solid #999">
		<th width="33%" style="border:1px solid #999">Desconto 3:</th>
		<td height="30px" style="text-align: center"><input value="<?php if(isset($_POST['d3'])){echo $d3*100;}?>" id="desconto" type="number" name="d3">%</td>
	</tr>
	<tr style="border:1px solid #999">
		<th width="33%" style="border:1px solid #999">Desconto 4:</th>
		<td height="30px" style="text-align: center"><input value="<?php if(isset($_POST['d4'])){echo $d4*100;}?>" id="desconto" type="number" name="d4">%</td>
	</tr
	<tr style="border:1px solid #999">
		<th width="33%" style="border:1px solid #999">Desconto 5:</th>
		<td height="30px" style="text-align: center"><input value="<?php if(isset($_POST['d5'])){echo $d5*100;}?>" id="desconto" type="number" name="d5">%</td>
	</tr>
	<tr style="border:1px solid #999">
		<th width="33%" style="border:1px solid #999">Desconto 6:</th>
		<td height="30px" style="text-align: center"><input value="<?php if(isset($_POST['d6'])){echo $d6*100;}?>" id="desconto" type="number" name="d6">%</td>
	</tr>
	<tr style="border:1px solid #999">
		<th style="text-align: center;border:1px solid #999">Índice :</th>
		<td height="30px" style="text-align: center"><input  id="desconto" style="background-color: #f5f5f5;" type="number" name="vFinal" value="<?=$vFinal;?>" readonly="">%</td>
	</tr>
</table>
<button class="btn btn-default" style="margin-left: 45%;padding: 5px 10px;margin-bottom: 5px;margin-top: 5px;" type="submit"><img width="22px" height="22px" src="calc.png"></button>
</form>
<form action="NvPedido.php" method="post">
	<button type="submit" class="btn btn-default" style="margin-left: 45%;padding: 5px 10px " name="tabDesc" value="<?=$vFinal?>"><img width="22px" height="22px" src="certo.png"></button>
</form>
</div>