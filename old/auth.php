<?php

$pdo = new PDO('mysql:host=localhost;dbname=agenda', 'root', 'root');

$login = $_POST['login'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE login = :login AND password = :password";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':login', $login);
$stmt->bindValue(':password', $password);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    session_start();
    $_SESSION['login'] = $login;
    header('Location: index.php');
} else {
    header('Location: autenticar.php');
}

?>