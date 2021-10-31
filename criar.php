<?php

// Start the session if it hasn't already been started
if (!isset($_SESSION)) {
    session_start();
}

// Get the session variables from the post form if set
if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['telefone'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];

    // Validate the session variables
    if (empty($nome) || empty($email) || empty($telefone)) {
        // Alert
        echo "<script>alert('Preencha todos os campos!');</script>";
    }

    // Connect to the database
    $pdo = new PDO('mysql:host=localhost;dbname=agenda', 'root', '');

    // Check if the contact already exists
    $sql = "SELECT * FROM contato WHERE ContatoNome = :nome AND UserID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':id', $_SESSION['user']);
    $stmt->execute();
    $result = $stmt->fetchAll();

    // If the contact already exists, alert
    if (count($result) > 0) {
        echo "<script>alert('Contato já existe!');</script>";
    } else {

        $sql = "INSERT INTO contato (ContatoNome, UserID) VALUES (:nome, :id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':id', $_SESSION['user']);
        $stmt->execute();

        // Get the contact ID
        $sql = "SELECT ContatoID FROM contato WHERE ContatoNome = :nome AND UserID = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':id', $_SESSION['user']);
        $stmt->execute();
        $result = $stmt->fetch();
        $contatoID = $result['ContatoID'];

        // Add the phone number to the database
        $sql = "INSERT INTO telefone (TelNumero, ContatoID) VALUES (:phone, :userId)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':phone', $telefone);
        $stmt->bindParam(':userId', $contatoID);
        $stmt->execute();

        // Add the email to the database
        $sql = "INSERT INTO email (EmailEnd, ContatoID) VALUES (:email, :userId)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':userId', $contatoID);
        $stmt->execute();

        // Alert
        echo "<script>alert('Contato adicionado com sucesso!');</script>";

        // Redirect
        header("Location: index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Pessoal</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.teal-light_green.min.css" />
    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
</head>
<style>
    /* Align card to the middle */
    .mdl-card {
        display: block;
        position: absolute;
        top: 40%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
</style>

<body>
    <!-- Always shows a header, even in smaller screens. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
        <!-- import header -->
        <?php include 'header.php'; ?>
        <main class="mdl-layout__content">
            <div class="page-content">
                <!-- Create contact screen -->
                <div class="mdl-grid">
                    <div class="mdl-cell mdl-cell--12-col">
                        <div class="mdl-card mdl-shadow--2dp">
                            <div class="mdl-card__title mdl-color--primary mdl-color-text--white">
                                <h2 class="mdl-card__title-text">Criar Contato</h2>
                            </div>
                            <div class="mdl-card__supporting-text">
                                <form action="criar.php" method="post">
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input class="mdl-textfield__input" type="text" id="nome" name="nome">
                                        <label class="mdl-textfield__label" for="nome">Nome</label>
                                    </div>
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input class="mdl-textfield__input" type="text" id="email" name="email">
                                        <label class="mdl-textfield__label" for="email">Email</label>
                                    </div>
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input class="mdl-textfield__input" type="number" id="telefone" name="telefone">
                                        <label class="mdl-textfield__label" for="telefone">Telefone</label>
                                    </div>
                                    <!-- send button -->
                                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" type="submit">
                                        Criar
                                    </button>
        </main>
    </div>
</body>

</html>