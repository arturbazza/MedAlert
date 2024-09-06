<?php
include '../config/db.php'; // Arquivo de configuração com a conexão ao banco de dados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Hash da senha para segurança
    $telefone = $_POST['telefone'];
    $tipo_usuario = $_POST['tipo_usuario'];

    // Verificar se o email já está cadastrado
    $sql = "SELECT id_usuario FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        // Exibe uma mensagem de alerta em JavaScript e permanece na mesma página
        echo "<script>alert('Este email já está cadastrado!');</script>";
    } else {
        // Inserir o novo usuário no banco de dados
        $sql = "INSERT INTO usuarios (nome, email, senha, telefone, tipo_usuario) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $nome, $email, $senha, $telefone, $tipo_usuario);

        if ($stmt->execute()) {
            // Redireciona para a página de login com a mensagem de sucesso
            header('Location: login.php?msg=success');
            exit;
        } else {
            echo "<p style='color: red; text-align: center;'>Erro ao cadastrar usuário: " . $conn->error . "</p>";
        }
    }

    $stmt->close();
    $conn->close();
}
?>
