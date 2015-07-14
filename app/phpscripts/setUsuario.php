<?php 
require_once('../config.php');

$pass_login = $_POST['pass_login'];
$pass_senha = $_POST['pass_senha']; 
$pass_nivel = $_POST['pass_nivel'];

$erros=0;
$msg="";

if (strlen( $pass_login )< 6) {
	$erros++;
	$msg.="<br /><b>Nome:</b> Por favor, digite seu nome";
}

if (strlen( $pass_senha )< 6 ) {
	$erros++;
	$msg.="<br /><b>Cidade:</b> Por favor, digite o nome de sua cidade";
}

if (empty( $pass_nivel )) {
	$erros++;
	$msg.="<br /><b>Estado:</b> Por favor, selecione o estado";
}


if($db->fetchOne(sprintf("SELECT count(*) FROM `acesse_ip_bloqueio` WHERE `number_ip` = '%s'", $ipUser )) > 0 ){
	$erros++;
	$msg.="<br /><b>Error:</b> Envio de e-mail Negado pelo Administrador!";	
}

if ($erros>0){
	
	echo sprintf("<b style='color:#c30;'>Os dados não foram cadastrados</b><br />Por favor confira o(s) seguinte(s) campo(s):%s", $msg );
 
} else {
	
	sleep(1);
		
	
	$insertSQL = sprintf("INSERT INTO `password` (`pass_login` ,`pass_senha` ,`pass_nivel`)
VALUES ('%s', '%s', '%s')",	$pass_login, $pass_senha, $pass_nivel);

	$Result1 = mysqli_query($conexao,$insertSQL) or die(mysqli_error());

	echo "<script type=\"text/javascript\">
				alert(\"Cadastro efetuado com sucesso!\");
			</script>";
}
?>