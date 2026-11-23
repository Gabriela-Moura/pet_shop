<?php
    include __DIR__ . "/conexao.php";

    $id = $_GET['id'];
    $sql = "DELETE FROM consultas WHERE idConsulta= ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    header("Location: inicio.php");