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
$sql = "SELECT a.id_alerta, a.data_hora_alerta, a.status_alerta, a.metodo_alerta, m.nome_medicamento, p.nome AS nome_paciente 
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
    <h3 style="text-align: center;">Gerenciar de Alertas</h3>
    <table class="styled-table">
        <thead>
            <tr>
                <th>Paciente</th>
                <th>Medicamento</th>
                <th>Data e Hora</th>
                <th>Método</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['nome_paciente']; ?></td>
                    <td><?= $row['nome_medicamento']; ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($row['data_hora_alerta'])); ?></td>
                    <td><?= ucfirst($row['metodo_alerta']); ?></td>
                    <td><?= ucfirst($row['status_alerta']); ?></td>
                    <td>
                        <a href="editar_alerta.php?id=<?= $row['id_alerta']; ?>" class="btn-edit">Editar</a>
                        <a href="deletar_alerta.php?id=<?= $row['id_alerta']; ?>" class="btn-delete" onclick="return confirm('Tem certeza que deseja excluir este alerta?');">Deletar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
