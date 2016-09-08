<?php
// technocurve arc 3 php bv block1/3 start
$color1 = "#E2FFE3";
$color2 = "#F9F9F9";
$color = $color1;

// technocurve arc 3 php bv block1/3 end
$query_Recordset1 = "SELECT SQL_NO_CACHE s.sac_nome, s.sac_telefone, s.sac_cidade, s.sac_estado, p.parcela_vencimento, m.qtde_parcela_manutencao, m.manutencao_id, p.parcela_valor, p.parcela_id, p.`numero_parcela`, p.`parcela_situacao`, e.pass_nome FROM parcela_aparelho AS p INNER JOIN manutencao AS m on p.manutencao_id=m.manutencao_id LEFT JOIN sacado AS s ON s.sac_id=p.sac_id RIGHT JOIN `password` AS e ON e.pass_id=m.id_especialista WHERE p.parcela_situacao = 'ab' ORDER BY s.sac_nome ASC, p.parcela_vencimento ASC LIMIT 30";


If(isset($_GET['DataVencida'])) {
	
	$query_Recordset1 = sprintf("SELECT SQL_NO_CACHE s.sac_nome, s.sac_telefone, s.sac_cidade, s.sac_estado, p.parcela_vencimento, m.qtde_parcela_manutencao, m.manutencao_id, p.parcela_valor, p.parcela_id, p.`numero_parcela`, p.`parcela_situacao`, e.pass_nome FROM parcela_aparelho AS p INNER JOIN manutencao AS m on p.manutencao_id=m.manutencao_id INNER JOIN sacado AS s ON s.sac_id=p.sac_id LEFT JOIN `password` AS e ON e.pass_id=m.id_especialista WHERE p.parcela_situacao = 'ab' AND p.parcela_vencimento < '%s' ORDER BY s.sac_nome ASC, p.parcela_vencimento ASC LIMIT 30", date('Y-m-d') );
	
}

if( isset( $_GET['acao'] ) && $_GET['acao'] == 'excluir' ){
	$idParcela = isset( $_GET['idParcela'] ) ? intval( $_GET['idParcela'] ) : '-1';
	
	mysqli_query(db_connect(),sprintf("DELETE FROM `parcela_aparelho` WHERE (`parcela_id`='%s') LIMIT 1", $idParcela));
	echo "<script type=\"text/javascript\">
				alert(\"Dados excluídos com sucesso!\");
			</script>";
			
	echo sprintf('<script type="text/javascript">
			location.href="%s";
		</script>', $_SERVER['HTTP_REFERER']);
	die();		

} elseif( isset( $_GET['acao'] ) && $_GET['acao'] == 'baixa' ){
	
	$idParcela = isset( $_GET['idParcela'] ) ? intval( $_GET['idParcela'] ) : '-1';
	mysqli_query(db_connect(),sprintf("UPDATE `parcela_aparelho` SET `parcela_situacao`='pg' WHERE (`parcela_id`='%s') LIMIT 1", $idParcela));
	echo "<script type=\"text/javascript\">
				alert(\"Baixa efetuada com sucesso!\");
			</script>";
	

	echo sprintf('<script type="text/javascript">
			location.href="%s";
		</script>', $_SERVER['HTTP_REFERER']);
	die();

} elseif( isset( $_GET['acao'] ) && $_GET['acao'] == 'mostrar' ){
	
	$idTitulo = isset( $_GET['idTitulo'] ) ? intval( $_GET['idTitulo'] ) : '-1';
	$query_Recordset1 = sprintf("SELECT SQL_NO_CACHE s.sac_nome, s.sac_telefone, s.sac_cidade, s.sac_estado, p.parcela_vencimento, m.qtde_parcela_manutencao, m.manutencao_id, p.parcela_valor, p.parcela_id, p.`numero_parcela`, p.`parcela_situacao`, e.pass_nome FROM parcela_aparelho AS p INNER JOIN manutencao AS m on p.manutencao_id=m.manutencao_id INNER JOIN sacado AS s ON s.sac_id=p.sac_id LEFT JOIN `password` AS e ON e.pass_id=m.id_especialista WHERE p.manutencao_id = '%s' ORDER BY s.sac_nome ASC LIMIT 30",$idTitulo );
	
} 

if(isset($_GET['b'])){
	
	$sql = "SELECT SQL_NO_CACHE s.sac_nome, s.sac_telefone, s.sac_cidade, s.sac_estado, p.parcela_vencimento, m.qtde_parcela_manutencao, m.manutencao_id, p.parcela_valor, p.parcela_id, p.parcela_situacao, p.`numero_parcela`, p.`parcela_situacao`, e.pass_nome FROM parcela_aparelho AS p INNER JOIN manutencao AS m on p.manutencao_id=m.manutencao_id INNER JOIN sacado AS s ON s.sac_id=p.sac_id LEFT JOIN `password` AS e ON e.pass_id=m.id_especialista ";
	
	if(!empty($_GET['b']) || !empty($_GET['dataInicio']) || !empty($_GET['dataFim']) || !empty($_GET['resp']) || !empty($_GET['TipoData'])) {
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
		
		if ( $dataInicio == date('Y-m-d')) {

			$sql .= sprintf( " p.parcela_vencimento = CURDATE() AND p.parcela_vencimento <= '%s' ", $dataFim );
			
		}  else {
			$sql .= sprintf(" p.parcela_vencimento BETWEEN '%s' AND '%s' ", $dataInicio, $dataFim );
		}
	}
	
	if(!empty( $_GET['resp'] )) {
		
		if(!empty($_GET['b']) || !empty($_GET['dataInicio']) || !empty($_GET['dataFim'])) {
			$sql .= " AND ";
		}
		
		$sql .= sprintf(" m.id_especialista = '%s' ", $_GET['resp']) ;
	}
	
	if(!empty($_GET['TipoData'])) {
		$TipoData = $_GET['TipoData'];
		
		if(!empty($_GET['b']) || !empty($_GET['dataInicio']) || !empty($_GET['dataFim']) || !empty($_GET['resp'])) {
			$sql .= " AND ";
		}
		
		if($TipoData==1){
			$sql .= sprintf(" p.parcela_situacao = 'ab' AND p.parcela_vencimento > '%s'", date('Y-m-d') );
		} elseif($TipoData==2){
			$sql .= sprintf(" p.parcela_situacao = 'ab' AND p.parcela_vencimento < '%s'", date('Y-m-d') );
		} elseif($TipoData==3){
			$sql .= " p.parcela_situacao = 'pg'" ;
		} 
		
	}
		 
	$query_Recordset1 = $sql .=" ORDER BY s.sac_nome ASC, p.parcela_vencimento ASC";

}

$Recordset1 = mysqli_query(db_connect(),$query_Recordset1) or die(mysqli_error());
$row_Recordset1 = mysqli_fetch_assoc($Recordset1);

if(mysqli_num_rows($Recordset1) == 0 ){
	echo "<script type=\"text/javascript\">
				alert(\"Não nenhum registro encontrados!\");
					location.href='default.php';
				</script>";
}

$query_password = "SELECT SQL_NO_CACHE * FROM password where especialista='S'";
$password = mysqli_query(db_connect(),$query_password) or die(mysqli_error());
?>
<div id="boxLogin">
  <table width="100%" border="0">
    <tr>
      <td class="link">Consulta de Aparelhos</td>
      <td align="right" class="link"><a href="javascript:history.back()" title="Voltar a página anterior"><img src="../images/voltar.png" width="32" height="32" border="0" /></a></td>
    </tr>
    <tr>
      <td colspan="2"><form id="formB" name="formB" method="get" action="default.php?pag=consultaAparelho">
        <table width="100%" border="0">
          <tr>
            <td>Filtros
              <input name="pag" type="hidden" id="pag" value="consultaAparelho" />
              :</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="7%">Cliente:</td>
            <td width="23%" align="left"><input name="b" type="text" id="b" size="30" /></td>
            <td width="49%"><table width="100%" border="0">
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
		while( $row_password  = mysqli_fetch_assoc($password)){
		?>
        <option value="<?php echo $row_password['pass_id']; ?>"><?php echo $row_password['pass_nome']; ?></option>
        <?php
		}
		?>
      </select>
                </td>
              </tr>
            </table></td>
            <td width="13%"><table>
                <tr>
                  <td><label>
                    <input type="radio" name="TipoData" value="2" />
                    vencidos</label></td>
                </tr>
                <tr>
                  <td><label>
                    <input type="radio" name="TipoData" value="1" />
                    à vencer</label></td>
                </tr>
				<tr>
                  <td><label>
                    <input type="radio" name="TipoData" value="3" />
                    pagos</label></td>
                </tr>
            </table></td>
            <td width="8%" align="right"><input type="submit" name="Submit" value="Buscar" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="3" align="right"><label></label></td>
            </tr>
        </table>
                  </form>
      </td>
    </tr>
    <tr>
      <td colspan="2">
	    <div class="barraVertical">
	  <table class="borda_cinza" width="100%" border="0" cellpadding="10" cellspacing="0">
        <tr>
          <td width="10%" align="left">Visualizar Manutenção</td>
          <td width="30%" height="30" align="left"><strong>Cliente</strong></td>
          <td width="16%" align="left"><strong>Profissional Responsável</strong></td>
          <td width="23%" align="center"><strong>Valor Parcela </strong></td>
          <td width="14%" align="center"><strong>Vencimento Parcela </strong></td>
          <td width="17%" align="center"><strong>Ação</strong></td>
        </tr>
        <?php
		$total=$totalpg=0;
		do {
		$total = $total+$row_Recordset1['parcela_valor'];
		if(isset($row_Recordset1['parcela_situacao']) && $row_Recordset1['parcela_situacao'] =="pg"){
			$color="#DBE2F9";
			$totalpg = $totalpg+$row_Recordset1['parcela_valor'];
		} else {
	
			
			if($row_Recordset1['parcela_vencimento'] <= date('Y-m-d', strtotime("+7 day"))){
				$color="#FFFF8C";
			}
			
			if($row_Recordset1['parcela_vencimento'] < date('Y-m-d') ){
				$color="#FFD9D8";
			}	
		}
		?>
          <tr <?php 
// technocurve arc 3 php bv block2/3 start
echo " style=\"background-color:$color;\"";
// technocurve arc 3 php bv block2/3 end
?>>
            <td height="60" align="left" style="border-top: 1px solid #ccc;">
			
			<a href="../default.php?pag=consultaManutencao&acao=mostrar&idManutencao=<?php echo $row_Recordset1['manutencao_id']; ?>" title="Visualizar Parcelamento de Manutenção"><img src="images/lupa.png" width="27" height="26" border="0" /></a><br/><?php echo $row_Recordset1['qtde_parcela_manutencao']; ?></td>
              <td height="30" align="left" style="border-top: 1px solid #ccc;"><?php echo "<strong>". $row_Recordset1['sac_nome'] ."</strong><br /><span style=\"font-size:11px; color:#888;\">". $row_Recordset1['sac_cidade'] . "/" . $row_Recordset1['sac_estado'] . "<br/ >Contato: <b>". $row_Recordset1['sac_telefone'] ."</b></span>";  ?></td>
              <td align="left" style="border-top: 1px solid #ccc;"><?php echo $row_Recordset1['pass_nome']; ?></td>
              <td align="center" style="border-top: 1px solid #ccc;"><?php echo number_format( $row_Recordset1['parcela_valor'], 2,",","." ); ?></td>
            <td align="center" style="border-top: 1px solid #ccc;">
			<?php
			if($row_Recordset1['parcela_vencimento'] ==="0000-00-00"){
				echo "Data não informada";
			} else {
				echo @date('d/m/Y', strtotime( $row_Recordset1['parcela_vencimento'] )) ."<br />";
			
			}
			
			if(isset($row_Recordset1['parcela_situacao']) && $row_Recordset1['parcela_situacao'] =="pg"){
					echo "QUITADO";
				}
			 
			?></td>
            <td align="center" style="border-top: 1px solid #ccc;">
			
			<a href="?pag=consultaAparelho&acao=baixa&idTitulo=<?php echo $row_Recordset1['manutencao_id']; ?>&idParcela=<?php echo $row_Recordset1['parcela_id']; ?>" onclick="tmt_confirm('Confirma%20baixa%20para%20<?php
			 echo $row_Recordset1['sac_nome'];?>%20%20-%20%20R$%20%20<?php echo number_format( $row_Recordset1['parcela_valor'], 2,",","." ); ?>%20%20-%20%20<?php
			 
			if($row_Recordset1['parcela_vencimento'] ==="0000-00-00"){
				echo "Data não informada";
			} else { 
				echo @date('d/m/Y', strtotime( $row_Recordset1['parcela_vencimento'] ));
			}
			
			?>%20?');return document.MM_returnValue" title="Receber fatura"><img src="images/tool_drop_target.png" alt="#" width="16" height="16" border="0" /></a>&nbsp;
			
			<?php
			/*
			<a href="?pag=editarParcelaAparelho&idParcela=<?php echo $row_Recordset1['parcela_id']; ?>" title="Editar fatura"><img src="images/pen.png" alt="#" width="16" height="16" border="0" /></a>&nbsp;
			*/
			?>
			
			<?php
				if($dados["pass_nivel"]>2){
			?>
			
			<a href="?pag=consultaAparelho&acao=excluir&idParcela=<?php echo $row_Recordset1['parcela_id']; ?>" title="Excluir"><img src="images/excluir.gif" width="16" height="16" border="0" onclick="tmt_confirm('Realmente%20deseja%20excluir?');return document.MM_returnValue" /></a>
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
      </table>
	  </div>	  </td>
    </tr>
    <tr>
      <td colspan="2"><table width="100%" border="0">
        <tr>
          <td height="40">Duplicatas vencidas: R$: <strong><?php 
		  
		  
			$sql = mysqli_query(db_connect(),sprintf("SELECT SQL_NO_CACHE SUM(parcela_valor) AS soma FROM parcela_aparelho WHERE `parcela_situacao` = 'ab' AND `parcela_vencimento` < '%s'",  date('Y-m-d')));
			
			$valor_total = mysqli_fetch_array($sql);
		  
			echo number_format( $valor_total["soma"], 2,",","." );
			mysqli_free_result($sql);
			
			?></strong></td>
          <td>Duplicatas vincendo em menos de 07 dias: R$: <strong><?php 
		  
		  
			$sql = mysqli_query(db_connect(),sprintf("SELECT SQL_NO_CACHE SUM(parcela_valor) AS soma FROM parcela_aparelho WHERE parcela_situacao = 'ab' AND `parcela_vencimento` >= '%s' AND `parcela_vencimento` <= '%s' ",  date('Y-m-d'), date('Y-m-d', strtotime("+7 day"))));
		  
			$valor_total = mysqli_fetch_array($sql);		  
			echo number_format( $valor_total["soma"], 2,",","." );
			mysqli_free_result($sql);
			
			?></strong></td>
          <td>Todas: R$: <strong><?php echo number_format( $total, 2,",","." ); ?></strong></td>
          </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          </tr>
      </table></td>
    </tr>
  </table>
</div>
<?php
mysqli_free_result($Recordset1);
mysqli_free_result($password);
?>
