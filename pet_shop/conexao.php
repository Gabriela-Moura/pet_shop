<?php
    $conn = mysqli_connect("localhost", "root", "123456", "pet_shop", 3306);

    if(!$conn) {
        die("Erro de conexão: " . mysqli_connect_error());
    }
?>