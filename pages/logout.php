<?php
session_start();
include_once '../config/db.php'; // Inclui o arquivo de configuração para definir a constante BASE_URL

session_unset(); // Limpa todas as variáveis de sessão
session_destroy(); // Destrói a sessão

// Redireciona para a página inicial usando a BASE_URL
header('Location: ' . BASE_URL . 'pages/index.php');
exit;
?>
