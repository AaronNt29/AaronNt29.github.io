<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (empty($_SESSION['id_user'])) {
    header('Location: /index.php?action=showLogin');
    exit();
}

$page_title   = "Temporalidad - Brotes";
$active_page  = 'notas';
$navbar_title = "Temporalidad de los Brotes de Dengue";
$custom_css   = [
    '/public/css/estilo.css'
];
$custom_js    = [];

require_once __DIR__ . '/partials/header.php';
require_once __DIR__ . '/partials/sidebar.php';
?>

<section id="content">
    <?php require_once __DIR__ . '/partials/navbar.php'; ?>

    <main class="bg-gray-50 p-6">
        <!-- Título -->
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-blue-800 mb-2">Tendencia Temporal de Casos Semanales</h1>
            <p class="text-gray-700 text-lg max-w-3xl leading-relaxed">
                Este panel visualiza los cambios en la cantidad de casos de dengue por semana, ayudando a detectar picos y descensos que guían decisiones de salud pública y modelamiento predictivo.
            </p>
        </div>

        <!-- Gráfico de picos -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-12">
            <h2 class="text-xl font-semibold text-blue-700 mb-4">Gráfico de Casos por Semana Año 2023</h2>
            <canvas id="graficoPicos" height="100"></canvas>
        </div>

        <!-- Tabla comparativa -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-12">
            <h2 class="text-xl font-semibold text-blue-700 mb-4">Comparación Semana a Semana</h2>
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-100 text-gray-600">
                        <th class="p-3">Semana</th>
                        <th class="p-3">Casos</th>
                        <th class="p-3">Variación</th>
                        <th class="p-3">Tendencia</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <tr class="border-t">
                        <td class="p-3">S11</td>
                        <td class="p-3">134</td>
                        <td class="p-3">+49</td>
                        <td class="p-3 text-green-600">⬆️ Aumento</td>
                    </tr>
                    <tr class="border-t">
                        <td class="p-3">S12</td>
                        <td class="p-3">180</td>
                        <td class="p-3">+46</td>
                        <td class="p-3 text-orange-500">⬆️ Notable</td>
                    </tr>
                    <tr class="border-t">
                        <td class="p-3">S13</td>
                        <td class="p-3">253</td>
                        <td class="p-3">+73</td>
                        <td class="p-3 text-red-600 font-bold">⬆️ Pico</td>
                    </tr>
                    <tr class="border-t">
                        <td class="p-3">S14</td>
                        <td class="p-3">345</td>
                        <td class="p-3">+92</td>
                        <td class="p-3 text-red-600 font-bold">⬆️ Máximo</td>
                    </tr>
                    <tr class="border-t">
                        <td class="p-3">S15</td>
                        <td class="p-3">280</td>
                        <td class="p-3">-65</td>
                        <td class="p-3 text-yellow-500">⬇️ Descenso</td>
                    </tr>
                    <tr class="border-t">
                        <td class="p-3">S16</td>
                        <td class="p-3">198</td>
                        <td class="p-3">-82</td>
                        <td class="p-3 text-yellow-500">⬇️ Fuerte baja</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Observación final -->
        <div class="max-w-3xl">
            <h3 class="text-lg font-semibold text-blue-700 mb-2">Observaciones Generales</h3>
            <p class="text-gray-700 text-base leading-relaxed">
                La visualización combinada permite detectar patrones semanales críticos, donde se destacan semanas de mayor incidencia como S14. Estos datos sirven como base para entrenar modelos predictivos de brotes a futuro y tomar decisiones oportunas.
            </p>
        </div>
    </main>
</section>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('graficoPicos').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['S10', 'S11', 'S12', 'S13', 'S14', 'S15', 'S16'],
        datasets: [{
            label: 'Casos',
            data: [85, 134, 180, 253, 345, 280, 198],
            fill: false,
            borderColor: '#3B82F6',
            backgroundColor: '#3B82F6',
            tension: 0.4,
            pointRadius: 6,
            pointHoverRadius: 8,
            pointBackgroundColor: function(context) {
                const value = context.raw;
                return value === 345 ? '#EF4444' : '#3B82F6';
            }
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return ` Casos: ${context.raw}`;
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 50 }
            }
        }
    }
});
</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
