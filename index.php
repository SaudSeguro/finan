<?php
require_once('config.php'); 
$rsAdmin = mysqli_query(db_connect(),"SELECT * FROM `password` WHERE `pass_id` = '1'");
if(mysqli_num_rows($rsAdmin) == 0 ){
	mysqli_query(db_connect(),"INSERT INTO `password` (`pass_login` ,`pass_senha` ,`pass_nivel`)
	VALUES ('admin', 'admin', '3')");
}
mysqli_free_result($rsAdmin);
mysqli_close(db_connect());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
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
