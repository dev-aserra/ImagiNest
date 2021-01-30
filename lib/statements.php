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

function insereixUsuari($email, $username, $password_hash, $firstname, $lastname)
{
    global $db;
    $sql = "INSERT INTO users (mail, username, passHash, userFirstName, userLastName) VALUES (? ,? ,? ,? ,?)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $email, PDO::PARAM_STR);
    $stmt->bindParam(2, $username, PDO::PARAM_STR);
    $stmt->bindParam(3, $password_hash, PDO::PARAM_STR);
    $stmt->bindParam(4, $firstname, PDO::PARAM_STR);
    $stmt->bindParam(5, $lastname, PDO::PARAM_STR);
    $stmt->execute();
}

function existeixUsernameMail($usernameMail)
{
    global $db;
    $sql = "SELECT * FROM users WHERE (username = ? or mail = ?) and (active = 1)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1, $usernameMail, PDO::PARAM_STR);
    $stmt->bindParam(2, $usernameMail, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->rowCount();
}

function comprovaContrasenya($usernameMail, $password)
{
    global $db;
    $sql = "SELECT passHash FROM users WHERE (username = ? or mail = ?)";
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
    $sql = "UPDATE users SET lastSignIn = current_timestamp WHERE (username = ? or mail = ?)";
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