<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login · Random Forest Dengue</title>

  <!-- CSS principal del login -->
  <link rel="stylesheet" href="/public/css/estilologin.css?v=4">

  <!-- Iconos (Boxicons) -->
  <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

  <div class="container">
    <!-- Panel de marca / bienvenida -->
    <div class="toggle-box">
      <span class="badge">Random Forest · Dengue</span>
      <h1>Dengue Perú Analytics</h1>
      <p>Analítica temporal y espacial de brotes con modelos Random Forest. Ingresa para acceder a tus indicadores y tableros.</p>
    </div>

    <!-- Panel de formulario -->
    <div class="form-box">
      <div class="header">
        <h1>Iniciar sesión</h1>
        <p>Ingresa tus credenciales para continuar</p>
      </div>

      <form action="/index.php?action=login" method="POST" autocomplete="off" novalidate>
        <!-- Email -->
        <div class="input-box">
          <label for="email">Email</label>
          <div class="input-wrap">
            <input id="email" type="email" name="email" placeholder="tu@correo.com" required autocomplete="username" />
            <i class='bx bxs-user'></i>
          </div>
        </div>

        <!-- Password -->
        <div class="input-box">
          <label for="password">Password</label>
          <div class="input-wrap">
            <input id="password" type="password" name="password" placeholder="••••••••" required autocomplete="current-password" />
            <i class='bx bxs-lock-alt'></i>
          </div>
        </div>

        <!-- Olvidé mi contraseña -->
        <div class="forgot-link">
          <a href="/index.php?action=forgot">¿Olvidaste tu contraseña?</a>
        </div>

        <!-- Acciones -->
        <button type="submit" class="btn">Ingresar</button>
        <a href="/index.php?action=register" class="btn btn--secondary">Crear cuenta</a>

        <!-- Mensaje de error (desde ?error=1) -->
        <?php if (isset($_GET['error']) && $_GET['error'] === '1'): ?>
          <div class="error-message" style="margin-top:12px;">
            Email o contraseña incorrectos
          </div>
        <?php endif; ?>
      </form>
    </div>
  </div>

  <?php if (isset($_GET['error']) && $_GET['error'] === '1'): ?>
  <script>
    Swal.fire({
      icon:'error',
      title:'Error',
      text:'Email o contraseña incorrectos',
      confirmButtonColor:'#1565c0'
    });
  </script>
  <?php endif; ?>

</body>
</html>
