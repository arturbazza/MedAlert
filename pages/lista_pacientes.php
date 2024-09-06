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

// Recupera a lista de pacientes
$sql = "SELECT * FROM pacientes WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['id_usuario']);
$stmt->execute();
$result = $stmt->get_result();
?>

<main>
    <h3 style="text-align: center;">Lista de Pacientes</h3>

    <ul>
        <?php while ($row = $result->fetch_assoc()): ?>
            <li><?php echo $row['nome']; ?> (<?php echo date('d/m/Y', strtotime($row['data_nascimento'])); ?>)</li>
        <?php endwhile; ?>
    </ul>
</main>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>
