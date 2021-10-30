<?php

require_once 'class/User.php';

$name = $_POST['nome'];
$email = $_POST['email'];
$login = $_POST['login'];
$password = $_POST['senha'];

$user = new User($name, $email, $login, $password);

$pdo = new PDO('mysql:host=localhost;dbname=agenda', 'root', '');

$sql = "INSERT INTO usuario (UserNome, UserEmail, UserLogin, UserSenha) VALUES (:name, :email, :login, :password)";
$sql = $pdo->prepare($sql);
$sql->bindValue(':name', $user->getName());
$sql->bindValue(':email', $user->getEmail());
$sql->bindValue(':login', $user->getLogin());
$sql->bindValue(':password', $user->getPassword());
$sql->execute();

header("Location: index.php");
die();