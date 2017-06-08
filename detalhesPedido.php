<?php 								// TELA A SER IMPRESSA COM DETALHES DOS PEDIDOS REALIZADOS

include("Cabecalho.php");


$pedido = $_GET['numeroPedido'];
$valorTfinal = $_GET['valorTfinal'];
$item = 0;
$quantTotal = 0;

//	SQL PARA CABECALHO 1
$resultado = ibase_query($conexao,"select p.CODIGO,p.NOME,p.FONE, p.ENDERECO, p.CIDADE, p.CEP, p.CICCGC from ea p left outer join avec8501 q on(q.VELOCAL = p.CODIGO) where q.numero_pedido = '$pedido' ");
$ea = ibase_fetch_assoc($resultado);

//	SQL PARA CABECALHO 2
$resultado = ibase_query($conexao,"select p.CODIGO_CLIENTE, p.NOME, p.ENDERECO, p.CIDADE, p.CEP, p.TELEFONE1, p.BAIRRO, p.ESTADO from augc0301 p left outer join avec8501 q on(q.CODIGO_CLIENTE = p.CODIGO_CLIENTE) where q.numero_pedido = '$pedido' ");
$augc0301 = ibase_fetch_assoc($resultado);


//	SQL PARA RODAPE
$resultado = ibase_query($conexao,"select p.entregue, p.data_entrega, p.operacao, p.tabela_vencimento, p.codig_transportadora, p.cod_repres, p.valor_total, p.frete, p.desconto_geral, q.desc_op_nf as op, r.descricao as tab from avec8501 p 
	left outer join afvc0901 q on (q.cod_op = p.operacao) 
	left outer join afvt0101 r on (r.codigo = p.tabela_vencimento)
	where numero_pedido = '$pedido' ");
$avec8501 = ibase_fetch_assoc($resultado);

$frete = '';
if ($avec8501['FRETE'] == '0') {$frete = 'Retirada'; }
else if ($avec8501['FRETE'] == '1') {$frete = 'CIF - Pago'; }
else if ($avec8501['FRETE'] == '2') {$frete = 'FOB - A Pagar'; }

?>

<div id="impressao">
<div id="imprimir" >
<div style="width: 90%;margin-left: 5%">
<table class="imprime" style="width: 100%;border-top: 1px solid black;font-size: 9pt;border-bottom: 1px solid black">
	<tr>
		<td width="266.6px"><?=$ea['NOME']; ?></td>
		<td style="border-bottom: 1px solid #333" rowspan="3" width="266.6px"><img src="<?php if($ea['CODIGO']=='01'){echo 'Logo Magazin.png';}else{echo 'Logo Rocaza.png';}?>" width="200px"></td>
		<td align="center" width="266.6px">CEP:<?=$ea['CEP'];?><span style="margin-left: 10px"><?=$ea['CIDADE'];?></span></td>
	</tr>
	<tr>
		<td><?=$ea['ENDERECO'];?></td>
		<td align="center">CNPJ:<span style="margin-left: 10px"><?=$ea['CICCGC']?></span></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #333">Fone:<?=$ea['FONE']?></td>
		<td style="border-bottom: 1px solid #333" align="center">Hora:<?=date("H:i");?></td>
	</tr>
	<tr>
		<td style="line-height: 25px">Pedido:<span style="margin-left: 10px;"><?=$pedido?></span></td>
		<td style="text-align: center;"><span>Emissão:</span><?=date("d/m/y");?></td>
		<td style="text-align: center;">Operação:<span style="margin-left: 3%"><?=$avec8501['OP']; ?></span></td>
	</tr>
	<tr>
		<td style="line-height: 25px">Cliente:<span style="margin-left: 10px;margin-right: 10px"><?=$augc0301['CODIGO_CLIENTE'];?></span><span style="font-weight: bold;"><?=$augc0301['NOME'];?></span></td>	
		<td style="text-align: center">Fone:<span style="margin-left: 3%"><?=$augc0301['TELEFONE1']; ?></span></td>
		<td style="text-align: center;">CEP:<span style="margin-left: 3%"><?=$augc0301['CEP']; ?></span></td>
	</tr>
	<tr>
		<td style="line-height: 25px;">Endereço:<span style="margin-left: 3%"><?=$augc0301['ENDERECO']; ?></span></td>
		<td style="text-align: center;">Cidade/UF:<span style="margin-left: 3%"><?=$augc0301['CIDADE']."/".$augc0301['ESTADO']; ?></span></td>
		<td style="text-align: center;">Bairro:<span style="margin-left: 3%"><?=$augc0301['BAIRRO']; ?></span></td>
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
$resultado = ibase_query($conexao,"select p.cod,p.codigo,p.valor,p.quantidade,p.desconto,p.total_unit,p.obs from avec85it p where p.numero_pedido = '$pedido' order by p.cod ");
while ($avec85it = ibase_fetch_assoc($resultado)) {?>
 	
<tr>
	<td width="3%"><?=$avec85it['COD']; ?></td>
	<td width="10%"><?=$avec85it['CODIGO']; ?></td>
	<td><?=$avec85it['CODIGO']; ?></td>
	<td width="9%" style="text-align: center;"><?=$avec85it['QUANTIDADE']; ?></td>
	<td width="12%" style="text-align: right;"><?php printf("%.2f",$avec85it['VALOR']); ?></td>
	<td width="10%" style="text-align: center;"><?=$avec85it['DESCONTO']; ?></td>
	<td width="12%" style="text-align: right;"><?php printf("%.2f",$avec85it['TOTAL_UNIT']); ?></td>
	<td width="12%"><?=$avec85it['OBS']; ?></td>
</tr>


<?php 	if ($item < $avec85it['COD']) {
 		$item = $avec85it['COD'];
 	}
 	$quantTotal = $quantTotal + $avec85it['QUANTIDADE'];
} ?>

</table>


<div style="position: absolute; bottom: 4cm;width: 21cm;  font-family: arial, sans-serif;font-size: 8pt;">
	
	<table class="imprime" style="line-height: 25px;width: 100%;border-top: 2px solid black;font-size: 9pt;width: 90%">
	<tr>
		<td width="35%">Tabela Venc: <span style="margin-left: 5%"><?=$avec8501['TAB'];?></span></td>
		<td width="35%">Quant Total:<span style="margin-left: 5%"><?=$quantTotal; ?></span></td>
		<td width="30%">Itens:<span style="margin-left: 5%"><?=$item;?></span></td>
	</tr>
	<tr>
		<td width="35%">Transportadora: <span style="margin-left: 5%"><?=$avec8501['CODIG_TRANSPORTADORA'];?></span></td>
		<td width="35%">Representante:<span style="margin-left: 5%"><?=$avec8501['COD_REPRES']; ?></span></td>
		<td width="30%">Frete:<span style="margin-left: 5%"><?=$frete;?></span></td>
	</tr>
	<tr>
		<td width="35%">Data Entrega: <span style="margin-left: 5%"><?=substr($avec8501['DATA_ENTREGA'], 0, 10);?></span></td>
		<td width="30%">Desconto Geral:<span style="margin-left: 5%"><?=$avec8501['DESCONTO_GERAL'];?></span></td>
		<td width="35%">Obs.:<span style="margin-left: 5%"><?=$avec8501['ENTREGUE']; ?></span></td>
	</tr>
	<tr style="line-height: 60px">
		<td><strong>TOTAL:<strong style="margin-left: 10%">R$<?=$avec8501['VALOR_TOTAL']; ?></strong></strong></td>
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


<input type="button" class="cadFeito2" onclick="printPageArea('impressao')" value="Imprimir">

<script>
    function printPageArea(areaID){
    var printContent = document.getElementById(areaID);
    var WinPrint = window.open('', '', '');
    WinPrint.document.write(printContent.innerHTML);
    WinPrint.document.close();
    WinPrint.focus();
    WinPrint.print();
   	WinPrint.document.close();
   	WinPrint.close();
}
</script>