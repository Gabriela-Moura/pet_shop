<?php

require 'conexao.php';

session_start();

$erro = "";

if (isset($_POST['entrar'])) {

    $sql = $pdo->prepare("
        SELECT * FROM usuarios
        WHERE email = ?
    ");

    $sql->execute([$_POST['email']]);

    $usuario = $sql->fetch(PDO::FETCH_ASSOC);

    if (
        $usuario &&
        password_verify($_POST['senha'], $usuario['senha'])
    ) {

        session_regenerate_id(true);

        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['ultimo_acesso'] = time();

        header("Location: index.php");
        exit;
    } else {

        $erro = "E-mail ou senha incorretos.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <main>

        <h1>Loja</h1>
        <h3>Entrar no sistema</h3>

        <?php if (isset($_GET['expirou'])): ?>
            <p>Sua sessão expirou. Faça login novamente.</p>
        <?php endif; ?>

        <?php if ($erro): ?>
            <p><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>

        <form method="POST">

            <label>E-mail:</label>
            <input type="email" name="email" required>

            <label>Senha:</label>
            <input type="password" name="senha" required>

            <button name="entrar">Entrar</button>

        </form>

    </main>

</body>

</html>