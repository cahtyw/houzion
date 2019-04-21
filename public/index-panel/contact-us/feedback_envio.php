<?php

 include("../../../api/PHPMailer/class.phpmailer.php");
 include("../../../api/PHPMailer/class.smtp.php");
$nome = $_POST['name'];
$email= $_POST['email'];
$telefone = $_POST['phone'];
$mensagem = $_POST['message'];
$sobrenome = $_POST['surname'];
$mail = new PHPMailer(true);

$mail->IsSMTP(); 
$mail->Host = "smtp.gmail.com"; 
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'ssl'; 
$mail->Port=465;
$mail->Username = 'cti73c@gmail.com'; 
$mail->Password = 'bj2fF4@1'; 
// Define o remetente
$mail->SetFrom($email,$nome); 

// Define os destinatário(s)
$mail->AddAddress("cti73c@gmail.com","Houzion Automação Residencial");
$mail->AddAddress("cti73c@gmail.com");

$mail->IsHTML(true); 
$mail->Subject  = "FEEDBACK"; // Assunto da mensagem

$mail->Body =  "<html>
<head>
	<meta charset=\'utf-8'/>
</head>
<body>

    <h3>Nome:</h3> $nome $sobrenome<br>
    <h3>Email:</h3>$email<br>
    <h3>Mensagem:</h3>$mensagem<br>
    <h3>Telefone:</h3>$telefone<br>
    
";
$mail->AltBody = "<html>
<head>
	<meta charset=\'utf-8'/>
</head>
<body>
	A equipe <h2>Houzion</h2> agradece pelo seu feedback
";



/*$mail->Subject  = $assunto; 
$mail->Body = '<html>
<head>
</head>
<body>

<strong>Informações enviadas do feedback</strong><p>
<span><b>Nome: </b>'.$nome.'</span><br>
<span><b>Email: </b>'.$email.'</span><br>
<span><b>Assunto: </b>'.$assunto.'</span><br>
<span><b>Mensagem: </b>'.$mensagem.'</span><br>

</body>
</html>';
$mail->AltBody = "<html><head></head><body>A equipe <strong>Houzion </strong> agradece seu feedback. Sua solicitação será atendida o mais rápido possível.</html></body>";*/
$enviado = $mail->Send();

// Define os anexos (opcional)
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");  // Insere um anexo


$mail->ClearAllRecipients();
$mail->ClearAttachments();
// Exibe uma mensagem de resultado

if ($enviado==true) {
  //echo "Email enviado com sucesso!";
    //exit("Email enviado com sucesso!");
  
  
} 
else 
{
  echo "Não foi possível enviar o e-mail.";
  echo "<b>Informações do erro:</b> " . $mail->ErrorInfo;
}

header("Location: ../../../main.php");
?>