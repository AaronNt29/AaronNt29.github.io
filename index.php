<?php
// index.php (RAÍZ)
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/app/controllers/LoginController.php';
require_once __DIR__ . '/app/controllers/RegisterController.php';
require_once __DIR__ . '/app/controllers/PasswordResetController.php';
require_once __DIR__ . '/app/controllers/UserController.php'; // ⬅️ NUEVO

$loginController     = new LoginController();
$registerController  = new RegisterController();
$passwordController  = new PasswordResetController();
$userController      = new UserController(); // ⬅️ NUEVO

$action = $_GET['action'] ?? 'showLogin';

switch ($action) {
    // ====== PASSWORD RESET ======
    case 'forgot':
        $passwordController->showForgot();
        break;

    case 'forgotRequest':
        if ($_SERVER['REQUEST_METHOD']==='POST') $passwordController->request();
        else header('Location: /index.php?action=forgot');
        break;

    case 'reset':
        $passwordController->showReset();
        break;

    case 'resetPassword':
        if ($_SERVER['REQUEST_METHOD']==='POST') $passwordController->resetPassword();
        else header('Location: /index.php?action=forgot');
        break;

    // ====== LOGIN ======
    case 'login': // procesa el formulario de login
        $email    = $_POST['email'] ?? null;
        $password = $_POST['password'] ?? null;

        if ($email && $password) {
            $loginController->login($email, $password);
        } else {
            $_SESSION['flash_error'] = 'Completa email y contraseña.';
            header('Location: /index.php?action=showLogin');
            exit;
        }
        break;

    case 'logout':
        $loginController->logout();
        break;

    // ====== INICIO (protegido) ======
    case 'inicio':
        if (empty($_SESSION['id_user'])) {
            header('Location: /index.php?action=showLogin');
            exit;
        }
        $active_page = 'inicio';
        include __DIR__ . '/app/views/Inicio.php';
        break;

    // ====== INDICADORES (protegidos) ======
    case 'indicador1':
        if (empty($_SESSION['id_user'])) { header('Location: /index.php?action=showLogin'); exit; }
        $active_page = 'atenciones';
        include __DIR__ . '/app/views/Indicador1.php';
        break;

    case 'indicador2':
        if (empty($_SESSION['id_user'])) { header('Location: /index.php?action=showLogin'); exit; }
        $active_page = 'Dashboards';
        include __DIR__ . '/app/views/Indicador2.php';
        break;

    case 'indicador3':
        if (empty($_SESSION['id_user'])) { header('Location: /index.php?action=showLogin'); exit; }
        $active_page = 'Archivos';
        include __DIR__ . '/app/views/Indicador3.php';
        break;

    case 'indicador4':
        if (empty($_SESSION['id_user'])) { header('Location: /index.php?action=showLogin'); exit; }
        $active_page = 'notas';
        include __DIR__ . '/app/views/Indicador4.php';
        break;

    // ====== REGISTRO ======
    case 'showRegister':
        $registerController->showRegister();
        break;

    case 'register': // procesa el formulario de registro
        $nombre    = $_POST['nombre']    ?? '';
        $apellido  = $_POST['apellido']  ?? '';
        $email     = $_POST['email']     ?? '';
        $password  = $_POST['password']  ?? '';
        $password2 = $_POST['password2'] ?? '';
        $registerController->register($nombre, $apellido, $email, $password, $password2);
        break;

    // ====== USUARIO (perfil/edición) ======
    case 'usuario':
        $userController->showProfile();
        break;

    case 'usuarioUpdate':
        $userController->updateProfile();
        break;

    case 'usuarioChangePassword':
        $userController->changePassword();
        break;

    // ====== LOGIN (vista por defecto) ======
    case 'showLogin':
    default:
        $loginController->showLogin();
        break;
}
