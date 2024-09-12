<?php
//session_start();
//include_once __DIR__ . '/../config/db.php';

// Função para enviar e-mail
function enviarEmail($email, $nomePaciente, $medicamento, $dataHoraAlerta) {
    $assunto = "Lembrete de Medicação para o Paciente: $nomePaciente";
    $mensagem = "Olá, este é um lembrete para a medicação do paciente $nomePaciente.\n\n"
              . "Medicamento: $medicamento\n"
              . "Horário do Alerta: " . date('d/m/Y H:i', strtotime($dataHoraAlerta)) . "\n\n"
              . "Por favor, verifique e administre a medicação no horário correto.";
    
    $headers = "From: no-reply@medalert.com\r\n";
    mail($email, $assunto, $mensagem, $headers);
}

// Consulta os alertas que vão ocorrer nos próximos 10 minutos
$sql = "SELECT a.id_alerta, a.data_hora_alerta, u.email, p.nome AS nome_paciente, m.nome_medicamento 
        FROM alertas a
        JOIN medicamentos m ON a.id_medicamento = m.id_medicamento
        JOIN pacientes p ON m.id_paciente = p.id_paciente
        JOIN usuarios u ON p.id_usuario = u.id_usuario
        WHERE a.status_alerta = 'pendente' 
        AND a.data_hora_alerta BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 10 MINUTE)";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Enviar email para o usuário
        enviarEmail($row['email'], $row['nome_paciente'], $row['nome_medicamento'], $row['data_hora_alerta']);

        // Marcar alerta como enviado (pode criar uma coluna para controlar envio, se necessário)
        $update_sql = "UPDATE alertas SET status_alerta = 'confirmado' WHERE id_alerta = ?";
        $stmt_update = $conn->prepare($update_sql);
        $stmt_update->bind_param("i", $row['id_alerta']);
        $stmt_update->execute();
    }
}

// Mensagem de notificação na tela inicial
if (isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION['id_usuario'];

    // Verifica se há alertas pendentes nos próximos 10 minutos para exibir na tela inicial
    $sql_notificacoes = "SELECT a.data_hora_alerta, m.nome_medicamento 
                         FROM alertas a
                         JOIN medicamentos m ON a.id_medicamento = m.id_medicamento
                         JOIN pacientes p ON m.id_paciente = p.id_paciente
                         WHERE p.id_usuario = ?
                         AND a.status_alerta = 'pendente'
                         AND a.data_hora_alerta BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 1 MINUTE)";
    
    $stmt_notificacoes = $conn->prepare($sql_notificacoes);
    $stmt_notificacoes->bind_param("i", $id_usuario);
    $stmt_notificacoes->execute();
    $result_notificacoes = $stmt_notificacoes->get_result();

    if ($result_notificacoes->num_rows > 0) {
        echo "<div class='notification-container'>";
        while ($row = $result_notificacoes->fetch_assoc()) {
            echo "<p style='color: red;'>Alerta! Medicamento: " . $row['nome_medicamento'] . 
                 " às " . date('H:i', strtotime($row['data_hora_alerta'])) . "</p>";
        }
        echo "</div>";
    }
}
?>
