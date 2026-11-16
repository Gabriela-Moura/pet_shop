
<?php
include "conexao.php";
session_start();

$sql = "SELECT * FROM animais WHERE idCliente = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $_SESSION['cliente']);
mysqli_stmt_execute($stmt);
$animais = mysqli_stmt_get_result($stmt);
?>

<h2>Agendar Nova Consulta</h2>

<form action="salvar_consulta.php" method="POST">

    Animal:
    <select name="idAnimal" required>
        <?php while ($animal = mysqli_fetch_assoc($animais)) { ?>
            <option value="<?= $animal['idAnimal'] ?>">
                <?= htmlspecialchars($animal['nome']) ?>
            </option>
        <?php } ?>
    </select><br>

    Descrição:
    <input type="text" name="descricao" required><br>

    Data:
    <input type="date" name="data" id="data" required><br>

    Horário:
    <select name="horario" id="horario" required>
        <option value="">Selecione uma data primeiro</option>
    </select><br>

    Preço:
    <input type="number" name="preco" step="0.01" required><br>

    <button type="submit">Agendar</button>

</form>


<script>
document.getElementById('data').addEventListener('change', function() {

    const data = this.value;
    const select = document.getElementById('horario');

    select.innerHTML = '<option value="">Carregando...</option>';

    fetch('horarios_disponiveis.php?data=' + data)
        .then(response => response.text())
        .then(html => {
            select.innerHTML = html;

            if (html.trim() === '') {
                select.innerHTML =
                    '<option value="">Todos os horários ocupados</option>';
            }
        });
});
</script>

