<?php

require 'conexao.php';
require 'autenticacao.php';
require 'criptografia.php';

// BUSCAR CLIENTE PARA EDIÇÃO
$clienteEditar = null;

if (isset($_GET['editar'])) {

    $sql = $pdo->prepare("
        SELECT * FROM clientes WHERE id = ?
    ");

    $sql->execute([$_GET['editar']]);

    $clienteEditar = $sql->fetch(PDO::FETCH_ASSOC);
}

// CADASTRAR CLIENTE
if (isset($_POST['salvar'])) {

    $cpf = preg_replace('/\D/', '', $_POST['cpf']);

    if (strlen($cpf) != 11) {
        die("CPF deve conter 11 números.");
    }

    $cpfCriptografado = criptografarCPF($cpf);

    $sql = $pdo->prepare("
        INSERT INTO clientes
        (nome, cpf, telefone, email, endereco)
        VALUES (?, ?, ?, ?, ?)
    ");

    $sql->execute([
        $_POST['nome'],
        $cpfCriptografado,
        $_POST['telefone'],
        $_POST['email'],
        $_POST['endereco']
    ]);

    header("Location: clientes.php");
    exit;
}

// ATUALIZAR CLIENTE
if (isset($_POST['atualizar'])) {

    $sql = $pdo->prepare("
        UPDATE clientes
        SET nome = ?,
            telefone = ?,
            email = ?,
            endereco = ?
        WHERE id = ?
    ");

    $sql->execute([
        $_POST['nome'],
        $_POST['telefone'],
        $_POST['email'],
        $_POST['endereco'],
        $_POST['id']
    ]);

    // ATUALIZAR CPF SOMENTE SE INFORMADO
    if (!empty($_POST['cpf'])) {

        $cpf = preg_replace('/\D/', '', $_POST['cpf']);

        if (strlen($cpf) != 11) {
            die("CPF deve conter 11 números.");
        }

        $cpfCriptografado = criptografarCPF($cpf);

        $sql = $pdo->prepare("
            UPDATE clientes
            SET cpf = ?
            WHERE id = ?
        ");

        $sql->execute([
            $cpfCriptografado,
            $_POST['id']
        ]);
    }

    header("Location: clientes.php");
    exit;
}

// EXCLUIR CLIENTE
if (isset($_GET['excluir'])) {

    $sql = $pdo->prepare("
        DELETE FROM clientes WHERE id = ?
    ");

    $sql->execute([$_GET['excluir']]);

    header("Location: clientes.php");
    exit;
}

// BUSCAR CLIENTES
$busca = $_GET['busca'] ?? '';

$sql = $pdo->prepare("
    SELECT * FROM clientes
    WHERE nome LIKE ?
    ORDER BY nome ASC
");

$sql->execute(["%$busca%"]);

$clientes = $sql->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Clientes</title>
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

        <h1>Cadastro de Clientes</h1>

        <h3><?= $clienteEditar ? 'Editar Cliente' : 'Novo Cliente' ?></h3>

        <form method="POST">

            <?php if ($clienteEditar): ?>
                <input type="hidden" name="id"
                    value="<?= $clienteEditar['id'] ?>">
            <?php endif; ?>

            <label>Nome:</label>
            <input type="text" name="nome"
                value="<?= htmlspecialchars($clienteEditar['nome'] ?? '') ?>"
                required>

            <label>CPF:</label>
            <input type="text" name="cpf"
                placeholder="<?= $clienteEditar ? '000.000.000-00' : '000.000.000-00' ?>"
                maxlength="14"
                <?= $clienteEditar ? '' : 'required' ?>>

            <label>Telefone:</label>
            <input type="text" name="telefone"
                value="<?= htmlspecialchars($clienteEditar['telefone'] ?? '') ?>">

            <label>E-mail:</label>
            <input type="email" name="email"
                value="<?= htmlspecialchars($clienteEditar['email'] ?? '') ?>">

            <label>Endereço:</label>
            <input type="text" name="endereco"
                value="<?= htmlspecialchars($clienteEditar['endereco'] ?? '') ?>">

            <?php if ($clienteEditar): ?>
                <button name="atualizar">Salvar Alterações</button>
                <a href="clientes.php">Cancelar</a>
            <?php else: ?>
                <button name="salvar">Cadastrar</button>
            <?php endif; ?>

        </form>

        <hr>

        <h3>Pesquisar clientes</h3>

        <form method="GET">

            <input type="text" name="busca"
                placeholder="Digite o nome do cliente"
                value="<?= htmlspecialchars($busca) ?>">

            <button type="submit">Buscar</button>

            <a href="clientes.php">Limpar</a>

        </form>

        <h3>Clientes cadastrados</h3>

        <table>

            <tr>
                <th>Nome</th>
                <th>CPF</th>
                <th>Telefone</th>
                <th>E-mail</th>
                <th>Endereço</th>
                <th>Ações</th>
            </tr>

            <?php foreach ($clientes as $c): ?>

                <tr>

                    <td><?= htmlspecialchars($c['nome']) ?></td>

                    <td>
                        <?= htmlspecialchars(
                            descriptografarCPF($c['cpf'])
                        ) ?>
                    </td>

                    <td><?= htmlspecialchars($c['telefone'] ?? '') ?></td>
                    <td><?= htmlspecialchars($c['email'] ?? '') ?></td>
                    <td><?= htmlspecialchars($c['endereco'] ?? '') ?></td>

                    <td>
                        <a href="clientes.php?editar=<?= $c['id'] ?>">
                            Editar
                        </a>

                        <a href="clientes.php?excluir=<?= $c['id'] ?>"
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