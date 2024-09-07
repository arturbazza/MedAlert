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

// Lógica para exclusão de paciente
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $sql_delete = "DELETE FROM pacientes WHERE id_paciente = ? AND id_usuario = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("ii", $delete_id, $_SESSION['id_usuario']);

    if ($stmt_delete->execute()) {
        echo "<br><br><p style='color: red; text-align: center; font-weight: bold;'>Paciente excluído com sucesso!</p>";
    } else {
        echo "<br><br><p style='color: red; text-align: center; font-weight: bold;'>Erro ao excluir paciente: " . $conn->error . "</p>";
    }
}

// Lógica para listar os pacientes
$sql = "SELECT id_paciente, nome, data_nascimento, sexo, telefone, endereco FROM pacientes WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['id_usuario']);
$stmt->execute();
$result = $stmt->get_result();
?>

<main>
    <h3 style="text-align: center;">Gerenciar Pacientes</h3>
    
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; max-width: 800px; margin: 20px auto; background-color: #fff;">
        <tr style="background-color: #f2f2f2;">
            <th>ID</th>
            <th>Nome</th>
            <th>Data de Nascimento</th>
            <th>Sexo</th>
            <th>Telefone</th>
            <th>Endereço</th>
            <th>Ação</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id_paciente']; ?></td>
                <td><?= $row['nome']; ?></td>
                <td><?= date('d/m/Y', strtotime($row['data_nascimento'])); ?></td>
                <td><?= $row['sexo']; ?></td>
                <td><?= $row['telefone']; ?></td>
                <td><?= $row['endereco']; ?></td>
                <td>
                    <a href="editar_paciente.php?id=<?= $row['id_paciente']; ?>">Editar</a> | 
                    <a href="?delete_id=<?= $row['id_paciente']; ?>" onclick="return confirm('Tem certeza que deseja excluir este paciente?');">Excluir</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</main>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
