<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	
	
	$rs = mysql_query(sprintf("SELECT * FROM `sacado` WHERE `sac_cpf` = '%s'", $_POST['sac_cpf']));
	if(mysql_num_rows($rs) > 0 ){
		
		echo "<script type=\"text/javascript\">
					alert(\"Erro: CPF " . $_POST['sac_cpf'] . " já encontra-se registrado!\");
				</script>";
		
	} else {
	
		$insertSQL = sprintf("INSERT INTO sacado (sac_cpf, sac_nome, sac_endereco, sac_bairro, sac_cidade, sac_estado, sac_cep, sac_telefone, sac_telefone2, sac_telefone3, sac_email, sac_observacao) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
						   GetSQLValueString($_POST['sac_cpf'], "text"),
						   GetSQLValueString($_POST['sac_nome'], "text"),
						   GetSQLValueString($_POST['sac_endereco'], "text"),
						   GetSQLValueString($_POST['sac_bairro'], "text"),
						   GetSQLValueString($_POST['sac_cidade'], "text"),
						   GetSQLValueString($_POST['sac_estado'], "text"),
						   GetSQLValueString($_POST['sac_cep'], "text"),
						   GetSQLValueString($_POST['sac_telefone'], "text"),
						   GetSQLValueString($_POST['sac_telefone2'], "text"),
						   GetSQLValueString($_POST['sac_telefone3'], "text"),
						   GetSQLValueString($_POST['sac_email'], "text"),
						   GetSQLValueString($_POST['sac_observacao'], "text"));

		$Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());

		echo "<script type=\"text/javascript\">
					alert(\"Cadastro efetuado com sucesso!\");
				</script>";
	}		
}
?>
<script language="javascript">
$(document).ready( function() {
	$("#form1").validate({
		// Define as regras
		rules:{
			
			sac_cpf: {
				required: true,
				cpf: true
			},
			
			
			sac_nome: {
				required: true
			},
			
			sac_endereco: {
				required: true
			},
			
			sac_bairro: {
				required: true
			},
			
			sac_cidade: {
				required: true
			},
			
			sac_estado: {
				required: true
			},
			
			sac_cep: {
				required: true
			},
			
			sac_telefone: {
				required: true
			},
			
			sac_email: {
				email: true
			}
		
		},
		// Define as mensagens de erro para cada regra
		messages:{
			
			sac_cpf: {
				required: "Por favor, digite o CPF.",
				cpf: 'CPF inválido',
			},
			
			sac_nome: {
				required: "Por favor, o nome do sacado.",
			},
			
			sac_endereco: {
				required: "Por favor, o endereço do sacado.",
			},
			
			sac_bairro: {
				required: "Por favor, o bairro do sacado.",
			},
			
			sac_cidade: {
				required: "Por favor, a cidade do sacado.",
			},
			
			sac_estado: {
				required: "Por favor, o estado do sacado.",
			},
			
			sac_cep: {
				required: "Por favor, o cep do sacado.",
			},
			
			sac_telefone: {
				required: "Por favor, o telefone do sacado.",
			},
			
			sac_email: {
				required: "Por favor, informe um email válido.",
			}
		}
	});

	$(document).ready(function(){
		$("#sac_cpf").mask("999.999.999-99");
		$("#sac_cep").mask("99.999-999");
		$("#sac_telefone").mask("(99) 9999-9999");
		$("#sac_telefone2").mask("(99) 9999-9999");
		$("#sac_telefone3").mask("(99) 9999-9999");
	});
	
});
</script>
<h2>Incluir Cliente</h2>
<center>
<form method="post" name="form1" id="form1" action="<?php echo $editFormAction; ?>">

  <table align="center">
    <tr valign="baseline">
      <td height="25" align="right" nowrap>CPF:</td>
      <td align="left"><label><input type="text" name="sac_cpf" id="sac_cpf" value="" size="32"></label></td>
    </tr>
    <tr valign="baseline">
      <td height="25" align="right" nowrap>Nome Cliente:</td>
      <td align="left"><label><input type="text" name="sac_nome" id="sac_nome" value="" size="32"></label></td>
    </tr>
    <tr valign="baseline">
      <td height="25" align="right" nowrap>Endereço:</td>
      <td align="left"><label><input type="text" name="sac_endereco" id="sac_endereco" value="" size="32"></label></td>
    </tr>
    <tr valign="baseline">
      <td height="25" align="right" nowrap>Bairro:</td>
      <td align="left"><label><input type="text" name="sac_bairro" id="sac_bairro" value="" size="32"></label></td>
    </tr>
    <tr valign="baseline">
      <td height="25" align="right" nowrap>Cidade:</td>
      <td align="left"><label><input type="text" name="sac_cidade" id="sac_cidade" value="" size="32"></label></td>
    </tr>
    <tr valign="baseline">
      <td height="25" align="right" nowrap>Estado:</td>
      <td align="left"><label>  
	  <select name="sac_estado" id="sac_estado" style="font-size: 11px; color: #000000; font-family: Verdana, Arial, Helvetica, sans-serif; margin-top: 0px;">
        <option value="">Selecione</option>
        <option value="AC" >AC</option>
        <option value="AL" >AL</option>
        <option value="AP" >AP</option>
        <option value="AM" >AM</option>
        <option value="BA" >BA</option>
        <option value="CE" >CE</option>
        <option value="DF" >DF</option>
        <option value="ES" >ES</option>
        <option value="GO" >GO</option>
        <option value="MA" >MA</option>
        <option value="MS" >MS</option>
        <option value="MT" selected="selected">MT</option>
        <option value="MG" >MG</option>
        <option value="PA" >PA</option>
        <option value="PB" >PB</option>
        <option value="PR" >PR</option>
        <option value="PE" >PE</option>
        <option value="PI" >PI</option>
        <option value="RJ" >RJ</option>
        <option value="RN" >RN</option>
        <option value="RS" >RS</option>
        <option value="RO" >RO</option>
        <option value="RR" >RR</option>
        <option value="SC" >SC</option>
        <option value="SP" >SP</option>
        <option value="SE" >SE</option>
        <option value="TO" >TO</option>
      </select>
	  </label></td>
    </tr>
    <tr valign="baseline">
      <td height="25" align="right" nowrap>Cep:</td>
      <td align="left"><label><input type="text" name="sac_cep" id="sac_cep" value="" size="32"></label></td>
    </tr>
    <tr valign="baseline">
      <td height="25" align="right" nowrap>Fone:</td>
      <td align="left"><label><input type="text" name="sac_telefone" id="sac_telefone" value="" size="20"></label></td>
    </tr>
    <tr valign="baseline">
      <td height="25" align="right" nowrap>Fone2:</td>
      <td align="left"><input type="text" name="sac_telefone2" id="sac_telefone2" value="" size="20"></td>
    </tr>
    <tr valign="baseline">
      <td height="25" align="right" nowrap>Fone3:</td>
      <td align="left"><input type="text" name="sac_telefone3" id="sac_telefone3" value="" size="20"></td>
    </tr>
    <tr valign="baseline">
      <td height="25" align="right" nowrap>Email:</td>
      <td align="left"><label><input type="text" name="sac_email" id="sac_email" value="" size="32"></label></td>
    </tr>
    <tr valign="baseline">
      <td height="25" align="right" valign="top" nowrap>Observação:</td>
      <td align="left"><label><textarea name="sac_observacao" id="sac_observacao" cols="35" rows="5"></textarea></label>      </td>
    </tr>
    <tr valign="baseline">
      <td height="25" align="right" nowrap>&nbsp;</td>
      <td align="left"><input type="submit" value="Cadastrar"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">

</form>
  </center>