<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'conexao.php';
include 'funcoes.php';

$id = $_POST['id'] ?? $_GET['id'];
$ferramentas = buscarFerramenta($conexao, $id);
$nome = $_POST['nome'] ?? null;
$fabricante = $_POST['idUsuario'] ?? null;
$marca = $_POST['marca'] ?? null;
$modelo = $_POST['modelo'] ?? null;
$peso = $_POST['peso'] ?? null;
$material = $_POST['material'] ?? null;
$tamanho = $_POST['tamanho'] ?? null;
$tensao_eletrica = $_POST['tensao_eletrica'] ?? null;
$estoque =  $_POST['estoque'] ?? null;
$estoque_minimo = $_POST['estoque_minimo'] ?? null;

$editar = $nome !== null && editar($conexao, $id, $nome, $fabricante, $marca, $modelo, $peso, $material, $tamanho, $tensao_eletrica, $estoque, $estoque_minimo);
$fabricantes = buscarFabricante($conexao);

if ($editar) {
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
    <form method="post" action="editar.php">
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <label>NOME</label>
        <input type="text" name='nome' value="<?php echo htmlspecialchars($ferramentas['nome'])?>">
        <label>FABRICANTE</label>
        <select name="idUsuario" required>
            <option value="">Selecione um fabricante</option>

            <?php while ($fabricante = mysqli_fetch_assoc($fabricantes)): ?>
                <option
                    value="<?php echo htmlspecialchars($fabricante['idUsuario']); ?>"
                    <?php echo ($fabricante['idUsuario'] == $ferramentas['idUsuario']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($fabricante['nome']); ?>
                </option>
            <?php endwhile; ?>
        </select>
        <label>MARCA</label>
        <input type="text" name='marca'value="<?php echo htmlspecialchars($ferramentas['marca'])?>">
        <label>MODELO</label>
        <input type="text" name='modelo' value="<?php echo htmlspecialchars($ferramentas['modelo'])?>">
        <label>PESO</label>
        <input type="text" name='peso' value="<?php echo htmlspecialchars($ferramentas['peso'])?>">
        <label>MATERIAL</label>
        <input type="text" name='material' value="<?php echo htmlspecialchars($ferramentas['material'])?>">
        <label>TAMANHO</label>
        <input type="text" name='tamanho' value="<?php echo htmlspecialchars($ferramentas['tamanho'])?>">
        <label>TENSÃO</label>
        <input type="text" name='tensao_eletrica' value="<?php echo htmlspecialchars($ferramentas['tensao_eletrica'])?>">
        <label>ESTOQUE</label>
        <input type="number" name='estoque' value="<?php echo htmlspecialchars($ferramentas['estoque'])?>">
        <label>ESTOQUE MÍNIMO</label>
        <input type="number" name='estoque_minimo' value="<?php echo htmlspecialchars($ferramentas['estoque_minimo'])?>">

        <button type="submit">Salvar alterações</button>
</form>