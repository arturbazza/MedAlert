<?php
require __DIR__ . '/vendor/autoload.php'; // Autoload do Composer

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load(); // Carrega as variáveis de ambiente

if ($_SERVER['SERVER_NAME'] === "localhost") {
    $servername = $_ENV['DB_LOCAL_SERVERNAME'];
    $username = $_ENV['DB_LOCAL_USERNAME'];
    $password = $_ENV['DB_LOCAL_PASSWORD'];
    $dbname = $_ENV['DB_LOCAL_DBNAME'];
    $base_url = $_ENV['DB_LOCAL_BASE_URL'];
} elseif ($_SERVER['SERVER_NAME'] === "medalert.com.br") {
    $servername = $_ENV['DB_PROD_SERVERNAME'];
    $username = $_ENV['DB_PROD_USERNAME'];
    $password = $_ENV['DB_PROD_PASSWORD'];
    $dbname = $_ENV['DB_PROD_DBNAME'];
    $base_url = $_ENV['DB_PROD_BASE_URL'];
}

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Define a constante BASE_URL
define('BASE_URL', $base_url);
?>
