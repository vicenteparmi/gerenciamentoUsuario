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

// Save values if set for name
if (isset($_POST['name']) && !empty($_POST['name'])) {
    $name = $_POST['name'];

    $sql = "UPDATE contato SET ContatoNome = :name WHERE ContatoID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':id', $_GET['id']);
    $stmt->execute();
}

// Add email if set
if (isset($_POST['novoEmail']) && !empty($_POST['novoEmail'])) {
    $email = $_POST['novoEmail'];

    $sql = "INSERT INTO email (EmailEnd, ContatoID) VALUES (:email, :id)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':id', $_GET['id']);
    $stmt->execute();
}

// Add phone if set
if (isset($_POST['novoTelefone']) && !empty($_POST['novoTelefone'])) {
    $phone = $_POST['novoTelefone'];

    // Check if phone is a number
    if (is_numeric($phone)) {
        $sql = "INSERT INTO telefone (TelNumero, ContatoID) VALUES (:phone, :id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':id', $_GET['id']);
        $stmt->execute();
    } else {
        // Alert user if phone is invalid
        echo "<script>alert('Telefone inválido');</script>";
    }
}

// Remove email
if (isset($_GET['deleteEmail'])) {
    $sql = "DELETE FROM email WHERE EmailID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $_GET['deleteEmail']);
    $stmt->execute();
}

// Remove phone
if (isset($_GET['deleteTelefone'])) {
    $sql = "DELETE FROM telefone WHERE TelID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $_GET['deleteTelefone']);
    $stmt->execute();
}

// Check if return is set
if (isset($_POST['return'])) {
    // Go to the index
    header("Location: index.php");
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
    /* center the card on the screen */
    .mdl-card {
        width: 512px;
        margin: 0 auto;
    }
</style>

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
                        <form action="edit.php?id=<?php echo $_GET['id'] ?>" method="post">
                            <?php
                            // get the contact to edit
                            $contactId = $_GET['id'];

                            // get the contact from database
                            $sql = "SELECT * FROM contato WHERE ContatoID = :id";
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
                            echo '<input class="mdl-textfield__input" type="text" id="name" name="name" value="' . $contact['ContatoNome'] . '">';
                            echo '<label class="mdl-textfield__label" for="name">Nome</label>';
                            echo '</div>';

                            // Create a table to add or remove emails
                            echo '<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th class="mdl-data-table__cell--non-numeric">Email</th>';
                            echo '<th>Ações</th>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<td class="mdl-data-table__cell--non-numeric">';
                            echo '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">';
                            echo '<input class="mdl-textfield__input" type="text" id="email" name="novoEmail">';
                            echo '<label class="mdl-textfield__label" for="email">Email</label>';
                            echo '</div>';
                            echo '</td>';
                            echo '<td>';
                            echo '<button type="submit" class="mdl-button mdl-js-button mdl-button--icon" id="addEmail">';
                            echo '<i class="material-icons">add</i>';
                            echo '</button>';
                            echo '</td>';
                            echo '</tr>';

                            // List all the emails so far
                            foreach ($emails as $email) {
                                echo '<tr><td class="mdl-data-table__cell--non-numeric">';
                                echo '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">';
                                echo '<span>' . $email['EmailEnd'] . '</span>';
                                echo '</div>';
                                echo '</td>';
                                echo '<td>';
                                echo '<button type="button" onClick="deleteEmail(' . $email['EmailID'] . ', ' . $_GET['id'] . ')" class="mdl-button mdl-js-button mdl-button--icon" id="removeEmail">';
                                echo '<i class="material-icons">remove</i>';
                                echo '</button>';
                                echo '</td>';
                                echo '</tr>';
                            }

                            echo '</thead>';
                            echo '</table><br>';

                            // Create the same table but for phone numbers
                            echo '<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th class="mdl-data-table__cell--non-numeric">Telefone</th>';
                            echo '<th>Ações</th>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<td class="mdl-data-table__cell--non-numeric">';
                            echo '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">';
                            echo '<input class="mdl-textfield__input" type="text" id="phone" name="novoTelefone">';
                            echo '<label class="mdl-textfield__label" for="phone">Telefone</label>';
                            echo '</div>';
                            echo '</td>';
                            echo '<td>';
                            echo '<button type="submit" class="mdl-button mdl-js-button mdl-button--icon" id="addPhone">';
                            echo '<i class="material-icons">add</i>';
                            echo '</button>';
                            echo '</td>';
                            echo '</tr>';

                            // List all the phones so far
                            foreach ($phones as $phone) {
                                echo '<tr><td class="mdl-data-table__cell--non-numeric">';
                                echo '<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">';
                                echo '<input class="mdl-textfield__input" type="text" id="phone" name="phone[]" value="' . $phone['TelNumero'] . '">';
                                echo '<label class="mdl-textfield__label" for="phone">Telefone</label>';
                                echo '</div>';
                                echo '</td>';
                                echo '<td>';
                                echo '<button onClick="deleteTelefone(' . $phone['TelID'] . ', ' . $_GET['id'] . ')" type="button" class="mdl-button mdl-js-button mdl-button--icon" id="removePhone">';
                                echo '<i class="material-icons">remove</i>';
                                echo '</button>';
                                echo '</td></tr>';
                            }
                            echo '</thead>';
                            echo '</table><br>';


                            ?>
                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" type="submit" name="return">
                                Salvar e voltar
                            </button>
                            <button onClick="deleteContact(<?php echo $_GET['id']; ?>)" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" type="button">
                                Excluir contato
                            </button>
                    </div>
        </main>
    </div>
    <script src="scripts/edit.js" type="text/javascript"></script>
</body>

</html>