
<?php
session_start();

include "config/conexao.php";

// Verificar se o cliente está logado
if (!isset($_SESSION['cliente'])) {
    header("Location: view/index.html");
    exit;
}

// O ID do cliente já é armazenado diretamente na sessão
$idCliente = $_SESSION['cliente'];

$sqlAviso = "SELECT consultas.idConsulta,
                    consultas.data_hora,
                    animais.nome AS nomeAnimal
             FROM consultas
             INNER JOIN animais
             ON consultas.idAnimal = animais.idAnimal
             WHERE animais.idCliente = ?
             AND consultas.status = 'desmarcada'
             AND consultas.cliente_visualizou_cancelamento = 0";

$stmtAviso = mysqli_prepare($conn, $sqlAviso);

if (!$stmtAviso) {
    die("Erro ao preparar notificação: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmtAviso, "i", $idCliente);
mysqli_stmt_execute($stmtAviso);

$resultadoAviso = mysqli_stmt_get_result($stmtAviso);

$notificacoes = [];

while ($aviso = mysqli_fetch_assoc($resultadoAviso)) {
    $notificacoes[] = $aviso;
}

$sql = "SELECT consultas.*, animais.nome AS nomeAnimal
        FROM consultas
        INNER JOIN animais
        ON consultas.idAnimal = animais.idAnimal
        WHERE animais.idCliente = ?
        AND consultas.status = 'agendada'
        ORDER BY consultas.data_hora ASC";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("Erro ao buscar consultas: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $idCliente);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Página do cliente</title>
</head>

<body>

    <h1>
        Bem-vindo, <?= htmlspecialchars($_SESSION['nome']); ?>!
    </h1>

    <?php foreach ($notificacoes as $aviso): ?>

        <div style="
            background-color: #fff3cd;
            border: 1px solid #ffecb5;
            color: #856404;
            padding: 15px;
            margin: 15px 0;
            border-radius: 8px;
        ">

            <strong>⚠️ Atenção! Consulta desmarcada.</strong>

            <p>
                A consulta do animal
                <strong>
                    <?= htmlspecialchars($aviso['nomeAnimal']); ?>
                </strong>
                foi desmarcada pelo veterinário.
            </p>

            <p>
                Data e horário:
                <?= date('d/m/Y \à\s H:i', strtotime($aviso['data_hora'])); ?>
            </p>

        </div>

    <?php endforeach; ?>


    <?php

    foreach ($notificacoes as $aviso) {

        $sqlLido = "UPDATE consultas
                    SET cliente_visualizou_cancelamento = 1
                    WHERE idConsulta = ?";

        $stmtLido = mysqli_prepare($conn, $sqlLido);

        if (!$stmtLido) {
            die("Erro ao atualizar notificação: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmtLido, "i", $aviso['idConsulta']);
        mysqli_stmt_execute($stmtLido);

        mysqli_stmt_close($stmtLido);
    }
    ?>

    <form action="view/nova_consulta.php" method="POST">
        <button type="submit">Agendar Nova Consulta</button>
    </form>

    <h2>Suas consultas:</h2>

    <?php if (mysqli_num_rows($resultado) > 0): ?>

        <?php while ($consulta = mysqli_fetch_assoc($resultado)): ?>

            <div style="
                border: 1px solid #ccc;
                padding: 15px;
                margin: 10px 0;
                border-radius: 8px;
            ">

                <p>
                    <strong>Animal:</strong>
                    <?= htmlspecialchars($consulta['nomeAnimal']); ?>
                    <br>

                    <strong>Descrição:</strong>
                    <?= htmlspecialchars($consulta['descricao']); ?>
                    <br>

                    <strong>Data:</strong>
                    <?= date('d/m/Y H:i', strtotime($consulta['data_hora'])); ?>
                    <br>

                    <strong>Preço:</strong>
                    R$ <?= number_format($consulta['preco'], 2, ',', '.'); ?>
                    <br>
                </p>

                <a href="editar.php?id=<?= $consulta['idConsulta']; ?>">
                    Editar
                </a>

                <a href="excluir.php?id=<?= $consulta['idConsulta']; ?>">
                    Excluir
                </a>

            </div>

        <?php endwhile; ?>

    <?php else: ?>

        <p>Você ainda não possui consultas agendadas.</p>

    <?php endif; ?>

</body>
</html>
