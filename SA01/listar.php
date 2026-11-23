<?php
include 'conexao.php';
include 'funcoes.php';

$ferramentas = listarFerramentas($conexao);

if(isset($_GET['excluir'])) {
    excluirFerramenta($conexao, $_GET['excluir']);
    header("Location: listar.php");
    exit;
}

?>

<!DOCTYPE html>
    <html lang = "pt-br">
    <head>
        <meta charset = "UTF-8">
        <title>FERRAMENTAS</title>
</head>
<body>
    <h1>LISTA DE FERRAMENTAS</h1>
    <table border='1'>
        <tr>
        <th>Nome</th>
        <th>Fabricante</th>
        <th>Marca</th>
        <th>Modelo</th>
        <th>Peso</th>
        <th>Material</th>
        <th>Tamanho</th>
        <th>Tensão Elétrica</th>
        <th>Estoque</th>
        <th>Ações</th>
    </tr>
        <?php while ($ferramenta = mysqli_fetch_assoc($ferramentas)) { ?>
        <tr>
            <td><?php echo htmlspecialchars($ferramenta['nome'])?></td>
            <td><?php echo htmlspecialchars($ferramenta['nome_fabricante'])?></td>
            <td><?php echo htmlspecialchars($ferramenta['marca'])?></td>
            <td><?php echo htmlspecialchars($ferramenta['modelo'])?></td>
            <td><?php echo htmlspecialchars($ferramenta['peso'])?></td>
            <td><?php echo htmlspecialchars($ferramenta['material'])?></td>
            <td><?php echo htmlspecialchars($ferramenta['tamanho'])?></td>
            <td><?php echo htmlspecialchars($ferramenta['tensao_eletrica'])?></td>
            <td><?php echo htmlspecialchars($ferramenta['estoque'])?></td>
            <td>
                <a href="editar.php?id=<?php echo htmlspecialchars($ferramenta['id']); ?>">Editar</a> |
                <a href="listar.php?excluir=<?php echo htmlspecialchars($ferramenta['id']); ?>">Excluir</a>
            </td>
        </tr>
        <?php } ?>
    </table>
    <form method="POST" action="cadastrar.php">
        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>