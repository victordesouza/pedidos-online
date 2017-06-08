<?php include("Cabecalho.php");
$menuativo ="";
if (isset($_GET['ordena'])) {
	$menuativo = $_GET['ordena'];
}else {
	$menuativo = 'CODIGO';
}

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
	<th id="pointer"><input type="checkbox" disabled="true"></th>
	<th id="pointer"<?php if($menuativo == 'CODIGO'){echo "class=ativo";}?> onClick="window.location.href = '?ordena=CODIGO'">CODIGO</th>
	<th id="pointer"<?php if($menuativo == 'DESCRICAO'){echo "class=ativo";}?> onClick="window.location.href = '?ordena=DESCRICAO'">DESCRICAO</th>
	<th id="pointer"<?php if($menuativo == 'ESTOQUE'){echo "class=ativo";}?> onClick="window.location.href = '?ordena=ESTOQUE'">ESTOQUE</th>
	<th id="pointer">RESERVADO</th>
	<th id="pointer">DISPONIVEL</th>
	<th id="pointer"<?php if($menuativo == 'PCO_VENDA'){echo "class=ativo";}?> onClick="window.location.href = '?ordena=PCO_VENDA'">PCO_VENDA</th>
	<th id="pointer"<?php if($menuativo == 'GRUPO'){echo "class=ativo";}?> onClick="window.location.href = '?ordena=GRUPO'">GRUPO</th>
	<th id="pointer"<?php if($menuativo == 'SUB_GRUPO'){echo "class=ativo";}?> onClick="window.location.href = '?ordena=SUB_GRUPO'">SUB_GRUPO</th>
</tr>

<?php
	

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
		$resultado = ibase_query($conexao,"select p.codigo,p.aiq_ipi,p.percentual_icms, p.descricao, p.estoque,p.pco_venda, g.descricao as grupo, sg.descricao as sub_grupo,
		(SELECT SUM(ITENS.QUANTIDADE) FROM avec85it ITENS
		LEFT OUTER JOIN avec8501 CAB ON (CAB.numero_pedido = ITENS.numero_pedido)
		WHERE CAB.aux2 = '0' AND ITENS.veitentrega IN ('I','F')
		and itens.codigo = p.codigo) as reservado,

		(SELECT p.estoque- SUM(ITENS.QUANTIDADE) FROM avec85it ITENS
		LEFT OUTER JOIN avec8501 CAB ON (CAB.numero_pedido = ITENS.numero_pedido)
		WHERE CAB.aux2 = '0' AND ITENS.veitentrega IN ('I','F')
		and itens.codigo = p.codigo) AS disponivel

		from acec1101 p
		left outer join acec1201 g  on (g.codigo = p.grupo)
		left outer join acec1201 sg on (sg.codigo = p.grcodigosubgrupo)
		where p.prativo = 'S' and p.com_fab_s_fs = '2' order by $menuativo");
		
	}else {

		$pesquisa = pesquisa($menuativo);
		$resultado = ibase_query($conexao,"select p.codigo, p.descricao, p.estoque,p.pco_venda, g.descricao as grupo, sg.descricao as sub_grupo,
		(SELECT SUM(ITENS.QUANTIDADE) FROM avec85it ITENS
		LEFT OUTER JOIN avec8501 CAB ON (CAB.numero_pedido = ITENS.numero_pedido)
		WHERE CAB.aux2 = '0' AND ITENS.veitentrega IN ('I','F')
		and itens.codigo = p.codigo) AS reservado,

		(SELECT p.estoque- SUM(ITENS.QUANTIDADE) FROM avec85it ITENS
		LEFT OUTER JOIN avec8501 CAB ON (CAB.numero_pedido = ITENS.numero_pedido)
		WHERE CAB.aux2 = '0' AND ITENS.veitentrega IN ('I','F')
		and itens.codigo = p.codigo) AS disponivel

		from acec1101 p
		left outer join acec1201 g  on (g.codigo = p.grupo)
		left outer join acec1201 sg on (sg.codigo = p.grcodigosubgrupo)
		where p.prativo = 'S' and p.com_fab_s_fs = '2' and $pesquisa ");
		
	}
	while ($Produtos = ibase_fetch_assoc($resultado)) {
		array_push($ProdutosArray,$Produtos);
	}
	return $ProdutosArray;
}

		function pesquisa($menuativo){
			$pesquisar=explode(" ",$_POST['pesquisar']);
			for ($i=0; $i < count($pesquisar); $i++) { 
				if ($i == 0) {
					$pesquisa = $menuativo." containing '".$pesquisar[$i];
					if($i + 1 == count($pesquisar) || $i == count($pesquisar)){
						$pesquisa = $menuativo." containing '".$pesquisar[$i]."' order by ".$menuativo;
					}
				}else if($i + 1 == count($pesquisar)){
					$pesquisa .= "' and ".$menuativo." containing '".$pesquisar[$i]."' order by ".$menuativo;
				}else{
					$pesquisa .= "' and ".$menuativo." containing '".$pesquisar[$i];
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

?>
	 <tr>
	 	<td>
		<form action="NvPedido.php?feitoProduto=true" method="post">
			<input type="hidden" name="codProduto" value="<?=$Produtos['CODIGO']?>">
			<input type="hidden" name="descricaoProduto" value="<?=$Produtos['DESCRICAO']?>">
			<input type="hidden" name="precoProduto" value="<?=$Produtos['PCO_VENDA']?>">
			<input type="hidden" name="ipi" value="<?=$Produtos['AIQ_IPI']?>">
			<input type="hidden" name="icms" value="<?=$Produtos['PERCENTUAL_ICMS']?>">
			<input type="checkbox" name="checkbox" onChange="this.form.submit()">
		</form>
		</td>
	 	<td><?=$Produtos['CODIGO']?></td>
	 	<td><?=$Produtos['DESCRICAO']?></td> 
	 	<td><?=$Produtos['ESTOQUE']?></td> 
	 	<td><?=$Produtos['RESERVADO']?></td> 
	 	<td><?=$Produtos['DISPONIVEL']?></td> 
	 	<td><?=$Produtos['PCO_VENDA']?></td> 
	 	<td><?=$Produtos['GRUPO']?></td>
	 	<td><?=$Produtos['SUB_GRUPO']?></td>  
	 </tr>

<?php } ?>
</table>	
<?php include("rodape.php");?>
