<?php
include dirname(__FILE__) . '\..\config\db.php';

function existeixMail($email)
{
    global $db;
    $sql = "SELECT * FROM users WHERE mail = ?";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $email, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->rowCount();
}

function existeixUsername($username)
{
    global $db;
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $username, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->rowCount();
}

function insereixUsuari($email, $username, $password_hash, $firstname, $lastname, $activationcode)
{
    global $db;
    $sql = "INSERT INTO users (mail, username, passHash, userFirstName, userLastName, activationCode) VALUES (? ,? ,? ,? ,? ,?)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $email, PDO::PARAM_STR);
    $stmt->bindParam(2, $username, PDO::PARAM_STR);
    $stmt->bindParam(3, $password_hash, PDO::PARAM_STR);
    $stmt->bindParam(4, $firstname, PDO::PARAM_STR);
    $stmt->bindParam(5, $lastname, PDO::PARAM_STR);
    $stmt->bindParam(6, $activationcode, PDO::PARAM_STR);
    return $stmt->execute();
}

function existeixUsernameMail($usernameMail)
{
    global $db;
    $sql = "SELECT * FROM users WHERE (username = ? OR mail = ?) AND (active = 1)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $usernameMail, PDO::PARAM_STR);
    $stmt->bindParam(2, $usernameMail, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->rowCount();
}

function comprovaContrasenya($usernameMail, $password)
{
    global $db;
    $sql = "SELECT passHash FROM users WHERE (username = ? OR mail = ?)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $usernameMail, PDO::PARAM_STR);
    $stmt->bindParam(2, $usernameMail, PDO::PARAM_STR);
    $stmt->execute();
    $pass = $stmt->fetchColumn();

    return password_verify($password, $pass);
}

function actualitzarIniciSessio($usernameMail)
{
    global $db;
    $sql = "UPDATE users SET lastSignIn = CURRENT_TIMESTAMP WHERE (username = ? OR mail = ?)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $usernameMail, PDO::PARAM_STR);
    $stmt->bindParam(2, $usernameMail, PDO::PARAM_STR);
    $stmt->execute();
}

function getUsername($usernameMail)
{
    global $db;
    $sql = "SELECT username FROM users WHERE mail = ?";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $usernameMail, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchColumn();
}

function getUserId($username)
{
    global $db;
    $sql = "SELECT iduser FROM users WHERE username = ?";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $username, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchColumn();
}

function comprovaCodiActivacio($email, $hash)
{
    global $db;
    $sql = "SELECT * FROM users WHERE mail = ? AND activationCode = ? AND active = 0";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $email, PDO::PARAM_STR);
    $stmt->bindParam(2, $hash, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->rowCount();
}

function activarCompte($email, $hash)
{
    global $db;
    $sql = "UPDATE users SET active = 1, activationDate = CURRENT_TIMESTAMP, activationCode = NULL WHERE mail = ? AND activationCode = ? AND active = 0";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $email, PDO::PARAM_STR);
    $stmt->bindParam(2, $hash, PDO::PARAM_STR);
    $stmt->execute();
}

function getEmail($usernameMail)
{
    global $db;
    $sql = "SELECT mail FROM users WHERE username = ?";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $usernameMail, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchColumn();
}

function actualitzarResetPassword($email, $resetPassCode)
{
    global $db;
    $sql = "UPDATE users SET resetPass = 1, resetPassExpiry = DATE_ADD(CURRENT_TIMESTAMP, INTERVAL 30 MINUTE), resetPassCode = ? WHERE mail = ? AND active = 1";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $resetPassCode, PDO::PARAM_STR);
    $stmt->bindParam(2, $email, PDO::PARAM_STR);
    $stmt->execute();
}

function comprovaCodiResetPswd($usernameMail, $hash)
{
    global $db;
    $sql = "SELECT * FROM users WHERE (username = ? OR mail = ?) AND resetPassCode = ? AND resetPass = 1 AND active = 1";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $usernameMail, PDO::PARAM_STR);
    $stmt->bindParam(2, $usernameMail, PDO::PARAM_STR);
    $stmt->bindParam(3, $hash, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->rowCount();
}

function comprovaTempsResetPswd($usernameMail, $hash)
{
    global $db;
    $sql = "SELECT resetPassExpiry < CURRENT_TIMESTAMP FROM users WHERE (username = ? OR mail = ?) AND resetPassCode = ? AND resetPass = 1 AND active = 1";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $usernameMail, PDO::PARAM_STR);
    $stmt->bindParam(2, $usernameMail, PDO::PARAM_STR);
    $stmt->bindParam(3, $hash, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchColumn();
}

function actualitzarContrasenya($usernameMail, $password_hash)
{
    global $db;
    $sql = "UPDATE users SET passHash = ? WHERE (username = ? OR mail = ?) AND resetPass = 1 AND active = 1";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $password_hash, PDO::PARAM_STR);
    $stmt->bindParam(2, $usernameMail, PDO::PARAM_STR);
    $stmt->bindParam(3, $usernameMail, PDO::PARAM_STR);
    $stmt->execute();
}

function netejarResetPassword($usernameMail)
{
    global $db;
    $sql = "UPDATE users SET resetPass = 0, resetPassExpiry = NULL, resetPassCode = NULL WHERE (username = ? OR mail = ?) AND active = 1";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $usernameMail, PDO::PARAM_STR);
    $stmt->bindParam(2, $usernameMail, PDO::PARAM_STR);
    $stmt->execute();
}

function insereixFotografia($nom,$descripcio,$path,$usuariId)
{
    global $db;
    $sql = "INSERT INTO fotografia (nom, descripcio, data, url, usuariId) VALUES (? ,? ,CURRENT_TIMESTAMP ,? ,?)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $nom, PDO::PARAM_STR);
    $stmt->bindParam(2, $descripcio, PDO::PARAM_STR);
    $stmt->bindParam(3, $path, PDO::PARAM_STR);
    $stmt->bindParam(4, $usuariId, PDO::PARAM_INT);
    return $stmt->execute();
}

function existeixHashtag($hashtag)
{
    global $db;
    $sql = "SELECT nom FROM hashtags WHERE nom = ?";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $hashtag, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchColumn();
}

function insereixHashtag($hashtag) 
{
    global $db;
    $sql = "INSERT INTO hashtags (nom) VALUES (?)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $hashtag, PDO::PARAM_STR);
    return $stmt->execute();
}

function insereixFotografiaHashtag($imgNom, $hashtag)
{
    global $db;
    $sql = "INSERT INTO fotografiahashtags (fotografiaNom, hashtagNom) VALUES (? ,?)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $imgNom, PDO::PARAM_STR);
    $stmt->bindParam(2, $hashtag, PDO::PARAM_STR);
    return $stmt->execute();
}

function comprovarHashtags($imgNom,$hashtagArray)
{
    foreach ($hashtagArray[0] as $hashtag) {
        if(!existeixHashtag($hashtag))
        {
            insereixHashtag($hashtag);
        }
        insereixFotografiaHashtag($imgNom,$hashtag);
    }
}

function buscaUltimaFotografia()
{
    global $db;
    $sql = "SELECT nom FROM fotografia WHERE data = (SELECT MAX(data) FROM fotografia)";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    return $stmt->fetchColumn();
}

function getUsernameById($userId)
{
    global $db;
    $sql = "SELECT username FROM users WHERE iduser = ?";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $userId, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchColumn();
}

function getUserByPhoto($nom)
{
    global $db;
    $sql = "SELECT usuariId FROM fotografia WHERE nom = ?";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $nom, PDO::PARAM_STR);
    $stmt->execute();

    $userId = $stmt->fetchColumn();

    return  getUsernameById($userId);
}

function getDateByPhoto($fotografiaNom)
{
    global $db;
    $sql = "SELECT data FROM fotografia WHERE nom = ?";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $fotografiaNom, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchColumn();
}

function getDescriptionByPhoto($fotografiaNom)
{
    global $db;
    $sql = "SELECT descripcio FROM fotografia WHERE nom = ?";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $fotografiaNom, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchColumn();
}

function getUrlByPhoto($fotografiaNom)
{
    global $db;
    $sql = "SELECT url FROM fotografia WHERE nom = ?";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $fotografiaNom, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetchColumn();
}

function getRandomPhoto($rand)
{
    $random = $rand - 1;
    global $db;
    $sql = "SELECT nom FROM fotografia LIMIT 1 OFFSET $random";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    return $stmt->fetchColumn();
}

function getNumberOfPhotos()
{
    global $db;
    $sql = "SELECT count(*) FROM fotografia";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    return $stmt->fetchColumn();
}

