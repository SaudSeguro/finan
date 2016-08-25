<?php
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
   
	$altSQL = sprintf("UPDATE `password` SET `pass_nome` = '%s', `especialista` ='%s',  `pass_login` = '%s' ,`pass_senha` = '%s'  ,`pass_nivel` = '%s' WHERE ( `pass_id`='%s' ) LIMIT 1",
							$_POST['pass_nome'],
							isset($_POST['especialista']) ? $_POST['especialista'] : "N",
							$_POST['pass_login'],
							$_POST['pass_senha'], 
							$_POST['pass_nivel'],
							$_GET['idUsu']);

	$Result1 = mysqli_query($conexao,$altSQL) or die(mysqli_error());

	echo "<script type=\"text/javascript\">
					alert(\"Cadastro alterado com sucesso!\");
					location.href='?pag=consultaUsuario';
				</script>";
		
}
$query_cadastro = sprintf("SELECT * FROM password WHERE ( `pass_id`='%s' ) LIMIT 1", $_GET['idUsu']);
$cadastro = mysqli_query($conexao,$query_cadastro) or die(mysqli_error());
$row_cadastro = mysqli_fetch_assoc($cadastro);
$totalRows_cadastro = mysqli_num_rows($cadastro);
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

<h2>Alterar dados de Usuário </h2>
<form method="post" name="form1" id="form1" action="<?php echo $editFormAction; ?>">
  <center>
  <table align="center">
    
    <tr valign="baseline">
      <td nowrap align="right">Nome Usuário:</td>
      <td align="left"><input type="text" name="pass_nome" id="pass_nome" value="<?php echo $row_cadastro['pass_nome'] ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Login:</td>
      <td align="left"><label><input type="text" name="pass_login" id="pass_login" value="<?php echo $row_cadastro['pass_login'] ?>" size="32"></label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Senha:</td>
      <td align="left"><label><input name="pass_senha" type="password" id="pass_senha" value="" size="15" maxlength="15">
      </label></td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap align="right">Repita a Senha:</td>
      <td align="left"><label><input name="conf_pass_senha" type="password" id="conf_pass_senha" value="" size="15" maxlength="15">
      </label></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Profissional:</td>
      <td align="left"><input name="especialista" type="checkbox" id="especialista" value="S" <?php if (!(strcmp("S", $row_cadastro['especialista']))) {echo "checked=\"checked\"";} ?>  /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Nível de Acesso:</td>
      <td align="left"><label>
        <select name="pass_nivel" id="pass_nivel">
          <option value="">Selecione</option>
          <option value="1" <?php if (!(strcmp("1", $row_cadastro['pass_nivel']))) {echo "selected=\"selected\"";} ?>>Operador</option>
          
		<?php
		if($row_cadastro['pass_nivel'] ==3){
		?>
		  
		  <option value="3" selected="selected">Administrador</option>
		
		<?php
		} elseif($row_cadastro['pass_nivel'] > 1){
		?>
			 
			 <option value="2" <?php if (!(strcmp("2", $row_cadastro['pass_nivel']))) {echo "selected=\"selected\"";} ?>>Administrador</option>
                          				
		<?php
		}
		
		?>
      </select>			
      </label></td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td align="left"><input type="submit" value="Alterar"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
  </center>
</form>
<?php
mysqli_free_result($cadastro);
?>
