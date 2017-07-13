<?php		// TELA DE CONFIRMAï¿½ï¿½O DOS DADOS DO PEDIDO E MUDANï¿½A DE ENDEREï¿½O DO CLIENTE
include ("Cabecalho.php");

$valorTfinal = array_sum($_SESSION['valorT']);
if (isset($_POST['descGeral'])) {
	$descGeral = $_POST['descGeral'];
	$_SESSION['valorTfinal'] = $valorTfinal*(1 - ($descGeral/100));
	$_SESSION['descGeral'] = (($descGeral/100)*$valorTfinal);
}
if (isset($_SESSION['nomeCliente'])) {
	$nomeRepresentante = $_SESSION['nomeCliente'];
}


$quantTotal = $_SESSION['quantTotal'];

$cliente = $_SESSION['escolhaCliente'];
$tab = $_SESSION['escolhaTab'];
$trans = $_SESSION['escolhaTrans'];

if (isset($_POST['frete'])){
$_SESSION['frete'] = $_POST['frete'];
}


if ($_SESSION['local']==0 || $_SESSION['operacao']==0 || !isset($_SESSION['oc']) || empty($quantTotal)||empty($valorTfinal)||empty($cliente)||empty($tab)||empty($trans)) {
	header('Location: NvPedido.php?error=true');
}

$endereco = $complemento = $numero = $bairro = $cidade = $cep = $estado = $emailNFE = $fone1 = 1;

	if(array_key_exists("error",$_GET) && $_GET["error"]=="true"){ ?>
		<p class="alert-danger">Campos Obrigatórios Precisam ser preenchidos</p><br>
	<?php }?>

<h3 align="center">Confirmação do Pedido</h3>
<div class="conteudo">
<div class="confirma">
<br>
<form action="salvarPedido.php" method="post">
<table class="confirma" align="center">

<?php
$resultado = mysqli_query($conexao,"select NOME, CODIGO_CLIENTE, CLENDERECO, CLENDNUMERO, EMAILCOMERCIAL, CLENDCOMPLEMENTO, BAIRRO, CEP, CIDADE, CONTATO, ESTADO, EMAIL, TELEFONE1, TELEFONE2 from AUGC0301 where CODIGO_CLIENTE = '$cliente';");
$clientes = mysqli_fetch_assoc($resultado);
$cliente = $clientes['NOME'];
if ($_SESSION['local'] == 1 && $_SESSION['operacao'] == 1) {
	$local = '00004';
}else if ($_SESSION['local'] == 1 && $_SESSION['operacao'] == 2) {
	$local = '06101';
}else if ($_SESSION['local'] == 2 && $_SESSION['operacao'] == 1) {
	$local = 'A0004';
}else {
	$local = '06101';
}
?>

<tr class="confirma">
	<th class="confirma" style="width: 16.5%">Cliente: </th>
	<td align="center" class="confirma"	 style="width: 16.5%"><input type="text" id="txtconfirma" value="<?=$cliente?>" readonly=""></td>
	<th class="confirma" style="width: 16.5%">Tab. Vencimento:</th>
	<td align="center" class="confirma" style="width: 16.5%"><input type="text" id="txtconfirma" value="<?=$tab?>" readonly=""></td>
	<th class="confirma" style="width: 16.5%">Total de Produtos:</th>
	<td align="center" class="confirma" style="width: 16.5%"><input type="text" id="txtconfirma" value="<?=$quantTotal?>" readonly=""></td>
</tr>
<tr class="confirma">
	<th class="confirma" style="width: 16.5%">Valor IPI: </th>
	<td align="center" class="confirma" style="width: 16.5%"><input type="text" id="txtconfirma" name="ipi" value="<?php if(isset($_SESSION['local'])) {echo array_sum($_SESSION['ipiT']) * 0.05;} ?>" readonly=""></td>
	<th class="confirma" style="width: 16.5%">Local:</th>
	<td align="center" class="confirma" style="width: 16.5%"><input type="text" id="txtconfirma" value="<?php if($_SESSION['local']==1){echo "Magazin Estofados";} else{echo "Moveis Rocaza";} ?>" readonly=""></td>
	<th class="confirma" style="width: 16.5%">Operação:</th>
	<td align="center" class="confirma" style="width: 16.5%"><input type="text" id="txtconfirma" value="<?php if($_SESSION['operacao']==1){echo "Dentro do Estado";}else echo "Fora do Estado"; ?>" readonly=""></td>
</tr>
<tr class="confirma">
	<th class="confirma" style="width: 16.5%">Data de Emissão: </th>
	<td align="center" class="confirma" style="width: 16.5%"><input type="text" id="txtconfirma" value="<?=date('d/m/y'); ?>" readonly=""></td>
	<th class="confirma" style="width: 16.5%">Valor Total:</th>
	<td align="center" class="confirma" style="width: 16.5%"><input type="text" name="valorTfinal" id="txtconfirma" value="<?='R$ '.$_SESSION['valorTfinal']?>" readonly=""></td>
	<th class="confirma" style="width: 16.5%">Nome Contato:</th>
	<td align="center" class="confirma" style="width: 16.5%"><input type="text"  id="	txtedit"  name="contato"></td>
</tr>
<tr class="confirma">
	<td></td><td></td><th colspan="2" style="text-align: center;">Endereço Editável</th><td></td><td></td>
</tr>

<tr class="confirma">
	<th class="confirma" style="width: 16.5%">Endereço *:</th>
	<td align="center" class="confirma" colspan="3" style="width: 16.5%"><input type="text" id="txtedit" name="endereco" placeholder="<?php if(!empty($clientes['CLENDERECO'])){echo $clientes['CLENDERECO'];} else{$endereco = 0;}?>"></td>
	<th class="confirma" style="width: 16.5%">Número *:</th>
	<td align="center" class="confirma" style="width: 16.5%"><input type="number" name="numero" id="txtedit" placeholder="<?php if(!empty($clientes['CLENDNUMERO'])){echo $clientes['CLENDNUMERO'];} else{$numero = 0;}?>"></td>
</tr>
<tr class="confirma">
	<th class="confirma" style="width: 16.5%">Complemento:</th>
	<td align="center" class="confirma" style="width: 16.5%"><input type="text" name="complemento" id="txtedit" placeholder="<?php if(!empty($clientes['CLENDCOMPLEMENTO'])){echo $clientes['CLENDCOMPLEMENTO'];} else{$complemento = 0;}?>"></td>
	<th class="confirma" style="width: 16.5%">Email:</th>
	<td align="center" class="confirma" style="width: 16.5%"><input type="email" id="txtedit" name="email" placeholder="<?php if(!empty($clientes['EMALI'])){echo $clientes['EMAIL'];} else{$email = 0;}?>"></td>
	<th class="confirma" style="width: 16.5%">Email NFE *:</th>
	<td align="center" class="confirma" style="width: 16.5%"><input type="email" id="txtedit" name="emailNFE" placeholder="<?php if(!empty($clientes['EMAILCOMERCIAL'])){echo $clientes['EMAILCOMERCIAL'];} else{$emailNFE = 0;}?>"></td>
</tr>
<tr class="confirma">
	<th class="confirma" style="width: 16.5%">Cidade *:</th>
	<td align="center" class="confirma" style="width: 16.5%"><input type="text" name="cidade" id="txtedit" placeholder="<?php if(!empty($clientes['CIDADE'])){echo $clientes['CIDADE'];} else{$cidade = 0;}?>"></td>
	<th class="confirma" style="width: 16.5%">UF *:</th>
	<td align="center" class="confirma" style="width: 16.5%"><input type="text" id="txtedit" name="estado" placeholder="<?php if(!empty($clientes['ESTADO'])){echo $clientes['ESTADO'];} else{$estado = 0;}?>"></td>
	<th class="confirma" style="width: 16.5%">CEP *:</th>
	<td align="center" class="confirma" style="width: 16.5%"><input type="text" id="txtedit" name="cep" placeholder="<?php if(!empty($clientes['CEP'])){echo $clientes['CEP'];} else{$cep = 0;}?>"></td>
</tr>
<tr class="confirma">
	<th class="confirma" style="width: 16.5%">Bairro *:</th>
	<td align="center" class="confirma" style="width: 16.5%"><input type="text" id="txtedit" name="bairro" placeholder="<?php if(!empty($clientes['BAIRRO'])){echo $clientes['BAIRRO'];} else{$bairro = 0;}?>"></td>
	<th class="confirma" style="width: 16.5%">Telefone 1 *:</th>
	<td align="center" class="confirma" style="width: 16.5%"><input type="number" name="fone1" id="txtedit" placeholder="<?php if(!empty($clientes['TELEFONE1'])){echo $clientes['TELEFONE1'];} else{$fone1 = 0;}?>"></td>
	<th class="confirma" style="width: 16.5%">Telefone 2:</th>
	<td align="center" class="confirma" style="width: 16.5%"><input type="number" id="txtedit" name="fone2" placeholder="<?php if(!empty($clientes['TELEFONE2'])){echo $clientes['TELEFONE2'];} else{$fone2 = 0;}?>"></td>
</tr>
<tr>
	<td></td><td></td><td></td><td></td><th colspan="2">* Se o endereço estiver correto não altere-o</th>
</tr>

<input type="hidden" name="enderecoV" value="<?=$endereco;?>">
<input type="hidden" name="complementoV" value="<?=$complemento;?>">
<input type="hidden" name="numeroV" value="<?=$numero;?>">
<input type="hidden" name="emailNFEV" value="<?=$emailNFE;?>">
<input type="hidden" name="fone1V" value="<?=$fone1;?>">
<input type="hidden" name="bairroV" value="<?=$bairro;?>">
<input type="hidden" name="cepV" value="<?=$cep;?>">
<input type="hidden" name="cidadeV" value="<?=$cidade;?>">
<input type="hidden" name="estadoV" value="<?=$estado;?>">
<input type="hidden" name="operacao" value="<?=$local;?>">

<tr class="confirma">
	<td align="center" class="confirma" colspan="3" style="width: 16.5%"><textarea  name="obs" rows="4" cols="40" placeholder="Observações..."></textarea></td>
	<td></td>
	<td></td>
	<td align="center" class="confirma" style="width: 16.5%"><input type="submit" name="submit" value="CONFIRMAR PEDIDO" class="cadFeito1"></td>
</tr>

</table>






</form>
</div>
</div>
<?php include("rodape.php");?>
