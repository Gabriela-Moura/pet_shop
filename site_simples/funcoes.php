<?php
include "conexao.php";

function cadastrar_ferramenta($conexao, $nome, $marca, $modelo, $categoria, $material, $tamanho, $peso, $tensao, $caracteristicas, $estoque, $estoque_minimo){
    $sql = "INSERT INTO ferramentas(nome, marca, modelo, categoria, material, tamanho, peso, tensao, caracteristicas, estoque, estoque_minimo) VALUES('$nome', '$marca', '$modelo', '$categoria', '$material', '$tamanho', '$peso', '$tensao', '$caracteristicas', '$estoque', '$estoque_minimo')";

    return mysqli_query($conexao, $sql);
}

function excluirProduto($conexao, $id) {
    $id = (int)$id;
    return mysqli_query($conexao, "DELETE FROM ferramentas WHERE id = $id");
}

function listarProdutos($conexao) {
    $sql = "SELECT * FROM ferramentas";
    return mysqli_query($conexao, $sql);
}

function alterar_dados($conexao, $id, $ferramentas, $nome, $marca, $modelo, $categoria, $material, $tamanho, $peso, $tensao, $caracteristicas, $estoque, $estoque_minimo){
    $sql = "UPDATE ferramentas SET nome='$nome', marca='$marca', modelo='$modelo', categoria='$categoria', material='$material', tamanho='$tamanho', peso='$peso', tensao='$tensao', caracteristicas='$caracteristicas', estoque='$estoque', estoque_minimo='$estoque_minimo' WHERE id = $id"; 

    return mysqli_query($conexao, $sql);
}

function buscarFerramenta($conexao, $id) {
    $id = (int)$id;
    $sql = "SELECT * FROM ferramentas WHERE id = $id";
    return mysqli_fetch_assoc(mysqli_query($conexao, $sql));
}
?>