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
    /* Center table */
    .mdl-data-table {
        margin: auto;
        margin-top: 5vh;
        width: 90%;
    }

    /* Center button on page*/
    .mdl-card__actions {
        text-align: center;
    }
</style>

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
                if ($contacts == null) {
                    echo '<div class="mdl-card mdl-shadow--2dp">
                            <div class="mdl-card__title">
                                <h2 class="mdl-card__title-text">Nenhum contato cadastrado</h2>
                            </div>
                            <div class="mdl-card__supporting-text">
                                <p>Você ainda não possui nenhum contato cadastrado. Clique no botão abaixo para adicionar um novo contato.</p>
                            </div>
                            <div class="mdl-card__actions mdl-card--border">
                                <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href="newContact.php">
                                    Adicionar Contato
                                </a>
                            </div>
                        </div>';
                } else {
                    echo '<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
                            <thead>
                                <tr>
                                    <th class="mdl-data-table__cell--non-numeric">Nome</th>
                                    <th class="mdl-data-table__cell--non-numeric">Telefone</th>
                                    <th class="mdl-data-table__cell--non-numeric">E-mail</th>
                                    <th class="mdl-data-table__cell--non-numeric">Ações</th>
                                </tr>
                            </thead>
                            <tbody>';
                    // Show all contacts from this user
                    foreach ($contacts as $contact) {
                        echo '<tr>';
                        echo '<td class="mdl-data-table__cell--non-numeric">' . $contact['ContatoNome'] . '</td>';
                        echo '<td class="mdl-data-table__cell--non-numeric">';

                        // Get the phone numbers from the database
                        $sql = "SELECT * FROM telefone WHERE ContatoID = (:contact)";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':contact', $contact['ContatoID']);
                        $stmt->execute();
                        $phones = $stmt->fetchAll();

                        // Show all phone numbers
                        foreach ($phones as $phone) {
                            echo $phone['TelNumero'] . '<br>';
                        }

                        echo '</td>';
                        echo '<td class="mdl-data-table__cell--non-numeric">';

                        // Get the emails from the database
                        $sql = "SELECT * FROM email WHERE ContatoID = (:contact)";
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':contact', $contact['ContatoID']);
                        $stmt->execute();
                        $emails = $stmt->fetchAll();

                        // Show all emails
                        foreach ($emails as $email) {
                            echo $email['EmailEnd'] . '<br>';
                        }

                        echo '</td>';
                        echo '<td class="mdl-data-table__cell--non-numeric">';
                        echo '<a href="edit.php?id=' . $contact['ContatoID'] . '">Editar</a>';
                        echo '<a href="delete.php?id=' . $contact['ContatoID'] . '">Excluir</a>';
                        echo '</td>';
                        echo '</tr>';   
                    
                    }

                    echo '</tbody>
                    </table>';

                    echo '<div class="mdl-card__actions mdl-card--border">
                                <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" href="criar.php">
                                    Adicionar Contato
                                </a>
                            </div>';

                }

                ?>
            </div>
        </main>
    </div>
</body>

</html>