<?php
session_start();
include_once __DIR__ . '/../config/db.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ' . BASE_URL . 'pages/login.php');
    exit;
}

// Deleta o alerta
if (isset($_GET['id'])) {
    $id_alerta = $_GET['id'];

    $sql = "DELETE FROM alertas WHERE id_alerta = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_alerta);

    if ($stmt->execute()) {
        header('Location: ' . BASE_URL . 'pages/lista_alertas.php');
        exit;
    } else {
        echo "Erro ao deletar alerta: " . $conn->error;
    }
}
?>
