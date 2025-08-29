<?php
// app/controllers/PasswordResetController.php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../models/User.php';

// Intentamos cargar Database según tu estructura (raíz /config o /app/config)
$dbCandidates = [
  __DIR__ . '/../../config/database.php',
  __DIR__ . '/../config/database.php'
];
foreach ($dbCandidates as $p) { if (is_file($p)) { require_once $p; break; } }

class PasswordResetController {
    private PDO $pdo;

    public function __construct() {
        if (!class_exists('Database')) {
            throw new Exception('No encuentro Database.php');
        }
        $db = new Database();
        $this->pdo = $db->conn;
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    // Carga mail.php desde /config o /app/config (según tengas)
    private function mailConfig(): array {
        $candidates = [
          __DIR__ . '/../../config/mail.php',
          __DIR__ . '/../config/mail.php'
        ];
        foreach ($candidates as $p) if (is_file($p)) return require $p;
        throw new Exception('mail.php no encontrado');
    }

    public function showForgot() {
        include __DIR__ . '/../views/forgot.php';
    }

    public function request() {
        $email = trim($_POST['email'] ?? '');
        $redirect = '/index.php?action=forgot&sent=1'; // respuesta genérica

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: $redirect"); exit;
        }

        $userModel = new User();
        $user = $userModel->findByEmail($email);
        if (!$user) { header("Location: $redirect"); exit; } // NO revelar si existe

        // Token
        $tokenPlain = bin2hex(random_bytes(32));         // 64 chars
        $tokenHash  = password_hash($tokenPlain, PASSWORD_DEFAULT);

        $sql = "INSERT INTO password_resets (user_id, token_hash, expires_at)
                VALUES (:uid, :hash, DATE_ADD(NOW(), INTERVAL 30 MINUTE))";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':uid'=>$user['id_user'], ':hash'=>$tokenHash]);

        // Link
        $base   = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? '/'), '/');
        $base   = ($base === '') ? '/' : $base;
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        $link   = $scheme . $_SERVER['HTTP_HOST'] . $base . '/index.php?action=reset&token=' . urlencode($tokenPlain);

        // Enviar correo (PHPMailer)
        $cfg = $this->mailConfig();
        require_once __DIR__ . '/../../vendor/autoload.php';
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = $cfg['host'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $cfg['username'];
            $mail->Password   = $cfg['password'];
            $mail->SMTPSecure = $cfg['secure'];
            $mail->Port       = $cfg['port'];
            $mail->CharSet    = 'UTF-8';

            $mail->setFrom($cfg['from'], $cfg['from_name']);
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Restablece tu contraseña';
            $mail->Body    = $this->resetEmailHtml($link);
            $mail->AltBody = "Abre este enlace para restablecer tu contraseña:\n$link";
            $mail->send();
        } catch (Exception $e) {
            error_log('Mailer Error: ' . $mail->ErrorInfo);
        }

        header("Location: $redirect"); exit;
    }

    public function showReset() {
        $token = $_GET['token'] ?? '';
        if (!$token || strlen($token) < 10) {
            header('Location: /index.php?action=forgot');
            exit;
        }
        include __DIR__ . '/../views/reset.php'; // el form incluye el token como hidden
    }

    public function resetPassword() {
        $token = $_POST['token'] ?? '';
        $pwd1  = $_POST['password'] ?? '';
        $pwd2  = $_POST['password2'] ?? '';

        if (!$token || !$pwd1 || $pwd1 !== $pwd2) {
            header('Location: /index.php?action=reset&token=' . urlencode($token) . '&error=1');
            exit;
        }

        // Buscar token vigente/no usado y que haga match (password_verify)
        $stmt = $this->pdo->query("SELECT id, user_id, token_hash, expires_at, used
                                   FROM password_resets
                                   WHERE used = 0 AND expires_at >= NOW()
                                   ORDER BY id DESC");
        $match = null;
        foreach ($stmt->fetchAll() as $row) {
            if (password_verify($token, $row['token_hash'])) { $match = $row; break; }
        }
        if (!$match) {
            header('Location: /index.php?action=forgot&expired=1');
            exit;
        }

        // Cambiar contraseña y marcar token usado
        $userModel = new User();
        $hash = password_hash($pwd1, PASSWORD_BCRYPT);
        $userModel->updatePasswordById((int)$match['user_id'], $hash);

        $upd = $this->pdo->prepare("UPDATE password_resets SET used = 1 WHERE id = :id");
        $upd->execute([':id' => $match['id']]);

        header('Location: /index.php?action=showLogin&pwd_changed=1');
        exit;
    }

    private function resetEmailHtml(string $link): string {
        $expires = '30 minutos';
        return '
        <div style="font-family:system-ui,Segoe UI,Arial;max-width:520px;margin:auto;padding:16px;">
          <h2 style="margin:0 0 12px;">Restablecer contraseña</h2>
          <p>Recibimos una solicitud para restablecer tu contraseña. Haz clic en el botón:</p>
          <p style="text-align:center;margin:24px 0;">
            <a href="'.htmlspecialchars($link).'" 
               style="display:inline-block;padding:12px 18px;text-decoration:none;border-radius:8px;
                      background:#1565c0;color:#fff;font-weight:600">
              Crear nueva contraseña
            </a>
          </p>
          <p>O copia este enlace:<br>
            <a href="'.htmlspecialchars($link).'">'.htmlspecialchars($link).'</a>
          </p>
          <p style="color:#555;font-size:14px">Este enlace vence en '.$expires.'. Si no lo solicitaste, ignora este mensaje.</p>
        </div>';
    }
}
