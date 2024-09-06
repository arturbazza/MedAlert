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

// Recupera a lista de alertas, medicamentos e pacientes
$sql = "SELECT a.data_hora_alerta, a.status_alerta, a.metodo_alerta, m.nome_medicamento, p.nome AS nome_paciente 
        FROM alertas a 
        JOIN medicamentos m ON a.id_medicamento = m.id_medicamento
        JOIN pacientes p ON m.id_paciente = p.id_paciente
        WHERE p.id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['id_usuario']);
$stmt->execute();
$result = $stmt->get_result();
?>

<main>
    <h3 style="text-align: center;">Lista de Alertas</h3>

    <ul>
        <?php while ($row = $result->fetch_assoc()): ?>
            <li>
                Paciente: <?= $row['nome_paciente']; ?> <br>
                Medicamento: <?= $row['nome_medicamento']; ?> <br>
                Data e Hora do Alerta: <?= date('d/m/Y H:i', strtotime($row['data_hora_alerta'])); ?> <br>
                Método de Alerta: <?= ucfirst($row['metodo_alerta']); ?> <br>
                Status: <?= ucfirst($row['status_alerta']); ?>
            </li>
            <hr>
        <?php endwhile; ?>
    </ul>
</main>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
