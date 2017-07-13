<?php include("Cabecalho.php");	// TELA PARA SELEÇÃO DE CLIENTES COM FILTROS DE COLUNAS EM ORDEM CRESCENTE E PESQUISA POR COLUNA ATIVA
$menuativo ="";
if (isset($_GET['ordena'])) {
	$menuativo = $_GET['ordena'];
}

?>
<h2 align="center">Tabela de Clientes</h2>

<form action="" method="post">
    <div class="input-group">
      <input type="text" class="form-control" placeholder="Pesquisar em <?php 
      		if($menuativo=='') {echo "Codigo";}
      		if($menuativo=='codC') {echo "Codigo";}
      		else if($menuativo=='nomeC') {echo "Nome";}
      		else if($menuativo=='CNPJ') {echo "CNPJ";}
      		else if($menuativo=='cidade') {echo "Cidade";}
      		else if($menuativo=='estado') {echo "Estado";}
      	?>" name="pesquisar">
      <div class="input-group-btn">
        <button style="height: 34px" type="submit" class="btn btn-default"><img width="22px" height="22px" src="search.png"></button>
      </div>
    </div>
 </form>



<table style="width: 100%;margin-top: 20px" align="center"  class=" table-striped table-bordered table-hover table-condensed ">
<tr>
	<th id="pointer"><input type="checkbox" disabled="true"></th>
	<th id="pointer"<?php if($menuativo == 'codC'){echo "class=ativo";}?> onClick="window.location.href = '?ordena=codC'">Codigo Cliente</th>
	<th id="pointer"<?php if($menuativo == 'nomeC'){echo "class=ativo";}?> onClick="window.location.href = '?ordena=nomeC'">Nome</th>
	<th id="pointer"<?php if($menuativo == 'CNPJ'){echo "class=ativo";}?> onClick="window.location.href = '?ordena=CNPJ'">CNPJ</th>
	<th id="pointer"<?php if($menuativo == 'cidade'){echo "class=ativo";}?> onClick="window.location.href = '?ordena=cidade'">Cidade</th>
	<th id="pointer"<?php if($menuativo == 'estado'){echo "class=ativo";}?> onClick="window.location.href = '?ordena=estado'">Estado</th>
</tr>

<?php 

function listaCliente($conexao){
	$clientesArray = array();
	if (!isset($_POST['pesquisar'])) {
		$resultado = mysqli_query($conexao,"select CODIGO_CLIENTE,NOME,CGC_CNPJ,CIDADE,ESTADO from AUGC0301 ORDER BY CODIGO_CLIENTE");
		if (isset($_GET['ordena']) && $_GET['ordena'] == 'nomeC') {
		$resultado = mysqli_query($conexao,"select CODIGO_CLIENTE,NOME,CGC_CNPJ,CIDADE,ESTADO from AUGC0301 ORDER BY NOME");
		}
		if (isset($_GET['ordena']) && $_GET['ordena'] == 'codC') {
		$resultado = mysqli_query($conexao,"select CODIGO_CLIENTE,NOME,CGC_CNPJ,CIDADE,ESTADO from AUGC0301 ORDER BY CODIGO_CLIENTE");
		}
		if (isset($_GET['ordena']) && $_GET['ordena'] == 'CNPJ') {
		$resultado = mysqli_query($conexao,"select CODIGO_CLIENTE,NOME,CGC_CNPJ,CIDADE,ESTADO from AUGC0301 ORDER BY CGC_CNPJ");
		}
		if (isset($_GET['ordena']) && $_GET['ordena'] == 'cidade') {
		$resultado = mysqli_query($conexao,"select CODIGO_CLIENTE,NOME,CGC_CNPJ,CIDADE,ESTADO from AUGC0301 ORDER BY CIDADE");
		}
		if (isset($_GET['ordena']) && $_GET['ordena'] == 'estado') {
		$resultado = mysqli_query($conexao,"select CODIGO_CLIENTE,NOME,CGC_CNPJ,CIDADE,ESTADO from AUGC0301 ORDER BY ESTADO");
		}
	}else {
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

		if (isset($_GET['ordena']) && $_GET['ordena'] == 'nomeC') {
			$pesquisa = pesquisa("NOME");
			$resultado = mysqli_query($conexao,"select CODIGO_CLIENTE,NOME,CGC_CNPJ,CIDADE,ESTADO from AUGC0301 where $pesquisa ");
		}
		if (isset($_GET['ordena']) && $_GET['ordena'] == 'codC') {
			$pesquisa = pesquisa("CODIGO_CLIENTE");
			$resultado = mysqli_query($conexao,"select CODIGO_CLIENTE,NOME,CGC_CNPJ,CIDADE,ESTADO from AUGC0301 where $pesquisa ");
		}
		if (isset($_GET['ordena']) && $_GET['ordena'] == 'CNPJ') {
			$pesquisa = pesquisa("CGC_CNPJ");
			$resultado = mysqli_query($conexao,"select CODIGO_CLIENTE,NOME,CGC_CNPJ,CIDADE,ESTADO from AUGC0301 where $pesquisa ");
		}
		if (isset($_GET['ordena']) && $_GET['ordena'] == 'cidade') {
			$pesquisa = pesquisa("CIDADE");
			$resultado = mysqli_query($conexao,"select CODIGO_CLIENTE,NOME,CGC_CNPJ,CIDADE,ESTADO from AUGC0301 where $pesquisa ");
		}
		if (isset($_GET['ordena']) && $_GET['ordena'] == 'estado') {
			$pesquisa = pesquisa("ESTADO");
			$resultado = mysqli_query($conexao,"select CODIGO_CLIENTE,NOME,CGC_CNPJ,CIDADE,ESTADO from AUGC0301 where $pesquisa ");
		}if (!isset($_GET['ordena'])) {
			$pesquisa = pesquisa("NOME");
			$resultado = mysqli_query($conexao,"select CODIGO_CLIENTE,NOME,CGC_CNPJ,CIDADE,ESTADO from AUGC0301 where $pesquisa ");
		}
	}
	while ($clientes = mysqli_fetch_assoc($resultado)) {
		array_push($clientesArray,$clientes);
	}
	return $clientesArray;
}

$clientesArray = listaCliente($conexao);

$i = 0;
foreach ($clientesArray as $clientes) {

?>
	 <tr>
	 	<td>
		<form action="NvPedido.php?feito=true" method="post">
			<input type="hidden" name="codCliente" value="<?=$clientes['CODIGO_CLIENTE']?>">
			<input type="hidden" name="nomeCliente" value="<?=$clientes['NOME']?>">
			<input type="checkbox" name="checkbox" onChange="this.form.submit()">
		</form>
		</td>
	 	<td><?=$clientes['CODIGO_CLIENTE']?></td>
	 	<td><?=$clientes['NOME']?></td> 
	 	<td><?=$clientes['CGC_CNPJ']?></td> 
	 	<td><?=$clientes['CIDADE']?></td> 
	 	<td><?=$clientes['ESTADO']?></td> 
	 </tr>

<?php } ?>
</table>
<?php include("rodape.php");?>
