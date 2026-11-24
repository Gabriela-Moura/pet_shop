<?php

require 'conexao.php';
require 'autenticacao.php';

// CADASTRAR
if (isset($_POST['salvar'])) {

    $sql = $pdo->prepare("
        INSERT INTO produtos
        (nome, categoria, preco, estoque)
        VALUES (?, ?, ?, ?)
    ");

    $sql->execute([
        $_POST['nome'],
        $_POST['categoria'],
        $_POST['preco'],
        $_POST['estoque']
    ]);

    header("Location: produtos.php");
    exit;
}

// ATUALIZAR
if (isset($_POST['atualizar'])) {

    $sql = $pdo->prepare("
        UPDATE produtos
        SET nome = ?,
            categoria = ?,
            preco = ?,
            estoque = ?
        WHERE id = ?
    ");

    $sql->execute([
        $_POST['nome'],
        $_POST['categoria'],
        $_POST['preco'],
        $_POST['estoque'],
        $_POST['id']
    ]);

    header("Location: produtos.php");
    exit;
}

// EXCLUIR
if (isset($_GET['excluir'])) {

    $sql = $pdo->prepare("
        DELETE FROM produtos WHERE id = ?
    ");

    $sql->execute([$_GET['excluir']]);

    header("Location: produtos.php");
    exit;
}

// BUSCAR PARA EDIÇÃO
$editar = null;

if (isset($_GET['editar'])) {

    $sql = $pdo->prepare("
        SELECT * FROM produtos WHERE id = ?
    ");

    $sql->execute([$_GET['editar']]);

    $editar = $sql->fetch(PDO::FETCH_ASSOC);
}

// LISTAR
$produtos = $pdo->query("
    SELECT * FROM produtos ORDER BY nome
")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Produtos</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header>
        <h2>Loja</h2>
        <p>
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

        <h1>Cadastro de Produtos</h1>

        <h3><?= $editar ? 'Editar Produto' : 'Novo Produto' ?></h3>

        <form method="POST">

            <?php if ($editar): ?>
                <input type="hidden" name="id"
                    value="<?= $editar['id'] ?>">
            <?php endif; ?>

            <label>Nome:</label>
            <input type="text" name="nome"
                value="<?= htmlspecialchars($editar['nome'] ?? '') ?>"
                required>

            <label>Categoria:</label>
            <input type="text" name="categoria"
                value="<?= htmlspecialchars($editar['categoria'] ?? '') ?>">

            <label>Preço:</label>
            <input type="number" step="0.01" name="preco"
                value="<?= $editar['preco'] ?? '' ?>" required>

            <label>Estoque:</label>
            <input type="number" name="estoque"
                value="<?= $editar['estoque'] ?? '' ?>" required>

            <?php if ($editar): ?>
                <button name="atualizar">Salvar Alterações</button>
                <a href="produtos.php">Cancelar</a>
            <?php else: ?>
                <button name="salvar">Cadastrar</button>
            <?php endif; ?>

        </form>

        <h3>Produtos cadastrados</h3>

        <table>

            <tr>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Preço</th>
                <th>Estoque</th>
                <th>Ações</th>
            </tr>

            <?php foreach ($produtos as $p): ?>

                <tr>
                    <td><?= htmlspecialchars($p['nome']) ?></td>
                    <td><?= htmlspecialchars($p['categoria']) ?></td>
                    <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
                    <td><?= $p['estoque'] ?></td>

                    <td>
                        <a href="produtos.php?editar=<?= $p['id'] ?>">Editar</a>

                        <a href="produtos.php?excluir=<?= $p['id'] ?>"
                            onclick="return confirm('Deseja excluir?')">
                            Excluir
                        </a>
                    </td>
                </tr>

            <?php endforeach; ?>

        </table>

    </main>
</body>

</html>