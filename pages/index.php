<?php
session_start();
include_once __DIR__ . '/../config/db.php';
include_once __DIR__ . '/../includes/header.php';
include_once __DIR__ . '/../includes/menu.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ' . BASE_URL . 'pages/login.php');
    exit;
}

// Inclui o arquivo de notificações
include_once __DIR__ . '/notificacoes.php';

// Recupera o nome do usuário logado
$sql_usuario = "SELECT nome FROM usuarios WHERE id_usuario = ?";
$stmt_usuario = $conn->prepare($sql_usuario);
$stmt_usuario->bind_param("i", $_SESSION['id_usuario']);
$stmt_usuario->execute();
$result_usuario = $stmt_usuario->get_result();
$usuario = $result_usuario->fetch_assoc();

// Recupera a lista de pacientes
$sql_pacientes = "SELECT id_paciente, nome, telefone, endereco, data_nascimento, sexo FROM pacientes WHERE id_usuario = ?";
$stmt_pacientes = $conn->prepare($sql_pacientes);
$stmt_pacientes->bind_param("i", $_SESSION['id_usuario']);
$stmt_pacientes->execute();
$result_pacientes = $stmt_pacientes->get_result();

// Recupera a lista de medicamentos
$sql_medicamentos = "SELECT m.id_medicamento, m.nome_medicamento, m.dosagem, m.frequencia, m.descricao, p.nome AS nome_paciente 
                     FROM medicamentos m
                     INNER JOIN pacientes p ON m.id_paciente = p.id_paciente
                     WHERE p.id_usuario = ?";
$stmt_medicamentos = $conn->prepare($sql_medicamentos);
$stmt_medicamentos->bind_param("i", $_SESSION['id_usuario']);
$stmt_medicamentos->execute();
$result_medicamentos = $stmt_medicamentos->get_result();

// Recupera a lista de alertas associados ao usuário logado
$sql_alertas = "SELECT a.id_alerta, a.data_hora_alerta, a.status_alerta, a.metodo_alerta, m.nome_medicamento 
                FROM alertas a
                JOIN medicamentos m ON a.id_medicamento = m.id_medicamento
                JOIN pacientes p ON m.id_paciente = p.id_paciente
                WHERE p.id_usuario = ?";
$stmt_alertas = $conn->prepare($sql_alertas);
$stmt_alertas->bind_param("i", $_SESSION['id_usuario']);
$stmt_alertas->execute();
$result_alertas = $stmt_alertas->get_result();

$hora_atual = date('d/m/Y H:i:s');

if ($_SERVER['SERVER_NAME'] === "localhost") {

    echo "<br><div style='color: green; text-align: center;'>localhost<br>".$hora_atual."</div>";

} elseif ($_SERVER['SERVER_NAME'] === "medalert.com.br") {

    echo "<br><div style='color: green; text-align: center;'>Uma dose de cuidado.<br>".$hora_atual."</div>";

} elseif ($_SERVER['SERVER_NAME'] === "192.168.0.15") {

    echo "<br><div style='color: green; text-align: center;'>SRVBLUR<br>".$hora_atual."</div>";
}
?>

<main>
    <h3 style="text-align: center;">Bem-vindo, <?= htmlspecialchars($usuario['nome']); ?>!</h3>
    <p style="text-align: center;">No menu acima você pode gerenciar seus pacientes, medicamentos e alertas.</p>
    
    <!--Alertas -->
    <div class="table-container">
            <h4><a href="<?= BASE_URL; ?>pages/lista_alertas.php" style="text-decoration: none; color: inherit;" title="Clique para ver a lista de alertas">Lista Alertas</a></h4>
            <table class="styled-table">
            <thead>
                <tr>
                    <th>Data e Hora</th>
                    <th>Status</th>
                    <th>Método</th>
                    <th>Medicamento</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row_alertas = $result_alertas->fetch_assoc()): ?>
                    <tr>
                        <td><?= date('d/m/Y H:i', strtotime($row_alertas['data_hora_alerta'])); ?></td>
                        <td><?= ucfirst($row_alertas['status_alerta']); ?></td>
                        <td><?= ucfirst($row_alertas['metodo_alerta']); ?></td>
                        <td><?= $row_alertas['nome_medicamento']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!--Pacientes -->
    <div class="table-container">
        <h4><a href="<?= BASE_URL; ?>pages/lista_pacientes.php" style="text-decoration: none; color: inherit;" title="Clique para ver a lista de pacientes">Lista Pacientes</a></h4>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Data de Nascimento</th>
                    <th>Sexo</th>
                    <th>Telefone</th>
                    <th>Endereço</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($paciente = $result_pacientes->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($paciente['nome']); ?></td>
                    <td><?= date('d/m/Y', strtotime($paciente['data_nascimento'])); ?></td>
                    <td><?= htmlspecialchars($paciente['sexo']); ?></td>
                    <td><?= htmlspecialchars($paciente['telefone']); ?></td>
                    <td><?= htmlspecialchars($paciente['endereco']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!--Medicamentos -->
    <div class="table-container">
        <h4>
    <a href="<?= BASE_URL; ?>pages/lista_medicamentos.php" style="text-decoration: none; color: inherit;" title="Clique para ver a lista de medicamentos">Lista Medicamentos</a>
</h4>

        <table class="styled-table">
            <thead>
                <tr>
                    <th>Medicamento</th>
                    <th>Dosagem (mg)</th>
                    <th>Frequência (horas/dias)</th>
                    <th>Descrição</th>
                    <th>Paciente</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($medicamento = $result_medicamentos->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($medicamento['nome_medicamento']); ?></td>
                    <td><?= htmlspecialchars($medicamento['dosagem']); ?></td>
                    <td><?= htmlspecialchars($medicamento['frequencia']); ?></td>
                    <td><?= htmlspecialchars($medicamento['descricao']); ?></td>
                    <td><?= htmlspecialchars($medicamento['nome_paciente']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

<div>&nbsp;</div>
<div>&nbsp;</div>
<div>&nbsp;</div>
<div>&nbsp;</div>
</main>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
