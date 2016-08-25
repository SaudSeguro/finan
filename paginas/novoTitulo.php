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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  
  $valorDocumento = trata( $_POST['titulo_valor'] );
  $_SESSION['sac_id'] = $_POST['sac_id'];
  
  $insertSQL = sprintf("INSERT INTO `titulos` (`sac_id` ,`id_especialista` ,`titulo_valor` , `titulo_forma_pagto` , `titulo_data_cadastro` ,`titulo_especie_pagto` ,`titulo_observacao`, `titulo_menor`)
VALUES ('%s', '%s', '%s', '%s', NOW(), '%s', '%s', '%s')",
						$_POST['sac_id'],
						$_POST['responsavel'],
						$valorDocumento,
						$_POST['titulo_forma_pagto'],
						$_POST['titulo_especie_pagto'],
						$_POST['titulo_observacao'],
						$_POST['titulo_menor']);

	$Result1 = mysqli_query($conexao,$insertSQL) or die(mysqli_error());
	$numero_titulo = mysqli_insert_id($conexao);
	
	$dataVencimento = $_POST['titulo_data_vencimento'];
	
	$totalparcela=0;
	foreach($dataVencimento AS $soma){
		if($soma !=="")
			$totalparcela=$totalparcela+1;
	}
	$valorParcela = ( $valorDocumento  / $totalparcela );
	$doc=0;
	foreach( $dataVencimento AS $data){
		
		if(!empty($data)) {
			$doc=$doc+1;
			$numeroDoc = "0$doc/0$totalparcela";
			mysqli_query($conexao,sprintf("INSERT INTO `parcela_titulo` (`titulo_id`, `sac_id`, `id_especialista`, `venc_parcela`, `valor_parcela`, `numero_documento`) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')",
						$numero_titulo,
						$_POST['sac_id'],
						$_POST['responsavel'],
						implode('-',array_reverse(explode('/', $data))),
						str_replace(",",".", $valorParcela ), 
						$numeroDoc));
		}				
	}	
	
	echo "<script type=\"text/javascript\">
				alert(\"Cadastro efetuado com sucesso!\");
			</script>";
	
	$linkImpressao = '<a href="default.php?pag=consultaParcelas&acao=mostrar&idTitulo='. $numero_titulo .'" onClick="window.open(this.href, this.target, \'width=700,height=auto,left=50,top=50, scrollbars=yes, ,menubar=yes\'); return false;" style="font-size:14px" title="Visualizar Duplicatas para impressão!"><input type="submit" value="Visualizar Duplicatas para impressão!"/></a>';

 }

$query_sacado = "SELECT * FROM sacado ORDER BY `sac_nome` ASC";
$sacado = mysqli_query($conexao,$query_sacado) or die(mysqli_error());

$query_password = "SELECT * FROM password where especialista='S'";
$password = mysqli_query($conexao,$query_password) or die(mysqli_error());
?>
<script language="javascript">
function enviardados(){
	if (document.form1.titulo_data_vencimento.value=="")
	{
		alert( "Selecione a data de vencimento!" );
		document.form1.titulo_data_vencimento.focus();
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
			
			responsavel: {
				required: true
			},
			
			titulo_valor: {
				required: true
			},
			
			titulo_forma_pagto: {
				required: true
			},
			
			titulo_data_vencimento: {
				required: true
			},
			
			titulo_especie_pagto: {
				required: true
			}			
		
		},
		// Define as mensagens de erro para cada regra
		messages:{
			
			sac_id: {
				required: "Por favor, selecione o sacado.",
			},
			
			responsavel: {
				required: "Por favor, selecione o especialista responsável.",
			},
			
			titulo_valor: {
				required: "Por favor, o valor do documento.",
			},
			
			titulo_forma_pagto: {
				required: "Por favor, informe a forma de pagamento.",
			},
			
			titulo_data_vencimento: {
				required: "Por favor, informe o vencimento da parcela.",
			},
			
			titulo_especie_pagto: {
				required: "Por favor, informe o tipo de documento.",
			}	
		}
	});
	
	
	$('#titulo_data_vencimento').focus(function(){
		$(this).calendario({ 
			target:'#titulo_data_vencimento',
			top:0,
			left:130
		});
	});
	
	$('#titulo_data_vencimento2').focus(function(){
		$(this).calendario({ 
			target:'#titulo_data_vencimento2',
			top:0,
			left:130
		});
		$("#titulo_data_vencimento2").mask("99/99/9999");
	});
	
	$('#titulo_data_vencimento3').focus(function(){
		$(this).calendario({ 
			target:'#titulo_data_vencimento3',
			top:0,
			left:130
		});
		$("#titulo_data_vencimento3").mask("99/99/9999");
	});
	
	$('#titulo_data_vencimento4').focus(function(){
		$(this).calendario({ 
			target:'#titulo_data_vencimento4',
			top:0,
			left:130
		});
		$("#titulo_data_vencimento4").mask("99/99/9999");
	});
	
	$('#titulo_observacao').limit('200','#Desc1');
	
	
});
</script>
<h2>Incluir Procedimento / Promissória</h2>
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
      <td height="25" align="right" nowrap>Nome Cliente:</td>
      <td align="left"><label>
      <select name="sac_id" id="sac_id">
        <option value="">Selecione</option>
		<?php
		while( $row_sacado  = mysqli_fetch_assoc($sacado)){
		?>
        <option value="<?php echo $row_sacado['sac_id']; ?>"><?php echo strtoupper( $row_sacado['sac_nome'] ); ?></option>
		<?php
		}
		?>
        </select>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td height="25" align="right" nowrap>Profissional Responsável:</td>
      <td align="left"><select name="responsavel" id="responsavel">
        <option value="">Selecione</option>
        <?php
		while( $row_password  = mysqli_fetch_assoc($password)){
		?>
        <option value="<?php echo $row_password['pass_id']; ?>"><?php echo strtoupper( $row_password['pass_nome'] ); ?></option>
        <?php
		}
		?>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td height="25" align="right" nowrap>Valor:</td>
      <td align="left"><label><input type="text" name="titulo_valor" onKeyDown="Formata(this,20,event,2)" id="titulo_valor" value="" size="15">
      </label></td>
    </tr>
    <tr valign="baseline">
      <td height="25" align="right" nowrap>Forma de pagamento:</td>
      <td align="left"><label>
        <select name="titulo_forma_pagto" id="titulo_forma_pagto">
          <option value="">Selecione</option>
          <option value="Prazo" selected="selected">À Prazo</option>
        </select>
      </label></td>
    </tr>
    
    <tr valign="baseline">
      <td height="25" align="right" nowrap="nowrap">Data  de vencimento:</td>
      <td align="left"><span><input name="titulo_data_vencimento[]" type="text" id="titulo_data_vencimento" value="" size="12" maxlength="10" /></span>&nbsp;1ª Parcela  </td>
    </tr>
    <tr valign="baseline">
      <td height="25" align="right" nowrap="nowrap">Data  de vencimento:</td>
      <td align="left"><input name="titulo_data_vencimento[]" type="text" id="titulo_data_vencimento2" value="" size="12" maxlength="10" />        &nbsp;2ª Parcela </td>
    </tr>
    <tr valign="baseline">
      <td height="25" align="right" nowrap="nowrap">Data  de vencimento:</td>
      <td align="left"><input name="titulo_data_vencimento[]" type="text" id="titulo_data_vencimento3" value="" size="12" maxlength="10" />        &nbsp;3ª Parcela  </td>
    </tr>
    <tr valign="baseline">
      <td height="25" align="right" nowrap="nowrap">Data  de vencimento:</td>
      <td align="left"><label>
        <input name="titulo_data_vencimento[]" type="text" id="titulo_data_vencimento4" value="" size="12" maxlength="10" />
        &nbsp;4ª Parcela  </label></td>
    </tr>
    
    <tr valign="baseline">
      <td height="25" align="right" nowrap>Tipo de documento:</td>
      <td align="left"><label>
        <select name="titulo_especie_pagto" id="titulo_especie_pagto">
          <option value="">Selecione</option>
          <option value="duplicata">Duplicata</option>
        </select>
      </label></td>
    </tr>
    
    <tr valign="baseline">
      <td height="25" align="right" valign="top" nowrap>Procedimento realizado:</td>
      <td align="left"><label><textarea name="titulo_observacao" id="titulo_observacao" cols="35" rows="5"></textarea></label>Caracteres restantes: <span id="Desc1"></span></td>
    </tr>
    <tr valign="baseline">
      <td height="25" align="right" nowrap>Menor:</td>
      <td><input type="text" name="titulo_menor" id="titulo_menor" value="" size="35" /></td>
    </tr>
    <tr valign="baseline">
      <td height="25" align="right" nowrap>&nbsp;</td>
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
