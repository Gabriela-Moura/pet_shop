<?php

include 'conexao.php';

$nome = $_POST['nome'];
$usuario = $_POST['usuario'];
$senha = $_POST['senha'];

$sql = "INSERT INTO usuario (nome, usuario, senha)
        VALUES ('$nome', '$usuario', '$senha')";

if (mysqli_query($conexao, $sql)) {
    echo "Cadastro realizado com sucesso!";
    echo "<br><a href='index.php'>Fazer login</a>";
} else {
    echo "Erro ao cadastrar: " . mysqli_error($conexao);
}

?>