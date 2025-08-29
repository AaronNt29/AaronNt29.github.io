<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Recuperar contraseña · Dengue Perú Analytics</title>

  <link rel="stylesheet" href="/public/css/estilologin.css?v=4">
  <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>

  <div class="container">
    <!-- Panel de formulario (izquierda) -->
    <div class="form-box">
      <div class="header">
        <h1>¿Olvidaste tu contraseña?</h1>
        <p>Ingresa tu correo y te enviaremos un enlace para restablecerla.</p>
      </div>

      <?php if (isset($_GET['sent'])): ?>
        <div class="notice" style="margin-bottom:12px;">
          Si el correo existe, te enviaremos un enlace para restablecer tu contraseña.
        </div>
      <?php endif; ?>

      <?php if (isset($_GET['expired'])): ?>
        <div class="error-message" style="margin-bottom:12px;">
          El enlace expiró o no es válido. Solicítalo nuevamente.
        </div>
      <?php endif; ?>

      <form method="POST" action="/index.php?action=forgotRequest" autocomplete="off" novalidate>
        <div class="input-box">
          <label for="email">Correo</label>
          <div class="input-wrap">
            <input id="email" type="email" name="email" placeholder="tu@correo.com" required>
            <i class='bx bxs-envelope'></i>
          </div>
        </div>

        <button class="btn" type="submit">Enviar enlace</button>
        <a class="btn btn--secondary" href="/index.php?action=showLogin">Volver al login</a>
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
