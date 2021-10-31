<header class="mdl-layout__header">
    <div class="mdl-layout__header-row">
        <!-- Title -->
        <a href="index.php" class="mdl-layout-title" style="color: inherit; text-decoration: none">Agenda Pessoal</a>
        <!-- Add spacer, to align navigation to the right -->
        <div class="mdl-layout-spacer"></div>
        <!-- Navigation. We hide it in small screens. -->
        <nav class="mdl-navigation mdl-layout--large-screen-only">
            <?php
            // Chack if user is logged in
            // Start session if not already started
            if (session_id() == '') {
                session_start();
            };
            // Check if user is logged in
            if (isset($_SESSION['user'])) {
                // Get person name on the database
                $pdo = new PDO('mysql:host=localhost;dbname=agenda', 'root', '');
                $sql = "SELECT * FROM usuario WHERE UserID = '" . $_SESSION['user'] . "'";
                $result = $pdo->query($sql);
                $userName = $result->fetch();

                // Print user name
                echo '<span class="mdl-navigation__link">Entrou como <b>' . $userName['UserNome'] . '</b></span>';

                echo '<a class="mdl-navigation__link" href="logout.php">Logout</a>';
            } else {
                echo '<a class="mdl-navigation__link" href="login.php">Entrar ou Cadastrar</a>';
            }
            ?>
        </nav>
    </div>
</header>