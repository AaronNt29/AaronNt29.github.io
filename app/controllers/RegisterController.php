<?php
// app/controllers/RegisterController.php
require_once __DIR__ . '/../models/User.php';

class RegisterController {

    public function showRegister() {
        include __DIR__ . '/../views/register.php';
    }

    public function register($nombre, $apellido, $email, $password, $password2) {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // Normalización
        $nombre   = trim((string)$nombre);
        $apellido = trim((string)$apellido);
        $email    = trim(mb_strtolower((string)$email));
        $password = (string)$password;
        $password2= (string)$password2;

        // Función helper para setear flash y flag
        $fail = function(string $msg){
            $_SESSION['__from_register_post'] = 1;     // <- FLAG
            $_SESSION['flash_error'] = $msg;
            header('Location: /index.php?action=showRegister');
            exit;
        };

        // Validaciones
        if ($nombre === '' || $apellido === '' || $email === '' || $password === '' || $password2 === '') {
            $fail('Completa todos los campos.');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $fail('Correo inválido.');
        }
        if ($password !== $password2) {
            $fail('Las contraseñas no coinciden.');
        }
        if (strlen($password) < 6) {
            $fail('La contraseña debe tener al menos 6 caracteres.');
        }

        try {
            $userModel = new User();

            if ($userModel->isEmailTaken($email)) {
                $fail('El email ya está registrado.');
            }

            $id = $userModel->create([
                'nombre'   => $nombre,
                'apellido' => $apellido,
                'email'    => $email,
                'password' => $password, // el modelo hace password_hash
            ]);

            if (!$id) {
                $fail('No se pudo crear la cuenta. Intenta de nuevo.');
            }

            // Éxito: limpiamos posibles flags y mandamos al login
            unset($_SESSION['__from_register_post'], $_SESSION['flash_error']);
            $_SESSION['flash_success'] = 'Tu cuenta fue creada. Ahora puedes iniciar sesión.';
            header('Location: /index.php?action=showLogin');
            exit;

        } catch (Throwable $e) {
            $fail('Ocurrió un error inesperado.');
        }
    }
}
