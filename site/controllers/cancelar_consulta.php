
<?php
session_start();
include __DIR__ . "/../config/conexao.php";

// Verificar se é veterinário
if (!isset($_SESSION['admin'])) {
    header("Location: ../view/index.html");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../view/paginaVet.php");
    exit;
}

$id = filter_input(INPUT_POST, 'idConsulta', FILTER_VALIDATE_INT);

if (!$id) {
    header("Location: ../view/paginaVet.php");
    exit;
}

$sql = "UPDATE consultas
        SET status = 'desmarcada'
        WHERE idConsulta = ?
        AND status = 'agendada'";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

header("Location: ../view/paginaVet.php");
exit;
?>
