<?php
session_start(); // Inicia a sessão
include_once '../config/db.php'; // Arquivo de conexão ao banco de dados

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Consulta ao banco de dados
    $sql = "SELECT id_usuario, nome, senha FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id_usuario, $nome, $hash_senha);
        $stmt->fetch();

        // Verifica se a senha está correta
        if (password_verify($senha, $hash_senha)) {
            // Senha correta, inicia a sessão
            $_SESSION['id_usuario'] = $id_usuario;
            $_SESSION['nome_usuario'] = $nome;
            header('Location: /index.php'); // Redireciona para a página inicial
            exit;
        } else {
            // Senha incorreta
            $_SESSION['erro_login'] = "Email ou senha inválidos.";
            header('Location: login.php');
            exit;
        }
    } else {
        // Usuário não encontrado
        $_SESSION['erro_login'] = "Email ou senha inválidos.";
        header('Location: login.php');
        exit;
    }
} else {
    header('Location: login.php'); // Redireciona se não for uma requisição POST
    exit;
}
