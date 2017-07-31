<?php 								// TELA A SER IMPRESSA COM DETALHES DOS PEDIDOS REALIZADOS

include("Cabecalho.php");


$pedido = $_GET['numeroPedido'];
$valorTfinal = $_GET['valorTfinal'];
$item = 0;
$quantTotal = 0;

//	SQL PARA CABECALHO 1
$resultado = mysqli_query($conexao,"select p.CODIGO,p.NOME,p.FONE, p.ENDERECO, p.CIDADE, p.CEP, p.CICCGC from EA p left outer join AVEC8501 q on(q.VELOCAL = p.CODIGO) where q.numero_pedido = '$pedido' ");
$EA = mysqli_fetch_assoc($resultado);

//	SQL PARA CABECALHO 2
$resultado = mysqli_query($conexao,"select p.CODIGO_CLIENTE, p.NOME, p.ENDERECO, p.CIDADE, p.CEP, p.TELEFONE1, p.BAIRRO, p.ESTADO from AUGC0301 p left outer join AVEC8501 q on(q.CODIGO_CLIENTE = p.CODIGO_CLIENTE) where q.numero_pedido = '$pedido' ");
$AUGC0301 = mysqli_fetch_assoc($resultado);


//	SQL PARA RODAPE
$resultado = mysqli_query($conexao,"select p.entregue, p.data_entrega, p.operacao, p.tabela_vencimento, p.codig_transportadora, p.cod_repres, p.valor_total, p.frete, p.desconto_geral, q.desc_op_nf as op, r.descricao as tab from AVEC8501 p
	left outer join AFVC0901 q on (q.cod_op = p.operacao)
	left outer join AFVT0101 r on (r.codigo = p.tabela_vencimento)
	where numero_pedido = '$pedido' ");
$AVEC8501 = mysqli_fetch_assoc($resultado);

$frete = '';
if ($AVEC8501['frete'] == '0') {$frete = 'Retirada'; }
else if ($AVEC8501['frete'] == '1') {$frete = 'CIF - Pago'; }
else if ($AVEC8501['frete'] == '2') {$frete = 'FOB - A Pagar'; }

?>

<div id="impressao">
<div id="imprimir" >
<div style="width: 90%;margin-left: 5%">
<table class="imprime" style="width: 100%;border-top: 1px solid black;font-size: 9pt;border-bottom: 1px solid black">
	<tr>
		<td width="266.6px"><?=$EA['NOME']; ?></td>
		<td style="border-bottom: 1px solid #333" rowspan="3" width="266.6px"><img src="<?php if($EA['CODIGO']=='01'){echo 'Logo Magazin.png';}else{echo 'Logo Rocaza.png';}?>" width="200px"></td>
		<td align="center" width="266.6px">CEP:<?=$EA['CEP'];?><span style="margin-left: 10px"><?=$EA['CIDADE'];?></span></td>
	</tr>
	<tr>
		<td><?=$EA['ENDERECO'];?></td>
		<td align="center">CNPJ:<span style="margin-left: 10px"><?=$EA['CICCGC']?></span></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #333">Fone:<?=$EA['FONE']?></td>
		<td style="border-bottom: 1px solid #333" align="center">Hora:<?=date("H:i");?></td>
	</tr>
	<tr>
		<td style="line-height: 25px">Pedido:<span style="margin-left: 10px;"><?=$pedido?></span></td>
		<td style="text-align: center;"><span>Emissão:</span><?=date("d/m/y");?></td>
		<td style="text-align: center;">Operação:<span style="margin-left: 3%"><?=$AVEC8501['op']; ?></span></td>
	</tr>
	<tr>
		<td style="line-height: 25px">Cliente:<span style="margin-left: 10px;margin-right: 10px"><?=$AUGC0301['CODIGO_CLIENTE'];?></span><span style="font-weight: bold;"><?=$AUGC0301['NOME'];?></span></td>
		<td style="text-align: center">Fone:<span style="margin-left: 3%"><?=$AUGC0301['TELEFONE1']; ?></span></td>
		<td style="text-align: center;">CEP:<span style="margin-left: 3%"><?=$AUGC0301['CEP']; ?></span></td>
	</tr>
	<tr>
		<td style="line-height: 25px;">Endereço:<span style="margin-left: 3%"><?=$AUGC0301['ENDERECO']; ?></span></td>
		<td style="text-align: center;">Cidade/UF:<span style="margin-left: 3%"><?=$AUGC0301['CIDADE']."/".$AUGC0301['ESTADO']; ?></span></td>
		<td style="text-align: center;">Bairro:<span style="margin-left: 3%"><?=$AUGC0301['BAIRRO']; ?></span></td>
	</tr>

</table>

<table class="imprime" width="100%" style="width: 100%;font-size: 9pt;margin-top: 20px;">
<tr>
	<td width="3%" style="line-height: 30px;border-bottom: 2px solid #333"><span style="font-weight: bold;">#</span></td>
	<td width="10%" style="border-bottom: 2px solid #333"><span style="font-weight: bold;">Código</span></td>
	<td style="border-bottom: 2px solid #333"><span style="font-weight: bold;">Descrição</span></td>
	<td width="9%" style="border-bottom: 2px solid #333"><span style="font-weight: bold;">Quantidade</span></td>
	<td width="12%" style="border-bottom: 2px solid #333" align="center"><span style="font-weight: bold;">Valor</span></td>
	<td width="10%" style="border-bottom: 2px solid #333" align="center"><span style="font-weight: bold;">% Desc</span></td>
	<td width="12%" style="border-bottom: 2px solid #333" align="center"><span style="font-weight: bold;">Total</span></td>
	<td width="15%" style="border-bottom: 2px solid #333"><span style="font-weight: bold;">Obs</span></td>
</tr>
<?php
//	SQL PARA CORPO
$resultado = mysqli_query($conexao,"select p.cod,p.codigo,p.valor,p.quantidade,p.desconto,p.total_unit,p.obs from AVEC85IT p where p.numero_pedido = '$pedido' order by p.cod ");
while ($AVEC85IT = mysqli_fetch_assoc($resultado)) {?>

<tr>
	<td width="3%"><?=$AVEC85IT['cod']; ?></td>
	<td width="10%"><?=$AVEC85IT['codigo']; ?></td>
	<td><?=$AVEC85IT['codigo']; ?></td>
	<td width="9%" style="text-align: center;"><?=$AVEC85IT['quantidade']; ?></td>
	<td width="12%" style="text-align: right;"><?php printf("%.2f",$AVEC85IT['valor']); ?></td>
	<td width="10%" style="text-align: center;"><?=$AVEC85IT['desconto']; ?></td>
	<td width="12%" style="text-align: right;"><?php printf("%.2f",$AVEC85IT['total_unit']); ?></td>
	<td width="12%"><?=$AVEC85IT['obs']; ?></td>
</tr>


<?php 	if ($item < $AVEC85IT['cod']) {
 		$item = $AVEC85IT['cod'];
 	}
 	$quantTotal = $quantTotal + $AVEC85IT['quantidade'];
} ?>

</table>


<div style="position: absolute; bottom: 4cm;width: 21cm;  font-family: arial, sans-serif;font-size: 8pt;">

	<table class="imprime" style="line-height: 25px;width: 100%;border-top: 2px solid black;font-size: 9pt;width: 90%">
	<tr>
		<td width="35%">Tabela Venc: <span style="margin-left: 5%"><?=$AVEC8501['tab'];?></span></td>
		<td width="35%">Quant Total:<span style="margin-left: 5%"><?=$quantTotal; ?></span></td>
		<td width="30%">Itens:<span style="margin-left: 5%"><?=$item;?></span></td>
	</tr>
	<tr>
		<td width="35%">Transportadora: <span style="margin-left: 5%"><?=$AVEC8501['codig_transportadora'];?></span></td>
		<td width="35%">Representante:<span style="margin-left: 5%"><?=$AVEC8501['cod_repres']; ?></span></td>
		<td width="30%">Frete:<span style="margin-left: 5%"><?=$frete;?></span></td>
	</tr>
	<tr>
		<td width="35%">Data Entrega: <span style="margin-left: 5%"><?=substr($AVEC8501['data_entrega'], 0, 10);?></span></td>
		<td width="30%">Desconto Geral:<span style="margin-left: 5%"><?=$AVEC8501['desconto_geral'];?></span></td>
		<td width="35%">Obs.:<span style="margin-left: 5%"><?=$AVEC8501['entregue']; ?></span></td>
	</tr>
	<tr style="line-height: 60px">
		<td><strong>TOTAL:<strong style="margin-left: 10%">R$<?=$AVEC8501['valor_total']; ?></strong></strong></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td></td>
		<td><p style="border-style:solid;border-width:1px;border-color:#333;width: 80%"></p></td>
		<td><p style="border-style:solid;border-width:1px;border-color:#333;width: 95%"></p></td>
	</tr>
	<tr>
		<td></td>
		<td>Ass. Cliente</td>
		<td>Ass. Operador</td>
	</tr>
	</table>
</div>

</div>
</div>
</div>


<input type="button" class="cadFeito2" onclick="printPagEArEA('impressao')" value="Imprimir">

<script>
    function printPagEArEA(arEAID){
    var printContent = document.getElementById(arEAID);
    var WinPrint = window.open('', '', '');
    WinPrint.document.write(printContent.innerHTML);
    WinPrint.document.close();
    WinPrint.focus();
    WinPrint.print();
   	WinPrint.document.close();
   	WinPrint.close();
}
</script>
