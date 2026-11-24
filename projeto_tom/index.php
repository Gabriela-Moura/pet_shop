<?php
require 'autenticacao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Início - Loja</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header>
        <h2>Loja</h2>

        <p>
            Bem-vindo(a),
            <?= htmlspecialchars($_SESSION['usuario_nome']) ?>

            | <a href="sair.php">Sair</a>
        </p>
    </header>

    <nav>
        <a href="index.php">Início</a>
        <a href="clientes.php">Clientes</a>
        <a href="produtos.php">Produtos</a>
        <a href="pedidos.php">Pedidos</a>
    </nav>

    <main>

        <h1>Painel Principal</h1>

        <p>Selecione uma opção para continuar:</p>

        <div class="cards">
            <a href="clientes.php">Cadastro de Clientes</a>
            <a href="produtos.php">Cadastro de Produtos</a>
            <a href="pedidos.php">Gerenciar Pedidos</a>
        </div>

    </main>

</body>

</html>