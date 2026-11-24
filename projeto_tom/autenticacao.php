
<?php

session_start();

$tempo_limite = 60; // 1 minuto

if (isset($_SESSION['usuario_id'])) {

    if (
        isset($_SESSION['ultimo_acesso']) &&
        (time() - $_SESSION['ultimo_acesso']) > $tempo_limite
    ) {

        session_unset();
        session_destroy();

        header("Location: login.php?expirou=1");
        exit;
    }

    $_SESSION['ultimo_acesso'] = time();
} else {

    header("Location: login.php");
    exit;
}
