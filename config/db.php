<?php
if ($_SERVER['SERVER_NAME'] === "localhost") {

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "medalert";
    $base_url = "http://localhost/medalert/";

} elseif ($_SERVER['SERVER_NAME'] === "medalert.com.br") {

    $servername = "mysql.medalert.com.br";
    $username = "medalert01";
    $password = "pixel1953";
    $dbname = "medalert01";
    $base_url = "https://medalert.com.br/medalert/";

} elseif ($_SERVER['SERVER_NAME'] === "192.168.0.15") {

    $servername = "localhost";
    $username = "root";
    $password = "pixel";
    $dbname = "medalert";
    $base_url = "http://192.168.0.15/medalert/";
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
