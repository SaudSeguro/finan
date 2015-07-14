<?php
require_once('Connections/conexao.php');
require_once('funcao_numero_extenso.php'); 

$colname_res = "-1";
if (isset($_GET['idTitulo'])) {
  $colname_res = (get_magic_quotes_gpc()) ? $_GET['idTitulo'] : addslashes($_GET['idTitulo']);
}

mysql_select_db($database_conexao, $conexao);
$query_res = sprintf("SELECT * FROM titulos AS t INNER JOIN sacado AS s ON t.sac_id=s.sac_id WHERE t.titulo_id = %s", $colname_res);
$res = mysql_query($query_res, $conexao) or die(mysql_error());
$row_res = mysql_fetch_assoc($res);
$totalRows_res = mysql_num_rows($res);

if (isset($_GET['idParcela'])) {
  $colname_par = (get_magic_quotes_gpc()) ? $_GET['idParcela'] : addslashes($_GET['idParcela']);
}

$query_par = sprintf("SELECT * FROM parcela_titulo WHERE id_parcela = '%s'", $colname_par);

$par = mysql_query($query_par, $conexao) or die(mysql_error());

$row_par = mysql_fetch_assoc($par);                 
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SaudSeguro - Promissória Nº <?php echo $row_par['numero_documento']; ?></title>
<link href="promissoria_style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
#promissoria{font:12px "Times New Roman", Times, serif; width:632px; height:349px; border:1px solid #333333; margin:0 auto; padding:5px; border-radius:5px 5px 5px;}
#promissoria .box1{width:100px; height:349px; float:left; border:1px solid #333333; border-radius:5px 5px 5px;}
#promissoria .box2{width:522px; height:349px; float:right;}
.borderDashed{border-bottom:1px dotted #333333; font-size:12px;}
.fontArial{font:10px Arial, Helvetica, sans-serif;}
.fontArial2{font:8px Arial, Helvetica, sans-serif;}
.fontNegrito{font:20px "Times New Roman", Times, serif; font-weight:bold; padding:0 5px;}
.contorno{font:13px "Times New Roman", Times, serif; border:2px solid #000000; border-radius:5px 5px 5px; padding-left:2px;}
-->
</style>
<style media="print">
.oculta
{
	visibility: hidden;
	float:right;
	width:100px;
}
</style>
</head>

<body>

<div id="promissoria">

	<div class="box1">
	<img src="images/republica_federativa.gif" />
	</div>

	<div class="box2">
	  <table width="99%"  height="349" border="0" cellpadding="0" cellspacing="2">
        <tr>
          <td align="right"><table width="300" height="17" border="0" cellpadding="0" cellspacing="0">
            <tr>
			<?php 
			$data = explode("-", $row_par['venc_parcela']);
			?>
				
              <td width="66" align="left" class="fontArial">Vencimento:</td>
              <td width="41" align="center" class="borderDashed"><?php echo @$data[2]; ?></td>
              <td width="15" align="left" class="fontArial">de</td>
              <td width="106" align="center" class="borderDashed"><?php echo @$data[1]; ?></td>
              <td width="17" align="left" class="fontArial">de</td>
              <td width="55" align="center" class="borderDashed"><?php echo @$data[0]; ?></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td align="center"><table height="30" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="63" align="right" class="fontNegrito">N°</td>
              <td width="120" align="center" class="contorno"><?php echo $row_par['numero_documento']; ?></td>
              <td width="183" align="right" class="fontNegrito">R$</td>
              <td width="123" align="center" class="contorno"><?php echo number_format( $row_par['valor_parcela'] , 2,",","."); ?></td>
              <td width="29" align="center">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td align="left"><table width="510" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="35" class="fontArial">Ao(s):</td>
              <td width="483" class="borderDashed"><?php  echo ordinal($row_par['venc_parcela']); ?></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td align="left" class="fontArial">pagarei por esta única via de <strong>NOTA PROMISSÓRIA</strong></td>
        </tr>
		
		<tr>
          <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="2%" align="center" class="fontArial">a</td>
              <td width="44%" align="center" class="borderDashed">ALEKSIAN SCHENKEL DE BASTIANI</td>
              <td width="13%" align="center" class="fontArial">CPF / CNPJ </td>
              <td width="41%" align="center" class="borderDashed">018.993.579-04</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td align="left"><table width="510" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="79" height="30" class="fontArial2">OU A SUA ORDEM<br />
              A QUANTIA DE</td>
              <td width="431" height="30" class="contorno">
				<?php
				$dim = extenso($row_par['valor_parcela']);
				echo str_replace(" E "," e ",ucwords($dim));
				?>
				</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td align="left"><table width="510" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="412" height="30" class="contorno">&nbsp;</td>
              <td width="98" height="30" align="right" class="fontArial2">EM MOEDA CORRENTE<br />
              DESTE PAÍS</td>
            </tr>
          </table></td>
        </tr>

        <tr>
          <td align="left" valign="bottom"><table width="245" border="0" cellspacing="2" cellpadding="0">
            <tr>
              <td width="66" align="left" class="fontArial">Pagável em: </td>
              <td width="175" class="borderDashed">DIAMANTINO / MT</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td align="left" valign="bottom"><table width="245" border="0" cellspacing="2" cellpadding="0">
            <tr>
              <td width="64" align="left" class="fontArial">Emitente: </td>
              <td width="175" class="borderDashed"><?php echo $row_res['sac_nome']; ?></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td align="left" valign="bottom"><table width="510" border="0" cellspacing="2" cellpadding="0">
            <tr>
              <td width="68" align="left" class="fontArial">CPF / CNPJ:</td>
              <td width="175" class="borderDashed"><?php echo $row_res['sac_cpf']; ?></td>
              <td width="64" align="right" class="fontArial">Data:</td>
              <td width="202" class="borderDashed"><?php echo date('d/m/Y'); ?></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td align="left" valign="bottom"><table width="510" border="0" cellspacing="2" cellpadding="0">
            <tr>
              <td width="69" align="left" class="fontArial">Endereço:</td>
              <td width="175" class="borderDashed"><?php echo $row_res['sac_endereco']; ?></td>
              <td width="64" align="right" class="fontArial">Assinatura:</td>
              <td width="202" class="borderDashed">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
      </table>
	</div>
	
</div><!--promissoria-->
<div align="center" style="margin-top:20px;"><div class="oculta">
    <a href="javascript:window.print()" title="Clique para imprimir">
<img src="images/botao_imprimir.jpg" border="0" class="oculta"/></a>
</div></div>

</body>
</html>
<?php
mysql_free_result($res);
?>
