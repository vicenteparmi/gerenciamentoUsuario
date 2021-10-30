<?php

$pdo = new PDO('mysql:host=localhost;dbname=agenda', 'root', '');
$sql = "SELECT * FROM usuario";
$usuarios = $pdo->query($sql)->fetchAll();

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Usuários</title>
</head>
<body>
    <h1>Agenda de Usuários</h1>
    <a href="cadastrar.php">Cadastrar Usuário</a>
    <a href="autenticar.php">Autenticar Usuário</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Ações</th>
        </tr>
        <?php foreach($usuarios as $usuario): ?>
        <tr>
            <td><?= $usuario['UserID'] ?></td>
            <td><?= $usuario['UserNome'] ?></td>
            <td><?= $usuario['UserEmail'] ?></td>
            <td>
                <a href="editar.php?id=<?= $usuario['id'] ?>">Editar</a>
                <a href="excluir.php?id=<?= $usuario['id'] ?>">Excluir</a>
            </td>
        </tr>
        <?php endforeach ?>
    </table>
    
</body>
</html>