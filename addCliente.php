<?php 								// FUNÇÃO DE CADASTRO DE NOVOS CLIENTES
include("Cabecalho.php");

if(array_key_exists("error",$_GET) && $_GET["error"]=="true"){ ?>
	<p class="alert-danger">Campos Obrigatórios Precisam ser preenchidos</p><br>
<?php }?>

<h3 align="center">Cadastrar Novo Cliente</h3>
<div class="conteudo">
<div class="confirma">
<br>

<table class="confirma" align="center">

<tr class="confirma">
	<th class="confirma"></th>
	<td class="confirma" align="center" colspan="4">
	<form action="" method="post"> 
		<input type="radio" name="tipo" value="j" onclick='this.form.submit();' <?php if((isset($_POST['tipo'])&&$_POST['tipo']=='j')||!isset($_POST['tipo'])){echo "checked";}?>><strong style="margin-left: 5px;font-size: 14px">Pessoa Jurídica</strong>
		<input style="margin-left: 40%" value="f" type="radio" name="tipo" onclick='this.form.submit();' <?php if(isset($_POST['tipo'])&&$_POST['tipo']=='f'){echo "checked";}?>><strong style="margin-left: 5px;font-size: 14px">Pessoa Física</strong>
	</form>
	</td>
	<th class="confirma"></th>
</tr>

<form action="salvarCliente.php" method="post">
<input type="hidden" name="tipoCliente" value="<?php if(isset($_POST['tipo'])){echo $_POST['tipo'];}else{echo "j";}?>">
<tr class="confirma">
	<th class="confirma" style="width: 10%"><p style="font-size: 14px;">Nome Completo *:</p></th>
	<td align="center" class="confirma"><input style="text-transform:uppercase" type="text" name="nome" class="txtedit"></td>
	<?php if(isset($_POST['tipo'])&&$_POST['tipo']=='f'){?>
		<th class="confirma" style="width: 15%"><p style="font-size: 14px;">CPF *:</p></th>
		<td align="center" class="confirma"><input type="text" class="txtedit" id="cpf" name="cnpjoucpf"></td>
	<?php }else {?>
		<th class="confirma" style="width: 15%"><p style="font-size: 14px;">CNPJ *:</p></th>
		<td align="center" class="confirma"><input type="text" class="txtedit" id="cnpj" name="cnpjoucpf"></td>
	<?php }?>
	<th class="confirma" style="width: 10%"><p style="font-size: 14px;">Local *:</p></th>
	<td align="center" class="confirma"><select class="txtedit" name="local"><option value="0">Selecionar</option><option value="01">Magazin Estofados</option><option value="02">Rocaza</option></select></td>
</tr>
<tr class="confirma">
	<th class="confirma" style="width: 15%"><p style="font-size: 14px;">Contato:</p></th>
	<td align="center" class="confirma"><input type="text" name="contato" class="txtedit"></td>
	<th class="confirma" style="width: 10%"><p style="font-size: 14px;">Endereço *:</p></th>
	<td align="center" class="confirma"><input type="text" class="txtedit" name="endereco"></td>
	<th class="confirma" style="width: 10%"><p style="font-size: 14px;">Complemento:</p></th>
	<td align="center" class="confirma"><input type="text" class="txtedit" name="complemento"></td>
</tr>
<tr class="confirma">
	<th class="confirma" style="width: 15%"><p style="font-size: 14px;">Número *:</p></th>
	<td align="center" class="confirma"><input type="number" name="numero" class="txtedit"></td>
	<th class="confirma" style="width: 15%"><p style="font-size: 14px;">Bairro *:</p></th>
	<td align="center" class="confirma"><input type="text" class="txtedit" name="bairro"></td>
	<th class="confirma" style="width: 15%"><p style="font-size: 14px;">Cidade *:</p></th>
	<td align="center" class="confirma"><input type="text" class="txtedit" name="cidade"></td>
</tr>
<tr class="confirma">
	<th class="confirma" style="width: 15%"><p style="font-size: 14px;">Estado *:</p></th>
	<td align="left" class="confirma"><select class="estado" name="estado">
	<option value="AC">AC</option>
	<option value="AL">AL</option>
	<option value="AP">AP</option>
	<option value="AM">AM</option>
	<option value="BA">BA</option>
	<option value="CE">CE</option>
	<option value="DF">DF</option>
	<option value="ES">ES</option>
	<option value="GO">GO</option>
	<option value="MA">MA</option>
	<option value="MT">MT</option>
	<option value="MS">MS</option>
	<option value="MG">MG</option>
	<option value="PA">PA</option>
	<option value="PB">PB</option>
	<option value="PR">PR</option>
	<option value="PE">PE</option>
	<option value="PI">PI</option>
	<option value="RJ">RJ</option>
	<option value="RN">RN</option>
	<option value="RS" selected="">RS</option>
	<option value="RO">RO</option>
	<option value="RR">RR</option>
	<option value="SC">SC</option>
	<option value="SP">SP</option>
	<option value="SE">SE</option>
	<option value="TO">TO</option>
	</select></td>
	<th class="confirma" style="width: 15%"><p style="font-size: 14px;">CEP *:</p></th>
	<td align="center" class="confirma"><input type="text" class="txtedit" name="cep" id="cep"></td>
	<th class="confirma" style="width: 15%"><p style="font-size: 14px;">Email:</p></th>
	<td align="center" class="confirma"><input type="email" class="txtedit" name="email"></td>
</tr>
<tr class="confirma">
	<th class="confirma" style="width: 15%"><p style="font-size: 14px;">Email NFE *:</p></th>
	<td align="center" class="confirma"><input type="email" name="emailNFE" class="txtedit"></td>
	<th class="confirma" style="width: 15%"><p style="font-size: 14px;">Fone 1 *:</p></th>
	<td align="center" class="confirma"><input type="number" class="txtedit" name="fone1"></td>
	<th class="confirma" style="width: 15%"><p style="font-size: 14px;">Fone 2:</p></th>
	<td align="center" class="confirma"><input type="number" class="txtedit" name="fone2"></td>
</tr>

</table>
<input type="submit" name="submit" value="CADASTRAR CLIENTE" style="margin-left: 70%" class="cadFeito1">
</form>
</div></div>

