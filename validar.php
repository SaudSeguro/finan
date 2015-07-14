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
	
	$re = mysqli_query($conexao,$sql) or die(mysqli_error());
	if(mysqli_num_rows($re)>0){
		$re = mysqli_query($conexao,sprintf("select * from password where pass_login = '%s' and pass_senha = '%s'", $login, $senha )) or die(mysqli_error());		
		$resultado = mysqli_fetch_array($re);
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