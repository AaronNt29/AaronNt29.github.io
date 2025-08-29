<?php
// app/controllers/UserController.php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../models/User.php';

class UserController {
    private User $model;

    public function __construct() {
        $this->model = new User();
    }

    /** Muestra el perfil */
    public function showProfile(): void {
        if (empty($_SESSION['id_user'])) {
            header('Location: /index.php?action=showLogin'); exit;
        }
        $user = $this->model->findById((int)$_SESSION['id_user']);
        if (!$user) {
            $_SESSION['flash_error'] = 'No se encontró el usuario.';
            header('Location: /index.php?action=inicio'); exit;
        }
        $active_page  = 'usuario';
        $page_title   = "Mi Perfil";
        $navbar_title = "Perfil de Usuario";
        include __DIR__ . '/../views/usuario.php';
    }

    /** POST: Actualizar nombre/email */
    public function updateProfile(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: /index.php?action=usuario'); exit; }
        if (empty($_SESSION['id_user'])) { header('Location: /index.php?action=showLogin'); exit; }

        $id    = (int)$_SESSION['id_user'];
        $name  = $_POST['name']  ?? '';
        $email = $_POST['email'] ?? '';

        if ($this->model->updateProfile($id, $name, $email)) {
            // refrescar sesión si la usas en navbar/header
            $_SESSION['name']  = $name;
            $_SESSION['email'] = $email;
            $_SESSION['flash_success'] = 'Perfil actualizado correctamente.';
        } else {
            $_SESSION['flash_error'] = 'No se pudo actualizar. Verifica el email o intenta nuevamente.';
        }
        header('Location: /index.php?action=usuario'); exit;
    }

    /** POST: Cambiar contraseña */
    public function changePassword(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: /index.php?action=usuario'); exit; }
        if (empty($_SESSION['id_user'])) { header('Location: /index.php?action=showLogin'); exit; }

        $id     = (int)$_SESSION['id_user'];
        $actual = $_POST['current_password'] ?? '';
        $nueva  = $_POST['new_password'] ?? '';
        $conf   = $_POST['confirm_password'] ?? '';

        if ($nueva === '' || $nueva !== $conf) {
            $_SESSION['flash_error'] = 'La nueva contraseña y su confirmación no coinciden.';
            header('Location: /index.php?action=usuario'); exit;
        }

        $user = $this->model->findById($id, true);
        if (!$user || empty($user['password_hash']) || !password_verify($actual, $user['password_hash'])) {
            $_SESSION['flash_error'] = 'Tu contraseña actual es incorrecta.';
            header('Location: /index.php?action=usuario'); exit;
        }

        $hash = password_hash($nueva, PASSWORD_DEFAULT);
        if ($this->model->updatePasswordById($id, $hash)) {
            $_SESSION['flash_success'] = 'Contraseña actualizada.';
        } else {
            $_SESSION['flash_error'] = 'No se pudo actualizar la contraseña.';
        }
        header('Location: /index.php?action=usuario'); exit;
    }
}
