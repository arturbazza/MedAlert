<?php
session_start();

// Verifica se o usuário não está logado
if (!isset($_SESSION['id_usuario'])) {
    header('Location: pages/login.php');
    exit;
}
?>

<?php include_once 'includes/header.php'; ?>
<?php include_once 'includes/menu.php'; ?>

<main>
    <h1>Bem-vindo, <?php echo $_SESSION['nome_usuario']; ?>!</h1>
    <p>Use o menu acima para navegar pelo sistema.</p>
</main>

<?php include_once 'includes/footer.php'; ?>
