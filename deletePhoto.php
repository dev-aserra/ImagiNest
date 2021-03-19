<?php
    session_start();
    include dirname(__FILE__) . "\\" . '\lib\statements.php';
    
    $errors = array();

    // Si no s'ha loginat, retorna a index.php
    if (!isset($_SESSION['username'])) {
        header('Location: index.php');
        exit;
    }
    else {
        if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['photo']) && !empty($_GET['photo']))
        {
            $photoUrl = $_GET['photo'];
            if(eliminarFoto($photoUrl)>0) 
            {
                if(unlink("./".$photoUrl)) $_SESSION['success'] = "S'ha eliminat correctament la imatge!";
                else $_SESSION['deleteImg'] = "No s'ha pogut eliminar la imatge!";
            }
            else $_SESSION['deleteImg'] = "No s'ha pogut eliminar la imatge!";
        }
        header('Location: home.php');
    }
?>