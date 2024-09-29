
<?php
$to = 'contato@medalert.com.br';
$subject = 'Teste de envio de e-mail';
$message = 'Este é um teste de envio de e-mail via PHP.';
$headers = 'From: arturbc@gmail.com' . "\r\n" .
           'Reply-To: arturbc@gmail.com' . "\r\n" .
           'X-Mailer: PHP/' . phpversion();

if(mail($to, $subject, $message, $headers)) {
    echo 'E-mail enviado com sucesso!';
} else {
    echo 'Falha no envio de e-mail.';
}
?>
