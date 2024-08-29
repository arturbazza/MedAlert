<?php
session_start();
include_once __DIR__ . '/../config/db.php';
include_once __DIR__ . '/../includes/header.php';
include_once __DIR__ . '/../includes/menu.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ' . BASE_URL . 'pages/login.php');
    exit;
}

// Lógica para inserir um novo alerta
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data_hora_alerta = $_POST['data_hora_alerta'];
    $status_alerta = 'pendente';
    $metodo_alerta = $_POST['metodo_alerta'];
    $id_medicamento = $_POST['id_medicamento'];

    $sql = "INSERT INTO alertas (data_hora_alerta, status_alerta, metodo_alerta, id_medicamento) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $data_hora_alerta, $status_alerta, $metodo_alerta, $id_medicamento);

    if ($stmt->execute()) {
        echo "<p>Alerta adicionado com sucesso!</p>";
    } else {
        echo "<p>Erro ao adicionar alerta: " . $conn->error . "</p>";
    }
}

// Recupera a lista de medicamentos
$sql_medicamentos = "SELECT id_medicamento, nome_medicamento FROM medicamentos WHERE id_paciente IN (SELECT id_paciente FROM pacientes WHERE id_usuario = ?)";
$stmt_medicamentos = $conn->prepare($sql_medicamentos);
$stmt_medicamentos->bind_param("i", $_SESSION['id_usuario']);
$stmt_medicamentos->execute();
$result_medicamentos = $stmt_medicamentos->get_result();
?>

<main>
    <h3 style="text-align: center;">Gerenciar Alertas</h3>

    <form action="" method="POST">
        <label for="data_hora_alerta">Data e Hora do Alerta:</label>
        <input type="datetime-local" id="data_hora_alerta" name="data_hora_alerta" required>

        <label for="metodo_alerta">Método de Alerta:</label>
        <select id="metodo_alerta" name="metodo_alerta" required>
            <option value="email">Email</option>
            <option value="sms">SMS</option>
            <option value="notificacao">Notificação</option>
        </select>

        <label for="id_medicamento">Medicamento:</label>
        <select id="id_medicamento" name="id_medicamento" required>
            <?php while ($row_medicamentos = $result_medicamentos->fetch_assoc()): ?>
                <option value="<?= $row_medicamentos['id_medicamento']; ?>"><?= $row_medicamentos['nome_medicamento']; ?></option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Adicionar Alerta</button>
    </form>
</main>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
