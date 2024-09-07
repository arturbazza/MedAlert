<?php
session_start();
include_once __DIR__ . '/../config/db.php';
include_once __DIR__ . '/../includes/header.php';
include_once __DIR__ . '/../includes/menu.php';

$id_medicamento = $_GET['id'];

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ' . BASE_URL . 'pages/login.php');
    exit;
}

// Lógica de edição do medicamento
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_medicamento = $_POST['nome_medicamento'];
    $dosagem = $_POST['dosagem'];
    $frequencia = $_POST['frequencia'];
    $descricao = $_POST['descricao'];

    $sql = "UPDATE medicamentos SET nome_medicamento = ?, dosagem = ?, frequencia = ?, descricao = ? WHERE id_medicamento = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nome_medicamento, $dosagem, $frequencia, $descricao, $id_medicamento);

    if ($stmt->execute()) {
        echo "<p style='color: green; text-align: center;'>Medicamento atualizado com sucesso!</p>";
    } else {
        echo "<p style='color: red; text-align: center;'>Erro ao atualizar medicamento: " . $conn->error . "</p>";
    }
}

// Recupera os dados do medicamento
$sql_medicamento = "SELECT * FROM medicamentos WHERE id_medicamento = ?";
$stmt_medicamento = $conn->prepare($sql_medicamento);
$stmt_medicamento->bind_param("i", $id_medicamento);
$stmt_medicamento->execute();
$medicamento = $stmt_medicamento->get_result()->fetch_assoc();
?>

<main>
    <h3 style="text-align: center;">Editar Medicamento</h3>

    <form action="" method="POST" style="max-width: 450px; margin: 0 auto;">
        <div style="display: flex; flex-direction: column; gap: 12px;">
            <label for="nome_medicamento">Nome do Medicamento:</label>
            <input type="text" id="nome_medicamento" name="nome_medicamento" value="<?= htmlspecialchars($medicamento['nome_medicamento']); ?>" required>

            <label for="dosagem">Dosagem:</label>
            <input type="text" id="dosagem" name="dosagem" value="<?= htmlspecialchars($medicamento['dosagem']); ?>" required>

            <label for="frequencia">Frequência:</label>
            <input type="text" id="frequencia" name="frequencia" value="<?= htmlspecialchars($medicamento['frequencia']); ?>" required>

            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" rows="2" required><?= htmlspecialchars($medicamento['descricao']); ?></textarea>

            <button type="submit">Atualizar Medicamento</button>
        </div>
    </form>
</main>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
