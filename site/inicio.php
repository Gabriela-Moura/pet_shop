<?php
session_start();

include "conexao.php";

if (!isset($_SESSION['cliente'])) {
    header("Location: index.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Página do cliente</title>
</head>
<body>

    <h1>
        Bem-vindo, <?php echo htmlspecialchars($_SESSION['nome']); ?>!
    </h1>

    <form action="nova_consulta.php" method="POST">
        <button type="submit"> Agendar Nova Consulta </button>
    </form>

    <?php

$sql = "SELECT consultas.*, animais.nome AS nomeAnimal
        FROM consultas
        INNER JOIN animais
        ON consultas.idAnimal = animais.idAnimal
        WHERE animais.idCliente = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $_SESSION['cliente']);

mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

echo "<h2>Suas consultas:</h2>";

if (mysqli_num_rows($resultado) > 0) {

    while ($consulta = mysqli_fetch_assoc($resultado)) { ?>
    <tr>
        <tr>
        <td>
            <p>
            Animal: <?= htmlspecialchars($consulta['nomeAnimal']) ?><br>
            Descrição: <?= htmlspecialchars($consulta['descricao']) ?><br>
            Data: <?= date('d/m/Y H:i', strtotime($consulta['data_hora'])) ?><br>
            Preço: R$ <?= number_format($consulta['preco'], 2, ',', '.') ?><br>
            </p>
        </td>
        <td>
            <a href="editar.php?id=<?= $consulta['idConsulta'] ?>">Editar</a>
            <a href="excluir.php?id=<?= $consulta['idConsulta'] ?>">Excluir</a>
        </td>
    </tr>

    <?php
    }

} else {
    echo "Você ainda não possui consultas cadastradas.";
}
?>

</body>
</html>