<?php
function sendMail($de,$para,$mensagem,$assunto)
{
	$assunto = "Mensagem do site: bazzanella.com.br!";
	$para = "arturbc@gmail.com";
	$de = "artur@bazzanella.com.br";
	
    require_once('phpmailer/class.phpmailer.php');
    $mail = new PHPMailer(true);

    $mail->IsSMTP();
    try {
      $mail->SMTPAuth   = true;                 
      $mail->Host       = 'smtp.uni5.net';     
      //$mail->SMTPSecure = "tls";                #remova se nao usar gmail
	  //$mail->Port       = 587;                  #remova se nao usar gmail
      $mail->Username   = 'edoppitz@edoppitz.com'; 
      $mail->Password   = '123@ed';
      //$mail->AddAddress($para);
	  $mail->AddAddress($para);
	  $mail->AddReplyTo($de);
      $mail->SetFrom($de);
      $mail->Subject = $assunto;
      $mail->MsgHTML($mensagem);
      $mail->Send();     
      $envio = true;
    } catch (phpmailerException $e) {
      $envio = false;
    } catch (Exception $e) {
      $envio = false;
    }
    return $envio;
}
?>
