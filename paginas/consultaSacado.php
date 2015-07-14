<?php
if( isset( $_GET['acao'] ) && $_GET['acao'] = 'excluir' ){
	$idSac = isset( $_GET['idSac'] ) ? intval( $_GET['idSac'] ) : '-1';
	
	$rsConsulta = mysql_query(sprintf("SELECT * FROM `titulos` WHERE `sac_id` = '%s'", $idSac));

	if(mysql_num_rows($rsConsulta) > 0 ){
		
		echo "<script type=\"text/javascript\">
						alert(\"Não é possível excluir este sacado, há títulos registrados!\");
						location.href='?pag=consultaSacado';
				</script>";
	
	} else {
	
		@mysql_query(sprintf("DELETE FROM `sacado` WHERE (`sac_id`='%s') LIMIT 1", $idSac));
		@mysql_query(sprintf("DELETE FROM `manutencao` WHERE (`sac_id`='%s') LIMIT 1", $idSac));
		@mysql_query(sprintf("DELETE FROM `parcela_aparelho` WHERE (`sac_id`='%s') LIMIT 1", $idSac));
		@mysql_query(sprintf("DELETE FROM `parcela_manutencao` WHERE (`sac_id`='%s') LIMIT 1", $idSac));
		@mysql_query(sprintf("DELETE FROM `titulos` WHERE (`sac_id`='%s') LIMIT 1", $idSac));
		echo "<script type=\"text/javascript\">
						alert(\"Dados excluídos com sucesso!\");
						location.href='?pag=consultaSacado';
					</script>";

	}	
}
// technocurve arc 3 php bv block1/3 start
$color1 = "#E2FFE3";
$color2 = "#F9F9F9";
$color = $color1;
// technocurve arc 3 php bv block1/3 end
$query_Recordset1 = "SELECT * FROM sacado ORDER BY sac_nome ASC";

if(isset($_GET['b'])){
	
	$query_Recordset1 = sprintf("SELECT * FROM sacado WHERE sac_nome LIKE '%s' ORDER BY  sac_nome ASC", "%". $_GET['b'] ."%" );
}


$Recordset1 = mysql_query($query_Recordset1, $conexao) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if(mysql_num_rows($Recordset1) == 0 ){
	echo "<script type=\"text/javascript\">
				alert(\"Não nenhum registro encontrado!\");
					location.href='default.php';
				</script>";
}

?>
<div id="boxLogin">
  <table width="100%" border="0">
    <tr>
      <td class="link">Consulta de Clientes:</td>
      <td align="right" class="link"><a href="javascript:history.back()" title="Voltar a página anterior"><img src="../images/voltar.png" width="32" height="32" border="0" /></a></td>
    </tr>
    <tr>
      <td colspan="2"><form id="formB" name="formB" method="get" action="default.php?pag=consultaTitulo">
        <table width="100%" border="0">
          <tr>
            <td>Filtros
              <input name="pag" type="hidden" id="pag" value="consultaSacado" />
              :</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="10%">&nbsp;Cliente:</td>
            <td width="27%" align="left"><input name="b" type="text" id="b" size="30" /></td>
            <td width="63%" align="left"><input type="submit" name="Submit" value="Buscar" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td align="right"><label></label></td>
          </tr>
        </table>
      </form></td>
    </tr>
    <tr>
      <td colspan="2">
	  <div class="barraVertical">
	  <table class="borda_cinza" width="100%" border="0" cellpadding="10" cellspacing="0">
        <tr>
          <td width="29%" height="30" align="left"><strong>&nbsp;&nbsp;Cliente</strong></td>
          <td width="30%" align="center"><strong>Telefone</strong></td>
          <td width="26%" align="center"><strong>Cidade/UF</strong></td>
          <td width="15%" align="center"><strong>Ação</strong></td>
        </tr>
        <?php do { ?>
          <tr <?php 
// technocurve arc 3 php bv block2/3 start
echo " style=\"background-color:$color\"";
// technocurve arc 3 php bv block2/3 end
?>>
              <td height="60" align="left" style="border-top: 1px solid #ccc;">&nbsp;&nbsp;<?php echo $row_Recordset1['sac_nome']; ?></td>
            <td align="center" style="border-top: 1px solid #ccc;"><?php echo $row_Recordset1['sac_telefone']; ?></td>
            <td align="center" style="border-top: 1px solid #ccc;">
			<?php
			 echo $row_Recordset1['sac_cidade'] . " / " . $row_Recordset1['sac_estado'];
			?></td>
            <td align="center" style="border-top: 1px solid #ccc;"><a href="?pag=alteraSacado&idSac=<?php echo $row_Recordset1['sac_id']; ?>" title="Alterar Dados"><img src="images/alterar.gif" alt="#" width="16" height="16" border="0" /></a>
			<?php
			if($dados["pass_nivel"]>1){
			?>
			&nbsp;&nbsp;<a href="?pag=consultaSacado&acao=excluir&idSac=<?php echo $row_Recordset1['sac_id']; ?>" title="Excluir"><img src="images/excluir.gif" width="16" height="16" border="0" onclick="tmt_confirm('Realmente%20deseja%20excluir?');return document.MM_returnValue" /></a>
			<?php
			}
			?>
			</td>
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
          <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
      </table>
	  </div>	  </td>
    </tr>
  </table>
</div>
<?php
mysql_free_result($Recordset1);
?>