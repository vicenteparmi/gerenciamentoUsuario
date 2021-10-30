<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
</head>

<body>
    <h1>Cadastrar Usuários</h1>
    <form action="efetuarCadastro.php" method="post">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome">
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email">
        <br>
        <label for="login">Login:</label>
        <input type="text" name="login" id="login">
        <br>
        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha">
        <br>
        <input type="submit" value="Cadastrar">
    </form>
</body>

</html>