<?php
session_start();
if(file_exists('seguranca.php')){
	require_once 'seguranca.php';
}
require_once('config.php'); 
@$dados = isset($_SESSION["dados"]) ? $_SESSION["dados"] : unserialize($_COOKIE["dados"]);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-br" xml:lang="pt-br">
<head>
<title>SaudSeguro - FINAN</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-utf-8" />
<meta name="description" content="Controle Interno" />
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
<meta name="author" content="William Silva Duarte" />
<meta http-equiv="content-language" content="pt-br" />
<link href="estilos.css" rel="stylesheet" type="text/css" />
<link href="jscripts/jquery.click-calendario-1.0.css" rel="stylesheet" type="text/css"/>
<script language="javascript" src="jscripts/jquery.js"></script>
<script type="text/javascript" src="jscripts/jquery.click-calendario-1.0-min.js"></script>
<script language="javascript" src="jscripts/jquery.validate.js"></script>
<script language="javascript" src="jscripts/jquery.maskedinput.js"></script>
<script type="text/javascript" src="jscripts/jquery.limit-1.2.js"></script>

<script type="text/javascript" src="jscripts/jquery-autocomplete/lib/jquery.bgiframe.min.js"></script>
<script type="text/javascript" src="jscripts/jquery-autocomplete/lib/jquery.ajaxQueue.js"></script>
<script type="text/javascript" src="jscripts/jquery-autocomplete/lib/thickbox-compressed.js"></script>
<script type="text/javascript" src="jscripts/jquery-autocomplete/jquery.autocomplete.js"></script>
<!--css -->
<link rel="stylesheet" type="text/css" href="jscripts/jquery-autocomplete/jquery.autocomplete.css"/>
<link rel="stylesheet" type="text/css" href="jscripts/jquery-autocomplete/lib/thickbox.css"/>

<script type="text/javascript">
 
$(document).ready( function() {
	
	
	$("#formb").validate({
		// Define as regras
		rules:{
			
			dataInicio: {
				required: false,
			},
			
			
			dataInicio: {
				required: false
			}
			
		
		}
		
	});

	$("#b").autocomplete("autocompleta/completar.php", {
		width:390,
		selectFirst: false
	});
	
	
	$("#dataInicio").mask("99/99/9999");
	$("#dataFim").mask("99/99/9999");
	
});
</script>


<script language="javascript" src="jscripts/funcao.js"></script>
</head>
<body>
<div id="tudo">
	<div id="conteudo">
	
		<span><a class="link" href="<?php echo $_SERVER['PHP_SELF']; ?>" title="Início do Sistema"><img src="images/home_badge.png" /></a> </span>
		<span onMouseOver="mouseOver(1);" onMouseOut="mouseOut();"><img src="images/kmenuedit.png" title="Cadastros" style="cursor:pointer" /></span>
		<span onMouseOver="mouseOver(2);" onMouseOut="mouseOut();"><img src="images/search.png" title="Consultas" style="cursor:pointer"  /></span>
		<span><a class="link" href="default.php?pag=sair" title="Sair do sistema"><img src="images/session_logout.png" /></a> </span>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Olá! <strong><?php echo strtoupper( @$dados["pass_nome"] ); ?></strong> <br />
		<br />
		<div id="texto"></div>
		<br />
		<?php
		if(isset($_GET['pag'])){
			include("paginas/" . trim ( $_GET['pag'] ) .'.php');
		} else {
			echo "<h1></h1>";
			include("paginas/aviso.php");
		}
		?>
		<div id="pagina"></div>
  </div>
	<div id="footer">&copy; <?php echo @date('Y'); ?></div>
</div>
</body>
</html>
<?php
//require_once('backup.php');
mysqli_close(db_connect());
?>