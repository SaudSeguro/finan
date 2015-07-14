<?php
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	
	
	$rs = mysql_query(sprintf("SELECT `pass_login` FROM `password` WHERE `pass_login` = '%s'", $_POST['pass_login']));
	if(mysql_num_rows($rs) == 1 ){
		
		echo "<script type=\"text/javascript\">
					alert(\"Este login ". $_POST['pass_login'] ." já está em uso!\");
				</script>";
		
	} else {
  
	
	  $insertSQL = sprintf("INSERT INTO `password` (`pass_nome`, `especialista`, `pass_login` ,`pass_senha` ,`pass_nivel`)
	VALUES ('%s', '%s', '%s', '%s', '%s')",
							$_POST['pass_nome'],
							isset($_POST['especialista']) ? $_POST['especialista'] : "N",
							$_POST['pass_login'],
							$_POST['pass_senha'], 
							$_POST['pass_nivel']);
	 $Result1 = mysql_query($insertSQL, $conexao) or die(mysql_error());

	  echo "<script type=\"text/javascript\">
					alert(\"Cadastro efetuado com sucesso!\");
				</script>";
		unset($_POST);		
	}		
}
?>
<script language="javascript">
$(document).ready( function() {
	$("#form1").validate({
		// Define as regras
		rules:{
			
			pass_nome: {
				required: true
			},
			
			pass_login: {
				required: true,
				minlength: 4
			},
			
			pass_senha: {
				required: true,
				minlength: 4,
				maxlength:15
			},
			
			conf_pass_senha: {
				required: true,
				minlength: 4,
				maxlength:15,
				equalTo: "#pass_senha"
			},
			
			pass_nivel: {
				required: true
			}
		
		},
		// Define as mensagens de erro para cada regra
		messages:{
			
			pass_nome: {
				required: "Por favor, digite seu nome de usúario."
			},
			
			pass_login: {
				required: "Por favor, digite seu login.",
				minlength: "Seu login deve conter no mínimo 4 caracteres."
			},
			
			pass_senha: {
				required: "Por favor, digite sua senha.",
				minlength: "Sua senha deve ter pelo menos 4 caracteres."
			},
			
			conf_pass_senha: {
				required: "Por favor, confirme sua senha.",
				minlength: "Sua senha deve ter pelo menos 4 caracteres.",
				equalTo: "Por favor, digite a mesma senha como acima!"
			},
			
			pass_nivel: {
				required: "Por favor, selecione o nível de acesso."
			}
		}
	});
});
</script>
<h2>Incluir Usuário </h2>
<form method="post" name="form1" id="form1" action="<?php echo $editFormAction; ?>">
   <center>
  <table align="center">
    
    <tr valign="baseline">
      <td height="25" align="right" nowrap>Nome Usuário:</td>
      <td align="left"><input type="text" name="pass_nome" id="pass_nome" value="<?php echo @$_POST['pass_nome']; ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td height="25" align="right" nowrap>Login:</td>
      <td align="left"><label><input type="text" name="pass_login" id="pass_login" value="" size="32"></label></td>
    </tr>
    <tr valign="baseline">
      <td height="25" align="right" nowrap>Senha:</td>
      <td align="left"><label><input name="pass_senha" type="password" id="pass_senha" value="" size="15" maxlength="15">
      </label></td>
    </tr>
    
    <tr valign="baseline">
      <td height="25" align="right" nowrap>Repita a Senha:</td>
      <td align="left"><label><input name="conf_pass_senha" type="password" id="conf_pass_senha" value="" size="15" maxlength="15">
      </label></td>
    </tr>
    <tr valign="baseline">
      <td height="25" align="right" nowrap>Profissional:</td>
      <td align="left"><input name="especialista" type="checkbox" id="especialista" value="S" <?php if (!(strcmp("S", $_POST['especialista']))) {echo "checked=\"checked\"";} ?> /></td>
    </tr>
    <tr valign="baseline">
      <td height="25" align="right" nowrap>Nível de Acesso:</td>
      <td align="left"><label>
        <select name="pass_nivel" id="pass_nivel">
          <option value="">Selecione</option>
          <option value="1" <?php if (!(strcmp("1", @$_POST['pass_nivel']))) {echo "selected=\"selected\"";} ?>>Operador</option>
          <option value="2" <?php if (!(strcmp("2", @$_POST['pass_nivel']))) {echo "selected=\"selected\"";} ?>>Administrador</option>
        </select>
      </label></td>
    </tr>
    
    <tr valign="baseline">
      <td height="25" align="right" nowrap>&nbsp;</td>
      <td align="left"><input type="submit" value="Cadastrar"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
   </center>
</form>