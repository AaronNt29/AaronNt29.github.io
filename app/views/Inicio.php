<?php
// app/views/Inicio.php
if (session_status() === PHP_SESSION_NONE) session_start();

/* ================================================================
   BASE_URL y ASSET_BASE robustos (evita // y http://public/...)
   - BASE_URL: carpeta donde vive index.php (ej. "/", "/RFDENGUE")
   - ASSET_BASE: carpeta de assets (si estás en /public, la deja igual;
                 si no, agrega "/public")
================================================================= */
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '/';
$dir        = str_replace('\\', '/', dirname($scriptName));

$BASE_URL = '/' . ltrim($dir, '/');
$BASE_URL = rtrim($BASE_URL, '/');
if ($BASE_URL === '' || $BASE_URL === '\\') { $BASE_URL = '/'; }

if (substr($BASE_URL, -7) === '/public') {
    $ASSET_BASE = $BASE_URL;                          // ya estás en /public
} else {
    $ASSET_BASE = ($BASE_URL === '/') ? '/public' : $BASE_URL . '/public';
}

// ✅ El LoginController setea $_SESSION['id_user'] (no 'user_id')
if (empty($_SESSION['id_user'])) {
    header('Location: ' . $BASE_URL . '/index.php?action=showLogin');
    exit();
}

$page_title   = "Prototipo - Presentación";
$active_page  = 'inicio';
$navbar_title = "Presentación";

// Inyecta CSS (versionado para evitar caché)
$custom_css = [$ASSET_BASE . '/css/estilo.css?v=6'];
$custom_js  = [];

require_once __DIR__ . '/partials/header.php';
require_once __DIR__ . '/partials/sidebar.php';
?>

<section id="content">
    <?php require_once __DIR__ . '/partials/navbar.php'; ?>

    <main class="bg-gray-50 p-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-blue-800 mb-4">
                Modelo Random Forest para la Predicción de Brotes de Dengue en Perú
            </h1>
            <p class="text-gray-700 text-lg leading-relaxed max-w-4xl">
                Este prototipo es parte del desarrollo de un sistema web interactivo para predecir brotes de dengue en el Perú
                utilizando técnicas de aprendizaje automático, específicamente el algoritmo <strong>Random Forest</strong>. 
                Su objetivo es proporcionar una herramienta visual y analítica que apoye la toma de decisiones en salud pública, 
                basada en datos climáticos y epidemiológicos.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Tarjeta 1 -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="card-media">
                    <img src="<?= $ASSET_BASE ?>/img/ImgInicio/img1.jpg"
                         alt="Mapa y situación actual del dengue en Perú" loading="lazy">
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-blue-700 mb-2">Situación Actual del Dengue</h3>
                    <p class="text-gray-600 text-sm">
                        El dengue continúa siendo una de las principales amenazas epidemiológicas en diversas regiones del país.
                    </p>
                </div>
            </div>

            <!-- Tarjeta 2 -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="card-media">
                    <img src="<?= $ASSET_BASE ?>/img/ImgInicio/img2.png"
                         alt="Esquema del modelo predictivo Random Forest" loading="lazy">
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-blue-700 mb-2">Modelo Predictivo</h3>
                    <p class="text-gray-600 text-sm">
                        Se emplea Random Forest para predecir zonas de riesgo utilizando variables como temperatura, humedad y precipitaciones.
                    </p>
                </div>
            </div>

            <!-- Tarjeta 3 -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="card-media">
                    <img src="<?= $ASSET_BASE ?>/img/ImgInicio/img3.jpg"
                         alt="Dashboard de visualización interactiva de brotes" loading="lazy">
                </div>
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-blue-700 mb-2">Visualización Interactiva</h3>
                    <p class="text-gray-600 text-sm">
                        El sistema integrará dashboards visuales para interpretar datos históricos y pronósticos de brotes.
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-12 max-w-4xl">
            <h2 class="text-2xl font-bold text-blue-800 mb-4">Objetivos</h2>
            <p class="text-gray-700 text-lg leading-relaxed">
                Los objetivos específicos fueron los siguientes: a) 
                Predecir la incidencia de brotes de dengue mediante el modelo Random Forest en 
                Perú. b) Predecir la detección de patrones espaciales de los brotes de dengue 
                mediante el modelo Random Forest en Perú. c) Predecir la temporalidad de los 
                brotes de dengue mediante el modelo Random Forest en Perú. 
            </p>
        </div>
    </main>
</section>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
