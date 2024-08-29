<?php
session_start(); // Inicia a sessão
include_once '../includes/header.php';
include_once '../includes/menu.php';

// Verifica se o usuário já está logado
if (isset($_SESSION['id_usuario'])) {
    header('Location: ' . BASE_URL . 'index.php');
    exit;
}
?>

<main>
    <h3 style="text-align: center;">Tela de autenticação</h3>
    <form action="autenticar.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
        
        <button type="submit">Entrar</button>
        <h5 style="text-align: center;">Não tem cadastro, clique <a href="register.php">aqui</a>.</h5>
    </form>
    
    <?php
    // Exibe mensagens de erro, se houver
    if (isset($_SESSION['erro_login'])) {
        echo "<p style='color:red;'>".$_SESSION['erro_login']."</p>";
        unset($_SESSION['erro_login']);
    }
    ?>

    
</main>

<?php include_once '../includes/footer.php'; ?>
