<?php
session_start();

include __DIR__ . "/../config/conexao.php";

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
        $sql = "SELECT * FROM consultas WHERE idAnimal = ?";
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
            Descrição: <?= htmlspecialchars($consulta['descricao']) ?><br>
            Data: <?= htmlspecialchars($consulta['data_hora']) ?><br>
            Preço: R$ <?= htmlspecialchars($consulta['preco']) ?><br>
            </p>
        </td>
        <td>
            <a href="editar.php?id=<?= $consulta['idConsulta'] ?>">Editar</a>
            <a href="../controllers/excluir.php?id=<?= $consulta['idConsulta'] ?>">Excluir</a>
        </td>
    </tr>

    <?php
    }

} else {
    echo "Você ainda não possui consultas cadastradas.";
}
?>
<form action="../controllers/sair.php" method="POST">
    <button type="submit">Sair</button>
</form>

</body>
</html>