<?php
    $conexao = mysqli_connect('localhost', 'root', '123456', 'ferramentas', 3306);

    if ($conexao) {
        die ("Erro na conexão: ". mysql_connect_error());
    }
?>