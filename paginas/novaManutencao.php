<?php
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

function trata($preco){
	if(!is_numeric($preco)) {
		$preco= str_replace(".","",$preco);
		$preco = str_replace(",",".",$preco);
	}
	return $preco;
}

function convertData($i){
	if(!empty($i)){
		return implode('-',array_reverse(explode('/', $i)));
	} else {
		return null;
	}		
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  
	$valor_total_aparelho = trata( $_POST['valor_total_aparelho'] );
	$_SESSION['sac_id'] = $_POST['sac_id'];
	$qtdeParcelasManutencao = intval( @$_POST['numero_parcela_manutencao'] );
	$venc_parcelas = convertData( @$_POST['manutencao_data_vencimento'] );
	$valor_manutencao = str_replace(",",".", @$_POST['valor_mensal_manutencao']);
	
	//Conta a qtde de meses
	$dataVencimento = $_POST['data_vencimento_aparelho'];
	
	$qtdeParcelasAparelho=0;
	foreach($dataVencimento AS $soma){
		if($soma !=="")
			$qtdeParcelasAparelho=$qtdeParcelasAparelho+1;
	}
	
	$valor_parcela_aparelho = ( $valor_total_aparelho  / $qtdeParcelasAparelho );
	//-----------------
	
	$insertSQL = sprintf("INSERT INTO `manutencao` (`sac_id`, `id_especialista`, `valor_total_aparelho`, `valor_parcela_aparelho`, `valor_parcela_manutencao`, `qtde_parcela_aparelho`, `qtde_parcela_manutencao`, `observacoes`, `data_cadastro`) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', NOW())",
	@$_POST['sac_id'],
	@$_POST['responsavel_id'],
	@$valor_total_aparelho,
	@$valor_parcela_aparelho,
	@$valor_manutencao,
	@$qtdeParcelasAparelho,
	@$qtdeParcelasManutencao,
	@$_POST['titulo_observacao']);

	$Result1 = mysqli_query($conexao,$insertSQL) or die(mysqli_error());
	$manutecao_id = mysqli_insert_id($conexao);
	
	//cadastra parcela aparelho	
	
	foreach( $dataVencimento AS $data){
		
		if(!empty($data)) {

			$sql = mysqli_query($conexao,sprintf("INSERT INTO `parcela_aparelho` (`manutencao_id`, `sac_id`, `parcela_vencimento`, `parcela_valor`) VALUES ('%s', '%s', '%s', '%s')",
			$manutecao_id,
			$_POST['sac_id'],
			implode('-',array_reverse(explode('/', $data))),
			$valor_parcela_aparelho)) or die (mysqli_error());
			
		}				
	}
	
	
	//Cadastra parcela manutencao
	
	$meses = array();
	$venc = strtotime($venc_parcelas);
	
	for ($i=0; $i <= $qtdeParcelasManutencao - 1; $i++) {
		
		$meses[$i] = date('Y-m-d', mktime(0,0,0,date('m',$venc) + $i, date('d',$venc), date('Y',$venc)));
		
		$sql = sprintf("INSERT INTO `parcela_manutencao` (`sac_id`, `manutencao_id`, `numero_parcela`, `parcela_valor`, `parcela_vencimento`) VALUES ('%s', '%s', '%s', '%s', '%s');",
					@$_POST['sac_id'],
					$manutecao_id,
					$i+1,
					$valor_manutencao,
					$meses[$i]);
		
		mysqli_query($conexao,$sql) or die(mysqli_error());			
	}
	
	echo "<script type=\"text/javascript\">
				alert(\"Cadastro efetuado com sucesso!\");
			</script>";
	
	$linkImpressao = '<a href="default.php?pag=consultaAparelho&acao=mostrar&idTitulo='. $manutecao_id .'" style="font-size:14px" title="Visualizar Duplicatas para impressão!"><input type="button" value="Visualizar Cadastro!"/></a>';

 }

$query_sacado = "SELECT * FROM sacado ORDER BY `sac_nome` ASC";
$sacado = mysqli_query($conexao,$query_sacado) or die(mysqli_error());

$query_password = "SELECT * FROM password where especialista='S'";
$password = mysqli_query($conexao,$query_password) or die(mysqli_error());
?>
<script language="javascript">
function enviardados(){
	if (document.form1.data_vencimento_aparelho_1.value=="")
	{
		alert( "Selecione a data de vencimento do aparelho!" );
		document.form1.data_vencimento_aparelho_1.focus();
		return false;

	}
}
</script>
<script language="javascript">
$(document).ready( function() {
	$("#form1").validate({
		// Define as regras
		rules:{
			
			sac_id: {
				required: true
			},
			
			responsavel_id: {
				required: true
			},
			
			valor_total_aparelho: {
				required: true
			},
			
			data_vencimento_aparelho_1: {
				required: true
			},
			
			valor_mensal_manutencao: {
				required: true
			},
			
			numero_parcela_manutencao: {
				required: true
			}			
		
		},
		// Define as mensagens de erro para cada regra
		messages:{
			
			sac_id: {
				required: "Por favor, selecione o sacado.",
			},
			
			responsavel_id: {
				required: "Por favor, selecione o especialista responsável.",
			},
			
			valor_total_aparelho: {
				required: "Por favor, informe o valor do aparelho.",
			},
			
			data_vencimento_aparelho_1: {
				required: "Por favor, informe o vencimento da parcela do aparelho.",
			},
			
			valor_mensal_manutencao: {
				required: "Por favor, informe o valor mensal da manutenção.",
			},
			
			numero_parcela_manutencao: {
				required: "Por favor, informe o total de parcela manutenção.",
			},
			
			manutencao_data_vencimento: {
				required: "Por favor, informe o vencimento da parcela manutenção.",
			}
		}
	});
	
	$('#data_vencimento_aparelho_1').focus(function(){
		$(this).calendario({ 
			target:'#data_vencimento_aparelho_1',
			top:0,
			left:130
		});
	});
	
	$('#data_vencimento_aparelho_2').focus(function(){
		$(this).calendario({ 
			target:'#data_vencimento_aparelho_2',
			top:0,
			left:130
		});
		$("#data_vencimento_aparelho_2").mask("99/99/9999");
	});
	
	$('#data_vencimento_aparelho_3').focus(function(){
		$(this).calendario({ 
			target:'#data_vencimento_aparelho_3',
			top:0,
			left:130
		});
		$("#data_vencimento_aparelho_3").mask("99/99/9999");
	});
	
	$('#manutencao_data_vencimento').focus(function(){
		$(this).calendario({ 
			target:'#manutencao_data_vencimento',
			top:0,
			left:130
		});
		$("#manutencao_data_vencimento").mask("99/99/9999");
	});
	
	$('#titulo_observacao').limit('200','#Desc1');
	
	
});
</script>
<h2>Incluir Manutenção</h2>
<form method="post" name="form1" id="form1" onSubmit="return enviardados();" action="<?php echo $editFormAction; ?>">
 <center>
  <table align="center">
    
	<?php
	if(isset( $Result1 )){
		echo sprintf('<tr valign="baseline">
      <td height="30" colspan="2" align="right" nowrap>%s</td>
    </tr>', $linkImpressao);
	}
	?>
    <tr valign="baseline">
      <td height="30" align="right" nowrap>Nome Cliente:</td>
      <td align="left"><label>
      <select name="sac_id" id="sac_id">
        <option value="">Selecione</option>
		<?php
		while( $row_sacado  = mysqli_fetch_assoc($sacado)){
		?>
        <option value="<?php echo $row_sacado['sac_id']; ?>"><?php echo mb_strtoupper( $row_sacado['sac_nome'] ); ?></option>
		<?php
		}
		?>
        </select>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td height="30" align="right" nowrap>Profissional Responsável:</td>
      <td align="left"><select name="responsavel_id" id="responsavel_id">
        <option value="">Selecione</option>
        <?php
		while( $row_password  = mysqli_fetch_assoc($password)){
		?>
        <option value="<?php echo $row_password['pass_id']; ?>"><?php echo mb_strtoupper( $row_password['pass_nome'] ); ?></option>
        <?php
		}
		?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td height="30" align="right" nowrap>Valor Total do Aparelho:</td>
      <td align="left"><label><input type="text" name="valor_total_aparelho" onKeyDown="Formata(this,20,event,2)" id="valor_total_aparelho" value="" size="15">
      </label></td>
    </tr>
    
    <tr valign="baseline">
      <td height="30" align="right" nowrap="nowrap">Data Vencimento Aparelho:</td>
      <td align="left"><span><input name="data_vencimento_aparelho[]" type="text" id="data_vencimento_aparelho_1" value="" size="12" maxlength="10" /></span>        &nbsp;1ª Parcela  </td>
    </tr>
    <tr valign="baseline">
      <td height="30" align="right" nowrap="nowrap">Data Vencimento Aparelho:</td>
      <td align="left"><input name="data_vencimento_aparelho[]" type="text" id="data_vencimento_aparelho_2" value="" size="12" maxlength="10" />        &nbsp;2ª Parcela </td>
    </tr>
    <tr valign="baseline">
      <td height="30" align="right" nowrap="nowrap">Data Vencimento Aparelho:</td>
      <td align="left"><input name="data_vencimento_aparelho[]" type="text" id="data_vencimento_aparelho_3" value="" size="12" maxlength="10" />        &nbsp;3ª Parcela  </td>
    </tr>
    
	<tr valign="baseline">
      <td height="30" align="right" nowrap>Valor Mensal de Manunteção:</td>
      <td align="left"><label><input type="text" name="valor_mensal_manutencao" onKeyDown="Formata(this,20,event,2)" id="valor_mensal_manutencao" value="" size="15">
      </label></td>
    </tr>
	
    <tr valign="baseline">
      <td height="30" align="right" nowrap>Total de Parcela Manutenção:</td>
      <td align="left"><label>
        <select name="numero_parcela_manutencao" id="numero_parcela_manutencao">
			<option value="">Selecione</option>
			<?php
			for($i=1;$i<=60;$i++){
			?>
			<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php
			}
			?>
        </select>
      </label></td>
    </tr>
    
	<tr valign="baseline">
      <td height="30" align="right" nowrap="nowrap">Data Vencimento Manutenção:</td>
      <td align="left"><label>
        <input name="manutencao_data_vencimento" type="text" id="manutencao_data_vencimento" value="" size="12" maxlength="10" />
        &nbsp;1ª Parcela  </label></td>
    </tr>	
	
    <tr valign="baseline">
      <td height="30" align="right" valign="top" nowrap>Observações:</td>
      <td align="left"><label><textarea name="titulo_observacao" id="titulo_observacao" cols="35" rows="5"></textarea></label>Caracteres restantes: <span id="Desc1"></span></td>
    </tr>
	
    <tr valign="baseline">
      <td height="30" align="right" nowrap>&nbsp;</td>
      <td align="left"><input type="submit" value="Cadastrar"></td>
    </tr>
	
  </table>
  <input type="hidden" name="MM_insert" value="form1">
  </center>
</form>
<?php
mysqli_free_result($sacado);
mysqli_free_result($password);
?>