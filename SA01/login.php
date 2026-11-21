<?php
include "conexao.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarioo WHERE usuario = '$usuario";
?>

<DOCTYPE html>
    <html lang = "pt-br">
    <head>
        <meta charset = "UTF-8">
        <title>FERRAMENTAS</title>
</head>
<body>
    <form method="POST" action="login.php">
        <label>USUARIO</label>
        <input type="text" required value="usuario">
        <label>SENHA</label>
        <input type="text" required value="senha">
        <button type="submit">Entrar</button>
</form>
</body>
</html>

<?php
    if ($senha == $sql(usu)) {

    }
?>