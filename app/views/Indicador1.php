<?php
// app/views/Indicador1.php
if (session_status() === PHP_SESSION_NONE) session_start();

/* BASE_URL dinámica según la carpeta del proyecto (p. ej. /RFDENGUE) */
$BASE_URL = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? '/'), '/');
$BASE_URL = ($BASE_URL === '') ? '/' : $BASE_URL;

/* ✅ Tu LoginController guarda $_SESSION['id_user'] (no 'user_id') */
if (empty($_SESSION['id_user'])) {
    header('Location: ' . $BASE_URL . '/index.php?action=showLogin');
    exit();
}

$page_title   = "Casos confirmados - Prototipo";
$active_page  = 'atenciones';
$navbar_title = "Casos Confirmados en un Periodo";

/* ✅ CSS con BASE_URL para que cargue desde /public/css en cualquier carpeta */
$custom_css = [
    $BASE_URL . '/public/css/estilo.css'
];
$custom_js = [];

/* ✅ Includes con __DIR__ para no romper rutas relativas */
require_once __DIR__ . '/partials/header.php';
require_once __DIR__ . '/partials/sidebar.php';
?>

<section id="content">
    <?php require_once __DIR__ . '/partials/navbar.php'; ?>

    <main class="bg-gray-50 p-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-blue-800 mb-2">
                Casos Confirmados de Dengue en un Periodo
            </h1>
            <p class="text-gray-700 max-w-3xl text-lg leading-relaxed">
                Este módulo del prototipo presenta una visualización simulada de los casos confirmados y probables de dengue registrados por semana y año en Perú.
            </p>
        </div>

        <!-- Tarjetas estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-sm font-medium text-gray-500 mb-2">Total de casos confirmados</h3>
                <p class="text-3xl font-bold text-green-600">1,234</p>
                <p class="text-sm text-gray-400">Periodo: 2023 - Semana 1 a 20</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-sm font-medium text-gray-500 mb-2">Casos probables</h3>
                <p class="text-3xl font-bold text-yellow-500">456</p>
                <p class="text-sm text-gray-400">Periodo: 2023 - Semana 1 a 20</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-sm font-medium text-gray-500 mb-2">Semana con más casos</h3>
                <p class="text-3xl font-bold text-red-500">Semana 14</p>
                <p class="text-sm text-gray-400">Casos: 210</p>
            </div>
        </div>

        <!-- Gráfico simulado -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-10">
            <h3 class="text-xl font-semibold text-blue-700 mb-4">Distribución Semanal de Casos (2023)</h3>
            <div class="w-full h-64 bg-gray-100 flex items-center justify-center text-gray-400">
                Gráfico de barras simulado aquí
            </div>
        </div>

        <!-- Tabla resumen (simulada) -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-semibold text-blue-700 mb-4">Resumen por Año y Semana</h3>
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-sm text-gray-600">
                        <th class="p-3">Año</th>
                        <th class="p-3">Semana</th>
                        <th class="p-3">Tipo</th>
                        <th class="p-3">Cantidad</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700">
                    <tr class="border-t">
                        <td class="p-3">2023</td>
                        <td class="p-3">12</td>
                        <td class="p-3">Confirmado</td>
                        <td class="p-3">98</td>
                    </tr>
                    <tr class="border-t">
                        <td class="p-3">2023</td>
                        <td class="p-3">13</td>
                        <td class="p-3">Confirmado</td>
                        <td class="p-3">102</td>
                    </tr>
                    <tr class="border-t">
                        <td class="p-3">2023</td>
                        <td class="p-3">14</td>
                        <td class="p-3">Probable</td>
                        <td class="p-3">45</td>
                    </tr>
                    <tr class="border-t">
                        <td class="p-3">2023</td>
                        <td class="p-3">15</td>
                        <td class="p-3">Confirmado</td>
                        <td class="p-3">88</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</section>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
