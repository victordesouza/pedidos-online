<?php                 // TELA PARA REALIZAR PEDIDO, CONTÉM CABEÇALHO, CORPO E RODAPÉ 
include("Cabecalho.php");

if(array_key_exists("zerar",$_GET) && $_GET["zerar"]=="true"){
  $nomeCliente = $_SESSION['nomeCliente'];
  $codRepresentante = $_SESSION['codRepresentante'];
  session_unset();
  $_SESSION['itensAtivos'] = 0;
  $_SESSION['nomeCliente'] = $nomeCliente;
  $_SESSION['codRepresentante'] = $codRepresentante;
}
if(array_key_exists("feito",$_GET) && $_GET["feito"]=="true" && isset($_POST['codCliente'])){
  $escolhaCliente = $_POST['codCliente'];
  $_SESSION['escolhaCliente'] = $escolhaCliente;
}
if(array_key_exists("feitoTrans",$_GET) && $_GET["feitoTrans"]=="true" && isset($_POST['codTrans'])&& isset($_POST['nomeTrans'])){
  $escolhaTrans = $_POST['nomeTrans'];
  $_SESSION['escolhaTrans'] = $escolhaTrans;
  $_SESSION['codTrans'] = $_POST['codTrans'];
}
if(array_key_exists("feitoProduto",$_GET) && $_GET["feitoProduto"]=="true" && isset($_POST['descricaoProduto']) && isset($_POST['precoProduto']) && isset($_POST['codProduto']) && isset($_POST['ipi']) && isset($_POST['icms'])){
  $_SESSION['descricaoProduto'] = $_POST['descricaoProduto'];
  $_SESSION['precoProduto'] = $_POST['precoProduto'];
  $_SESSION['escolhaProduto'] = $_POST['codProduto'];
  $_SESSION['ipi'] = $_POST['ipi'];
  $_SESSION['icms'] = $_POST['icms'];
}
if(array_key_exists("feitoTab",$_GET) && $_GET["feitoTab"]=="true" && isset($_POST['descricaoTab']) && isset($_POST['codTab'])){
  $escolhaTab = $_POST['descricaoTab'];
  $_SESSION['escolhaTab'] = $escolhaTab;
  $_SESSION['codTab'] = $_POST['codTab'];
}
if(array_key_exists("error",$_GET) && $_GET["error"]=="true"){ ?>
<p class="alert-danger">Preencha os Campos Obrigatórios</p><br>
<?php }
if (isset($_SESSION['valorT'])) {
  $valorTfinal = array_sum($_SESSION['valorT']);
}else {
  $valorTfinal = 0;
}
$_SESSION['quantTotal'] = 0;
$_SESSION['item'] = 0;
if (isset($_POST['operacao'])) {
  $_SESSION['operacao'] = $_POST['operacao'];
}
$ipiTotal = 0;
if (isset($_POST['local'])) {
  $_SESSION['local'] = $_POST['local'];
}

if (isset($_POST['oc'])) {
  $_SESSION['oc'] = $_POST['oc'];
}

$trans = ibase_query($conexao,"select FNOME, FCOD from augc0501 where FTIPO ='T'");

if (isset($_GET['tabDesc'])) {
  $_SESSION['tabDesc'] = $_GET['tabDesc'];
}else{$_SESSION['tabDesc']=0;}
$tabDesc = $_SESSION['tabDesc'];

?>

<script>
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>

<h3 align="center">Realizar Novo Pedido</h3>
  <div class="conteudo">
  <div class="cabecalho">             <!-- ###########   CABEÇALHO   ###############-->  

    <table align="left" width="90%" style="margin-left: 50px;line-height: 170%">
    <tr>
      <th>Cliente: *</th>
      <td><form action="PesqCliente.php">
        <input id="cabecalhotxt" style="margin-left: 30px;margin-top: 3px;text-align: center;" type="text" value="<?php if(isset($_SESSION['escolhaCliente'])){echo $_SESSION['escolhaCliente'];}?>" name="cli" disabled>
        <button style="margin-top: 3px;margin-left: 10px;height: 25px;" type="submit" class="btn btn-default"><img width="22px" height="22px" src="search.png"></button>
      </form></td>

      <td></td><td></td>
      <form action="Transportadora.php" method="post">
      <th><p style="margin-left: 100px;font-size: 14px;font-family: Helvetica ", Helvetica, Arial, sans-serif;">Transportadora: *</p></th>
      <td>
        <input id="cabecalhotxt" style="margin-left: 50px;margin-top: 3px;text-align: center;" type="text" value="<?php if(isset($_SESSION['escolhaTrans'])){echo $_SESSION['escolhaTrans'];}?>" name="trans" disabled>
        <button style="margin-top: 3px;margin-left: 10px;height: 25px;" type="submit" class="btn btn-default"><img width="22px" height="22px" src="search.png"></button>
      </td></form>

    </tr>
    <tr>
      <th>Tabela de Vencimento: *</th>
      <td><form action="TabVencimento.php">
        <input id="cabecalhotxt" style="margin-left: 30px;margin-top: 3px;text-align: center;" type="text" name="tabVencimento" value="<?php if(isset($_SESSION['escolhaTab'])){echo $_SESSION['escolhaTab'];}?>" disabled>
        <button style="margin-top: 3px;margin-left: 10px;height: 25px;" type="submit" class="btn btn-default"><img width="22px" height="22px" src="search.png"></button>
      </form></td>
      <td></td><td></td>
      <form action="" method="post">
      <th><p style="margin-left: 100px;font-size: 14px;font-family: Helvetica ", Helvetica, Arial, sans-serif;">Local: *</p></th>
      <td><select name="local" onchange="this.form.submit()" style="margin-left: 50px;width: 180px;float: left;font-size: 11px;height: 28px" class="form-control" id="sel1" <?php if($_SESSION['itensAtivos']!='0'&&$_SESSION['local']!='0'){echo "disabled='' ";} ?>>
          <option value="0" <?php if(isset($_SESSION['local']) && $_SESSION['local']==0){echo "selected";}?>>Selecionar</option>
          <option value="1" <?php if(isset($_SESSION['local']) && $_SESSION['local']==1){echo "selected";}?>>01-MAGAZIN ESTOFADOS</option>
          <option value="2" <?php if(isset($_SESSION['local']) && $_SESSION['local']==2){echo "selected";}?>>02-MOVEIS ROCAZA</option>
        </select></td>
      </form>
      </tr>
    <tr>
      <th>Operação: *</th>
      <form action="" method="post">
      <td><select  onchange="this.form.submit()" name="operacao" style="margin-left: 30px;width: 180px;float: left;font-size: 11px;height: 28px" class="form-control" id="sel1" <?php if($_SESSION['itensAtivos']!='0'&&$_SESSION['operacao']!='0'){echo "disabled='' ";} ?>>
          <option value="0" <?php if(isset($_SESSION['operacao']) && $_SESSION['operacao']==0){echo "selected";}?>>Selecionar</option>
          <option value="1" <?php if(isset($_SESSION['operacao']) && $_SESSION['operacao']==1){echo "selected";}?>>Venda Dentro do Estado</option>
          <option value="2" <?php if(isset($_SESSION['operacao']) && $_SESSION['operacao']==2){echo "selected";}?>>Venda Fora do Estado</option>
        </select></td>
      </form>

      <td></td><td></td>
      <form action="" method="post">
      <th><p style="margin-left: 100px;font-size: 14px;font-family: Helvetica ", Helvetica, Arial, sans-serif;">Ordem de Compra: *</p></th>
      <td><input value="<?php if(isset($_SESSION['oc'])){echo $_SESSION['oc'];}?>" style="margin-left: 50px;height: 25px;text-align: center;<?php if(isset($_SESSION['oc'])){echo "background-color: #f5f5f5";}?>" height="20px" id="txtgenerico" type="text" name="oc" <?php if(isset($_SESSION['oc'])){echo "readonly";}?> >
      <button style="margin-left: 10px;height: 25px;" type="submit" class="btn btn-default"><img width="22px" height="22px" src="certo.png"></button>
      </td>
      </form>

    </tr>
    </table>
  </div>          <!-- ###########   FIM CABEÇALHO   ###############-->  

  <div class="corpo">       <!-- ###########   CORPO   ###############-->          
    
  <table class="corpo" style="margin-bottom: 1.5%" align="center">
    <tr>
      <th class="corpo" width="4%">Itens</th>
      <th class="corpo" width="15%">Nº Produto*</th>
      <th class="corpo">Descrição</th>
      <th class="corpo" width="6%">Quantidade*</th>
      <th class="corpo" width="12%">% Desc</th>
      <th class="corpo" width="10%">Valor Unit*</th>
      <th class="corpo" width="6%">% IPI</th>
      <th class="corpo" width="6%">% ICMS</th>
      <th class="corpo" width="12%">Valor Total</th>
      <th class="corpo" width="6%">Modificar</th>
    </tr>

  <form action="addPedido.php" method="post">       <!-- PARA ADICIONAR UM ITEM À LISTA DE PRODUTOS DO PEDIDO -->
    <tr>
    <td align="center">#</td>
      <td class="corpo"><input id="corpotxt" type="text" name="nProduto" value="<?php if(isset($_SESSION['escolhaProduto'])){echo $_SESSION['escolhaProduto'];}?>"><button style="margin-left: 3px;" type="button" onclick="window.location.href='PesqProduto.php';" class="btn btn-default"><img width="22px" height="22px" src="search.png"></button></td>

      <td class="corpo"><input type="text" name="descProduto" id="descricaotxt" align="center" value="<?php if(isset($_SESSION['descricaoProduto'])){echo $_SESSION['descricaoProduto'];}?>"></td>
      
      <td class="corpo"><input id="corpotxt" type="number" name="quant" min="1" value="1"></td>
     
     <td class="corpo"><input id="quant" type="text" style="background-color: white;" name="desc" value="<?php if(isset($_POST['tabDesc'])){echo $_POST['tabDesc'];} ?>"><button style="margin-left: 3%;" type="button" onclick="window.location.href='desconto.php';" class="btn btn-default"><img width="22px" height="22px" src="search.png"></button></td>

      <td class="corpo"><input id="corpotxt" type="text" style="background-color: white;" name="valorU" value="<?php if(isset($_SESSION['precoProduto'])){echo $_SESSION['precoProduto'];}?>"></td>

      <td class="corpo"><input id="corpotxt" type="text" style="background-color: #f5f5f5;" name="ipi" value="<?php if(isset($_SESSION['ipi'])){echo $_SESSION['ipi'];}else{echo "";}?>" readonly ></td>

      <td class="corpo"><input id="corpotxt" type="text" style="background-color: #f5f5f5;" name="icms" value="<?php if(isset($_SESSION['icms'])){echo $_SESSION['icms'];}else{echo "";}?>" readonly ></td>

      <td class="corpo"><input id="corpotxt" type="text" style="background-color: #f5f5f5;" name="valorT" disabled></td>
      <td class="corpo" align="center" ><button style="margin-left: 10px;height: 25px;" type="submit" class="btn btn-default"><img width="22px" height="22px" src="certo.png"></button></td>
    </tr>
  </form>
</table>
<table class="corpo" style="margin-bottom: 1.5%" align="center">
<?php
if (isset($_SESSION['cesta'])) {
  $arrlength = count($_SESSION['cesta']);

for($x = 0; $x < $arrlength; $x++) {
  if (!empty($_SESSION['cesta'][$x]) && !empty($_SESSION['valorU'][$x])) {
    $_SESSION['quantTotal'] = $_SESSION['quantTotal'] + $_SESSION['quant'][$x];
?>


<tr><form action="removePedido.php" method="post">      <!--PARA REMOVER UM ITEM À LISTA DE PRODUTOS DO PEDIDO-->
      <td width="4%" class="corpo" align="center"><?php $_SESSION['item']++; echo $_SESSION['item']; ?></td>  

      <td width="15%" class="corpo"><input id="corpotxt" style="text-align: center;background-color: #f5f5f5;" type="text" name="valor" value="<?=$_SESSION['cesta'][$x];?>" disabled></td>
      
      <td class="corpo"><p id="descricaotxt"><?=$_SESSION['descProduto'][$x]; ?></p></td>

      <td width="6%" class="corpo"><input id="corpotxt" style="text-align: center;background-color: #f5f5f5;" type="text" name="quant" value="<?=$_SESSION['quant'][$x];?>" disabled></td>

      <td  width="12%" class="corpo"><input id="corpotxt" type="text" style="background-color: #f5f5f5;" name="desc" value="<?=$_SESSION['desc'][$x]; ?>" disabled></td>

      <td  width="10%" class="corpo"><input id="corpotxt" type="text" style="background-color: #f5f5f5;" name="valorU" value="R$ <?=$_SESSION['valorU'][$x];?>" disabled></td>

      <td  width="6%" class="corpo"><input id="corpotxt" type="text" style="background-color: #f5f5f5;"  value="<?=$_SESSION['ipiProduto'][$x];?>" disabled></td>

      <td  width="6%" class="corpo"><input id="corpotxt" type="text" style="background-color: #f5f5f5;" value="<?=$_SESSION['icmsProduto'][$x];?>" disabled></td>

      <td width="12%" class="corpo"><input id="corpotxt" type="text" style="background-color: #f5f5f5;" name="valorT" value="R$ <?=$_SESSION['valorT'][$x];?>" disabled></td>
      <td width="6%" class="corpo" align="center"><button type="submit" class="btn btn-default"><img width="22px" height="22px" src="error.png"></button></td>

      <input type="hidden" name="escolha" value="<?php echo $x;?>">
    </form>
    </tr>

<?php
}}}
?>



  </table>
  </div>                  <!-- ###########   FIM  CORPO   ###############-->  


  <div class="rodape">            <!-- ###########   RODAPE   ###############-->  
    <table align="left" style="margin-left: 5%;line-height: 170%;width: 95%">         
    <form action="Confirmacao.php" method="post">
    <tr>
      <th><p>% Desc Geral:</p> </th>
      <td>
        <input style="text-align: center;" type="text" name="descGeral" id="rodapetxt" >%
      </td>
      <th>Quantidade Total: *</th>
      <td>
        <input type="text" style="background-color: #f5f5f5;text-align: center;" id="rodapetxt" name="quantTotal" value="<?=$_SESSION['quantTotal'];?>" disabled>
      </td>
    </tr>
    <tr>
      <th><p>Valor IPI:</p></th>
      <td>
        <input type="text" style="text-align: center;background-color: #f5f5f5" id="rodapetxt" name="valorIPI" readonly="" value="<?php if(isset($_SESSION['ipiT']) && isset($_SESSION['local']) && $_SESSION['local'] == '1') { echo 'R$ '.(array_sum($_SESSION['ipiT']) * 0.05);} else { echo "R$ 0";} ?>">
      </td> 
      <th><p>Valor Total:</p></th>
      <td>
      <input type="text" style="text-align: center;background-color: #f5f5f5" id="rodapetxt" name="valorTfinal" readonly="" value="<?='R$ '.$valorTfinal;?>" >
      </td> 

    </tr>
    <tr>
        <th>Tipo de Frete: *</th>

      <td><select name="frete" style="width: 180px;float: left;font-size: 11px;height: 28px" class="form-control" id="sel1">
          <option value="0">Retirada</option>
          <option value="1">CIF - Pago</option>
          <option value="2">FOB - A Pagar</option>
        </select></td>

      <td></td>
      <td>
        <input type="submit" name="submit" value="Finalizar" class="cadFeito">
      </td>
    </tr>
    </form>
    </table>
  </div>
  </div>

            <!-- ###########   FIM  RODAPE   ###############-->  
<?php include("rodape.php");?>


