<?php
if( isset( $_GET['acao'] ) && $_GET['acao'] = 'excluir' ){
	$idUsu = isset( $_GET['idUsu'] ) ? intval( $_GET['idUsu'] ) : '-1';
	mysqli_query(db_connect(),sprintf("DELETE FROM `password` WHERE (`pass_id`='%s' AND `pass_nivel` < '3') LIMIT 1", $idUsu));
	echo "<script type=\"text/javascript\">
					alert(\"Dados excluídos com sucesso!\");
					location.href='?pag=consultaUsuario';
				</script>";
	die();			
}
// technocurve arc 3 php bv block1/3 start
$color1 = "#E8F9E8";
$color2 = "#D1F9DB";
$color = $color1;
// technocurve arc 3 php bv block1/3 end
if($dados["pass_nivel"]==3){
	$query_Recordset1 = "SELECT SQL_NO_CACHE * FROM password ORDER BY pass_login ASC";
} else {
	$query_Recordset1 = "SELECT SQL_NO_CACHE * FROM password WHERE pass_nivel < '3' ORDER BY pass_login ASC";
}
$Recordset1 = mysqli_query(db_connect(),$query_Recordset1) or die(mysqli_error());
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);
?>
<div id="boxLogin">
  <table width="100%" border="0">
    <tr>
      <td class="link">Usuário(s) Administrativo(s): </td>
      <td align="right" class="link"><a href="javascript:history.back()" title="Voltar a página anterior"><img src="../images/voltar.png" width="32" height="32" border="0" /></a></td>
    </tr>
    <tr>
      <td colspan="2"><table class="borda_cinza" width="100%" border="0" cellpadding="10" cellspacing="0">
        <tr>
          <td align="left"><strong>Nome</strong></td>
          <td height="30" align="left"><strong>Login</strong></td>
          <td align="center"><strong>Senha</strong></td>
          <td align="center"><strong>Nível</strong></td>
          <td align="center"><strong>Ação</strong></td>
        </tr>
        <?php do { ?>
          <tr <?php 
// technocurve arc 3 php bv block2/3 start
echo " style=\"background-color:$color\"";
// technocurve arc 3 php bv block2/3 end
?>>
            <td align="left"><?php echo $row_Recordset1['pass_nome']; ?></td>
              <td height="30" align="left"><?php echo $row_Recordset1['pass_login']; ?></td>
            <td align="center">
			<?php
			if($dados["pass_nivel"]==3){
				echo $row_Recordset1['pass_senha']; 
			} else {
				echo "******";
			}			
			?></td>
            <td align="center">
			<?php
			if($row_Recordset1['pass_nivel'] ==1){
				echo "Operador";
			} elseif($row_Recordset1['pass_nivel'] >1){
				echo "Administrador";
			}	
			?></td>
            <td align="center"><a href="?pag=alteraUsuario&idUsu=<?php echo $row_Recordset1['pass_id']; ?>" title="Alterar Dados"><img src="images/alterar.gif" alt="#" width="16" height="16" border="0" /></a>
			
			<?php
			if($dados["pass_nivel"]==3){
			?>
			&nbsp;&nbsp;<a href="?pag=consultaUsuario&acao=excluir&idUsu=<?php echo $row_Recordset1['pass_id']; ?>" title="Excluir"><img src="images/excluir.gif" width="16" height="16" border="0" onclick="tmt_confirm('Realmente%20deseja%20excluir?');return document.MM_returnValue" /></a>
			<?php
			}
			?>			</td>
          </tr>
		   <?php 
		// technocurve arc 3 php bv block3/3 start
		if ($color == $color1) {
			$color = $color2;
		} else {
			$color = $color1;
		}
		// technocurve arc 3 php bv block3/3 end
		?>
          <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
      </table></td>
    </tr>
  </table>
</div>
<?php
mysqli_free_result($Recordset1);
?>