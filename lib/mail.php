<?php
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php';
function enviarMailVerificacio($email, $username, $activationcode)
{
    $url = "http://localhost/practiquesphp/Practica5/Web/mailCheckAccount.php?code=" . $activationcode . "&mail=" . $email;
    include dirname(__FILE__) . '\..\templates\verificacioMail.phtml';

    $mail = new PHPMailer();
    $mail->IsSMTP();

    //Configuració del servidor de Correu
    //Modificar a 0 per eliminar msg error
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;

    //Credencials del compte GMAIL
    $mail->Username = '';
    $mail->Password = '';

    //Dades del correu electrònic
    $mail->SetFrom('noreply@imaginest.com', 'ImagiNest');
    $mail->AddAddress($email);

    $mail->Subject = 'Confirma el teu registre';
    $mail->AddEmbeddedImage(dirname(__FILE__) . '/../img/email.jpg', 'logo_mail');
    $mail->MsgHTML($body);

    //Enviament
    $mail->Send();
}

function enviarMailResetPassword($email, $username, $resetPassCode, $tipus)
{
  if ($tipus) $url = "http://localhost/practiquesphp/Practica5/Web/resetPassword.php?code=" . $resetPassCode . "&mail=" . $email;
  else $url = "http://localhost/practiquesphp/Practica5/Web/resetPassword.php?code=" . $resetPassCode . "&user=" . $username;
    
    include dirname(__FILE__) . '\..\templates\resetPassword.phtml';

    $mail = new PHPMailer();
    $mail->IsSMTP();

    //Configuració del servidor de Correu
    //Modificar a 0 per eliminar msg error
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;

    //Credencials del compte GMAIL
    $mail->Username = '';
    $mail->Password = '';

    //Dades del correu electrònic
    $mail->SetFrom('noreply@imaginest.com', 'ImagiNest');
    $mail->AddAddress($email);

    $mail->Subject = 'Restabliment de contrasenya';
    $mail->AddEmbeddedImage(dirname(__FILE__) . '/../img/email.jpg', 'logo_mail');
    $mail->MsgHTML($body);

    //Enviament
    $mail->Send();
}

function enviarMailContrasenyaCanviada($email)
{
  $url = "http://localhost/practiquesphp/Practica5/Web/index.php";
    
    include dirname(__FILE__) . '\..\templates\contrasenyaCanviada.phtml';

    $mail = new PHPMailer();
    $mail->IsSMTP();

    //Configuració del servidor de Correu
    //Modificar a 0 per eliminar msg error
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;

    //Credencials del compte GMAIL
    $mail->Username = '';
    $mail->Password = '';

    //Dades del correu electrònic
    $mail->SetFrom('noreply@imaginest.com', 'ImagiNest');
    $mail->AddAddress($email);

    $mail->Subject = 'Contrasenya Modificada';
    $mail->AddEmbeddedImage(dirname(__FILE__) . '/../img/email.jpg', 'logo_mail');
    $mail->MsgHTML($body);

    //Enviament
    $mail->Send();
}