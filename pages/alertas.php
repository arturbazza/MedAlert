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
    $data_alerta = $_POST['data_alerta']; // Recebe a data no formato dd/mm/aaaa
    $hora_alerta = $_POST['hora_alerta']; // Recebe a hora no formato HH:mm
    $status_alerta = 'pendente';
    $metodo_alerta = $_POST['metodo_alerta'];
    $id_medicamento = $_POST['id_medicamento'];

    // Converte a data de dd/mm/aaaa para aaaa-mm-dd
    $data_formatada = DateTime::createFromFormat('d/m/Y', $data_alerta)->format('Y-m-d');
    // Concatena a data e a hora para o formato MySQL
    $data_hora_alerta = $data_formatada . ' ' . $hora_alerta . ':00';

    $sql = "INSERT INTO alertas (data_hora_alerta, status_alerta, metodo_alerta, id_medicamento) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $data_hora_alerta, $status_alerta, $metodo_alerta, $id_medicamento);

    if ($stmt->execute()) {
        echo "<p style='color: green; text-align: center;'>Alerta adicionado com sucesso!</p>";
    } else {
        echo "<p style='color: red; text-align: center;'>Erro ao adicionar alerta: " . $conn->error . "</p>";
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
        <label for="data_alerta">Data do Alerta:</label>
        <input type="text" id="data_alerta" name="data_alerta" placeholder="dd/mm/aaaa" pattern="\d{2}/\d{2}/\d{4}" required>

        <label for="hora_alerta">Hora do Alerta:</label>
        <input type="time" id="hora_alerta" name="hora_alerta" required>

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
