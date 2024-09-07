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

// Recupera o alerta para edição
if (isset($_GET['id'])) {
    $id_alerta = $_GET['id'];

    $sql = "SELECT * FROM alertas WHERE id_alerta = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_alerta);
    $stmt->execute();
    $result = $stmt->get_result();
    $alerta = $result->fetch_assoc();
}

// Atualiza o alerta
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_alerta = $_POST['id_alerta'];
    $data_alerta = $_POST['data_alerta'];
    $hora_alerta = $_POST['hora_alerta'];
    $metodo_alerta = $_POST['metodo_alerta'];
    $status_alerta = $_POST['status_alerta'];

    $data_formatada = DateTime::createFromFormat('d/m/Y', $data_alerta)->format('Y-m-d');
    $data_hora_alerta = $data_formatada . ' ' . $hora_alerta . ':00';

    $sql = "UPDATE alertas SET data_hora_alerta = ?, metodo_alerta = ?, status_alerta = ? WHERE id_alerta = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $data_hora_alerta, $metodo_alerta, $status_alerta, $id_alerta);

    if ($stmt->execute()) {
        echo "<p style='color: green; text-align: center;'>Alerta atualizado com sucesso!</p>";
    } else {
        echo "<p style='color: red; text-align: center;'>Erro ao atualizar alerta: " . $conn->error . "</p>";
    }
}
?>

<main>
    <h3 style="text-align: center;">Editar Alerta</h3>

    <form action="" method="POST">
        <input type="hidden" name="id_alerta" value="<?= $alerta['id_alerta']; ?>">

        <label for="data_alerta">Data do Alerta:</label>
        <input type="text" id="data_alerta" name="data_alerta" value="<?= date('d/m/Y', strtotime($alerta['data_hora_alerta'])); ?>" required>

        <label for="hora_alerta">Hora do Alerta:</label>
        <input type="time" id="hora_alerta" name="hora_alerta" value="<?= date('H:i', strtotime($alerta['data_hora_alerta'])); ?>" required>

        <label for="metodo_alerta">Método de Alerta:</label>
        <select id="metodo_alerta" name="metodo_alerta">
            <option value="email" <?= ($alerta['metodo_alerta'] == 'email') ? 'selected' : ''; ?>>Email</option>
            <option value="sms" <?= ($alerta['metodo_alerta'] == 'sms') ? 'selected' : ''; ?>>SMS</option>
            <option value="notificacao" <?= ($alerta['metodo_alerta'] == 'notificacao') ? 'selected' : ''; ?>>Notificação</option>
        </select>

        <label for="status_alerta">Status do Alerta:</label>
        <select id="status_alerta" name="status_alerta">
            <option value="pendente" <?= ($alerta['status_alerta'] == 'pendente') ? 'selected' : ''; ?>>Pendente</option>
            <option value="concluido" <?= ($alerta['status_alerta'] == 'concluido') ? 'selected' : ''; ?>>Concluído</option>
        </select>

        <button type="submit">Salvar</button>
    </form>
</main>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
