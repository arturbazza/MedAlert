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

// Lógica para exclusão de usuário
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Verifica se o usuário tem pacientes vinculados
    $sql_check = "SELECT COUNT(*) AS total FROM pacientes WHERE id_usuario = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("i", $delete_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row_check = $result_check->fetch_assoc();

    if ($row_check['total'] > 0) {
        echo "<br><br><p style='color: red; text-align: center; font-weight: bold;'>Este usuário tem pacientes vinculados e não pode ser excluído sem removê-los.</p>";
    } else {
        $sql_delete = "DELETE FROM usuarios WHERE id_usuario = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("i", $delete_id);

        if ($stmt_delete->execute()) {
            echo "<br><br><p style='color: red; text-align: center; font-weight: bold;'>Usuário excluído com sucesso!</p>";
        } else {
            echo "<br><br><p style='color: red; text-align: center; font-weight: bold;'>Erro ao excluir usuário: " . $conn->error . "</p>";
        }
    }
}

// Lógica para listar os usuários
$sql = "SELECT id_usuario, nome, email, telefone, tipo_usuario FROM usuarios";
$result = $conn->query($sql);
?>

<main>
    <h3 style="text-align: center;">Gerenciar Usuários</h3>
    
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; max-width: 800px; margin: 20px auto; background-color: #fff;">
        <tr style="background-color: #f2f2f2;">
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Tipo de Usuário</th>
            <th>Ação</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id_usuario']; ?></td>
                <td><?= $row['nome']; ?></td>
                <td><?= $row['email']; ?></td>
                <td><?= $row['telefone']; ?></td>
                <td><?= ucfirst($row['tipo_usuario']); ?></td>
                <td>
                    <a href="editar_usuario.php?id=<?= $row['id_usuario']; ?>">Editar</a> | 
                    <a href="?delete_id=<?= $row['id_usuario']; ?>" onclick="return confirm('Tem certeza que deseja excluir este usuário?');">Excluir</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</main>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
