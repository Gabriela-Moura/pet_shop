<?php

require 'conexao.php';
require 'autenticacao.php';
require 'criptografia.php';

// CADASTRAR PEDIDO
if (isset($_POST['salvar'])) {

    $sql = $pdo->prepare("
        INSERT INTO pedidos
        (cliente_id, produto_id, quantidade, data_pedido)
        VALUES (?, ?, ?, ?)
    ");

    $sql->execute([
        $_POST['cliente_id'],
        $_POST['produto_id'],
        $_POST['quantidade'],
        $_POST['data']
    ]);

    header("Location: pedidos.php");
    exit;
}

// ATUALIZAR PEDIDO
if (isset($_POST['atualizar'])) {

    $sql = $pdo->prepare("
        UPDATE pedidos
        SET cliente_id = ?,
            produto_id = ?,
            quantidade = ?,
            data_pedido = ?
        WHERE id = ?
    ");

    $sql->execute([
        $_POST['cliente_id'],
        $_POST['produto_id'],
        $_POST['quantidade'],
        $_POST['data'],
        $_POST['id']
    ]);

    header("Location: pedidos.php");
    exit;
}

// EXCLUIR PEDIDO
if (isset($_GET['excluir'])) {

    $sql = $pdo->prepare("
        DELETE FROM pedidos WHERE id = ?
    ");

    $sql->execute([$_GET['excluir']]);

    header("Location: pedidos.php");
    exit;
}

// BUSCAR PEDIDO PARA EDIÇÃO
$editar = null;

if (isset($_GET['editar'])) {

    $sql = $pdo->prepare("
        SELECT * FROM pedidos WHERE id = ?
    ");

    $sql->execute([$_GET['editar']]);

    $editar = $sql->fetch(PDO::FETCH_ASSOC);
}

// BUSCAR CLIENTES
$clientes = $pdo->query("
    SELECT * FROM clientes ORDER BY nome
")->fetchAll(PDO::FETCH_ASSOC);

// BUSCAR PRODUTOS
$produtos = $pdo->query("
    SELECT * FROM produtos ORDER BY nome
")->fetchAll(PDO::FETCH_ASSOC);

// LISTAR PEDIDOS COM DADOS DE TRÊS TABELAS
$pedidos = $pdo->query("
    SELECT
        pedidos.*,
        clientes.nome AS cliente,
        clientes.cpf,
        produtos.nome AS produto,
        produtos.preco

    FROM pedidos

    INNER JOIN clientes
        ON pedidos.cliente_id = clientes.id

    INNER JOIN produtos
        ON pedidos.produto_id = produtos.id

    ORDER BY MONTH(pedidos.data_pedido) ASC

")->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Pedidos</title>
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

        <h1>Gerenciamento de Pedidos</h1>

        <h3><?= $editar ? 'Editar Pedido' : 'Novo Pedido' ?></h3>

        <form method="POST">

            <?php if ($editar): ?>
                <input type="hidden" name="id"
                    value="<?= $editar['id'] ?>">
            <?php endif; ?>

            <label>Cliente:</label>

            <select name="cliente_id" required>

                <option value="">Selecione o cliente</option>

                <?php foreach ($clientes as $c): ?>

                    <option value="<?= $c['id'] ?>"
                        <?= ($editar && $editar['cliente_id'] == $c['id'])
                            ? 'selected' : '' ?>>

                        <?= htmlspecialchars($c['nome']) ?>

                    </option>

                <?php endforeach; ?>

            </select>

            <label>Produto:</label>

            <select name="produto_id" required>

                <option value="">Selecione o produto</option>

                <?php foreach ($produtos as $p): ?>

                    <option value="<?= $p['id'] ?>"
                        <?= ($editar && $editar['produto_id'] == $p['id'])
                            ? 'selected' : '' ?>>

                        <?= htmlspecialchars($p['nome']) ?>

                    </option>

                <?php endforeach; ?>

            </select>

            <label>Quantidade:</label>
            <input type="number" name="quantidade"
                min="1"
                value="<?= $editar['quantidade'] ?? 1 ?>"
                required>

            <label>Data do pedido:</label>
            <input type="date" name="data"
                value="<?= $editar['data_pedido'] ?? date('Y-m-d') ?>"
                required>

            <?php if ($editar): ?>
                <button name="atualizar">Salvar Alterações</button>
                <a href="pedidos.php">Cancelar</a>
            <?php else: ?>
                <button name="salvar">Cadastrar Pedido</button>
            <?php endif; ?>

        </form>

        <h3>Pedidos cadastrados</h3>

        <table>

            <tr>
                <th>Data</th>
                <th>Cliente</th>
                <th>CPF</th>
                <th>Produto</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th>Ações</th>
            </tr>

            <?php foreach ($pedidos as $p): ?>

                <tr>

                    <td>
                        <?= date('d/m/Y', strtotime($p['data_pedido'])) ?>
                    </td>

                    <td><?= htmlspecialchars($p['cliente']) ?></td>

                    <td>
                        <?= htmlspecialchars(
                            descriptografarCPF($p['cpf'])
                        ) ?>
                    </td>

                    <td><?= htmlspecialchars($p['produto']) ?></td>

                    <td>
                        R$ <?= number_format($p['preco'], 2, ',', '.') ?>
                    </td>

                    <td><?= $p['quantidade'] ?></td>

                    <td>
                        <a href="pedidos.php?editar=<?= $p['id'] ?>">
                            Editar
                        </a>

                        <a href="pedidos.php?excluir=<?= $p['id'] ?>"
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