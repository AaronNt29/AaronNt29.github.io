<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (empty($_SESSION['id_user'])) {
    header('Location: /index.php?action=showLogin');
    exit;
}

$page_title   = "Casos por género y edad - Prototipo";
$active_page  = 'Dashboards';
$navbar_title = "Casos por Género y Edad";
$custom_css   = ['/public/css/estilo.css'];
$custom_js    = [];

// IMPORTANTE: rutas basadas en este archivo
require_once __DIR__ . '/partials/header.php';
require_once __DIR__ . '/partials/sidebar.php';
?>

<section id="content">
    <?php require_once __DIR__ . '/partials/navbar.php'; ?>

    <main class="bg-gray-50 p-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-blue-800 mb-2">
                Casos Confirmados de Dengue por Género y Edad
            </h1>
            <p class="text-gray-700 max-w-3xl text-lg leading-relaxed">
                Este módulo muestra un resumen visual de la distribución de casos de dengue según el sexo y los rangos de edad de los pacientes, permitiendo identificar patrones demográficos clave en los brotes.
            </p>
        </div>

        <!-- Distribución por género -->
        <div class="mb-12">
            <h2 class="text-xl font-semibold text-blue-700 mb-4">Distribución por Género</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-lg shadow-md p-6 flex flex-col justify-center items-center h-64">
                    <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">
                        Gráfico circular simulado (hombres vs mujeres)
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <p class="text-sm text-gray-600 mb-2">Resumen</p>
                    <ul class="text-gray-700 space-y-2 text-sm">
                        <li><strong>Hombres:</strong> 620 casos (53%)</li>
                        <li><strong>Mujeres:</strong> 560 casos (47%)</li>
                        <li><strong>Total:</strong> 1,180 casos confirmados</li>
                        <li>Periodo: Ene - May 2023</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Distribución por edad -->
        <div class="mb-12">
            <h2 class="text-xl font-semibold text-blue-700 mb-4">Distribución por Grupo Etario</h2>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="w-full h-64 bg-gray-100 flex items-center justify-center text-gray-400">
                    Gráfico de barras por grupo de edad (simulado)
                </div>
            </div>
            <div class="mt-4 text-sm text-gray-600">
                <p><strong>Grupo con más casos:</strong> 20-29 años (25%)</p>
                <p><strong>Otros grupos destacados:</strong> 30-39 años (20%), 10-19 años (18%)</p>
            </div>
        </div>

        <!-- Nota final -->
        <div class="max-w-4xl">
            <h3 class="text-lg font-semibold text-blue-700 mb-2">Importancia del análisis demográfico</h3>
            <p class="text-gray-700 text-base leading-relaxed">
                Comprender cómo afecta el dengue a distintos grupos poblacionales permite orientar mejor las campañas de prevención, control y atención médica, reforzando la vigilancia en los sectores más vulnerables.
            </p>
        </div>
    </main>
</section>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
