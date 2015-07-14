<?php
session_start();			
if(file_exists("init.php")){
	require_once "init.php";
} else {
	die("Arquivo de init não encontrado");
}

function limpa($string){
	$var = trim($string);
	$var = addslashes($var);	
	return $var;
}

if(getenv("REQUEST_METHOD") == "POST"){
	$login  = isset($_POST["login"]) ? limpa($_POST["login"]) : "";
	$senha = isset($_POST["senha"]) ? limpa($_POST["senha"]) : "";
	
	$sql = sprintf("select count(*) from password where pass_login = '%s' and pass_senha = '%s'", $login, $senha);
	mysql_connect(SERVIDOR, USUARIO, SENHA) or die(mysql_error());
	mysql_select_db(BANCO) or die(mysql_error());
	
	$re = mysql_query($sql) or die(mysql_error());
	if(mysql_result($re, 0)){
		$re = mysql_query(sprintf("select * from password where pass_login = '%s' and pass_senha = '%s'", $login, $senha )) or die(mysql_error());		
		$resultado = mysql_fetch_array($re);
		if($resultado["pass_nivel"] > 0){
			
			$dados = array();
			
			$dados["login"]        = $login;
			$dados["senha"]        = $senha;
			$dados["pass_nivel"]   = $resultado["pass_nivel"];
			$dados["pass_nome"]    = $resultado["pass_nome"];
					
			$_SESSION["dados"] = $dados;
						
			if(isset($_POST["cookie"])){			
				setcookie("dados", serialize($dados), time()+60*60*24*365);			
			}
			header("Location: ../default.php");
		} else {
			header("Location: ../login.php?pag=login&erro=2");
		}		
	} else {
		header("Location: ../login.php?pag=login&erro=3");
	}
}
?>