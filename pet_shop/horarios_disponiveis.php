
<?php
include __DIR__ . "/conexao.php";

$data = $_GET['data'] ?? '';

$horarios = [
    '08:00', '09:00', '10:00', '11:00',
    '12:00', '13:00', '14:00', '15:00',
    '16:00', '17:00'
];

$sql = "SELECT TIME(data_hora) AS horario
        FROM consultas
        WHERE DATE(data_hora) = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $data);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

$ocupados = [];

while ($row = mysqli_fetch_assoc($resultado)) {
    $ocupados[] = substr($row['horario'], 0, 5);
}

foreach ($horarios as $horario) {
    if (!in_array($horario, $ocupados)) {
        echo "<option value='$horario'>$horario</option>";
    }
}
?>
