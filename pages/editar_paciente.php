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

// Verifica se foi enviado o ID do paciente
if (!isset($_GET['id'])) {
    echo "<p style='text-align: center; color: red;'>Paciente não encontrado.</p>";
    exit;
}

$id_paciente = $_GET['id'];

// Recupera os dados do paciente para edição
$sql = "SELECT * FROM pacientes WHERE id_paciente = ? AND id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_paciente, $_SESSION['id_usuario']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p style='text-align: center; color: red;'>Paciente não encontrado ou você não tem permissão para editá-lo.</p>";
    exit;
}

$paciente = $result->fetch_assoc();

// Lógica para atualizar o paciente
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $data_nascimento = $_POST['data_nascimento'];
    $sexo = $_POST['sexo'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];

    // Converte a data de dd/mm/aaaa para aaaa-mm-dd
    $data_nascimento_formatada = DateTime::createFromFormat('d/m/Y', $data_nascimento)->format('Y-m-d');

    // Atualiza o paciente no banco de dados
    $sql = "UPDATE pacientes SET nome = ?, data_nascimento = ?, sexo = ?, telefone = ?, endereco = ? WHERE id_paciente = ? AND id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $nome, $data_nascimento_formatada, $sexo, $telefone, $endereco, $id_paciente, $_SESSION['id_usuario']);

    if ($stmt->execute()) {
        echo "<p style='text-align: center; color: green;'>Paciente atualizado com sucesso!</p>";
    } else {
        echo "<p style='text-align: center; color: red;'>Erro ao atualizar paciente: " . $conn->error . "</p>";
    }
}
?>

<main>
    <h3 style="text-align: center;">Editar Paciente</h3>

    <form action="" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo $paciente['nome']; ?>" required>

        <label for="data_nascimento">Data de Nascimento:</label>
        <input type="text" id="data_nascimento" name="data_nascimento" value="<?php echo date('d/m/Y', strtotime($paciente['data_nascimento'])); ?>" placeholder="dd/mm/aaaa" pattern="\d{2}/\d{2}/\d{4}" required>

        <label for="sexo" style="width: 99%;">Sexo:</label>
        <select id="sexo" name="sexo" required>
            <option value="M" <?php if ($paciente['sexo'] == 'M') echo 'selected'; ?>>Masculino</option>
            <option value="F" <?php if ($paciente['sexo'] == 'F') echo 'selected'; ?>>Feminino</option>
            <option value="O" <?php if ($paciente['sexo'] == 'O') echo 'selected'; ?>>Outro</option>
        </select>

        <label for="telefone">Telefone (somente números):</label>
        <input type="text" id="telefone" name="telefone" value="<?php echo $paciente['telefone']; ?>" placeholder="00123456789">

        <label for="endereco">Endereço:</label>
        <input type="text" id="endereco" name="endereco" value="<?php echo $paciente['endereco']; ?>">

        <button type="submit">Atualizar Paciente</button>
    </form>
</main>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
