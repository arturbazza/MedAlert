<nav>
    <button id="menu-toggle">☰ MENU</button>
    <ul id="menu">
        <li><a href="http://www.medalert.com.br">Site</a></li>
        <li><a href="<?= BASE_URL; ?>pages/index.php">Sistema</a></li>
        
        <!-- Dropdown Pacientes -->
        <li class="dropdown">
            <a href="javascript:void(0)">Pacientes</a>
            <ul class="dropdown-content">
                <li><a href="<?= BASE_URL; ?>pages/pacientes.php">Adicionar Paciente</a></li>
                <li><a href="<?= BASE_URL; ?>pages/lista_pacientes.php">Lista Pacientes</a></li>
            </ul>
        </li>

        <!-- Dropdown Medicamentos -->
        <li class="dropdown">
            <a href="javascript:void(0)">Medicamentos</a>
            <ul class="dropdown-content">
                <li><a href="<?= BASE_URL; ?>pages/medicamentos.php">Adicionar Medicamentos</a></li>
                <li><a href="<?= BASE_URL; ?>pages/lista_medicamentos.php">Lista Medicamentos</a></li>
            </ul>
        </li>

        <!-- Dropdown Alertas -->
        <li class="dropdown">
            <a href="javascript:void(0)">Alertas</a>
            <ul class="dropdown-content">
                <li><a href="<?= BASE_URL; ?>pages/alertas.php">Adicionar Alertas</a></li>
                <li><a href="<?= BASE_URL; ?>pages/lista_alertas.php">Lista Alertas</a></li>
            </ul>
        </li>

        <li><a href="<?= BASE_URL; ?>pages/usuarios.php">Usuários</a></li>
        <li><a href="<?= BASE_URL; ?>pages/login.php">Login</a></li>
        <li><a href="<?= BASE_URL; ?>pages/logout.php">Sair</a></li>
    </ul>
</nav>

<script>
// Script para alternar o menu em dispositivos móveis
document.getElementById('menu-toggle').addEventListener('click', function() {
    var menu = document.getElementById('menu');
    menu.classList.toggle('active');
});
</script>
