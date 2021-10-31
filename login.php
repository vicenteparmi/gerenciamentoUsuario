<?php
// Start session if not already started
if(session_id() == '') {
    session_start();
};

// Check user credentials in database and redirect to home page if successful
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $db = new PDO('mysql:host=localhost;dbname=agenda', 'root', '');
    $query = $db->prepare("SELECT * FROM usuario WHERE UserNome = :username AND UserSenha = :password");
    $query->bindParam(':username', $username);
    $query->bindParam(':password', $password);
    $query->execute();
    $user = $query->fetch();
    if ($user) {
        // Get user id from database
        $query = $db->prepare("SELECT * FROM usuario WHERE UserLogin = :username");
        $query->bindParam(':username', $username);
        $query->execute();
        $user = $query->fetch();
        $_SESSION['user'] = $user['UserID'];
        header('Location: index.php');
        echo "Login efetuado com sucesso!";
    } else {
        echo "<script type='text/javascript'>alert('Usuário não encontrado. Cetifique-se de que digitou corretamente as informações ou crie um novo usuário.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.teal-light_green.min.css" />
    <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>
</head>

<style>
    .mdl-grid {
        display: block;
        margin: 0;
    }

    .page-content {
        width: 100%;
        margin: 0 auto;
        display: flex;
        justify-content: center;
    }
</style>

<body>
    <!-- Always shows a header, even in smaller screens. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
        <!-- import header -->
        <?php include 'header.php'; ?>
        <main class="mdl-layout__content">
            <div class="page-content">
                <div class="mdl-grid">
                    <div class="mdl-cell mdl-cell--4-col"></div>
                    <div class="mdl-cell mdl-cell--4-col">
                        <div class="mdl-card mdl-shadow--2dp">
                            <div class="mdl-card__title mdl-color--primary mdl-color-text--white">
                                <h2 class="mdl-card__title-text">Login</h2>
                            </div>
                            <div class="mdl-card__supporting-text">
                                <form action="login.php" method="post">
                                    <div class="mdl-textfield mdl-js-textfield">
                                        <input class="mdl-textfield__input" type="text" id="username" name="username" />
                                        <label class="mdl-textfield__label" for="username">Login</label>
                                    </div>
                                    <div class="mdl-textfield mdl-js-textfield">
                                        <input class="mdl-textfield__input" type="password" id="password" name="password" />
                                        <label class="mdl-textfield__label" for="password">Senha</label>
                                    </div>
                                    <div class="mdl-card__actions mdl-card--border">
                                        <button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" type="submit">Entrar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--4-col"></div>
                </div>
                <div class="mdl-grid">
                    <div class="mdl-cell mdl-cell--4-col"></div>
                    <div class="mdl-cell mdl-cell--4-col">
                        <div class="mdl-card mdl-shadow--2dp">
                            <div class="mdl-card__title mdl-color--primary mdl-color-text--white">
                                <h2 class="mdl-card__title-text">Cadastre-se</h2>
                            </div>
                            <div class="mdl-card__supporting-text">
                                <form action="efetuarCadastro.php" method="post">
                                    <div class="mdl-textfield mdl-js-textfield">
                                        <input class="mdl-textfield__input" type="text" id="username12" name="username12" />
                                        <label class="mdl-textfield__label" for="username12">Nome Completo</label>
                                    </div>
                                    <div class="mdl-textfield mdl-js-textfield">
                                        <input class="mdl-textfield__input" type="text" id="email2" name="email2" />
                                        <label class="mdl-textfield__label" for="email2">Email</label>
                                    </div>
                                    <div class="mdl-textfield mdl-js-textfield">
                                        <input class="mdl-textfield__input" type="text" id="username2" name="username2" />
                                        <label class="mdl-textfield__label" for="username2">Login</label>
                                    </div>
                                    <div class="mdl-textfield mdl-js-textfield">
                                        <input class="mdl-textfield__input" type="password" id="password2" name="password2" />
                                        <label class="mdl-textfield__label" for="password2">Senha</label>
                                    </div>
                                    <div class="mdl-card__actions mdl-card--border">
                                        <button class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect" type="submit">Cadastrar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--4-col"></div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>