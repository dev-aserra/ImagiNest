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