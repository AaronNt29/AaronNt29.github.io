<!-- SIDEBAR -->
<section id="sidebar">
    <a href="?action=inicio" class="brand">
        <i class='bx bx-pie-chart bx-lg'></i>
        <span class="text">
            Dengue Perú<br>
            analytics
        </span>
    </a>

    <ul class="side-menu top">
        <li class="<?= (isset($active_page) && $active_page === 'inicio') ? 'active' : '' ?>">
            <a href="?action=inicio">
                <i class='bx bxs-dashboard bx-sm'></i>
                <span class="text">Inicio</span>
            </a>
        </li>
        <li class="<?= (isset($active_page) && $active_page === 'atenciones') ? 'active' : '' ?>">
            <a href="?action=indicador1">
                <i class='bx bxs-calendar-event bx-sm'></i>
                <span class="text">Casos confirmados en un periodo</span>
            </a>
        </li>
        <li class="<?= (isset($active_page) && $active_page === 'Dashboards') ? 'active' : '' ?>">
            <a href="?action=indicador2">
                <i class='bx bxs-group bx-sm'></i>
                <span class="text">Casos por género y edad</span>
            </a>
        </li>
        <li class="<?= (isset($active_page) && $active_page === 'Archivos') ? 'active' : '' ?>">
            <a href="?action=indicador3">
                <i class='bx bxs-map-pin bx-sm'></i>
                <span class="text">Áreas con concentración de brotes.</span>
            </a>
        </li>
        <li class="<?= (isset($active_page) && $active_page === 'notas') ? 'active' : '' ?>">
            <a href="?action=indicador4">
                <i class='bx bxs-timer bx-sm'></i>
                <span class="text">Temporalidad de brotes</span>
            </a>
        </li>
    </ul>

    <!-- BLOQUE DE PERFIL Y SALIR ABAJO -->
    <ul class="side-menu bottom">
        <li class="<?= (isset($active_page) && $active_page === 'usuario') ? 'active' : '' ?>">
            <a href="?action=usuario">
                <i class='bx bxs-user-circle bx-sm'></i>
                <span class="text">Usuario</span>
            </a>
        </li>
        <li>
            <a href="?action=logout" class="logout">
                <i class='bx bx-power-off bx-sm bx-burst-hover'></i>
                <span class="text">Salir</span>
            </a>
        </li>
    </ul>
</section>
<!-- SIDEBAR -->
