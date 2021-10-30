<header class="mdl-layout__header">
    <div class="mdl-layout__header-row">
        <!-- Title -->
        <a href="index.php" class="mdl-layout-title">Agenda Pessoal</a>
        <!-- Add spacer, to align navigation to the right -->
        <div class="mdl-layout-spacer"></div>
        <!-- Navigation. We hide it in small screens. -->
        <nav class="mdl-navigation mdl-layout--large-screen-only">
            <?php
            // Chack if user is logged in
            if (isset($_SESSION['user_id'])) {
                echo '<a class="mdl-navigation__link" href="logout.php">Logout</a>';
            } else {
                echo '<a class="mdl-navigation__link" href="login.php">Entrar ou Cadastrar</a>';
            }
            ?>
        </nav>
    </div>
</header>