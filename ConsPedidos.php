<?php 			// TELA HOME DO SISTEMA QUE MOSTRA PEDIDOS JÁ FEITOS PELO REPRESENTANTE, COM A POSSIBILIDADE DE IMPRIMIR PEDIDO ESPECÍFICO
include("Cabecalho.php");
$nome = $_SESSION['nomeCliente'];
$menuativo ="";
if (isset($_GET['ordena'])) {
	$menuativo = $_GET['ordena'];
}
if(array_key_exists("cliente",$_GET) && $_GET["cliente"]=="true"){ ?>
	<p class="alert-success">Novo Cliente Cadastrado com Sucesso</p><br>
<?php }
if(array_key_exists("pedido",$_GET) && $_GET["pedido"]=="true"){ ?>
	<p class="alert-success">Pedido Realizado com Sucesso</p><br>
<?php }
?>

<div class="user">
<span><img style="margin-left: 3%;margin-top: 1.5%;margin-right: 5%" src="user.png" width="15%"><span style="font-size: 16px;">Olá <?=$nome?>  ,</span><a style="color: red;float: right;margin-right: 2%;margin-top: 5%" href="Login.php"><button class="btn btn-danger">Sair</button></a>  
</span>
</div>

<form action="" method="post">
    <div class="input-group" style="width: 100%; float: left;margin-top: 10px;margin-bottom: 10px">
      <input type="text" class="form-control" placeholder="Pesquisar em <?php 
      		if($menuativo=='') {echo "Nº Pedido";}
      		if($menuativo=='pedido') {echo "Nº Pedido";}
      		else if($menuativo=='oc') {echo "Ordem Compra";}
      		else if($menuativo=='cliente') {echo "Cliente";}
      		else if($menuativo=='emissao') {echo "Data Emissao";}
      		else if($menuativo=='entrega') {echo "Data Entrega";}
      		else if($menuativo=='valor') {echo "Valor Total";}
      	?>" name="pesquisar">
      <div class="input-group-btn">
        <button style="height: 34px" type="submit" class="btn btn-default"><img width="22px" height="22px" src="search.png"></button>
      </div>
    </div>
 </form>


<table style="width: 99%;margin-top: 20px"   class=" table-striped table-bordered table-hover table-condensed ">
<tr>
	
	<th id="pointer" <?php if($menuativo == 'pedido'){echo "class=ativo";}?> onClick="window.location.href = '?ordena=pedido'">Nº Pedido</th>
	<th id="pointer" <?php if($menuativo == 'oc'){echo "class=ativo";}?> onClick="window.location.href = '?ordena=oc'">OC</th>
	<th id="pointer" <?php if($menuativo == 'cliente'){echo "class=ativo";}?> onClick="window.location.href = '?ordena=cliente'">Cliente</th>
	<th id="pointer" <?php if($menuativo == 'emissao'){echo "class=ativo";}?> onClick="window.location.href = '?ordena=emissao'">Data Emissao</th>
	<th id="pointer" <?php if($menuativo == 'entrega'){echo "class=ativo";}?> onClick="window.location.href = '?ordena=entrega'">Data Entrega</th>
	<th id="pointer" <?php if($menuativo == 'valor'){echo "class=ativo";}?> onClick="window.location.href = '?ordena=valor'">Valor Total</th>
	<th>Detalhes</th>
</tr>

<?php 

function pesquisa($coluna){
	$pesquisar=explode(" ",$_POST['pesquisar']);
	for ($i=0; $i < count($pesquisar); $i++) { 
		if ($i == 0) {
			$pesquisa = $coluna." containing '".$pesquisar[$i];
			if($i + 1 == count($pesquisar) || $i == count($pesquisar)){
				$pesquisa = $coluna." containing '".$pesquisar[$i]."' order by ".$coluna;
			}
		}else if($i + 1 == count($pesquisar)){
			$pesquisa .= "' and ".$coluna." containing '".$pesquisar[$i]."' order by ".$coluna;
		}else{
			$pesquisa .= "' and ".$coluna." containing '".$pesquisar[$i];
		}
	}
	return $pesquisa;	
}

function listaPedidos($conexao){
$codRepresentante = $_SESSION['codRepresentante'];
$pedidosArray = array();

if (!isset($_POST['pesquisar'])) {

	if (isset($_GET['ordena']) && $_GET['ordena'] == 'cliente') {
		$cabecalho = ibase_query($conexao, "select f.numero_pedido,f.numero_o_com, g.nome, f.data_emissao, f.data_entrega, f.valor_total from avec8501 f left outer join augc0301 g on (g.codigo_cliente = f.codigo_cliente) where f.fovendedoraux = '$codRepresentante' order by g.nome ");
	}else if (isset($_GET['ordena']) && $_GET['ordena'] == 'oc') {
		$cabecalho = ibase_query($conexao, "select f.numero_pedido,f.numero_o_com, g.nome, f.data_emissao, f.data_entrega, f.valor_total from avec8501 f left outer join augc0301 g on (g.codigo_cliente = f.codigo_cliente) where f.fovendedoraux = '$codRepresentante' order by f.numero_o_com ");
	}else if (isset($_GET['ordena']) && $_GET['ordena'] == 'emissao') {
		$cabecalho = ibase_query($conexao, "select f.numero_pedido,f.numero_o_com, g.nome, f.data_emissao, f.data_entrega, f.valor_total from avec8501 f left outer join augc0301 g on (g.codigo_cliente = f.codigo_cliente) where f.fovendedoraux = '$codRepresentante' order by f.data_emissao ");
	}else if (isset($_GET['ordena']) && $_GET['ordena'] == 'entrega') {
		$cabecalho = ibase_query($conexao, "select f.numero_pedido,f.numero_o_com, g.nome, f.data_emissao, f.data_entrega, f.valor_total from avec8501 f left outer join augc0301 g on (g.codigo_cliente = f.codigo_cliente) where f.fovendedoraux = '$codRepresentante' order by f.data_entrega ");
	}else if (isset($_GET['ordena']) && $_GET['ordena'] == 'valor') {
		$cabecalho = ibase_query($conexao, "select f.numero_pedido,f.numero_o_com, g.nome, f.data_emissao, f.data_entrega, f.valor_total from avec8501 f left outer join augc0301 g on (g.codigo_cliente = f.codigo_cliente) where f.fovendedoraux = '$codRepresentante' order by f.valor_total ");
	}else{
		$cabecalho = ibase_query($conexao, "select f.numero_pedido,f.numero_o_com, g.nome, f.data_emissao, f.data_entrega, f.valor_total from avec8501 f left outer join augc0301 g on (g.codigo_cliente = f.codigo_cliente) where f.fovendedoraux = '$codRepresentante' order by f.numero_pedido ");
	}
}else {

	if (isset($_GET['ordena']) && $_GET['ordena'] == 'cliente') {
		$pesquisa = pesquisa("g.nome");
		$cabecalho = ibase_query($conexao,"select f.numero_pedido,f.numero_o_com, g.nome, f.data_emissao, f.data_entrega, f.valor_total from avec8501 f left outer join augc0301 g on (g.codigo_cliente = f.codigo_cliente) where f.fovendedoraux = '$codRepresentante' and $pesquisa ");
	}else if (isset($_GET['ordena']) && $_GET['ordena'] == 'oc') {
		$pesquisa = pesquisa("f.numero_o_com");
		$cabecalho = ibase_query($conexao,"select f.numero_pedido,f.numero_o_com, g.nome, f.data_emissao, f.data_entrega, f.valor_total from avec8501 f left outer join augc0301 g on (g.codigo_cliente = f.codigo_cliente) where f.fovendedoraux = '$codRepresentante' and $pesquisa ");
	}else if (isset($_GET['ordena']) && $_GET['ordena'] == 'emissao') {
		$pesquisa = pesquisa("f.data_emissao");
		$cabecalho = ibase_query($conexao,"select f.numero_pedido,f.numero_o_com, g.nome, f.data_emissao, f.data_entrega, f.valor_total from avec8501 f left outer join augc0301 g on (g.codigo_cliente = f.codigo_cliente) where f.fovendedoraux = '$codRepresentante' and $pesquisa ");
	}else if (isset($_GET['ordena']) && $_GET['ordena'] == 'entrega') {
		$pesquisa = pesquisa("f.data_entrega");
		$cabecalho = ibase_query($conexao,"select f.numero_pedido,f.numero_o_com, g.nome, f.data_emissao, f.data_entrega, f.valor_total from avec8501 f left outer join augc0301 g on (g.codigo_cliente = f.codigo_cliente) where f.fovendedoraux = '$codRepresentante' and $pesquisa ");
	}else if (isset($_GET['ordena']) && $_GET['ordena'] == 'valor') {
		$pesquisa = pesquisa("f.valor_total");
		$cabecalho = ibase_query($conexao,"select f.numero_pedido,f.numero_o_com, g.nome, f.data_emissao, f.data_entrega, f.valor_total from avec8501 f left outer join augc0301 g on (g.codigo_cliente = f.codigo_cliente) where f.fovendedoraux = '$codRepresentante' and $pesquisa ");
	}else{
		$pesquisa = pesquisa("f.numero_pedido");
		$cabecalho = ibase_query($conexao,"select f.numero_pedido,f.numero_o_com, g.nome, f.data_emissao, f.data_entrega, f.valor_total from avec8501 f left outer join augc0301 g on (g.codigo_cliente = f.codigo_cliente) where f.fovendedoraux = '$codRepresentante' and $pesquisa ");

	}

}

while ($pedidos = ibase_fetch_assoc($cabecalho)) {
		array_push($pedidosArray,$pedidos);
	}
	return $pedidosArray;
}

$pedidosArray = listaPedidos($conexao);
$i = 0;
foreach ($pedidosArray as $pedidos) {

?>
	 <tr>
	 	<td><?=$pedidos['NUMERO_PEDIDO']?></td>
	 	<td><?=$pedidos['NUMERO_O_COM']?></td>
	 	<td><?=$pedidos['NOME']?></td> 
	 	<td><?=substr($pedidos['DATA_EMISSAO'], -0, -8)?></td> 
	 	<td><?=substr($pedidos['DATA_ENTREGA'], -0, -8)?></td> 
	 	<td>R$ <?=round($pedidos['VALOR_TOTAL'], 2);?></td> 
	 	<td>
	 	<a href="detalhesPedido.php?numeroPedido=<?=$pedidos['NUMERO_PEDIDO']?>&cliente=<?=$pedidos['NOME']?>&valorTfinal=<?=$pedidos['VALOR_TOTAL']?>">Detalhes</a>
		</td>
	 </tr>

<?php } ?>
</table>


<?php include("rodape.php");?>

