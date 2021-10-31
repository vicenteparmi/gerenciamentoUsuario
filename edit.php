<?php

    // start session if not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // if user is not logged in, redirect to login page
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit;
    }

    // Connect to database
    $pdo = new PDO('mysql:host=localhost;dbname=agenda', 'root', '');
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

<body>
    <!-- Always shows a header, even in smaller screens. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
        <!-- import header -->
        <?php include 'header.php'; ?>
        <main class="mdl-layout__content">
            <div class="page-content">
                <!-- create a card to edit the contact -->
                <div class="mdl-card mdl-shadow--2dp">
                    <div class="mdl-card__title mdl-color--primary mdl-color-text--white">
                        <h2 class="mdl-card__title-text">Editar Contato</h2>
                    </div>
                    <div class="mdl-card__supporting-text">
                        <form action="edit.php" method="post">
                            <?php
                            // get the contact to edit
                            $contactId = $_GET['id'];

                            // get the contact from database
                            $sql = "SELECT * FROM contato WHERE id = :id";
                            $stmt = $pdo->prepare($sql);
                            $stmt->bindParam(':id', $contactId);
                            $stmt->execute();
                            $contact = $stmt->fetch(PDO::FETCH_ASSOC);

                            // get the phone numbers from database
                            $sql = "SELECT * FROM telefone WHERE ContatoID = :id";
                            $stmt = $pdo->prepare($sql);
                            $stmt->bindParam(':id', $contactId);
                            $stmt->execute();
                            $phones = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            // get the emails from database
                            $sql = "SELECT * FROM email WHERE ContatoID = :id";
                            $stmt = $pdo->prepare($sql);
                            $stmt->bindParam(':id', $contactId);
                            $stmt->execute();
                            $emails = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            // Create a form to edit the contact
                            echo '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">';
                            echo '<input class="mdl-textfield__input" type="text" id="name" name="name" value="' . $contact['Nome'] . '">';
                            echo '<label class="mdl-textfield__label" for="name">Nome</label>';
                            echo '</div>';
                            

                            ?>
                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" type="submit">
                                Salvar
                            </button>
            </div>
        </main>
    </div>
</body>

</html>