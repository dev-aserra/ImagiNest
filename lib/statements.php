<?php
function existeixMail($email)
{
    include dirname(__FILE__) . '\..\config\db.php';
    $stmt = $db->prepare("SELECT * FROM users WHERE mail = '{$email}' ");
    $stmt->execute();

    return $stmt->rowCount();
}

function existeixUsername($username)
{
    include dirname(__FILE__) . '\..\config\db.php';
    $stmt = $db->prepare("SELECT * FROM users WHERE username = '{$username}' ");
    $stmt->execute();

    return $stmt->rowCount();
}

function insereixUsuari($email, $username, $password_hash, $firstname, $lastname)
{
    include dirname(__FILE__) . '\..\config\db.php';
    $stmt = $db->prepare("INSERT INTO users (mail, username, passHash, userFirstName, userLastName) VALUES ('{$email}', '{$username}', '{$password_hash}', '{$firstname}', '{$lastname}')");
    $stmt->execute();
}

function existeixUsernameMail($usernameMail)
{
    include dirname(__FILE__) . '\..\config\db.php';
    $stmt = $db->prepare("SELECT * FROM users WHERE (username = '{$usernameMail}' or mail = '{$usernameMail}') and (active = 1)");
    $stmt->execute();

    return $stmt->rowCount();
}

function comprovaContrasenya($usernameMail, $password)
{
    include dirname(__FILE__) . '\..\config\db.php';
    $stmt = $db->prepare("SELECT passHash FROM users WHERE (username = '{$usernameMail}' or mail = '{$usernameMail}')");
    $stmt->execute();
    $pass = $stmt->fetchColumn();

    return password_verify($password, $pass);
}

function actualitzarIniciSessio($usernameMail)
{
    include dirname(__FILE__) . '\..\config\db.php';
    $stmt = $db->prepare("UPDATE users SET lastSignIn = current_timestamp WHERE (username = '{$usernameMail}' or mail = '{$usernameMail}')");
    $stmt->execute();
}
