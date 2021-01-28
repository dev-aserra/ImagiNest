<?php
session_start();

// Inicialització de variables
$username = $email = $firstname = $lastname = $password = $verifypass = $usernameMail = $password_hash = "";
$errors = array();

// Connexió base de dades
include dirname(__FILE__) . "\\" . '..\config\db.php';
include dirname(__FILE__) . "\\" . 'statements.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // REGISTRE
    if (isset($_POST['register'])) {
        // Rebem els valors dels inputs del form
        $username = filter_input(INPUT_POST, 'username');
        $email = filter_input(INPUT_POST, 'email');
        $firstname = filter_input(INPUT_POST, 'firstname');
        $lastname = filter_input(INPUT_POST, 'lastname');
        $password = filter_input(INPUT_POST, 'pass');
        $verifypass = filter_input(INPUT_POST, 'verifypass');

        // Comprovacions de les dades introduides

        // Comprovar si existeix el correu
        if (existeixMail($email) > 0) {
            array_push($errors, "Usuari amb aquest correu ja existeix");
        }
        // Comprovar si existeix el nom d'usuari
        if (existeixUsername($username) > 0) {
            array_push($errors, "El nom d'usuari introduit ja existeix");
        }
        // Validar el nom d'usuari
        if (!preg_match("/^[a-zA-Z0-9]{6,10}$/", $username)) {
            array_push($errors, "Nom d'usuari: Només permet lletres, números i entre 6 i 10 caràcters");
        }
        // Validar el correu electrònic
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($errors, "Correu electrònic: El format és invàlid");
        }
        // Validar el nom
        if (!preg_match("/^[a-zA-Z ]*$/", $firstname)) {
            array_push($errors, "Nom: Només lletres i espais permesos");
        }
        // Validar els cognoms
        if (!preg_match("/^[a-zA-Z ]*$/", $lastname)) {
            array_push($errors, "Cognoms: Només lletres i espais permesos");
        }
        // Validar la contrasenya
        if (!preg_match("/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{6,20}$/", $password)) {
            array_push($errors, "La contrasenya hauria de tenir entre 6 i 20 caràcters i contenir almenys un caràcter especial, una minúscula, una majúscula i un dígit");
        }
        // Comprovar si les contrasenyes coincideixen
        if ($password != $verifypass) {
            array_push($errors, "Les contrasenyes no coincideixen");
        }

        // Finalment registrar l'usuari si no hi ha hagut errors
        if (count($errors) == 0) {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            insereixUsuari($email, $username, $password_hash, $firstname, $lastname);
            $_SESSION['success'] = "S'ha registrat l'usuari correctament";
            header('Location: index.php');
            exit;
        }
    }

    // LOGIN
    if (isset($_POST['login'])) {
        // Rebem els valors dels inputs del form
        $usernameMail = filter_input(INPUT_POST, 'userMail');
        $password = filter_input(INPUT_POST, 'pass');

        // Comprovem si existeix un usuari/email
        if (existeixUsernameMail($usernameMail) > 0) {
            // Comprovem si la contrasenya és correcte
            if (comprovaContrasenya($usernameMail, $password)) {
                // Llavors actualitzem el camp lastSignIn, guardem valors a la sessió i redirigim al home.php
                actualitzarIniciSessio($usernameMail);
                $_SESSION['username'] = $usernameMail;
                $_SESSION['success'] = "Has iniciat sessió correctament";
                header('Location: home.php');
                exit;
            }
        }
        // Si surt per alguna de les condicions, indica un error amb les dades introduïdes
        array_push($errors, "No s'ha pogut iniciar sessió amb les dades introduïdes");
    }
} else {
    // Si l'usuari ha fet login, redirigeix al home.php
    if (isset($_SESSION['username']) && (strrpos($_SERVER["REQUEST_URI"], "index.php"))) {
        header("Location: home.php");
        exit;
    }
}
