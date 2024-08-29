<?php include_once '../includes/header.php'; 
include_once '../includes/menu.php'; ?>

<main>
    <h3 style="text-align: center;">Cadastro de Usuário</h3>
    <form action="register_process.php" method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
        
        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone">
        
        <label for="tipo_usuario">Tipo de Usuário:</label>
        <select id="tipo_usuario" name="tipo_usuario" required>
            <option value="cuidador">Cuidador</option>
            <option value="enfermeiro">Enfermeiro</option>
            <option value="medico">Médico</option>
            <option value="responsavel">Responsável</option>
        </select>
        
        <button type="submit">Cadastrar</button>
        <p><a href="javascript:history.back()" title="Voltar para a página anterior"><< Voltar</a></p>
    </form>
    
</main>


<?php include_once '../includes/footer.php'; ?>
