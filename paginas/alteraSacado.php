<?php
$idSac = isset ( $_GET['idSac'] ) ? intval( $_GET['idSac'] ):'-1';
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
	
	$altSQL = sprintf("UPDATE `sacado` SET sac_cpf = %s, sac_nome = %s, sac_endereco = %s, sac_bairro = %s, sac_cidade = %s, sac_estado = %s, sac_cep = %s, sac_telefone = %s, sac_telefone2 = %s, sac_telefone3 = %s, sac_email = %s, sac_observacao = %s WHERE ( `sac_id` = %s )  LIMIT 1",
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
					   GetSQLValueString($_POST['sac_observacao'], "text"),
					   $idSac);
		$Result1 = mysqli_query(db_connect(),$altSQL) or die(mysqli_error());

		echo "<script type=\"text/javascript\">
					alert(\"Cadastro alterado com sucesso!\");
					location.href='?pag=consultaSacado';
				</script>";
		die();		
}

$query_cadastro = sprintf("SELECT * FROM sacado WHERE `sac_id` = %s", $idSac);
$cadastro = mysqli_query(db_connect(),$query_cadastro) or die(mysqli_error());
$row_cadastro = mysqli_fetch_assoc($cadastro);
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

<h2>Alterar Cliente</h2>
<center>
<form method="post" name="form1" id="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">CPF:</td>
      <td align="left"><label><input type="text" name="sac_cpf" id="sac_cpf" value="<?php echo $row_cadastro['sac_cpf']; ?>" size="32"></label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Nome Cliente:</td>
      <td align="left"><label><input type="text" name="sac_nome" id="sac_nome" value="<?php echo $row_cadastro['sac_nome']; ?>" size="32"></label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Endereço:</td>
      <td align="left"><label><input type="text" name="sac_endereco" id="sac_endereco" value="<?php echo $row_cadastro['sac_endereco']; ?>" size="32"></label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Bairro:</td>
      <td align="left"><label><input type="text" name="sac_bairro" id="sac_bairro" value="<?php echo $row_cadastro['sac_bairro']; ?>" size="32"></label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Cidade:</td>
      <td align="left"><label><input type="text" name="sac_cidade" id="sac_cidade" value="<?php echo $row_cadastro['sac_cidade']; ?>" size="32"></label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Estado:</td>
      <td align="left"><label><input name="sac_estado" type="text" id="sac_estado" value="<?php echo $row_cadastro['sac_estado']; ?>" size="2" maxlength="2">
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Cep:</td>
      <td align="left"><label><input type="text" name="sac_cep" id="sac_cep" value="<?php echo $row_cadastro['sac_cep']; ?>" size="32"></label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Fone:</td>
      <td align="left"><label><input type="text" name="sac_telefone" id="sac_telefone" value="<?php echo $row_cadastro['sac_telefone']; ?>" size="20">
      </label></td>
    </tr>
	 <tr valign="baseline">
      <td nowrap align="right">Fone2:</td>
      <td align="left"><label><input name="sac_telefone2" type="text" id="sac_telefone2" value="<?php echo $row_cadastro['sac_telefone2']; ?>" size="20">
      </label></td>
    </tr>
	
	 <tr valign="baseline">
      <td nowrap align="right">Fone3:</td>
      <td align="left"><label><input type="text" name="sac_telefone3" id="sac_telefone3" value="<?php echo $row_cadastro['sac_telefone3']; ?>" size="20">
      </label></td>
    </tr>
	
    <tr valign="baseline">
      <td nowrap align="right">Email:</td>
      <td align="left"><label><input type="text" name="sac_email" id="sac_email" value="<?php echo $row_cadastro['sac_email']; ?>" size="32"></label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">Observação:</td>
      <td align="left"><label><textarea name="sac_observacao" id="sac_observacao" cols="35" rows="5"><?php echo $row_cadastro['sac_observacao']; ?></textarea></label>
      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td align="left"><input type="submit" value="Alterar"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
</center>
<?php
mysqli_free_result($cadastro);
?>
