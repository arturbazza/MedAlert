<?php include '../partials/menu.php'; ?>
<?php
//require_once '../controller/UsuarioController.php';

//$controller = new UsuarioController();
//$usuarios = $controller->listar();
?>

<h1>Usuários</h1>
<a href="adicionar_usuario.php">Adicionar Novo Usuário</a>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Telefone</th>
        <th>Tipo de Usuário</th>
        <th>Ações</th>
    </tr>
    <?php foreach ($usuarios as $usuario): ?>
    <tr>
        <td><?= $usuario['id_usuario'] ?></td>
        <td><?= $usuario['nome'] ?></td>
        <td><?= $usuario['email'] ?></td>
        <td><?= $usuario['telefone'] ?></td>
        <td><?= $usuario['tipo_usuario'] ?></td>
        <td>
            <a href="editar_usuario.php?id=<?= $usuario['id_usuario'] ?>">Editar</a>
            <a href="deletar_usuario.php?id=<?= $usuario['id_usuario'] ?>" class="delete-link">Excluir</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php include '../partials/footer.php'; ?>
