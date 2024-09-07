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

// Deletar paciente
if (isset($_GET['delete'])) {
    $id_paciente = $_GET['delete'];
    $sql = "DELETE FROM pacientes WHERE id_paciente = ? AND id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_paciente, $_SESSION['id_usuario']);
    $stmt->execute();
    
    header('Location: ' . BASE_URL . 'pages/lista_pacientes.php');
    exit;
}

// Recupera a lista de pacientes
$sql = "SELECT * FROM pacientes WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['id_usuario']);
$stmt->execute();
$result = $stmt->get_result();
?>

<main>
    <h3 style="text-align: center;">Lista de Pacientes</h3>

    <table border="1" width="100%">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Data de Nascimento</th>
                <th>Sexo</th>
                <th>Telefone</th>
                <th>Endereço</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['nome']; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($row['data_nascimento'])); ?></td>
                    <td><?php echo $row['sexo']; ?></td>
                    <td><?php echo $row['telefone']; ?></td>
                    <td><?php echo $row['endereco']; ?></td>
                    <td>
                        <a href="editar_paciente.php?id=<?php echo $row['id_paciente']; ?>">Editar</a> | 
                        <a href="?delete=<?php echo $row['id_paciente']; ?>" onclick="return confirm('Tem certeza que deseja deletar?');">Deletar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
