<?php

session_start();

include __DIR__ . "/conexao.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.html");
    exit;
}

$usuario = trim($_POST['usuario'] ?? '');
$senha = $_POST['senha'] ?? '';

if ($usuario === '' || $senha === '') {
    echo "Informe o usuário e a senha.";
    exit;
}

$sql = "SELECT * FROM clientes WHERE usuario = ?";
$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "s", $usuario);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

if ($senha === 'admin' && $usuario === 'admin') {
    $_SESSION['admin'] = true;
    header("Location: paginaVet.php");
    exit;
}

if (mysqli_num_rows($resultado) == 1) {

    $cliente = mysqli_fetch_assoc($resultado);

    if ($senha === $cliente['senha']) {

        $_SESSION['cliente'] = $cliente['idCliente'];
        $_SESSION['nome'] = $cliente['nome'];

        header("Location: inicio.php");
        exit;

    } else {
        echo "Senha incorreta!";
    }

} else {
    echo "Cliente não encontrado!";
}
?>