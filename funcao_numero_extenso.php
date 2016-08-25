<?php
function extenso($valor = 0, $maiusculas = false) { 

	$singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão"); 
	$plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões", 
	"quatrilhões"); 

	$c = array("", "cem", "duzentos", "trezentos", "quatrocentos", 
	"quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos"); 
	$d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta", 
	"sessenta", "setenta", "oitenta", "noventa"); 
	$d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze", 
	"dezesseis", "dezesete", "dezoito", "dezenove"); 
	$u = array("", "um", "dois", "três", "quatro", "cinco", "seis", 
	"sete", "oito", "nove"); 

	$z = 0; 
	$rt = "";

	$valor = number_format($valor, 2, ".", "."); 
	$inteiro = explode(".", $valor); 
	for($i=0;$i<count($inteiro);$i++) 
	for($ii=strlen($inteiro[$i]);$ii<3;$ii++) 
	$inteiro[$i] = "0".$inteiro[$i]; 

	$fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2); 
	for ($i=0;$i<count($inteiro);$i++) { 
		$valor = $inteiro[$i]; 
		$rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]]; 
		$rd = ($valor[1] < 2) ? "" : $d[$valor[1]]; 
		$ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : ""; 

		$r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd && 
		$ru) ? " e " : "").$ru; 
		$t = count($inteiro)-1-$i; 
		$r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : ""; 
		if ($valor == "000")$z++; elseif ($z > 0) $z--; 
		if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t]; 
		if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) && 
		($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r; 
	} 

	if(!$maiusculas){ 
		return($rt ? $rt : "zero"); 
	} else { 

		if ($rt) $rt=str_replace(" E "," e ",ucwords($rt));
		return (($rt) ? ($rt) : "Zero"); 
	} 

} 

function ordinal($data){
	
	$data = explode('-',$data);
	if($data[2]<=10){$dia = (int) $data[2];} else {$dia = $data[2];}
	if($data[1]<=10){$mes = (int) $data[1];} else {$mes = $data[1];}	
	$ano = $data[0];
	
	$ordinal = array(1 => "primeiro", 2 => "segundo", 3 => "terceiro", 4 => "quarto", 5 => "quinto", 6 => "sexto", 7 => "sétimo", 8 => "oitavo", 9 => "nono");
	$ordinal10 = array(1 => "décimo", 2 => "vigésimo", 3 => "trigésimo");
	
	$meses = array (1 => "janeiro", 2 => "fevereiro", 3 => "março", 4 => "abril", 5 => "maio", 6 => "junho", 7 => "julho", 8 => "agosto", 9 => "setembro", 10 => "outubro", 11 => "novembro", 12 => "dezembro");
	
	$anos = array(2010 => "dez", 2011 => "onze", 2012 => "doze", 2013 => "treze", 2014 => "quatorze", 2015 => "quinze", 2016 => "dezesseis", 2017 => "dezesete", 2018 => "dezoito", 2019 => "dezenove", 2020 => "vinte", 2021 => "vinte e um", 2022 => "vinte e dois", 2023 => "vinte e três", 2024 => "vinte e quatro", 2025 => "vinte e cinco", 2026 => "vinte e seis", 2027 => "vinte e sete", 2028 => "vinte e oito", 2029 => "vinte e nove", 2030 => "trinta");	
	
	$u = array("", "um", "dois", "três", "quatro", "cinco", "seis", 
	"sete", "oito", "nove"); 
	
	$d = strlen($dia);	
	if($d > 1 ){
		$ndata = @$ordinal10[$dia[0]];
		$ndata .= " ". @$ordinal[$dia[1]];
	} else {
		$ndata = @$ordinal[$dia];
	}
	
	$ndata = ucwords($ndata);

	$nomemes = ucwords( $meses[$mes] );
	$nomeano = ucwords( $anos[$ano] );
	$data_extensa = "$ndata dia do mês de $nomemes do ano de Dois Mil e $nomeano";
	
	return $data_extensa;
}

//echo ordinal('2012-09-15');

?>