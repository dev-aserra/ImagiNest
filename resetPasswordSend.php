<?php
session_start();
include dirname(__FILE__) . "\\" . '\lib\mail.php';
include dirname(__FILE__) . "\\" . '\lib\statements.php';

// Comprova si s'accedeix per POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['pwdreset'])) {
        // Rebem el valor de l'input del form
        $usernameMail = filter_input(INPUT_POST, 'usermailpwd');

        // Comprovem si existeix un usuari/email
        if (existeixUsernameMail($usernameMail) > 0) {
            // Comprovem si ens ha introduït un nom d'usuari o un correu
            if(filter_var($usernameMail, FILTER_VALIDATE_EMAIL)) {
                // Correu electrònic
                $username = getUsername($usernameMail);
                $email = $usernameMail;
                $tipus = true;
            } else {
                // Nom d'usuari
                $email = getEmail($usernameMail);
                $username = $usernameMail;
                $tipus = false;
            }

            $resetPassCode = hash('sha256', rand().time());
            // Assigna els valors per poder restablir la contrasenya
            actualitzarResetPassword($email, $resetPassCode);
            // Enviem un correu electrònic pel restabliment de la contrasenya
            enviarMailResetPassword($email, $username, $resetPassCode, $tipus);
            $_SESSION['success'] = "S'ha rebut la petició correctament. Verifiqueu el vostre correu electrònic i seguiu les instruccions per restablir la contrasenya.";
        } else $_SESSION['pswdCheck']  = "L'usuari o adreça de correu electrònic introduït no és vàlid.";
    } else $_SESSION['pswdCheck']  = "Error a l'enviar la petició.";
} else $_SESSION['pswdCheck']  = "L'accés no és vàlid.";

header('Location: index.php');
exit;