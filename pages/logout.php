<?php
include_once '../includes/header.php';
include_once '../includes/menu.php';

session_start();
session_unset(); // Limpa todas as variáveis de sessão
session_destroy(); // Destrói a sessão

// Redireciona para a página inicial usando a BASE_URL
header('Location: ' . BASE_URL . 'index.php');
exit;
?>
