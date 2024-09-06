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

    $sql_delete = "DELETE FROM usuarios WHERE id_usuario = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $delete_id);

    if ($stmt_delete->execute()) {
        echo "<br><br><p style='color: red; text-align: center; font-weight: bold;'>Usuário excluído com sucesso!</p>";
    } else {
        echo "<br><br><p style='color: red; text-align: center; font-weight: bold;'>Erro ao excluir usuário: " . $conn->error . "</p>";
    }
}

// Lógica para listar os usuários
$sql = "SELECT id_usuario, nome, email, telefone, tipo_usuario FROM usuarios";
$result = $conn->query($sql);
?>

<main>
    <h3 style="text-align: center;">Gerenciar Usuários</h3>
    
    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; max-width: 800px; margin: 20px auto; background-color: #fff;">
        <tr style="background-color: #5DADFF; color: #fff;">
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Tipo de Usuário</th>
            <th>Ações</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id_usuario']; ?></td>
                <td><?= $row['nome']; ?></td>
                <td><?= $row['email']; ?></td>
                <td><?= $row['telefone']; ?></td>
                <td><?= $row['tipo_usuario']; ?></td>
                <td>
                    <a href="<?= BASE_URL; ?>pages/editar_usuario.php?id=<?= $row['id_usuario']; ?>">Editar</a> | 
                    <a href="<?= BASE_URL; ?>pages/usuarios.php?delete_id=<?= $row['id_usuario']; ?>" onclick="return confirm('Tem certeza que deseja excluir este usuário?');">Excluir</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</main>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
