<?php
session_start();
include dirname(__FILE__) . "\\" . 'lib\statements.php';
include dirname(__FILE__) . "\\" . 'lib\mail.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if(count($_GET) == 2 AND isset($_GET['code']) && !empty($_GET['code']) AND ((isset($_GET['mail']) && !empty($_GET['mail'])) || (isset($_GET['user']) && !empty($_GET['user'])))){
        // Verifiquem les dades
        $_SESSION['rpswdHash'] = $hash = filter_input(INPUT_GET, 'code'); // Assignem variable hash
        // Assignem variable email o user segons convingui
        if(isset($_GET['mail'])) $_SESSION['rpswdUserMail'] = $usernameMail = filter_input(INPUT_GET, 'mail');
        else $_SESSION['rpswdUserMail'] = $usernameMail = filter_input(INPUT_GET, 'user');

        // Si no existeix el codi i user/email i el temps ha excedit, redirigeix a index.php
        if(!(comprovaCodiResetPswd($usernameMail, $hash) > 0 AND !comprovaTempsResetPswd($usernameMail, $hash))){
            // URL no vàlid o temps excedit
            $_SESSION['pswdCheck'] = "L'URL no és vàlid o s'ha excedit el temps límit per restablir la contrasenya.";
            unset($_SESSION['rpswdHash'], $_SESSION['rpswdUserMail']);
            header('Location: index.php');
            exit;
        }
    }else{
        // Accés no vàlid a través de GET
        $_SESSION['pswdCheck'] = "L'accés no és vàlid. Utilitzeu l'enllaç que s'ha enviat al vostre correu electrònic";
        unset($_SESSION['rpswdHash'], $_SESSION['rpswdUserMail']);
        header('Location: index.php');
        exit;
    }
}elseif ($_SERVER["REQUEST_METHOD"] == "POST"){
    // Si entra per POST, comprova si s'ha enviat amb el nom resetPswd
    if (isset($_POST['resetPswd'])){
        $hash = $_SESSION['rpswdHash'];
        $usernameMail = $_SESSION['rpswdUserMail'];
        // Comprovem si existeix el codi i user/email i el temps no ha excedit
        if (comprovaCodiResetPswd($usernameMail, $hash) > 0 AND !comprovaTempsResetPswd($usernameMail, $hash)){
            // Agafem els valors del POST
            $password = filter_input(INPUT_POST, 'inputPswdReset');
            $verifypass = filter_input(INPUT_POST, 'inputPswdResetVerify');

            // Validar les contrasenyes
            if (preg_match("/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{6,20}$/", $password) AND $password == $verifypass){
                // Comprovem si la contrasenya no és la mateixa
                if (!comprovaContrasenya($usernameMail, $password)){
                    // Contrasenya diferent a la actual. Actualitzem a la nova
                    $password_hash = password_hash($password, PASSWORD_DEFAULT);
                    //Actualitzem la contrasenya desada a la base de dades
                    actualitzarContrasenya($usernameMail, $password_hash);
                    // Enviem un correu informant del canvi de contrasenya
                    enviarMailContrasenyaCanviada(getEmail($usernameMail));
                    // Esborrem els valors assignats pel restabliment de la contrasenya
                    netejarResetPassword($usernameMail);
                    $_SESSION['success'] = "S'ha restablert la contrasenya correctament.";
                    unset($_SESSION['rpswdHash'], $_SESSION['rpswdUserMail']);
                    header('Location: index.php');
                    exit;
                }else{
                    // Contrasenya igual a la actual. No actualitzem
                    // Esborrem els valors assignats pel restabliment de la contrasenya
                    netejarResetPassword($usernameMail);
                    $_SESSION['pswdCheck'] = "S'ha introduït la contrasenya actual. S'ha cancel·lat la operació.";
                    unset($_SESSION['rpswdHash'], $_SESSION['rpswdUserMail']);
                    header('Location: index.php');
                    exit;
                }
            }else{
                // La contrasenya no compleix la seguretat de contrasenya establerta
                // Esborrem els valors assignats pel restabliment de la contrasenya
                netejarResetPassword($usernameMail);
                $_SESSION['pswdCheck'] = "Les dades subministrades són incorrectes. S'ha cancel·lat la operació.";
                unset($_SESSION['rpswdHash'], $_SESSION['rpswdUserMail']);
                header('Location: index.php');
                exit;
            }
        }else{
            // El codi i usuari/email és incorrecte o el temps de restabliment ha expirat
            // URL no vàlid o temps excedit
            $_SESSION['pswdCheck'] = "L'URL no és vàlid o s'ha excedit el temps límit per restablir la contrasenya.";
            unset($_SESSION['rpswdHash'], $_SESSION['rpswdUserMail']);
            header('Location: index.php');
            exit;
        }
    }
}else {
    // Accés no vàlid
    $_SESSION['pswdCheck'] = "L'accés no és vàlid. Utilitzeu l'enllaç que s'ha enviat al vostre correu electrònic";
    unset($_SESSION['rpswdHash'], $_SESSION['rpswdUserMail']);
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Restablir Contrasenya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Spartan:wght@300;600&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="./css/styles.css" type="text/css" rel="stylesheet">
    <link rel="shortcut icon" href="./img/favicon.svg" type="image/x-icon"/>
</head>
    <body class="bg-dark">
        <section>
            <div class="row g-0">
                <div class="col-lg-3"></div>
                <div class="col-lg-6 d-flex flex-column align-items-end min-vh-100">
                    <div class="px-lg-5 pt-lg-4 pb-lg-3 p-4 w-50 mb-auto">
                        <img src="./img/logo.svg" class="img-fluid">
                    </div>
                    <div class="px-lg-5 py-lg-4 p-4 w-100 mb-auto">
                        <h1 class="fw-bold mb-4">Restablir la contrasenya</h1>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="mb-5" autocomplete="off">
                            <div class="mb-4">
                                <label for="inputPswdReset" class="form-label fw-bold">Nova Contrasenya</label>
                                <input type="password" name="inputPswdReset" class="form-control bg-dark-x border-0" id="inputPswdReset" placeholder="Introdueix la nova contrasenya" autocomplete="off">
                            </div>
                            <div class="mb-4">
                                <label for="inputPswdResetVerify" class="form-label fw-bold">Comprovar Contrasenya</label>
                                <input type="password" name="inputPswdResetVerify" id="inputPswdResetVerify" class="form-control bg-dark-x border-0 mb-2" placeholder="Introdueix novament la contrasenya">
                            </div>
                            <button type="submit" class="btn btn-primary w-100 fw-bold mb-4" name="resetPswd">Enviar</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-3"></div>
            </div>
        </section>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>   
    </body>
</html>