<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (empty($_SESSION['id_user'])) {
    header('Location: /index.php?action=showLogin');
    exit;
}

$page_title   = "Dashboard - Concentración de Brotes";
$active_page  = 'Archivos';
$navbar_title = "Áreas con Concentración de Brotes";
$custom_css   = ['/public/css/estilo.css'];
$custom_js    = [];

// Includes basados en la ruta real del archivo
require_once __DIR__ . '/partials/header.php';
require_once __DIR__ . '/partials/sidebar.php';
?>

<section id="content">
    <?php require_once __DIR__ . '/partials/navbar.php'; ?>

    <main class="bg-gray-50 p-6">
        <!-- Introducción -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-blue-800 mb-2">
                Áreas con Concentración de Brotes
            </h1>
            <p class="text-gray-700 text-lg max-w-3xl leading-relaxed">
                Este panel muestra la concentración de casos de dengue por departamento, considerando el tipo de diagnóstico (confirmado o probable), año y semana epidemiológica. El objetivo es identificar zonas críticas de brote en el Perú.
            </p>
        </div>

        <!-- Tarjetas resumen -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <h3 class="text-sm font-medium text-gray-500 mb-2">Departamento con más casos</h3>
                <p class="text-3xl font-bold text-green-600">Piura</p>
                <p class="text-sm text-gray-400">Total: 1,245 casos</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <h3 class="text-sm font-medium text-gray-500 mb-2">Semana pico</h3>
                <p class="text-3xl font-bold text-red-500">Semana 13</p>
                <p class="text-sm text-gray-400">Casos: 327</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <h3 class="text-sm font-medium text-gray-500 mb-2">Casos totales (confirmados)</h3>
                <p class="text-3xl font-bold text-blue-600">3,204</p>
                <p class="text-sm text-gray-400">Año: 2023</p>
            </div>
        </div>

        <!-- Mapa simulado -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-10">
            <h3 class="text-xl font-semibold text-blue-700 mb-4">Distribución Geográfica de Brotes (Mapa simulado)</h3>
            <div class="w-full h-72 bg-gray-200 flex items-center justify-center text-gray-500 text-sm">
                Mapa de calor o regiones con mayor incidencia (simulado)
            </div>
        </div>

        <!-- Dashboard visual por departamento -->
        <div class="mb-12">
            <h3 class="text-xl font-semibold text-blue-700 mb-4">Departamentos con Alta Incidencia</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                <div class="bg-green-100 text-green-800 rounded-lg p-4 shadow">
                    <h4 class="font-bold mb-1">Piura</h4>
                    <p class="text-sm">Confirmado: 1,245 casos</p>
                    <p class="text-sm">Probable: 320 casos</p>
                    <p class="text-sm">Última semana: 13</p>
                </div>

                <div class="bg-red-100 text-red-800 rounded-lg p-4 shadow">
                    <h4 class="font-bold mb-1">Loreto</h4>
                    <p class="text-sm">Confirmado: 980 casos</p>
                    <p class="text-sm">Probable: 210 casos</p>
                    <p class="text-sm">Última semana: 12</p>
                </div>

                <div class="bg-purple-100 text-purple-800 rounded-lg p-4 shadow">
                    <h4 class="font-bold mb-1">Ica</h4>
                    <p class="text-sm">Confirmado: 678 casos</p>
                    <p class="text-sm">Probable: 150 casos</p>
                    <p class="text-sm">Última semana: 11</p>
                </div>
            </div>
        </div>

        <!-- Observaciones finales -->
        <div class="mt-12 max-w-4xl">
            <h3 class="text-lg font-semibold text-blue-700 mb-2">Conclusiones</h3>
            <p class="text-gray-700 text-base leading-relaxed">
                Este dashboard permite identificar áreas críticas que requieren intervención prioritaria. La representación visual de los brotes por semana y departamento proporciona una base para alimentar el modelo predictivo Random Forest y reforzar las estrategias de vigilancia.
            </p>
        </div>
    </main>
</section>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
