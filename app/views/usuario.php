<?php
// app/views/usuario.php
if (session_status() === PHP_SESSION_NONE) session_start();

// Variables esperadas: $user (array), $page_title, $navbar_title, $active_page
require_once __DIR__ . '/partials/header.php';
require_once __DIR__ . '/partials/sidebar.php';
?>
<section id="content">
  <?php require_once __DIR__ . '/partials/navbar.php'; ?>

  <main class="usuario-main">
    <div class="usuario-header">
      <h1>Mi Perfil</h1>
      <p>Consulta y actualiza tus datos personales.</p>
    </div>

    <div class="usuario-grid">
      <!-- Tarjeta de resumen -->
      <div class="usuario-card">
        <div class="usuario-card-content">
          <i class='bx bxs-user-circle usuario-avatar'></i>
          <div>
            <h2><?= htmlspecialchars($user['name'] ?? ''); ?></h2>
            <p><?= htmlspecialchars($user['email'] ?? ''); ?></p>
          </div>
        </div>
        <hr>
        <div class="usuario-info">
          <p><strong>Último acceso:</strong> <?= htmlspecialchars($user['last_login_at'] ?? '—'); ?></p>
          <p><strong>Estado:</strong> <?= (isset($user['status']) && (int)$user['status']===1) ? 'Activo' : 'Inactivo'; ?></p>
          <p><strong>Creado:</strong> <?= htmlspecialchars($user['created_at'] ?? '—'); ?></p>
        </div>
      </div>

      <!-- Formulario perfil -->
      <div class="usuario-forms">
        <div class="usuario-form-box">
          <h3>Editar datos</h3>
          <form action="/index.php?action=usuarioUpdate" method="POST" autocomplete="off">
            <label>Nombre y Apellido</label>
            <input type="text" name="name" required value="<?= htmlspecialchars($user['name'] ?? ''); ?>">

            <label>Correo</label>
            <input type="email" name="email" required value="<?= htmlspecialchars($user['email'] ?? ''); ?>">

            <div class="usuario-form-actions">
              <button type="reset" class="btn-cancelar">Cancelar</button>
              <button type="submit" class="btn-guardar">Guardar</button>
            </div>
          </form>
        </div>

        <div class="usuario-form-box">
          <h3>Cambiar contraseña</h3>
          <form action="/index.php?action=usuarioChangePassword" method="POST" autocomplete="off">
            <label>Contraseña actual</label>
            <input type="password" name="current_password" required>

            <label>Nueva contraseña</label>
            <input type="password" name="new_password" required minlength="6">

            <label>Confirmar nueva</label>
            <input type="password" name="confirm_password" required minlength="6">

            <div class="usuario-form-actions">
              <button type="reset" class="btn-cancelar">Cancelar</button>
              <button type="submit" class="btn-guardar">Actualizar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>
</section>

<?php require_once __DIR__ . '/partials/footer.php'; ?>

<!-- SweetAlert de flashes -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if (!empty($_SESSION['flash_success'])): ?>
<script>
Swal.fire({icon:'success', title:'Listo', text:'<?= addslashes($_SESSION['flash_success']) ?>'});
</script>
<?php unset($_SESSION['flash_success']); endif; ?>

<?php if (!empty($_SESSION['flash_error'])): ?>
<script>
Swal.fire({icon:'error', title:'Atención', text:'<?= addslashes($_SESSION['flash_error']) ?>'});
</script>
<?php unset($_SESSION['flash_error']); endif; ?>
