<?php
if( isset( $_GET['acao'] ) && $_GET['acao'] == 'excluir' ){
	$idTitulo = isset( $_GET['idTitulo'] ) ? intval( $_GET['idTitulo'] ) : '-1';
	
	@mysql_query(sprintf("DELETE FROM `titulos` WHERE (`titulo_id`='%s') LIMIT 1", $idTitulo));
		
	@mysql_query(sprintf("DELETE FROM `parcela_titulo` WHERE (`titulo_id`='%s')", $idTitulo));
		
	echo "<script type=\"text/javascript\">
			alert(\"Dados excluídos com sucesso!\");
		</script>";
	
	echo sprintf('<script type="text/javascript">
			location.href="%s";
		</script>', @$_SERVER['HTTP_REFERER']);
	die();
	
}


// technocurve arc 3 php bv block1/3 start
$color1 = "#E2FFE3";
$color2 = "#F9F9F9";
$color = $color1;
// technocurve arc 3 php bv block1/3 end
$query_Recordset1 = "SELECT s.sac_nome, s.sac_telefone, s.sac_cidade, s.sac_estado, t.titulo_valor, t.titulo_data_cadastro,  t.titulo_observacao, t.titulo_menor, t.titulo_id, p.pass_nome FROM titulos AS t INNER JOIN sacado AS s ON t.sac_id=s.sac_id LEFT JOIN `password` AS p ON p.pass_id=t.id_especialista GROUP BY (t.titulo_id) ORDER BY s.sac_nome ASC LIMIT 30";

if(isset($_GET['b'])){
	
	$sql = "SELECT s.sac_nome, s.sac_telefone, s.sac_cidade, s.sac_estado, t.titulo_valor, t.titulo_data_cadastro, t.titulo_observacao, t.titulo_menor, t.titulo_id, p.pass_nome FROM titulos AS t INNER JOIN sacado AS s ON t.sac_id=s.sac_id LEFT JOIN `password` AS p ON p.pass_id=t.id_especialista ";
	
	if(!empty($_GET['b']) || !empty($_GET['dataInicio']) || !empty($_GET['dataFim']) || !empty($_GET['resp'])) {
		$sql .= "WHERE";
	}
	
	if(!empty($_GET['b'])) {
		$sql .= sprintf(" s.sac_nome LIKE '%s' ", "%". $_GET['b'] ."%" );
	}
	
	if(!empty($_GET['dataFim']) && !empty($_GET['dataInicio'])){
		
		if(!empty($_GET['b'])) {
			$sql .= " AND ";
		}
		
		$dataInicio = implode('-',array_reverse(explode('/', $_GET['dataInicio'])));
		$dataFim = implode('-',array_reverse(explode('/', $_GET['dataFim'])));
		$sql .= sprintf(" t.titulo_data_cadastro BETWEEN '%s' AND '%s' ", $dataInicio, $dataFim );
	}
	
	if(!empty( $_GET['resp'] )) {
		
		if(!empty($_GET['b']) || !empty($_GET['dataInicio']) || !empty($_GET['dataFim'])) {
			$sql .= " AND ";
		}
		
		$sql .= sprintf(" t.id_especialista = '%s'", $_GET['resp']) ;
	}
		 
	$query_Recordset1 = $sql .=" GROUP BY (t.titulo_id) ORDER BY s.sac_nome ASC";

}

$Recordset1 = mysql_query($query_Recordset1, $conexao) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

if(mysql_num_rows($Recordset1) == 0 ){
	echo "<script type=\"text/javascript\">
				alert(\"Não nenhum registro encontrado!\");
					location.href='default.php';
				</script>";
}

$query_password = "SELECT * FROM password where especialista='S'";
$password = mysql_query($query_password, $conexao) or die(mysql_error());
?>
<script src="../jscripts/SpryTooltip.js" type="text/javascript"></script>
<link href="../jscripts/SpryTooltip.css" rel="stylesheet" type="text/css" />
<div id="boxLogin">
  <table width="100%" border="0">
    <tr>
      <td class="link">Consulta de Procedimentos:</td>
      <td height="30" align="right" class="link"><a href="javascript:history.back()" title="Voltar a página anterior"><img src="../images/voltar.png" width="32" height="32" border="0" /></a></td>
    </tr>
    <tr>
      <td height="30" colspan="2"><form id="formB" name="formB" method="get" action="default.php?pag=consultaTitulo">
        <table width="100%" border="0">
          <tr>
            <td>Filtros
              <input name="pag" type="hidden" id="pag" value="consultaTitulo" />
              :</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="10%">Cliente:</td>
            <td width="24%" align="left"><input name="b" type="text" id="b" size="30" /></td>
            <td width="55%"><table width="100%" border="0">
                <tr>
                  <td width="32%" align="right">Período:</td>
                  <td width="31%">&nbsp;</td>
                  <td width="14%">&nbsp;</td>
                  <td width="23%">&nbsp;</td>
                </tr>
                <tr>
                  <td align="right">Data início:</td>
                  <td align="left"><input name="dataInicio" type="text" id="dataInicio" size="12" maxlength="10" /></td>
                  <td colspan="2" align="center">Especialista:</td>
                  </tr>
                <tr>
                  <td align="right">Data Fim:</td>
                  <td align="left"><input name="dataFim" type="text" id="dataFim" size="12" maxlength="10" /></td>
                  <td colspan="2" align="center"><select name="resp" id="resp">
        <option value="">Selecione</option>
        <?php
		while( $row_password  = mysql_fetch_assoc($password)){
		?>
        <option value="<?php echo $row_password['pass_id']; ?>"><?php echo $row_password['pass_nome']; ?></option>
        <?php
		}
		?>
      </select>
                  </td>
                  </tr>
            </table></td>
            <td width="11%" align="right"><input type="submit" name="Submit" value="Buscar" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2" align="right"><label></label></td>
          </tr>
        </table>
      </form></td>
    </tr>
    <tr>
      <td colspan="2">
	  <table class="borda_cinza" width="100%" border="0" cellpadding="10" cellspacing="0">
        
		<tr>
          <td width="10%" align="left">Visualizar Procedimentos:</td>
          <td width="30%" height="30" align="left"><strong>Cliente</strong></td>
          <td width="16%" align="left"><strong>Profissional  Responsável</strong></td>
          <td width="23%" align="center"><strong>Valor do Documento</strong></td>
          <td width="14%" align="center"><strong>Data do Documento</strong></td>
          <td width="17%" align="center"><strong>Ação</strong></td>
        </tr>
        <?php
		$total=$totalab=$totalpg=0;
		do {
		$total = $total+$row_Recordset1['titulo_valor'];
		?>
          <tr <?php 
// technocurve arc 3 php bv block2/3 start
echo " style=\"background-color:$color;\"";
// technocurve arc 3 php bv block2/3 end
?>>
            <td height="60" align="left" style="border-top: 1px solid #ccc;">
			
			<a href="?pag=consultaParcelas&acao=mostrar&idTitulo=<?php echo $row_Recordset1['titulo_id']; ?>"><img src="images/lupa.png" width="27" height="26" border="0" id="sprytrigger<?php echo $row_Recordset1['titulo_id']; ?>"  /></a>
			<div class="tooltipContent" id="sprytooltip<?php echo $row_Recordset1['titulo_id']; ?>">Procedimentos Realizado: <strong><?php echo  $row_Recordset1["titulo_observacao"]; ?></strong><br/>Data: <strong><?php echo date('d/m/Y', strtotime( $row_Recordset1["titulo_data_cadastro"] )); ?></strong><br/>
				<?php
				if($row_Recordset1["titulo_menor"]){
				?>
				Menor: <strong><?php echo $row_Recordset1["titulo_menor"]; ?></strong>
				<?php
				}
				?>
			</div>
			<script type="text/javascript">
			var sprytooltip1 = new Spry.Widget.Tooltip("sprytooltip<?php echo $row_Recordset1['titulo_id']; ?>", "#sprytrigger<?php echo $row_Recordset1['titulo_id']; ?>");
			</script>
			<br/>
			<?php echo $row_Recordset1['titulo_id']; ?></td>
              <td height="30" align="left" style="border-top: 1px solid #ccc;"><?php echo "<strong>". $row_Recordset1['sac_nome'] ."</strong><br /><span style=\"font-size:11px; color:#888;\">". $row_Recordset1['sac_cidade'] . "/" . $row_Recordset1['sac_estado'] . "<br/ >Contato: <b>". $row_Recordset1['sac_telefone'] ."</b></span>";  ?></td>
              <td align="left" style="border-top: 1px solid #ccc;"><?php echo $row_Recordset1['pass_nome']; ?></td>
              <td align="center" style="border-top: 1px solid #ccc;"><?php echo number_format( $row_Recordset1['titulo_valor'], 2,",","." ); ?><br/>
			
			
			<?php
			$sql=mysql_query(sprintf("SELECT `titulo_id` FROM `parcela_titulo` WHERE situacao_parcela ='ab' AND titulo_id ='%s'", $row_Recordset1['titulo_id']));
			
			if(mysql_num_rows($sql) > 0){
				$totalab = $totalab+$row_Recordset1['titulo_valor'];
				echo '<span style="color:red; font-size:11px;">Situação: Aberto</span>';
			} else {	
				$totalpg = $totalpg+$row_Recordset1['titulo_valor'];
				echo '<span style="color:#888; font-size:11px;">Situação: Liquidado</span>';
			}
			mysql_free_result( $sql );
			?>			</td>
            <td align="center" style="border-top: 1px solid #ccc;">
			<?php
			 echo @date('d/m/Y', strtotime( $row_Recordset1['titulo_data_cadastro'] ));
			?></td>
            <td align="center" style="border-top: 1px solid #ccc;">
			<a href="?pag=consultaParcelas&acao=mostrar&idTitulo=<?php echo $row_Recordset1['titulo_id']; ?>" onclick="tmt_confirm('Deseja%20visualizar%20as%20parcelas%20de%20<?php
			 echo $row_Recordset1['sac_nome'];?>%20antes?');return document.MM_returnValue" title="Baixar fatura"><img src="images/tool_drop_target.png" alt="#" width="16" height="16" border="0" /></a>
			<?php
				if($dados["pass_nivel"]>1){
			?>
			 &nbsp;&nbsp;<a href="?pag=consultaTitulo&acao=excluir&idTitulo=<?php echo $row_Recordset1['titulo_id']; ?>" title="Excluir duplicata"><img src="images/excluir.gif" width="16" height="16" border="0" onclick="tmt_confirm('Realmente%20deseja%20excluir%20?');return document.MM_returnValue" /></a>
			 <?php
			 } 
			 ?>			 </td>
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
	  </td>
    </tr>
    <tr>
      <td colspan="2"><table width="100%" border="0">
        <tr>
          <td height="30">Total Aberto: R$: <strong><?php echo number_format( $totalab, 2,",","." ); ?></strong></td>
          <td>Total Líquidado: R$: <strong><?php echo number_format( $totalpg, 2,",","." ); ?></strong></td>
          <td>&nbsp;</td>
          <td>Total: R$: <strong><?php echo number_format( $total, 2,",","." ); ?></strong></td>
        </tr>
        
      </table></td>
    </tr>
  </table>
</div>
<?php
mysql_free_result($Recordset1);
mysql_free_result($password);
?>
