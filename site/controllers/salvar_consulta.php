
<?php
session_start();
include "config/conexao.php";

$idAnimal = $_POST['idAnimal'];
$descricao = $_POST['descricao'];
$data_hora = $_POST['data'] . ' ' . $_POST['horario'] . ':00';
$preco = $_POST['preco'];

$sql = "INSERT INTO consultas
        (idAnimal, descricao, data_hora, preco, status)
        VALUES (?, ?, ?, ?, 'agendada')";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "isss",
    $idAnimal, $descricao, $data_hora, $preco);

mysqli_stmt_execute($stmt);

header("Location: inicio.php");
exit;
?>
