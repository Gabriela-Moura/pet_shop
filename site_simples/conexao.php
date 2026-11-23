<?php
    $conexao = mysqli_connect("localhost", "root", "123456", "loja_ferramentas", 3306);

    if (!$conexao) {
        die ("Erro conexão: " . mysqli_connect_error());
    }

    mysqli_set_charset($conexao, "utf8mb4")
?>