<?php
if ($_SERVER['SERVER_NAME'] === "localhost") {

    echo "SERVER_NAME: " . $_SERVER['SERVER_NAME'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "medalert";

    // Criar conexão
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }
} elseif ($_SERVER['SERVER_NAME'] === "medalert.com.br") {

    echo "SERVER_NAME: " . $_SERVER['SERVER_NAME'];

    $servername = "medalert.com.br";
    $username = "medalert01";
    $password = "medalert01";
    $dbname = "medalert01";

    // Criar conexão
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }
}

?>
