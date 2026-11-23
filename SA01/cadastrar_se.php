<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
</head>
<body>

    <h1>Cadastro de usuário</h1>

    <form action="salvar.php" method="POST">

        <label>Nome:</label>
        <input type="text" name="nome" required>

        <br><br>

        <label>Usuário:</label>
        <input type="text" name="usuario" required>

        <br><br>

        <label>Senha:</label>
        <input type="password" name="senha" required>

        <br><br>

        <button type="submit">Cadastrar</button>

    </form>

    <a href="index.php">Voltar para o login</a>

</body>
</html>