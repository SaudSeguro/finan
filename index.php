<?php
require_once('config.php'); 
$rsAdmin = mysql_query("SELECT * FROM `password` WHERE `pass_id` = '1'");
if(mysql_num_rows($rsAdmin) == 0 ){
	@mysql_query("INSERT INTO `password` (`pass_login` ,`pass_senha` ,`pass_nivel`)
	VALUES ('admin', 'admin', '3')");
}
@mysql_free_result($rsAdmin);
@mysql_close($conexao);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Início - SaudFINAN</title>
<style type="text/css">
<!--
#inicioSistema{
	text-align:center;
	height:300px;
	width:auto;
	margin-top:30px;
}
-->
</style>
<script type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>

<body>
<a href="javascript:void(0)" title="Clique para iniciar o sistema!" onclick="MM_openBrWindow('../default.php','SaudFinan','scrollbars=yes,resizable=yes')">
<div id="inicioSistema">
  <p><img src="images/logo_saudseguroInicio.png" width="545" height="140" border="0" /></p>
  <p>&nbsp;</p>
</div>
</a>
</body>
</html>
