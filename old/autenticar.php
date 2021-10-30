<?php

function auth($login, $senha) {
    $pdo = new PDO('mysql:host=localhost;dbname=agenda', 'root', 'root');    
    $sql = "SELECT * FROM users WHERE login = :login AND password = :password";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':login', $login);
    $stmt->bindValue(':password', $senha);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        session_start();
        $_SESSION['login'] = $login;
        header('Location: index.php');
    } else {
        header('Location: autenticar.php');
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticar Usuário</title>
</head>
<body>
    <h1>Autenticação de Usuário</h1>
    <form action="autenticar.php" method="post">
        <label for="login">Login:</label>
        <input type="text" name="login" id="login">
        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha">
        <input type="submit" value="Autenticar">
</body>
</html>