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

// Verifica se o usuário tem permissão para editar outros usuários
// if ($_SESSION['tipo_usuario'] != 'admin') {
//     echo "<p style='color:red;'>Você não tem permissão para acessar esta página.</p>";
//     include_once __DIR__ . '/../includes/footer.php';
//     exit;
// }

// Lógica para atualizar o usuário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario = $_POST['id_usuario'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $tipo_usuario = $_POST['tipo_usuario'];

    $sql_update = "UPDATE usuarios SET nome = ?, email = ?, telefone = ?, tipo_usuario = ? WHERE id_usuario = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssssi", $nome, $email, $telefone, $tipo_usuario, $id_usuario);

    if ($stmt_update->execute()) {
        echo "<p>Usuário atualizado com sucesso!</p>";
    } else {
        echo "<p>Erro ao atualizar usuário: " . $conn->error . "</p>";
    }
}

// Lógica para buscar as informações do usuário
if (isset($_GET['id'])) {
    $id_usuario = $_GET['id'];

    $sql = "SELECT * FROM usuarios WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
    } else {
        echo "<p>Usuário não encontrado.</p>";
        include_once __DIR__ . '/../includes/footer.php';
        exit;
    }
}
?>

<main>
    <h3 style="text-align: center;">Editar Usuário</h3>
    <form action="" method="POST">
        <input type="hidden" name="id_usuario" value="<?= $usuario['id_usuario']; ?>">
        
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?= $usuario['nome']; ?>" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= $usuario['email']; ?>" required>
        
        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone" value="<?= $usuario['telefone']; ?>" required>
        
        <label for="tipo_usuario">Tipo de Usuário:</label>
        <select id="tipo_usuario" name="tipo_usuario" required>
            <option value="cuidador" <?= $usuario['tipo_usuario'] == 'cuidador' ? 'selected' : ''; ?>>Cuidador</option>
            <option value="enfermeiro" <?= $usuario['tipo_usuario'] == 'enfermeiro' ? 'selected' : ''; ?>>Enfermeiro</option>
            <option value="medico" <?= $usuario['tipo_usuario'] == 'medico' ? 'selected' : ''; ?>>Médico</option>
        </select>
        
        <button type="submit">Salvar Alterações</button>
    </form>
</main>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
