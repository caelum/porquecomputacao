<?php 		
	/* Envio de e-mails do form de contato da Caelum */
	
	// e-mails e configurações das unidades
	$email_to = "contato.sp@caelum.com.br";
	
    // todos os campos possíveis
	$nome       = $_POST["nome"];
	$assunto    = $_POST["assunto"];
	$email      = $_POST["email"];
	$mensagem   = $_POST['mensagem'];
	$escondido  = $_POST["escondido"];
	
	$erro = false;
	// validação dos campos
	// TODO validar inputs maliciosos?
	if ( !empty($escondido) 
	     || empty($nome) || empty($email) || empty($mensagem) 
		 || !isValidEmail($email)
		) {
		$erro = true;
	} else {		
		$body   = "Nome: $nome \r\n"
			   	 ."Email: $email \r\n"
			   	 ."Email sobre: $assunto \r\n\r\n"
			   	 ."Mensagem: \r\n$mensagem\r\n";
		
		$headers = "From: $nome <$email>\r\n" .
		           "Reply-To: $nome <$email>\r\n";

		if (!mail($email_to, "[porquecomputacao] " . time(), $body, $headers)) {
			$erro = true;
		}
	}
	
	if ($erro) {
	    header("HTTP/1.1 400 Bad Request")
	} else {
	    header("HTTP/1.1 200 OK")
	}
	/*** functions ***/
	function isValidEmail($email){
		return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
	}
?>
