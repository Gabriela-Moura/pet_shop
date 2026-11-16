
<?php
session_start();
include "conexao.php";

// Verificar se é veterinário/admin
if (!isset($_SESSION['admin'])) {
    header("Location: index.html");
    exit;
}

// Buscar consultas de hoje e dos próximos dias
$sql = "SELECT consultas.*,
               animais.nome AS nomeAnimal,
               clientes.nome AS nomeCliente
        FROM consultas
        INNER JOIN animais
            ON consultas.idAnimal = animais.idAnimal
        INNER JOIN clientes
            ON animais.idCliente = clientes.idCliente
        WHERE DATE(consultas.data_hora) >= CURDATE()
        AND consultas.status = 'agendada'
        ORDER BY consultas.data_hora ASC";

$resultado = mysqli_query($conn, $sql);

// Organizar consultas por dia
$consultasPorDia = [];

while ($consulta = mysqli_fetch_assoc($resultado)) {
    $dia = date('Y-m-d', strtotime($consulta['data_hora']));
    $consultasPorDia[$dia][] = $consulta;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Página do Veterinário</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Bem-vindo, Veterinário!</h1>

<h2>Agenda de Consultas</h2>

<?php if (!empty($consultasPorDia)) { ?>

    <?php foreach ($consultasPorDia as $dia => $consultas) { ?>

        <h3>
            Consultas de <?= date('d/m/Y', strtotime($dia)) ?>
        </h3>

        <table border="1" cellpadding="8">
            <thead>
                <tr>
                    <th>Horário</th>
                    <th>Animal</th>
                    <th>Responsável</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($consultas as $consulta) { ?>
                    <tr>
                        <td>
                            <?= date('H:i', strtotime($consulta['data_hora'])) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($consulta['nomeAnimal']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($consulta['nomeCliente']) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($consulta['descricao']) ?>
                        </td>

                        <td>
                            R$ <?= number_format($consulta['preco'], 2, ',', '.') ?>
                        </td>

                        <td>
                            <form action="cancelar_consulta.php" method="POST"
                                onsubmit="return confirm('Deseja realmente desmarcar esta consulta?')">

                                <input type="hidden" name="idConsulta"
                                    value="<?= $consulta['idConsulta'] ?>">

                                <button type="submit">Desmarcar Consulta</button>
                            </form>
                        <td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <br>

    <?php } ?>

<?php } else { ?>

    <p>Não há consultas agendadas para hoje ou para os próximos dias.</p>

<?php } ?>

</body>
</html>
