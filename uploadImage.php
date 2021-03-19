<?php
    session_start();
    include dirname(__FILE__) . "\\" . '\lib\statements.php';

    $errors = array();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if($_FILES['imatge']['size'] != 0 && !empty($_POST['descripcio'])) {

            $mida = $_FILES['imatge']['size'];
            if($mida > 10 * 1024 * 1024){
                $_SESSION["uploadImg"] = "Fitxer massa gran de 10mb";
            }
            else {
                $descripcio =  filter_input(INPUT_POST, 'descripcio');
                $expresioRegular = '/#\w+/';
                preg_match_all($expresioRegular, $descripcio, $matches);

                $imgNom = $_FILES['imatge']['name'];
                $ext = pathinfo($imgNom, PATHINFO_EXTENSION);
                $imgNomRand = $imgNom . rand().time();

                $tipus = $_FILES['imatge']['type'];
                $allowed = array("image/jpeg", "image/png");
                if(in_array($tipus, $allowed)) {
                    $imgNomFinal = hash('sha256',$imgNomRand);
                    $imgNomFinal = $imgNomFinal .".". $ext;

                    $res = move_uploaded_file($_FILES['imatge']['tmp_name'], 'data/' . $imgNomFinal);

                    $path = "data/" . $imgNomFinal;

                    insereixFotografia($imgNomFinal,$descripcio,$path,getUserId($_SESSION['username']));
                    comprovarHashtags($imgNomFinal,$matches);         
                }
                else
                {
                    $_SESSION["uploadImg"] =  "Només es permet jpg i png!";
                }
            }
        }
        else $_SESSION["uploadImg"] =  "Comprova les dades inserides!";
    }
    header('Location: home.php');



