<?php
    $conexao = mysqli_connect('localhost', 'root', '123456', 'ferramentas', 3306);

    if (!$conexao) {
        die ("Erro na conexão: ". mysqli_connect_error());
    }
?>