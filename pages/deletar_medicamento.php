<?php
session_start();
include_once __DIR__ . '/../config/db.php';

$id_medicamento = $_GET['id'];

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ' . BASE_URL . 'pages/login.php');
    exit;
}

// Verifica se o medicamento pode ser excluído (checar conflitos com alertas)
$sql_verificar_alertas = "SELECT COUNT(*) AS total_alertas FROM alertas WHERE id_medicamento = ?";
$stmt_verificar_alertas = $conn->prepare($sql_verificar_alertas);
$stmt_verificar_alertas->bind_param("i", $id_medicamento);
$stmt_verificar_alertas->execute();
$total_alertas = $stmt_verificar_alertas->get_result()->fetch_assoc()['total_alertas'];

if ($total_alertas > 0) {
    echo "<p style='color: red; text-align: center;'>Este medicamento está vinculado a alertas e não pode ser excluído.</p>";
    exit;
}

// Exclui o medicamento
$sql = "DELETE FROM medicamentos WHERE id_medicamento = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_medicamento);

if ($stmt->execute()) {
    header('Location: lista_medicamentos.php');
} else {
    echo "<p style='color: red; text-align: center;'>Erro ao excluir medicamento: " . $conn->error . "</p>";
}
?>
