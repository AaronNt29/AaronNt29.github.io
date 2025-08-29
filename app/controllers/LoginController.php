<?php
// app/controllers/LoginController.php
require_once __DIR__ . '/../models/User.php';

class LoginController {

    // Mostrar el formulario de login
    public function showLogin() {
        include __DIR__ . '/../views/login.php';
    }

    // Autenticar usuario
    public function login($email, $password) {
        $email    = trim(mb_strtolower((string)$email));
        $password = (string)$password;

        if ($email === '' || $password === '') {
            header('Location: /index.php?action=showLogin&error=1');
            exit;
        }

        try {
            $userModel = new User();

            // Usa el método de autenticación del modelo (verifica status y password_hash)
            $user = $userModel->authenticate($email, $password);

            if ($user) {
                if (session_status() === PHP_SESSION_NONE) session_start();

                $_SESSION['id_user'] = (int)$user['id_user'];
                $_SESSION['name']    = $user['name'] ?? '';
                $_SESSION['email']   = $user['email'] ?? $email;

                // Marca último acceso
                $userModel->updateLastLogin((int)$user['id_user']);

                header('Location: /index.php?action=inicio');
                exit;
            }

            // Credenciales inválidas o usuario inactivo
            header('Location: /index.php?action=showLogin&error=1');
            exit;

        } catch (Throwable $e) {
            // Log opcional: error_log($e->getMessage());
            header('Location: /index.php?action=showLogin&error=1');
            exit;
        }
    }

    // Cerrar sesión
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_unset();
        session_destroy();
        header('Location: /index.php?action=showLogin');
        exit;
    }
}
