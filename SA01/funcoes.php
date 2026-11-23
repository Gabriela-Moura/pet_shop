<?php
include 'conexao.php';

function buscarFerramenta($conexao, $id) {
    $sql = "SELECT ferramentas.*, usuario.nome AS nome_fabricante
        FROM ferramentas
        INNER JOIN usuario
        ON ferramentas.idUsuario = usuario.idUsuario
        WHERE ferramentas.id = '$id'";

    $resultado = mysqli_query($conexao, $sql);

    return mysqli_fetch_assoc($resultado);
}
function listarFerramentas($conexao) {
    $sql = "SELECT ferramentas.*, usuario.nome AS nome_fabricante
        FROM ferramentas
        INNER JOIN usuario
        ON ferramentas.idUsuario = usuario.idUsuario";

    return mysqli_query($conexao, $sql);
};

function salvar($conexao, $nome, $idUsuario, $marca, $modelo, $peso, $material, $tamanho, $tensao_eletrica, $estoque, $estoque_minimo) {
    $sql = "INSERT INTO ferramentas(nome, idUsuario, marca, modelo, peso, material, tamanho, tensao_eletrica, estoque, estoque_minimo) VALUES ('$nome', '$idUsuario', '$marca', '$modelo', '$peso', '$material', '$tamanho', '$tensao_eletrica', '$estoque', '$estoque_minimo')";

    return mysqli_query($conexao, $sql);
};

function editar($conexao, $id, $nome, $idUsuario, $marca, $modelo, $peso, $material, $tamanho, $tensao_eletrica, $estoque, $estoque_minimo) {
    $sql = "UPDATE ferramentas SET nome = '$nome', idUsuario = '$idUsuario', marca = '$marca', modelo = '$modelo', peso = '$peso', material = '$material', tamanho = '$tamanho', tensao_eletrica = '$tensao_eletrica', estoque = '$estoque', estoque_minimo = '$estoque_minimo' WHERE id = '$id'";

    return mysqli_query($conexao, $sql);
};

function buscarFabricante($conexao) {
    $sql = "SELECT idUsuario, nome FROM usuario";

    return mysqli_query($conexao, $sql);
}

function excluirFerramenta($conexao, $id){
    $id = (int)$id;
    $sql = "DELETE from ferramentas WHERE id = $id";
    return mysqli_query($conexao, $sql);
};
?>