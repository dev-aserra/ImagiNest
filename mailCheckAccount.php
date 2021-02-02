<?php
session_start();
include dirname(__FILE__) . "\\" . 'lib\statements.php';

if(isset($_GET['mail']) && !empty($_GET['mail']) AND isset($_GET['code']) && !empty($_GET['code'])){
    // Verifiquem les dades
    $hash = filter_input(INPUT_GET, 'code'); // Assignem variable hash
    $email = filter_input(INPUT_GET, 'mail'); // Assignem variable email
                  
    if(comprovaCodiActivacio($email, $hash) > 0){
        // Si ens coincideix, activem el compte.
        activarCompte($email, $hash);
        $_SESSION['success'] = "El vostre compte s'ha activat, ara podeu iniciar la sessió.";
        
    }else{
        // No coincideix -> URL no vàlid o el compte ja està activat.
        $_SESSION['mailCheck'] = "L'URL no és vàlid o bé ja heu activat el vostre compte";
    }
                  
}else{
    // Accés no vàlid
    $_SESSION['mailCheck'] = "L'accés no és vàlid. Utilitzeu l'enllaç que s'ha enviat al vostre correu electrònic";
}

header('Location: index.php');
exit;