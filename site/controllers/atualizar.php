<?php
    include __DIR__ . "/../config/conexao.php";

    $idAnimal = $_POST['idAnimal'];
    $id = $_POST['idConsulta'];
    $descricao = $_POST['descricao'];
    $data_hora = $_POST['data'] . ' ' . $_POST['horario'] . ':00';
    $preco = $_POST['preco'];

    $sql = "UPDATE consultas SET idAnimal=$idAnimal, descricao='$descricao', data_hora='$data_hora', preco='$preco' WHERE idConsulta=$id";

    mysqli_query($conn, $sql);
    header("Location: ../inicio.php");
?>