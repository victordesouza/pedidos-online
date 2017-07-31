<?php include("Cabecalho.php");
$menuativo ="";
if (isset($_GET['ordena'])) {
	$menuativo = $_GET['ordena'];
}else {
	$menuativo = 'CODIGO';
}
error_reporting(0);
?>
<h2 align="center">Tabela de Produtos</h2>

<form action="" method="post">
    <div class="input-group">
      <input type="text" class="form-control" placeholder="Pesquisar em <?php 
      		if($menuativo=='CODIGO') {echo "CODIGO";}
      		else if($menuativo=='DESCRICAO') {echo "DESCRICAO";}
      		else if($menuativo=='ESTOQUE') {echo "ESTOQUE";}
      		else if($menuativo=='RESERVADO') {echo "RESERVADO";}
      		else if($menuativo=='DISPONIVEL') {echo "DISPONIVEL";}
      		else if($menuativo=='PCO_VENDA') {echo "PCO_VENDA";}
      		else if($menuativo=='GRUPO') {echo "GRUPO";}
      		else if($menuativo=='SUB_GRUPO') {echo "SUB_GRUPO";}
      	?>" name="pesquisar">
      <div class="input-group-btn">
        <button style="height: 34px" type="submit" class="btn btn-default"><img width="22px" height="22px" src="search.png"></button>
      </div>
    </div>
 </form>

<table style="width: 100%;margin-top: 20px" align="center"  class=" table-striped table-bordered table-hover table-condensed ">
<tr>
	<th id="pointer"<?php if($menuativo == 'CODIGO'){echo "class=ativo";}?> onClick="window.location.href = '?ordena=CODIGO'">CODIGO</th>
	<th id="pointer"<?php if($menuativo == 'DESCRICAO'){echo "class=ativo";}?> onClick="window.location.href = '?ordena=DESCRICAO'">DESCRICAO</th>
	<th id="pointer"<?php if($menuativo == 'ESTOQUE'){echo "class=ativo";}?> onClick="window.location.href = '?ordena=ESTOQUE'">ESTOQUE</th>
	<!--<th id="pointer">RESERVADO</th>
	<th id="pointer">DISPONIVEL</th>-->
	<th id="pointer"<?php if($menuativo == 'PCO_VENDA'){echo "class=ativo";}?> onClick="window.location.href = '?ordena=PCO_VENDA'">PCO_VENDA</th>
	<th id="pointer"<?php if($menuativo == 'GRUPO'){echo "class=ativo";}?> onClick="window.location.href = '?ordena=GRUPO'">GRUPO</th>
	<th id="pointer"<?php if($menuativo == 'SUB_GRUPO'){echo "class=ativo";}?> onClick="window.location.href = '?ordena=SUB_GRUPO'">SUB_GRUPO</th>
</tr>

<?php
/*
,(SELECT SUM(ITENS.QUANTIDADE) FROM AVEC85IT ITENS
		LEFT OUTER JOIN AVEC8501 CAB ON (CAB.numero_pedido = ITENS.numero_pedido)
		WHERE CAB.aux2 = '0' AND ITENS.veitentrega IN ('I','F')
		and itens.codigo = p.codigo) as reservado,

		(SELECT p.estoque- SUM(ITENS.QUANTIDADE) FROM AVEC85IT ITENS
		LEFT OUTER JOIN AVEC8501 CAB ON (CAB.numero_pedido = ITENS.numero_pedido)
		WHERE CAB.aux2 = '0' AND ITENS.veitentrega IN ('I','F')
		and itens.codigo = p.codigo) AS disponivel
,(SELECT SUM(ITENS.QUANTIDADE) FROM AVEC85IT ITENS
		LEFT OUTER JOIN AVEC8501 CAB ON (CAB.numero_pedido = ITENS.numero_pedido)
		WHERE CAB.aux2 = '0' AND ITENS.veitentrega IN ('I','F')
		and itens.codigo = p.codigo) AS reservado,

		(SELECT p.estoque- SUM(ITENS.QUANTIDADE) FROM AVEC85IT ITENS
		LEFT OUTER JOIN AVEC8501 CAB ON (CAB.numero_pedido = ITENS.numero_pedido)
		WHERE CAB.aux2 = '0' AND ITENS.veitentrega IN ('I','F')
		and itens.codigo = p.codigo) AS disponivel
*/	

function listaProduto($conexao){
	$ProdutosArray = array();
	if (isset($_GET['ordena']) && $_GET['ordena'] == 'CODIGO') {$menuativo = "p.codigo";}
		else if (isset($_GET['ordena']) && $_GET['ordena'] == 'DESCRICAO') {$menuativo = "p.descricao";}
		else if (isset($_GET['ordena']) && $_GET['ordena'] == 'ESTOQUE') {$menuativo = "p.estoque";}
		else if (isset($_GET['ordena']) && $_GET['ordena'] == 'PCO_VENDA') {$menuativo = "p.pco_venda";}
		else if (isset($_GET['ordena']) && $_GET['ordena'] == 'GRUPO') {$menuativo = "g.descricao";}
		else if (isset($_GET['ordena']) && $_GET['ordena'] == 'SUB_GRUPO') {$menuativo = "sg.descricao";}
		else {$menuativo = "p.codigo";}

	if (!isset($_POST['pesquisar'])) {
		$resultado = mysqli_query($conexao,"select p.codigo,p.aiq_ipi,p.percentual_icms, p.descricao, p.estoque,p.pco_venda, g.descricao as grupo, sg.descricao as sub_grupo
		from ACEC1101 p
		left outer join ACEC1201 g  on (g.codigo = p.grupo)
		left outer join ACEC1201 sg on (sg.codigo = p.grcodigosubgrupo)
		where p.prativo = 'S' and p.com_fab_s_fs = '2' order by $menuativo");
		
	}else {

		$pesquisa = pesquisa($menuativo);
		$resultado = mysqli_query($conexao,"select p.codigo, p.descricao, p.estoque,p.pco_venda, g.descricao as grupo, sg.descricao as sub_grupo
		from ACEC1101 p
		left outer join ACEC1201 g  on (g.codigo = p.grupo)
		left outer join ACEC1201 sg on (sg.codigo = p.grcodigosubgrupo)
		where p.prativo = 'S' and p.com_fab_s_fs = '2' and $pesquisa ");
		
	}
	while ($Produtos = mysqli_fetch_assoc($resultado)) {
		array_push($ProdutosArray,$Produtos);
	}
	return $ProdutosArray;
}

		function pesquisa($menuativo){
			$pesquisar=explode(" ",$_POST['pesquisar']);
			for ($i=0; $i < count($pesquisar); $i++) { 
				if ($i == 0) {
					$pesquisa = $menuativo." like '%".$pesquisar[$i];
					if($i + 1 == count($pesquisar) || $i == count($pesquisar)){
						$pesquisa = $menuativo." like '%".$pesquisar[$i]."%' order by ".$menuativo;
					}
				}else if($i + 1 == count($pesquisar)){
					$pesquisa .= "%' and ".$menuativo." like '%".$pesquisar[$i]."%' order by ".$menuativo;
				}else{
					$pesquisa .= "%'and ".$menuativo." like '%".$pesquisar[$i];
				}
			}
			return $pesquisa;	
		}

		if ($menuativo == 'CODIGO') {
			$menuativo = 'p.codigo';
		}else if ($menuativo == 'DESCRICAO') {
			$menuativo = 'p.descricao';
		}else if ($menuativo == 'ESTOQUE') {
			$menuativo = 'p.estoque';
		}else if ($menuativo == 'PCO_VENDA') {
			$menuativo = 'p.pco_venda';
		}else if ($menuativo == 'GRUPO') {
			$menuativo = 'g.descricao';
		}else if ($menuativo == 'SUB_GRUPO') {
			$menuativo = 'sg.descricao';
		}else
			$menuativo = 'CODIGO';
$ProdutosArray = listaProduto($conexao);

$i = 0;
foreach ($ProdutosArray as $Produtos) {
	$codProduto = $Produtos['codigo'];
	$descricaoProduto = $Produtos['descricao'];
	$precoProduto = $Produtos['pco_venda'];
	$ipi = $Produtos['aiq_ipi'];
	$icms = $Produtos['percentual_icms'];

?>
	 <tr id="pointer" onclick="window.location.href='NvPedido.php?codProduto=<?=$codProduto?>&descricaoProduto=<?=$descricaoProduto?>&precoProduto=<?=$precoProduto?>&ipi=<?=$ipi?>&icms=<?=$icms?>'">
	 	<td><?=$Produtos['codigo']?></td>
	 	<td><?=$Produtos['descricao']?></td> 
	 	<td><?=$Produtos['estoque']?></td> 
	 	<!--<td><?=$Produtos['reservado']?></td> 
	 	<td><?=$Produtos['disponivel']?></td>--> 
	 	<td><?=$Produtos['pco_venda']?></td> 
	 	<td><?=$Produtos['grupo']?></td>
	 	<td><?=$Produtos['sub_grupo']?></td>  
	 </tr>

<?php } ?>
</table>	
<?php include("rodape.php");?>
