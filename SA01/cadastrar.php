<?php
include 'conexao.php';
include 'funcoes.php';

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

$cadastrar = $nome !== null && salvar($conexao, $nome, $fabricante, $marca, $modelo, $peso, $material, $tamanho, $tensao_eletrica, $estoque, $estoque_minimo);
$fabricantes = buscarFabricante($conexao);
?>

<!DOCTYPE html>
    <html lang = "pt-br">
    <head>
        <meta charset = "UTF-8">
        <title>FERRAMENTAS</title>
</head>
<body>
    <form method="post" action="cadastrar.php">
        <label>NOME</label>
        <input type="text" name='nome'required>
        <label>FABRICANTE</label>
        <select name='idUsuario' required>
            <option value="">Selecione um fabricante</option>
            <?php while ($fabricante = mysqli_fetch_assoc($fabricantes)): ?>
                <option value="<?php echo htmlspecialchars($fabricante['idUsuario']) ?>"><?php echo htmlspecialchars($fabricante['nome']) ?></option>
            <?php endwhile; ?>
        </select>
        <label>MARCA</label>
        <input type="text" name='marca'required>
        <label>MODELO</label>
        <input type="text" name='modelo'required>
        <label>PESO</label>
        <input type="text" name='peso'required>
        <label>MATERIAL</label>
        <input type="text" name='material'required>
        <label>TAMANHO</label>
        <input type="text" name='tamanho'required>
        <label>TENSÃO</label>
        <input type="text" name='tensao_eletrica'required>
        <label>ESTOQUE</label>
        <input type="number" name='estoque'required>
        <label>ESTOQUE MÍNIMO</label>
        <input type="number" name='estoque_minimo'required>

        <button type="submit">Cadastrar</button>
</form>