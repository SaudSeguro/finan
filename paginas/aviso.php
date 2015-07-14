<?php
$query_Recordset1 = mysql_query( sprintf("SELECT * FROM parcela_titulo WHERE situacao_parcela = 'ab' AND venc_parcela < '%s'", date('Y-m-d') ));
if(mysql_num_rows($query_Recordset1) !== 0){

echo '<center>
	<table width="250" border="0" cellspacing="10">
	  
	  <tr>
		<td width="15%" height="100" align="center" valign="middle"><img src="../images/attach.png" width="32" height="32" /></td>
		<td width="85%" align="left" valign="middle"><p><strong>Nota!</strong><br>
		  Há documento(s) vencido(s).<br>
			<a href="?pag=consultaParcelas&DataVencida=1" title="Clique para visualizar">Clique Aqui</a>, para visualizar </p>      </td>
	  </tr>
	</table>
	</center>';
}
mysql_free_result( $query_Recordset1 );
?>
