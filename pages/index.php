<?php
session_start();
include_once __DIR__ . '/../config/db.php'; // Ajusta o caminho usando __DIR__

// Verifica se o usuário não está logado
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ' . BASE_URL . 'pages/login.php');
    exit;
}

include_once __DIR__ . '/../includes/header.php';
include_once __DIR__ . '/../includes/menu.php';
?>

<main>
    <h1>Bem-vindo, <?php echo $_SESSION['nome_usuario']; ?>!</h1>
    <p>Use o menu acima para navegar pelo sistema.</p>
</main>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
