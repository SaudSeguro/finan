<?php
define('BASE_CONTROLLERS', realpath(dirname(dirname(dirname(__FILE__)))).'/app/controllers/');
if ( file_exists(BASE_CONTROLLERS .'init.php') )
{
	include_once(BASE_CONTROLLERS .'init.php');
}

$nome = filter( getPost("nome") );
$email = FILTER_ERROR_EMAIL( getPost("email") );
$cidade = filter( getPost("cidade") );
$uf = filter( getPost("uf") );
$assunto = filter( getPost("assunto") );
$comentario = filter( getPost("comentario") );
$id_empresa = filter( getPost("id_empresa") );
$subdomain = filter( getPost("subdomain") );
$responsavel = filter( getPost("responsavel") );

$erros=0;
$msg="";

if (strlen( $nome )< 2) {
	$erros++;
	$msg.="<br /><b>Nome:</b> Por favor, digite seu nome";
}

if (!ereg("^[a-z0-9_-]+(\.[a-z0-9_-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)+$", $email )) {
	$erros++;
	$msg.="<br /><b>Email:</b> Confira seu endereço de e-mail";
}

if ($email == false)) {
	$erros++;
	$msg.="<br /><b>Email:</b> Confira seu endereço de e-mail";
}

if (strlen( $cidade )< 2) {
	$erros++;
	$msg.="<br /><b>Cidade:</b> Por favor, digite o nome de sua cidade";
}

if (strlen( $uf )< 2) {
	$erros++;
	$msg.="<br /><b>Estado:</b> Por favor, selecione o estado";
}

if (strlen( $assunto )< 2) {
	$erros++;
	$msg.="<br /><b>Assunto:</b> Por favor, digite o assunto da mensagem";
}

if (strlen( $comentario ) < 8) {
	$erros++;
	$msg.="<br /><b>Descrição:</b> Digite seu descrição";
}

if ($erros>0){
	
	echo sprintf("<b style='color:#c30;'>Sua mensagem não foi enviada</b><br />Por favor confira o(s) seguinte(s) campo(s):%s", $msg );
 
} else {
	/*
	if($db->fetchOne(sprintf("SELECT count(*) FROM `acesse_ip_bloqueio` WHERE `number_ip` = '%s'", $ipUser )) > 0 ){
		echo "<script type=\"text/javascript\">
			alert(\"Envio de e-mail Negado pelo Administrador!\");
		  </script>";
	} else {
		
		// Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer
		if(file_exists(PHPMAILER ."class.phpmailer.php")){
			require_once(PHPMAILER ."class.phpmailer.php");
		}else{
			die('Erro: class.phpmailer não encontrado!');
		}

		// Inicia a classe PHPMailer
		$mail = new PHPMailer();

		// Define os dados do servidor e tipo de conexão
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		if(file_exists(PHPMAILER ."conexao.phpmailer.php")){
			require_once(PHPMAILER ."conexao.phpmailer.php");
		}else{
			die('Erro: conexao.phpmailer não encontrado!');
		}
			
		// Define o remetente
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$mail->From = "no-reply@acesseloja.com.br"; // Seu e-mail
		$mail->FromName = $email; // Seu nome
		// Define os destinatário(s)
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		if($obj_sub->email !== $obj_sub->email_cobranca){
			$arrEmail = array($obj_sub->email,$obj_sub->email_cobranca);
		} else {
			$arrEmail = array($obj_sub->email);
		}

		foreach($arrEmail AS $_newMail) {
				
			$mail->AddAddress(trim("wsilvaduarte@hotmail.com"));
			//$mail->AddAddress(trim($_newMail));
			$mail->AddReplyTo(trim($email)); //Responder para
			$mail->AddBCC('wsilvaduarte@gmail.com'); // Cópia Oculta
			// Define os dados técnicos da Mensagem
			// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
			$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)

			// Define a mensagem (Texto e Assunto)   
			// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			$mail->Subject = sprintf("AcesseLoja - Contato no site - %s.acesseloja.com.br", $subdomain); // Assunto da mensagem
			$html_mail = sprintf("<html>
			<body>
			<font color='#003399' size='4' face='Arial, Helvetica, sans-serif'>Contato no site - %s.acesseloja.com.br</font>
			<br />
			<br />
			<b>%s</b><br />
			Este e-mail foi enviado através de formulário do site, para entrar em contato com o cliente, use os dados abaixo:<br /><br />
			----------------------------------------------------------
			<br />
			Nome: <b>%s</b><br /><br />
			Email: <b>%s</b><br /><br />
			Cidade: <b>%s</b><br /><br />
			Estado: <b>%s</b><br /><br />
			Telefone: <b>%s</b><br /><br />
			Assunto: <b>%s</b><br /><br /> 			
			Descrição: <b>%s</b>
			<br />
			<br />		
			----------------------------------------------------------
			<br />
			<br />
			<font color='#666666' size='1' face='verdana, Arial, Helvetica, sans-serif'>									
			Atenciosamente,
			<br />
			Equipe AcesseLoja.com -  Shopping Virtual<br />
			IP de origem: %s<br />
			Emitido: %s
			</font>
			</body>
			</html>", $subdomain, $responsavel, $nome, $email, $cidade, $uf, $telefone, $assunto, $descricao, date("d/m/Y H:i:s"), $ipUser );
					
			$mail->Body = $html_mail;		
			$mail->AltBody = $html_mail;

			// Envia o e-mail
			$enviado = $mail->Send();

			// Limpa os destinatários e os anexos
			$mail->ClearAllRecipients();
			$mail->ClearAttachments();
		}
			
			// Exibe uma mensagem de resultado
		if (isset($enviado)) {
				
			//instanciando o Objeto de Cadastro
			$cad = new manipulateData();
			$cad->setTable("`acesse_contato_lojas`");
			$cad->setFields("`id_cliente`, `nome`, `email`, `cidade`, `uf`, `telefone`, `assunto`, `descricao`,`ip`");
			$cad->setDados(sprintf("'%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'", $id_empresa, $nome, $email, $cidade, $uf, $telefone, $assunto,  nl2br( $descricao ), $ipUser));
			$cad->insert();						
				
			//instanciando o Objeto de Cadastro
			$cadNews = new ManipulateData();
			$cadNews->setTable("`acesse_newslatter`");
			$cadNews->setFields("`nome`, `email`");
				
			//verificando se existe o email esta cadastrado
			if($cadNews->getDadosDuplicados("$email") == false){
				$cadNews->setDados("'$nome','$email'");
				$cadNews->insert();
			}			
				
			sleep(2);
			$html = "<p>Olá <b>$nome</b>,<br />\n";
			$html.= "Grato pelo seu e-mail, reponderemos em breve!</p>\n";
			$html.= "<p>Você informou que seu email é: <b>$email</b></p>\n";
			$html.= "<p>O assunto enviado foi:</p>";
			$html.= "<p>&quot;$assunto&quot;</p>\n";
			echo $html;
				
				
		} else {
			echo "<script language=javascript>window.alert('Não foi possível efetuar a operação!')</script>";
				//$erroMail =  "<b>Informações do erro:</b> <br />" . $mail->ErrorInfo;
		}
		
	}
	*/
}
?>