<?php
include 'conexao.php';
include 'funcoes.php';

$id = $_POST['id'] ?? $_GET['id'];
$ferramentas = buscarFerramenta($conexao, $id);
$nome = $_POST['nome'] ?? null;
$marca = $_POST['marca'] ?? " ";
$modelo = $_POST['modelo'] ?? " ";
$categoria = $_POST['categoria'] ?? " ";
$material = $_POST['material'] ?? " ";
$tamanho = $_POST['tamanho'] ?? " ";
$peso = $_POST['peso'] ?? " ";
$tensao = $_POST['tensao'] ?? " ";
$caracteristicas = $_POST['caracteristicas'] ?? " ";
$estoque = $_POST['estoque'] ?? " ";
$estoque_minimo = $_POST['estoque_minimo'] ?? " ";

$alterar = $nome !== null && alterar_dados($conexao, $id, $ferramentas, $nome, $marca, $modelo, $categoria, $material, $tamanho, $peso, $tensao, $caracteristicas, $estoque, $estoque_minimo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ALTERAR</title>
</head>
<body>
    <h1>EDITAR DADOS</h1>
    <form method='post' action='alterar.php'>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label>NOME</label>
        <input type='text' value='<?php echo htmlspecialchars($ferramentas['nome']); ?>' name='nome'>
        <label>MARCA</label>
        <input required name="marca" value="<?php echo htmlspecialchars($ferramentas['marca']); ?>"><br><br>
        <label>Modelo</label>
        <input required name="modelo" value="<?php echo htmlspecialchars($ferramentas['modelo']); ?>"><br><br>
        <label>Categoria</label>
        <input required name="categoria" value="<?php echo htmlspecialchars($ferramentas['categoria']); ?>"><br><br>
        <label>Material ou cabo</label>
        <input name="material" value="<?php echo htmlspecialchars($ferramentas['material']); ?>"><br><br>
        <label>Tamanho</label>
        <input name="tamanho" value="<?php echo htmlspecialchars($ferramentas['tamanho']); ?>"><br><br>
        <label>Peso</label>
        <input name="peso" value="<?php echo htmlspecialchars($ferramentas['peso']); ?>"><br><br>
        <label>Tensão elétrica</label>
        <input name="tensao" value="<?php echo htmlspecialchars($ferramentas['tensao']); ?>"><br><br>
        <label>Estoque atual</label>
        <input required min="0" type="number" name="estoque" value="<?php echo htmlspecialchars($ferramentas['estoque']); ?>"><br><br>
        <label>Alerta abaixo de</label>
        <input required min="0" type="number" name="estoque_minimo" value="<?php echo htmlspecialchars($ferramentas['estoque_minimo']); ?>"><br><br>
        <button type="submit">Salvar alteração</button>
    </form>
    <?php if ($alterar) { ?>
        <p>Alteração realizada com sucesso!</p>
    <?php
        header("Location: listar.php");
    } ?>
</body>
</html>
