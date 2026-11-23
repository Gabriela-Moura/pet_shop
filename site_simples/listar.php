<?php
include "conexao.php";
include "funcoes.php";

if (isset($_GET['excluir'])){
    excluirProduto($conexao, $_GET['excluir']);
    header("Location: listar.php");
} 

$produtos = listarProdutos($conexao);
echo "Quantidade de produtos: " . mysqli_num_rows($produtos);
?>

<DOCTYPE html>
<html lang='pt-br'>
<head>
    <html charset UTF-8>
    <title>LISTAR</title>
</head>
<body>
    <table border='1'>
        <tr><th>Nome</th><th>Tamanho</th><th>Estoque</th><th>Ações</th></tr>
        <td> <?php while ($produto = mysqli_fetch_assoc($produtos)) { ?> </td>
        <tr>
            <td><?php echo htmlspecialchars($produto['nome'])?></td>
            <td><?php echo htmlspecialchars($produto['tamanho'])?></td>
            <td>
                <?php 
                    echo $produto['estoque'];
                    if($produto['estoque'] <= $produto['estoque_minimo']) {
                        echo "ESTOQUE BAIXO!";
                    };
                ?>
            </td>
            <td><a href="alterar.php?id=<?php echo $produto['id']; ?>">Editar</a> | <a href="listar.php?excluir=<?php echo $produto['id'] ?>">Excluir</a></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
