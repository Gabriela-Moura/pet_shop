<?php
include "conexao.php";
include "funcoes.php";
var_dump($_POST);

$nome = $_POST['nome'] ?? null;
$marca = $_POST['marca'] ?? "Não informado";
$modelo = $_POST['modelo'] ?? "Não informado";
$categoria = $_POST['categoria'] ?? "Não informado";
$material = $_POST['material'] ?? "Não informado";
$tamanho = $_POST['tamanho'] ?? "Não informado";
$peso = $_POST['peso'] ?? "Não informado";
$tensao = $_POST['tensao'] ?? "Não informado";
$caracteristicas = $_POST['caracteristicas'] ?? "Não informado";
$estoque = $_POST['estoque'] ?? "Não informado";
$estoque_minimo = $_POST['estoque_minimo'] ?? "Não informado";

$salvar = $nome !== null && cadastrar_ferramenta($conexao, $nome, $marca, $modelo, $categoria, $material, $tamanho, $peso, $tensao, $caracteristicas, $estoque, $estoque_minimo);
?>

<DOCTYPE html>
<html lang='pt-br'>
    <head>
        <html charset UTF-8>
        <title>CADASTRAR</title>
        <link rel='stylesheet' href='style.css'>
    <head>
<body>
    <h1>FORMULÁRIO DE CADASTRO</h1>
    <form method='post' action='cadastrar.php'>
        <label>NOME</label>
        <input type='text' required name='nome'>
        <label>MARCA</label>
        <input type='text' required name='marca'>
        <label>MODELO</label>
        <input type='text' required name='modelo'>
        <label>CATEGORIA</label>
        <input type='text' required name='categoria'>
        <label>MATERIAL</label>
        <input type='text' required name='material'>
        <label>TAMANHO</label>
        <input type='text' required name='tamanho'>
        <label>PESO</label>
        <input type='text' required name='peso'>
        <label>TENSAO</label>
        <input type='text' required name='tensao'>
        <label>CARACTERISTICAS</label>
        <input type='text' required name='caracteristicas'>
        <label>ESTOQUE</label>
        <input type='number' required name='estoque'>
        <label>ESTOQUE_MINIMO</label>
        <input type='number' required name='estoque_minimo'>
        <button type='submit'>CADASTRAR</button>
    </form>
</body>
</html>
