<nav>
    <button id="menu-toggle">☰ MENU</button>
    <ul id="menu">
        <li><a href="http://www.medalert.com.br">Site</a></li>
        <li><a href="<?= BASE_URL; ?>pages/index.php">Sistema</a></li>
        
        <!-- Dropdown Pacientes -->
        <li class="dropdown">
            <a href="javascript:void(0)">Pacientes</a>
            <ul class="dropdown-content">
                <li><a href="<?= BASE_URL; ?>pages/pacientes.php">Adicionar</a></li>
                <li><a href="<?= BASE_URL; ?>pages/lista_pacientes.php">Listar</a></li>
            </ul>
        </li>

        <!-- Dropdown Medicamentos -->
        <li class="dropdown">
            <a href="javascript:void(0)">Medicamentos</a>
            <ul class="dropdown-content">
                <li><a href="<?= BASE_URL; ?>pages/medicamentos.php">Adicionar</a></li>
                <li><a href="<?= BASE_URL; ?>pages/lista_medicamentos.php">Listar</a></li>
            </ul>
        </li>

        <!-- Dropdown Alertas -->
        <li class="dropdown">
            <a href="javascript:void(0)">Alertas</a>
            <ul class="dropdown-content">
                <li><a href="<?= BASE_URL; ?>pages/alertas.php">Adicionar</a></li>
                <li><a href="<?= BASE_URL; ?>pages/lista_alertas.php">Listar</a></li>
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
<!-- Banner centralizado -->
<div class="banner">
    <a href="https://www.weinmann.com.br/" target="_blank">
        <img src="<?= BASE_URL; ?>imgs/ROSA-20243840x960V3.png" alt="Ir para o site">
    </a>
    <!-- span class="banner-text">TEXTO!</!-->
