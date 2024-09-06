<?php
session_start(); // Inicia a sessão
include_once __DIR__ . '/../config/db.php';
include_once __DIR__ . '/../includes/header.php';
include_once __DIR__ . '/../includes/menu.php';

// Verifica se o usuário já está logado
if (isset($_SESSION['id_usuario'])) {
    header('Location: ' . BASE_URL . 'pages/index.php');
    exit;
}
?>

<main>
    <?php
if (isset($_GET['msg']) && $_GET['msg'] == 'success') {
    echo "<p style='color: green; text-align: center; font-weight: bold;'>Usuário cadastrado com sucesso! Faça login.</p>";
}
?>
    <h3 style="text-align: center;">Tela de autenticação</h3>
    <form action="<?= BASE_URL; ?>pages/autenticar.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
        
        <button type="submit">Entrar</button>
        <h5 style="text-align: center;">Não tem cadastro? <a href="<?= BASE_URL; ?>pages/register.php">Clique aqui</a>.</h5>
    </form>
    
    <?php
    // Exibe mensagens de erro, se houver
    if (isset($_SESSION['erro_login'])) {
        echo "<p style='color:red;'>".$_SESSION['erro_login']."</p>";
        unset($_SESSION['erro_login']);
    }
    ?>
</main>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
