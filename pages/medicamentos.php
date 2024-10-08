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

// Lógica para inserir um novo medicamento
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_medicamento = $_POST['nome_medicamento'];
    $dosagem = $_POST['dosagem'];
    $frequencia = $_POST['frequencia'];
    $descricao = $_POST['descricao'];
    $id_paciente = $_POST['id_paciente'];

    $sql = "INSERT INTO medicamentos (nome_medicamento, dosagem, frequencia, descricao, id_paciente) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nome_medicamento, $dosagem, $frequencia, $descricao, $id_paciente);

    if ($stmt->execute()) {
        echo "<p style='text-align: center; color: green;'>Medicamento adicionado com sucesso!</p>";
    } else {
        echo "<p style='text-align: center; color: red;'>Erro ao adicionar medicamento: " . $conn->error . "</p>";
    }
}

// Recupera a lista de pacientes
$sql_pacientes = "SELECT id_paciente, nome FROM pacientes WHERE id_usuario = ?";
$stmt_pacientes = $conn->prepare($sql_pacientes);
$stmt_pacientes->bind_param("i", $_SESSION['id_usuario']);
$stmt_pacientes->execute();
$result_pacientes = $stmt_pacientes->get_result();
?>

<main>
    <h3 style="text-align: center;">Gerenciar Medicamentos</h3>

    <form action="" method="POST" style="max-width: 450px; margin: 0 auto;">
        <div style="display: flex; flex-direction: column; gap: 12px;">
            
            <label for="nome_medicamento">Nome do Medicamento:</label>
            <input type="text" id="nome_medicamento" name="nome_medicamento" required>

            <!-- Dosagem -->
            <div style="display: flex; align-items: center;">
                <div style="flex: 1;">
                    <label for="dosagem">Dosagem:</label>
                    <input type="text" id="dosagem" name="dosagem" placeholder="Ex: 500mg" style="width: 94%;" required>
                </div>
                <span style="margin-left: 8px;">Ex: 500mg</span>
            </div>

            <!-- Frequência -->
            <div style="display: flex; align-items: center;">
                <div style="flex: 1;">
                    <label for="frequencia">Frequência:</label>
                    <input type="text" id="frequencia" name="frequencia" placeholder="Ex: 8/8h ou 1 por dia" style="width: 94%;" required>
                </div>
                <span style="margin-left: 8px;">Ex: 8h/8h ou 1 por dia</span>
            </div>

            <!-- Descrição -->
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" rows="2" style="width: 100%;  height: 80px" required></textarea>

            <!-- Paciente -->
            <label for="id_paciente">Paciente:</label>
            <select id="id_paciente" name="id_paciente" required style="width: 100%;">
                <?php while ($row_pacientes = $result_pacientes->fetch_assoc()): ?>
                    <option value="<?= $row_pacientes['id_paciente']; ?>"><?= $row_pacientes['nome']; ?></option>
                <?php endwhile; ?>
            </select>

            <!-- Botão -->
            <button type="submit" style="margin-top: 12px;">Adicionar Medicamento</button>
        </div>
    </form>
</main>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
