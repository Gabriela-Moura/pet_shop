<?php
include "conexao.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuario WHERE usuario = '$usuario' AND senha = '$senha'";

    $result = mysqli_query($conexao, $sql);
    if (!$result) {
        die("Erro na consulta: " . mysqli_error($conexao));
    }

    if (mysqli_num_rows($result) > 0) {
        header ("Location: listar.php");
    } else {
        $error = "Usuário ou senha inválidos.";
    }

}
?>

<!DOCTYPE html>
    <html lang = "pt-br">
    <head>
        <meta charset = "UTF-8">
        <title>FERRAMENTAS</title>
</head>
<body>
    <form method="POST" action="login.php">
        <label>USUARIO</label>
        <input type="text" required name="usuario">
        <label>SENHA</label>
        <input type="text" required name="senha">
        <button type="submit">Entrar</button>
</form>
</body>
</html>