<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
<head>
<title>SaudSeguro - FINAN</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-utf-8" />
<meta name="description" content="Controle Interno" />
<meta name="author" content="William Silva Duarte" />
<meta http-equiv="content-language" content="pt-br" />
<link href="estilos.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="jscripts/jquery.js"></script>
<script language="javascript" src="jscripts/jquery.validate.js"></script>

</head>
<body>
<div id="tudo">
	<div id="conteudo">
		<span><a class="link" href="default.php?pag=sair" title="Sair do sistema"><img src="images/session_logout.png" /></a> </span>
		<br />
		<br />
		<form id="form1" action="validar.php" method="post">
		   <fieldset> 
				<legend>Efetuar Login</legend>
				
				<label>Login: </label>
				<input id="login" name="login" type="text" value="" />
				<div class="clear"></div>

				<label>Senha: </label>
				<input id="senha" name="senha" type="password" value="" />
				<div class="clear"></div>

				 <label>&nbsp;</label>
				<input type="submit" value="Enviar" class="bt" />
				<div class="efentoLogin">
				<?php
					if(isset( $_GET['erro'] )){
						if($_GET['erro']==1)
							echo 'Por favor, digite seu login e senha!';
						if($_GET['erro']==2)
							echo 'Acesso não permitido.';
						if($_GET['erro']==3)
							echo 'Login ou senha não corresponde.';	
					}
				?>
				</div>
		   </fieldset> 
		</form>
		<div id="pagina"></div>
  </div>
	<div id="footer">&copy; <?php echo @date('Y'); ?></div>
</div>
</body>
</html>