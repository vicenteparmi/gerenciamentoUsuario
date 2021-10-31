<?php
// Add user to the database
echo "Efetuando cadastro e redirecionando...<br>";
$username = $_POST['username2'];
$password = $_POST['password2'];
$username1 = $_POST['username12'];
$email = $_POST['email2'];

// Check if the values are in the correct way
if(!preg_match("/^[a-zA-Z ]*$/",$username)){
    echo "Nome inválido<br>";
    echo "<script>setTimeout(\"location.href = 'login.php';\",3000);</script>";
    exit();
}

if(!preg_match("/^[a-zA-Z0-9]*$/", $password)){
    echo "<b>Senha inválida!</b>\n";
    echo "<script>setTimeout(\"location.href = 'login.php';\",3000);</script>";
    exit();
}
if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
    echo "<b>Login inválido!</b>\n";
    echo "<script>setTimeout(\"location.href = 'login.php';\",3000);</script>";
    exit();
}
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    echo "<b>Email inválido!</b>\n";
    echo "<script>setTimeout(\"location.href = 'login.php';\",3000);</script>";
    exit();
}

$db = new PDO('mysql:host=localhost;dbname=agenda', 'root', '');

// Try to get the user from the database if already exists
$stmt = $db->prepare("SELECT * FROM usuario WHERE UserLogin = :username");
$stmt->bindParam(':username', $username);
$stmt->execute();
$result = $stmt->fetchAll();

if ($result) {
    echo "Usuário já existe! Iremos te redirecionar ao início.";
    echo "<script>setTimeout(\"location.href = 'index.php';\",3000);</script>";
} else {
    // Add user to the database
    $query = $db->prepare("INSERT INTO usuario (UserNome, UserEmail, UserLogin, UserSenha) VALUES (:username, :email, :username1, :password)");
    $query->bindParam(':username', $username1);
    $query->bindParam(':password', $password);
    $query->bindParam(':username1', $username);
    $query->bindParam(':email', $email);
    $query->execute();

    // Start user session
    session_start();
    // Get user id from database
    $query = $db->prepare("SELECT * FROM usuario WHERE UserLogin = :username");
    $query->bindParam(':username', $username);
    $query->execute();
    $user = $query->fetch();
    $_SESSION['user'] = $user['UserID'];

    echo "Cadastro efetuado com sucesso! Redirecionando...";
    echo "<script>setTimeout(\"location.href = 'index.php';\",3000);</script>";
}

?>