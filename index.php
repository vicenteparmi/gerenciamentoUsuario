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
                <!-- Create table with all contacts from this user -->
                <?php
                $pdo = new PDO('mysql:host=localhost;dbname=agenda', 'root', '');
                $sql = "SELECT * FROM contato WHERE UserID = (:user)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':user', $_SESSION['user']);
                $stmt->execute();
                $contacts = $stmt->fetchAll();

                // If there are no contacts, show a message as a card
                echo '<div class="mdl-card mdl-shadow--2dp" style="margin-top:15vh; position:absolute; left: 50%; transform: translate(-50%, 0)">';
                echo '<div class="mdl-card__title mdl-card--expand">';
                echo '<h2 class="mdl-card__title-text">Nenhum contato cadastrado</h2>';
                echo '</div>';
                echo '<div class="mdl-card__supporting-text">';
                echo '<p>Você ainda não possui nenhum contato cadastrado.</p>';
                echo '</div>';
                // Button to create a contact
                echo '<div class="mdl-card__actions mdl-card--border">';
                echo '<a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href="create.php">';
                echo 'Criar contato';
                echo '</a>';
                echo '</div>';

                // Show all contacts from this user
                foreach ($contacts as $contact) {
                    echo '<tr>';
                    echo '<td class="mdl-data-table__cell--non-numeric">' . $contact['name'] . '</td>';
                    echo '<td class="mdl-data-table__cell--non-numeric">' . $contact['phone'] . '</td>';
                    echo '<td class="mdl-data-table__cell--non-numeric">' . $contact['email'] . '</td>';
                    echo '<td class="mdl-data-table__cell--non-numeric">';
                    echo '<a href="edit.php?id=' . $contact['id'] . '">Editar</a>';
                    echo '<a href="delete.php?id=' . $contact['id'] . '">Excluir</a>';
                    echo '</td>';
                    echo '</tr>';
                }

                ?>
            </div>
        </main>
    </div>
</body>

</html>