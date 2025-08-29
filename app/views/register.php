<?php
if (session_status() === PHP_SESSION_NONE) session_start();

/* Flash desde el controlador */
$flash_error   = $_SESSION['flash_error']   ?? null;
$from_post     = !empty($_SESSION['__from_register_post']); // lo marca RegisterController solo en POST fallido
$flash_success = $_SESSION['flash_success'] ?? null;

/* Detectar si REALMENTE venimos del submit de registro (referer seguro) */
$referer = $_SERVER['HTTP_REFERER'] ?? '';
$came_from_register_post = $from_post && $flash_error
    && strpos($referer, 'index.php') !== false
    && strpos($referer, 'action=register') !== false;

/* Limpiar flashes para que no persistan en refrescos */
unset($_SESSION['flash_error'], $_SESSION['flash_success'], $_SESSION['__from_register_post']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Registro · Random Forest Dengue</title>

  <link rel="stylesheet" href="/public/css/estiloregister.css?v=6">
  <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>

  <div class="container">
    <!-- Panel izquierdo -->
    <div class="toggle-box">
      <span class="badge">Random Forest · Dengue</span>
      <h1>Crear una cuenta</h1>
      <p>Accede a tableros, indicadores y módulos de monitoreo de brotes. Completa tus datos para registrarte.</p>
    </div>

    <!-- Panel derecho -->
    <div class="form-box">
      <div class="header">
        <h1>Registro</h1>
        <p>Completa los campos para crear tu cuenta</p>
      </div>

      <!-- Nada de alertas HTML permanentes -->

      <form action="/index.php?action=register" method="POST" autocomplete="off" novalidate>
        <div class="input-box">
          <label for="nombre">Nombres</label>
          <input id="nombre" type="text" name="nombre" placeholder="Tu nombre" required autocomplete="given-name" />
          <i class='bx bxs-user' aria-hidden="true"></i>
        </div>

        <div class="input-box">
          <label for="apellido">Apellidos</label>
          <input id="apellido" type="text" name="apellido" placeholder="Tus apellidos" required autocomplete="family-name" />
          <i class='bx bxs-id-card' aria-hidden="true"></i>
        </div>

        <div class="input-box">
          <label for="email">Email</label>
          <input id="email" type="email" name="email" placeholder="tu@correo.com" required autocomplete="email" />
          <i class='bx bxs-envelope' aria-hidden="true"></i>
        </div>

        <div class="input-box">
          <label for="password">Password</label>
          <input id="password" type="password" name="password" placeholder="••••••••" required autocomplete="new-password" />
          <i class='bx bxs-lock-alt' aria-hidden="true"></i>
        </div>

        <div class="input-box">
          <label for="password2">Confirmar password</label>
          <input id="password2" type="password" name="password2" placeholder="Repite tu password" required autocomplete="new-password" />
          <i class='bx bxs-lock' aria-hidden="true"></i>
        </div>

        <button type="submit" class="btn">Crear cuenta</button>
        <a href="/index.php?action=showLogin" class="btn btn--secondary">Volver al login</a>
      </form>
    </div>
  </div>

  <script>
    // Validación mínima en cliente
    document.querySelector('form')?.addEventListener('submit', function (e) {
      const p1 = document.getElementById('password').value.trim();
      const p2 = document.getElementById('password2').value.trim();

      if (p1.length < 6) {
        e.preventDefault();
        Swal.fire({icon:'warning', title:'Contraseña muy corta', text:'Usa al menos 6 caracteres.'});
        return;
      }
      if (p1 !== p2) {
        e.preventDefault();
        Swal.fire({icon:'error', title:'No coinciden', text:'Las contraseñas deben ser iguales.'});
        return;
      }
    });

    // Solo mostrar SweetAlert si venimos del POST fallido (no en visitas directas)
    <?php if ($came_from_register_post): ?>
      Swal.fire({
        icon: 'error',
        title: 'Revisa los campos',
        text: <?= json_encode($flash_error, JSON_UNESCAPED_UNICODE) ?>,
        confirmButtonColor: '#1565c0'
      });
    <?php endif; ?>
  </script>
</body>
</html>
