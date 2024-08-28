<?php
session_start(); // Inicia a sessão
include_once '../includes/header.php';
include_once '../includes/menu.php';

// Verifica se o usuário já está logado
if (isset($_SESSION['id_usuario'])) {
    header('Location: index.php'); // Redireciona para a página principal se já estiver logado
    exit;
}
?>

<main>
    <h1>Login</h1>
    <form action="autenticar.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
        
        <button type="submit">Entrar</button>
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
