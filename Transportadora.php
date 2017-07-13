<?php include("Cabecalho.php");
$menuativo ="";
if (isset($_GET['ordena'])) {
	$menuativo = $_GET['ordena'];
}

?>
<h2 align="center">Tabelade Transportadoras</h2>

<form action="" method="post">
    <div class="input-group">
      <input type="text" class="form-control" placeholder="Pesquisar em <?php 
      		if($menuativo=='') {echo "Codigo";}
      		if($menuativo=='codC') {echo "Codigo";}
      		else if($menuativo=='nomeC') {echo "Nome";}
      		else if($menuativo=='CNPJ') {echo "CNPJ";}
      		else if($menuativo=='fantasia') {echo "Nome Fantasia";}
      	?>" name="pesquisar">
      <div class="input-group-btn">
        <button style="height: 34px" type="submit" class="btn btn-default"><img width="22px" height="22px" src="search.png"></button>
      </div>
    </div>
 </form>



<table style="width: 100%;margin-top: 20px" align="center"  class=" table-striped table-bordered table-hover table-condensed ">
<tr>
	<th id="pointer"><input type="checkbox" disabled="true"></th>
	<th id="pointer"<?php if($menuativo == 'codC'){echo "class=ativo";}?> onClick="window.location.href = '?ordena=codC'">Codigo</th>
	<th id="pointer"<?php if($menuativo == 'nomeC'){echo "class=ativo";}?> onClick="window.location.href = '?ordena=nomeC'">Nome</th>
	<th id="pointer"<?php if($menuativo == 'CNPJ'){echo "class=ativo";}?> onClick="window.location.href = '?ordena=CNPJ'">CNPJ</th>
	<th id="pointer"<?php if($menuativo == 'fantasia'){echo "class=ativo";}?> onClick="window.location.href = '?ordena=fantasia'">Nome Fantasia</th>
</tr>

<?php 

function listaTrans($conexao){
	$transArray = array();
	if (!isset($_POST['pesquisar'])) {
		$resultado = mysqli_query($conexao,"select FCOD, FNOME, FCNPJ_CIC, FNOME_FANTASIA from AUGC0501 where FTIPO = 'T' ORDER BY FNOME");
		if (isset($_GET['ordena']) && $_GET['ordena'] == 'nomeC') {
		$resultado = mysqli_query($conexao,"select FCOD, FNOME, FCNPJ_CIC, FNOME_FANTASIA from AUGC0501 where FTIPO = 'T' ORDER BY FNOME");
		}
		if (isset($_GET['ordena']) && $_GET['ordena'] == 'codC') {
		$resultado = mysqli_query($conexao,"select FCOD, FNOME, FCNPJ_CIC, FNOME_FANTASIA from AUGC0501 where FTIPO = 'T' ORDER BY FCOD");
		}
		if (isset($_GET['ordena']) && $_GET['ordena'] == 'CNPJ') {
		$resultado = mysqli_query($conexao,"select FCOD, FNOME, FCNPJ_CIC, FNOME_FANTASIA from AUGC0501 where FTIPO = 'T' ORDER BY FCNPJ_CIC");
		}
		if (isset($_GET['ordena']) && $_GET['ordena'] == 'fantasia') {
		$resultado = mysqli_query($conexao,"select FCOD, FNOME, FCNPJ_CIC, FNOME_FANTASIA from AUGC0501 where FTIPO = 'T' ORDER BY FNOME_FANTASIA");
		}
	}else {

		if (isset($_GET['ordena']) && $_GET['ordena'] == 'nomeC') {
			$pesquisa = pesquisa("FNOME");
			$resultado = mysqli_query($conexao,"select FCOD,FNOME,FCNPJ_CIC,FNOME_FANTASIA from AUGC0501 where FTIPO = 'T' and $pesquisa ");
		}
		if (isset($_GET['ordena']) && $_GET['ordena'] == 'codC') {
			$pesquisa = pesquisa("FCOD");
			$resultado = mysqli_query($conexao,"select FCOD,FNOME,FCNPJ_CIC,FNOME_FANTASIA from AUGC0501 where FTIPO = 'T' and $pesquisa ");
		}
		if (isset($_GET['ordena']) && $_GET['ordena'] == 'CNPJ') {
			$pesquisa = pesquisa("FCNPJ_CIC");
			$resultado = mysqli_query($conexao,"select FCOD,FNOME,FCNPJ_CIC,FNOME_FANTASIA from AUGC0501 where FTIPO = 'T' and $pesquisa ");
		}
		if (isset($_GET['ordena']) && $_GET['ordena'] == 'fantasia') {
			$pesquisa = pesquisa("FNOME_FANTASIA");
			$resultado = mysqli_query($conexao,"select FCOD,FNOME,FCNPJ_CIC,FNOME_FANTASIA from AUGC0501 where FTIPO = 'T' and $pesquisa ");
		}
		if (!isset($_GET['ordena'])) {
			$pesquisa = pesquisa("FNOME");
			$resultado = mysqli_query($conexao,"select FCOD,FNOME,FCNPJ_CIC,FNOME_FANTASIA from AUGC0501 where FTIPO = 'T' and $pesquisa ");
		}
	}
	while ($trans = mysqli_fetch_assoc($resultado)) {
		array_push($transArray,$trans);
	}
	return $transArray;
}

function pesquisa($coluna){
	$pesquisar=explode(" ",$_POST['pesquisar']);
	for ($i=0; $i < count($pesquisar); $i++) { 
		if ($i == 0) {
			$pesquisa = $coluna." like '".$pesquisar[$i];
			if($i + 1 == count($pesquisar) || $i == count($pesquisar)){
				$pesquisa = $coluna." like '".$pesquisar[$i]."' order by ".$coluna;
			}
		}else if($i + 1 == count($pesquisar)){
			$pesquisa .= "' and ".$coluna." like '".$pesquisar[$i]."' order by ".$coluna;
		}else{
			$pesquisa .= "' and ".$coluna." like '".$pesquisar[$i];
		}
	}
	return $pesquisa;	
}

$transArray = listaTrans($conexao);

$i = 0;
foreach ($transArray as $trans) {

?>
	 <tr>
	 	<td>
		<form action="NvPedido.php?feitoTrans=true" method="post">
			<input type="hidden" name="codTrans" value="<?=$trans['FCOD']?>">
			<input type="hidden" name="nomeTrans" value="<?=$trans['FNOME']?>">
			<input type="checkbox" name="checkbox" onChange="this.form.submit()">
		</form>
		</td>
	 	<td><?=$trans['FCOD']?></td>
	 	<td><?=$trans['FNOME']?></td> 
	 	<td><?=$trans['FCNPJ_CIC']?></td> 
	 	<td><?=$trans['FNOME_FANTASIA']?></td> 
	 </tr>

<?php } ?>
</table>
<?php include("rodape.php");?>
