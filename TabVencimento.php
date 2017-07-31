<?php include("Cabecalho.php");
$menuativo ="";
if (isset($_GET['ordena'])) {
	$menuativo = $_GET['ordena'];
}

?>
<h2 align="center">Tabelade de Vencimento</h2>

<form action="" method="post">
    <div class="input-group">
      <input type="text" class="form-control" placeholder="Pesquisar em <?php 
      		if($menuativo=='') {echo "Codigo";}
      		if($menuativo=='cod') {echo "Codigo";}
      		else if($menuativo=='descricao') {echo "Descricao";}
      		else if($menuativo=='vezes') {echo "Quantas Vezes";}
      	?>" name="pesquisar">
      <div class="input-group-btn">
        <button style="height: 34px" type="submit" class="btn btn-default"><img width="22px" height="22px" src="search.png"></button>
      </div>
    </div>
 </form>



<table style="width: 100%;margin-top: 20px" align="center"  class=" table-striped table-bordered table-hover table-condensed ">
<tr>
	<th id="pointer"<?php if($menuativo == 'cod'){echo "class=ativo";}?> onClick="window.location.href = '?ordena=cod'">Codigo</th>
	<th id="pointer"<?php if($menuativo == 'descricao'){echo "class=ativo";}?> onClick="window.location.href = '?ordena=descricao'">Descricao</th>
	<th id="pointer"<?php if($menuativo == 'vezes'){echo "class=ativo";}?> onClick="window.location.href = '?ordena=vezes'">Quantas Vezes</th>
</tr>

<?php 

function tabVencimento($conexao){
	$tabArray = array();
	if (!isset($_POST['pesquisar'])) {
		$resultado = mysqli_query($conexao,"select CODIGO,DESCRICAO,QUANTAS_VEZES from AFVT0101 ORDER BY CODIGO");
		if (isset($_GET['ordena']) && $_GET['ordena'] == 'descricao') {
		$resultado = mysqli_query($conexao,"select CODIGO,DESCRICAO,QUANTAS_VEZES from AFVT0101 ORDER BY DESCRICAO");
		}
		if (isset($_GET['ordena']) && $_GET['ordena'] == 'cod') {
		$resultado = mysqli_query($conexao,"select CODIGO,DESCRICAO,QUANTAS_VEZES from AFVT0101 ORDER BY CODIGO");
		}
		if (isset($_GET['ordena']) && $_GET['ordena'] == 'vezes') {
		$resultado = mysqli_query($conexao,"select CODIGO,DESCRICAO,QUANTAS_VEZES from AFVT0101 ORDER BY QUANTAS_VEZES");
		}
	}else {

		if (isset($_GET['ordena']) && $_GET['ordena'] == 'descricao') {
			$pesquisa = pesquisa("DESCRICAO");
			$resultado = mysqli_query($conexao,"select CODIGO,DESCRICAO,QUANTAS_VEZES from AFVT0101 where $pesquisa ");
		}
		if (isset($_GET['ordena']) && $_GET['ordena'] == 'cod') {
			$pesquisa = pesquisa("CODIGO");
			$resultado = mysqli_query($conexao,"select CODIGO,DESCRICAO,QUANTAS_VEZES from AFVT0101 where $pesquisa ");
		}
		if (isset($_GET['ordena']) && $_GET['ordena'] == 'vezes') {
			$pesquisa = pesquisa("QUANTAS_VEZES");
			$resultado = mysqli_query($conexao,"select CODIGO,DESCRICAO,QUANTAS_VEZES from AFVT0101 where $pesquisa ");
		}
		if (!isset($_GET['ordena'])) {
			$pesquisa = pesquisa("CODIGO");
			$resultado = mysqli_query($conexao,"select CODIGO,DESCRICAO,QUANTAS_VEZES from AFVT0101 where $pesquisa ");
		}
	}
	while ($tab = mysqli_fetch_assoc($resultado)) {
		array_push($tabArray,$tab);
	}
	return $tabArray;
}

function pesquisa($coluna){
	$pesquisar=explode(" ",$_POST['pesquisar']);
		for ($i=0; $i < count($pesquisar); $i++) { 
			if ($i == 0) {
				$pesquisa = $coluna." like '%".$pesquisar[$i];
				if($i + 1 == count($pesquisar) || $i == count($pesquisar)){
					$pesquisa = $coluna." like '%".$pesquisar[$i]."%' order by ".$coluna;
				}
			}else if($i + 1 == count($pesquisar)){
				$pesquisa .= "%' and ".$coluna." like '%".$pesquisar[$i]."%' order by ".$coluna;
			}else{
				$pesquisa .= "%' and ".$coluna." like '%".$pesquisar[$i];
			}
		}
	return $pesquisa;	
}

$tabArray = tabVencimento($conexao);

$i = 0;
foreach ($tabArray as $tab) {
	$codTab = $tab['CODIGO'];
	$descricaoTab = $tab['DESCRICAO'];
?>
	 <tr id="pointer" onclick="window.location.href = 'NvPedido.php?descricaoTab=<?=$descricaoTab?>&codTab=<?=$codTab?>'">
	 	<td><?=$tab['CODIGO']?></td>
	 	<td><?=$tab['DESCRICAO']?></td> 
	 	<td><?=$tab['QUANTAS_VEZES']?></td> 
	 </tr>

<?php } ?>
</table>
<?php

include("rodape.php");
?>
