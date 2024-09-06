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

// Lógica para inserir um novo paciente
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $data_nascimento = $_POST['data_nascimento'];
    $sexo = $_POST['sexo'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];
    $id_usuario = $_SESSION['id_usuario'];

    // Converte a data de dd/mm/aaaa para aaaa-mm-dd
    $data_nascimento_formatada = DateTime::createFromFormat('d/m/Y', $data_nascimento)->format('Y-m-d');

    $sql = "INSERT INTO pacientes (nome, data_nascimento, sexo, telefone, endereco, id_usuario) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $nome, $data_nascimento_formatada, $sexo, $telefone, $endereco, $id_usuario);

    if ($stmt->execute()) {
        echo "<p style='text-align: center; color: green;'>Paciente adicionado com sucesso!</p>";
    } else {
        echo "<p style='text-align: center; color: red;'>Erro ao adicionar paciente: " . $conn->error . "</p>";
    }
}

// Recupera a lista de pacientes
$sql = "SELECT * FROM pacientes WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['id_usuario']);
$stmt->execute();
$result = $stmt->get_result();
?>

<main>
    <h3 style="text-align: center;">Gerenciar Pacientes</h3>

    <form action="" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="data_nascimento">Data de Nascimento:</label>
        <input type="text" id="data_nascimento" name="data_nascimento" placeholder="dd/mm/aaaa" pattern="\d{2}/\d{2}/\d{4}" required>

        <label for="sexo">Sexo:</label>
        <select id="sexo" name="sexo" required>
            <option value="M">Masculino</option>
            <option value="F">Feminino</option>
            <option value="O">Outro</option>
        </select>

        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone">

        <label for="endereco">Endereço:</label>
        <input type="text" id="endereco" name="endereco">

        <button type="submit">Adicionar Paciente</button>
    </form>

    <h3>Lista de Pacientes</h3>
    <ul>
        <?php while ($row = $result->fetch_assoc()): ?>
            <li><?php echo $row['nome']; ?> (<?php echo date('d/m/Y', strtotime($row['data_nascimento'])); ?>)</li>
        <?php endwhile; ?>
    </ul>
</main>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
