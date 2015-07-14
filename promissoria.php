<?php require_once('Connections/conexao.php'); ?>
<?php
$colname_res = "-1";
if (isset($_GET['id'])) {
  $colname_res = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysql_select_db($database_conexao, $conexao);
$query_res = sprintf("SELECT * FROM titulos AS t INNER JOIN sacado AS s ON t.sac_id=s.sac_id WHERE t.titulo_id = %s", $colname_res);
$res = mysql_query($query_res, $conexao) or die(mysql_error());
$row_res = mysql_fetch_assoc($res);
$totalRows_res = mysql_num_rows($res);

$query_par = sprintf("SELECT * FROM parcela_titulo WHERE titulo_id = '%s'", $colname_res);

$par = mysql_query($query_par, $conexao) or die(mysql_error());

                  
		$htmlParcela = '<tr>
                    <td align="center" class="parcela">Qtde. parcela(s): <b>'. mysql_num_rows($par) .'x </b></td>
                  </tr>'; 
                $i=1;
				while($row_par = mysql_fetch_assoc($par)) { 
				  $htmlParcela .= '<tr>
                    <td align="center" class="parcela">'.  $i++ .'ª Parcela Venc.: <strong>'. date('d/m/Y', strtotime( $row_par['venc_parcela'] )). " - R$: ". number_format( $row_par['valor_parcela'] , 2,",",".") .'</strong></td>
                  </tr>';

				}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SaudSeguro - Promissória Nº <?php echo $row_res['titulo_id']; ?></title>
<link href="promissoria_style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
#promissoria{font:12px "Times New Roman", Times, serif; width:632px; height:349px; border:1px solid #333333; margin:0 auto; padding:5px; border-radius:5px 5px 5px;}
#promissoria .box1{width:100px; height:349px; float:left; border:1px solid #333333; border-radius:5px 5px 5px;}
#promissoria .box2{width:522px; height:349px; float:right;}
.borderDashed{border-bottom:1px dotted #333333;}
.fontArial{font:10px Arial, Helvetica, sans-serif;}
.fontArial2{font:8px Arial, Helvetica, sans-serif;}
.fontNegrito{font:20px "Times New Roman", Times, serif; font-weight:bold; padding:0 5px;}
.contorno{border:2px solid #000000; border-radius:5px 5px 5px;}
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
              <td width="66" align="left" class="fontArial">Vencimento:</td>
              <td width="41" align="left" class="borderDashed">&nbsp;</td>
              <td width="15" align="left" class="fontArial">de</td>
              <td width="106" align="left" class="borderDashed">&nbsp;</td>
              <td width="17" align="left" class="fontArial">de</td>
              <td width="55" align="left" class="borderDashed">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td align="center"><table height="30" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="63" align="right" class="fontNegrito">N&ordm;</td>
              <td width="120" align="center" class="contorno">&nbsp;</td>
              <td width="183" align="right" class="fontNegrito">R$</td>
              <td width="123" align="center" class="contorno">&nbsp;</td>
              <td width="29" align="center">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td align="left"><table width="510" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="35" class="fontArial">Ao(s):</td>
              <td width="483" class="borderDashed">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td align="left" class="fontArial">pagarei por esta &uacute;nica via de <strong>NOTA PROMISS&Oacute;RIA</strong></td>
        </tr>
        <tr>
          <td align="left"><table width="510" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="79" height="30" class="fontArial2">OU A SUA ORDEM<br />
              A QUANTIA DE</td>
              <td width="431" height="30" class="contorno">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td align="left"><table width="510" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="412" height="30" class="contorno">&nbsp;</td>
              <td width="98" height="30" align="right" class="fontArial2">EM MOEDA CORRENTE<br />
              DESTE PA&iacute;S</td>
            </tr>
          </table></td>
        </tr>

        <tr>
          <td align="left" valign="bottom"><table width="245" border="0" cellspacing="2" cellpadding="0">
            <tr>
              <td width="66" align="left" class="fontArial">Pav&aacute;vel em: </td>
              <td width="175" class="borderDashed">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td align="left" valign="bottom"><table width="245" border="0" cellspacing="2" cellpadding="0">
            <tr>
              <td width="64" align="left" class="fontArial">Emitente: </td>
              <td width="175" class="borderDashed">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td align="left" valign="bottom"><table width="510" border="0" cellspacing="2" cellpadding="0">
            <tr>
              <td width="68" align="left" class="fontArial">CPF / CNPJ:</td>
              <td width="175" class="borderDashed">&nbsp;</td>
              <td width="64" align="right" class="fontArial">Data:</td>
              <td width="202" class="borderDashed">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td align="left" valign="bottom"><table width="510" border="0" cellspacing="2" cellpadding="0">
            <tr>
              <td width="69" align="left" class="fontArial">Endere&ccedil;o:</td>
              <td width="175" class="borderDashed">&nbsp;</td>
              <td width="64" align="right" class="fontArial">Assinatura:</td>
              <td width="202" class="borderDashed">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
      </table>
	</div>
	
</div><!--promissoria-->
</body>
</html>
<?php
mysql_free_result($res);
?>
