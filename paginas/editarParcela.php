<?php
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

function trata($preco){
	if(!is_numeric($preco)) {
		$preco= str_replace(".","",$preco);
		$preco = str_replace(",",".",$preco);
	}
	return $preco;
}

if (isset($_GET['idParcela'])) {
  $colname_par = (get_magic_quotes_gpc()) ? $_GET['idParcela'] : addslashes($_GET['idParcela']);
}


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  
	$valorParcela = trata( $_POST['titulo_valor'] );
	$dataVencimento = $_POST['venc_parcela'];
	
	$Result1 = mysqli_query(db_connect(),sprintf("UPDATE `parcela_titulo` SET `numero_documento` = '%s', `valor_parcela`='%s', `venc_parcela` = '%s' WHERE (`id_parcela`='%s') LIMIT 1",
				$_POST['numero_documento'],
				str_replace(",",".", $valorParcela ),
				implode('-',array_reverse(explode('/', $dataVencimento))),
				$_POST['id_parcela']));	
				
	
	echo "<script type=\"text/javascript\">
				alert(\"Dados Alterado com Sucesso!\");
			</script>";
	$linkImpressao = '<a href="contratoTitulo.php?idTitulo='. $_POST['sac_id'] .'&idParcela='. $colname_par .'" onClick="window.open(this.href, this.target, \'width=700,height=auto,left=50,top=50, scrollbars=yes, ,menubar=yes\'); return false;" style="font-size:14px" title="Visualizar Duplicatas para impressão!"><input type="submit" value="Visualizar Duplicata para impressão!"/></a>';

 }
 
$query_par = sprintf("SELECT * FROM parcela_titulo WHERE id_parcela = '%s'", $colname_par);

$par = mysqli_query(db_connect(),$query_par) or die(mysqli_error());
$row_par = mysqli_fetch_assoc($par);  
 
$query_sacado = "SELECT * FROM sacado where `sac_id` = '". $row_par['sac_id']."'";
$sacado = mysqli_query(db_connect(),$query_sacado) or die(mysqli_error());
?>
<script language="javascript">
function enviardados(){
	if (document.form1.titulo_data_vencimento.value=="")
	{
		alert( "Selecione a data de vencimento!" );
		document.form1.titulo_data_vencimento.focus();
		return false;

	}
}
</script>
<script language="javascript">
$(document).ready( function() {
	$("#form1").validate({
		// Define as regras
		rules:{
			
			sac_id: {
				required: true
			},
			
			responsavel: {
				required: true
			},
			
			titulo_valor: {
				required: true
			},
			
			titulo_data_vencimento: {
				required: true
			}			
		
		},
		// Define as mensagens de erro para cada regra
		messages:{
			
			sac_id: {
				required: "Por favor, selecione o sacado.",
			},
			
			responsavel: {
				required: "Por favor, selecione o especialista responsável.",
			},
			
			titulo_valor: {
				required: "Por favor, o valor do documento.",
			},
						
			titulo_data_vencimento: {
				required: "Por favor, informe o vencimento da parcela.",
			}	
		}
	});
	
	
	$('#titulo_data_vencimento').focus(function(){
		$(this).calendario({ 
			target:'#titulo_data_vencimento',
			top:0,
			left:130
		});
	});
	
	
});
</script>
<style media="print">
.oculta
{
	visibility: hidden;
	float:right;
	width:100px;
}
</style>
<h2>Editar Duplicata</h2>
<form method="post" name="form1" id="form1" onSubmit="return enviardados();" action="<?php echo $editFormAction; ?>">
 <center>
  <table align="center">
    
	<?php
	if(isset( $Result1 )){
		echo sprintf('<tr valign="baseline">
      <td height="30" colspan="2" align="right" nowrap>%s</td>
    </tr>', $linkImpressao);
	}
	?>
    <tr valign="baseline">
      <td height="25" align="right" nowrap>Nome Cliente:</td>
      <td align="left"><label>
      <select name="sac_id" id="sac_id">
		<?php
		while( $row_sacado  = mysqli_fetch_assoc($sacado)){
		?>
        <option value="<?php echo $row_sacado['sac_id']; ?>"><?php echo strtoupper( $row_sacado['sac_nome'] ); ?></option>
		<?php
		}
		?>
        </select>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td height="25" align="right" nowrap>N° Documento</td>
      <td align="left"><label><input type="text" name="numero_documento" id="numero_documento" value="<?php echo $row_par["numero_documento"]; ?>" size="15">
      </label></td>
    </tr>
    <tr valign="baseline">
      <td height="25" align="right" nowrap>Valor:</td>
      <td align="left"><label><input type="text" name="titulo_valor" onKeyDown="Formata(this,20,event,2)" id="titulo_valor" value="<?php echo number_format( $row_par["valor_parcela"], 2 ,",","." ); ?>" size="15">
      </label></td>
    </tr>
    
    <tr valign="baseline">
      <td height="25" align="right" nowrap="nowrap">Data  de vencimento:</td>
      <td align="left"><span><input name="venc_parcela" type="text" id="titulo_data_vencimento" value="<?php echo implode('/',array_reverse(explode('-', $row_par["venc_parcela"] ))); ?>" size="12" maxlength="10" /></span></td>
    </tr>
  
    <tr valign="baseline">
      <td height="25" align="right" nowrap>&nbsp;</td>
      <td align="left"><input type="submit" value="Alterar"></td>
    </tr>
  </table>
  <input type="hidden" name="id_parcela" value="<?php echo $row_par["id_parcela"]; ?>">
  <input type="hidden" name="MM_insert" value="form1">
  </center>
</form>
<?php
mysqli_free_result($sacado);
?>
