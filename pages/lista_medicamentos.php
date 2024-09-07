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

// Recupera a lista de medicamentos e pacientes
$sql = "SELECT m.id_medicamento, m.nome_medicamento, m.dosagem, m.frequencia, m.descricao, p.nome AS nome_paciente
        FROM medicamentos m
        JOIN pacientes p ON m.id_paciente = p.id_paciente
        WHERE p.id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['id_usuario']);
$stmt->execute();
$result = $stmt->get_result();
?>

<main>
    <h3 style="text-align: center;">Gerenciar Medicamentos</h3>
    <table class="styled-table">
        <thead>
            <tr>
                <th>Nome do Medicamento</th>
                <th>Dosagem</th>
                <th>Frequência</th>
                <th>Descrição</th>
                <th>Paciente</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nome_medicamento']); ?></td>
                    <td><?= htmlspecialchars($row['dosagem']); ?> mg</td>
                    <td><?= htmlspecialchars($row['frequencia']); ?> horas/dias</td>
                    <td><?= htmlspecialchars($row['descricao']); ?></td>
                    <td><?= htmlspecialchars($row['nome_paciente']); ?></td>
                    <td>
                        <a href="editar_medicamento.php?id=<?= $row['id_medicamento']; ?>" class="btn-edit">Editar</a>
                        <a href="deletar_medicamento.php?id=<?= $row['id_medicamento']; ?>" class="btn-delete" onclick="return confirm('Tem certeza que deseja excluir este medicamento?')">Excluir</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
