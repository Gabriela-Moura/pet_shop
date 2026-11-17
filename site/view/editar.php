
<?php
session_start();
include "config/conexao.php";

$id = $_GET['id'];

$sql = "SELECT * FROM consultas WHERE idConsulta = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);
$consultas = mysqli_fetch_assoc($resultado);

// Buscar animais do cliente logado
$sql = "SELECT * FROM animais WHERE idCliente = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $_SESSION['cliente']);
mysqli_stmt_execute($stmt);
$animais = mysqli_stmt_get_result($stmt);

// Separar data e horário da consulta original
$dataAtual = date('Y-m-d', strtotime($consultas['data_hora']));
$horarioAtual = date('H:i', strtotime($consultas['data_hora']));
?>

<link rel="stylesheet" href="style.css">

<h2>Editar Consulta</h2>

<form action="controllers/atualizar.php" method="post">

    <input type="hidden" name="idConsulta"
    value="<?= $consultas['idConsulta'] ?>">

    Animal:
    <select name="idAnimal" required>
        <?php while ($animal = mysqli_fetch_assoc($animais)) { ?>
            <option value="<?= $animal['idAnimal'] ?>"
                <?= $animal['idAnimal'] == $consultas['idAnimal'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($animal['nome']) ?>
            </option>
        <?php } ?>
    </select><br>

    Descrição:
    <input type="text" name="descricao" class="editar"
    value="<?= htmlspecialchars($consultas['descricao']) ?>" required><br>

    Data:
    <input type="date" name="data" id="data"
    value="<?= $dataAtual ?>" min="<?= date('Y-m-d') ?>" required><br>

    Horário:
    <select name="horario" id="horario" required>
        <option value="<?= $horarioAtual ?>">
            <?= $horarioAtual ?>
        </option>
    </select><br>

    Preço:
    <input type="number" name="preco" class="editar"
    step="0.01" value="<?= $consultas['preco'] ?>" required><br>

    <button type="submit">Atualizar</button>
</form>

<script>
const dataInput = document.getElementById('data');
const selectHorario = document.getElementById('horario');

const horarioAtual = <?= json_encode($horarioAtual) ?>;
const idConsulta = <?= json_encode($consultas['idConsulta']) ?>;

function carregarHorarios(data, horarioSelecionado = '') {

    selectHorario.innerHTML = '<option value="">Carregando...</option>';

    fetch('horarios_disponiveis.php?data=' + data
        + '&idConsulta=' + idConsulta)

        .then(response => response.text())

        .then(html => {
            selectHorario.innerHTML = html;

            if (horarioSelecionado) {
                const opcao = [...selectHorario.options].find(
                    option => option.value === horarioSelecionado
                );

                if (opcao) {
                    opcao.selected = true;
                }
            }

            if (selectHorario.options.length === 0) {
                selectHorario.innerHTML =
                    '<option value="">Todos os horários ocupados</option>';
            }
        });
}

// Carregar os horários da data original
carregarHorarios(dataInput.value, horarioAtual);

// Atualizar horários quando mudar a data
dataInput.addEventListener('change', function() {
    carregarHorarios(this.value);
});
</script>
