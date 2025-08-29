<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Nueva contraseña · Dengue Perú Analytics</title>

  <link rel="stylesheet" href="/public/css/estilologin.css?v=4">
  <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>

  <div class="container">
    <!-- Panel de formulario (izquierda) -->
    <div class="form-box">
      <div class="header">
        <h1>Nueva contraseña</h1>
        <p>Crea una nueva contraseña para tu cuenta.</p>
      </div>

      <?php if (!empty($_SESSION['flash_error'])): ?>
        <div class="error-message" style="margin-bottom:12px;">
          <?= htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="/index.php?action=resetPassword" autocomplete="off" novalidate>
        <!-- 🔐 Token oculto: IMPRESCINDIBLE -->
        <input type="hidden" name="token" value="<?= htmlspecialchars($token ?? ($_GET['token'] ?? '')) ?>">

        <!-- Password -->
        <div class="input-box">
          <label for="password">Nueva contraseña</label>
          <div class="input-wrap">
            <input id="password" type="password" name="password" placeholder="••••••••" required minlength="6">
            <i class='bx bxs-lock-alt'></i>
          </div>
        </div>

        <!-- Confirm -->
        <div class="input-box">
          <label for="password2">Confirmar contraseña</label>
          <div class="input-wrap">
            <input id="password2" type="password" name="password2" placeholder="••••••••" required minlength="6">
            <i class='bx bxs-lock-alt'></i>
          </div>
        </div>

        <!-- Acciones -->
        <button class="btn" type="submit">Guardar</button>
        <a class="btn btn--secondary" href="/index.php?action=showLogin">Cancelar</a>
      </form>
    </div>

    <!-- Panel de marca (derecha) -->
    <div class="toggle-box">
      <span class="badge">Random Forest · Dengue</span>
      <h1>Dengue Perú Analytics</h1>
      <p>Analítica temporal y espacial de brotes con modelos Random Forest. 
         Restablece tu acceso para continuar con tus indicadores y tableros.</p>
    </div>
  </div>

</body>
</html>
