
<?php

$host = "localhost";
$banco = "loja_tom";
$usuario = "root";
$senha = "123456";

try {

    $pdo = new PDO(
        "mysql:host=$host;dbname=$banco;charset=utf8mb4",
        $usuario,
        $senha
    );

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );
} catch (PDOException $e) {

    die("Erro na conexão com o banco de dados.");
}
