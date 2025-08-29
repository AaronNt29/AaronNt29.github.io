<?php
// app/models/User.php
require_once __DIR__ . '/../../config/database.php';

class User {
    private PDO $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->conn;
        // Asegura modo por defecto a FETCH_ASSOC si tu Database no lo hizo
        $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    /* ========= Lecturas básicas ========= */

    /** Busca por email (retorna array asociativo o null) */
    public function findByEmail(string $email): ?array {
        $sql = "SELECT id_user, name, email, password_hash, status, last_login_at, created_at, updated_at
                FROM users
                WHERE email = :email
                LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':email', trim(mb_strtolower($email)));
        $stmt->execute();
        $row = $stmt->fetch();
        return $row ?: null;
    }

    /** Alias legacy mantenido por compatibilidad */
    public function authenticateByEmail(string $email) {
        return $this->findByEmail($email);
    }

    /** Verifica si existe email */
    public function isEmailTaken(string $email): bool {
        return (bool) $this->findByEmail($email);
    }

    /** Obtiene usuario por id. Si $withHash=true incluye password_hash */
    public function findById(int $id_user, bool $withHash = false): ?array {
        $fields = 'id_user, name, email, status, last_login_at, created_at, updated_at';
        if ($withHash) $fields .= ', password_hash';

        $sql = "SELECT $fields FROM users WHERE id_user = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id_user, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row ?: null;
    }

    /* ========= Escrituras / updates ========= */

    /** Inserta usuario. Retorna id insertado o false si falla. */
    public function create(array $data) {
        // Espera: ['nombre'=>..., 'apellido'=>..., 'email'=>..., 'password'=>...]
        $nombre   = trim($data['nombre']   ?? '');
        $apellido = trim($data['apellido'] ?? '');
        $email    = trim(mb_strtolower($data['email'] ?? ''));
        $password = $data['password'] ?? '';

        if ($nombre === '' || $apellido === '' || $email === '' || $password === '') {
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        if ($this->isEmailTaken($email)) {
            // Puedes capturar esto en el controlador para mostrar error=email
            return false;
        }

        $fullName = trim($nombre . ' ' . $apellido);
        $hash     = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, email, password_hash, status)
                VALUES (:name, :email, :password_hash, :status)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':name',          $fullName);
        $stmt->bindValue(':email',         $email);
        $stmt->bindValue(':password_hash', $hash);
        $stmt->bindValue(':status',        1, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            return false;
        }

        return (int) $this->conn->lastInsertId();
    }

    /** Actualiza last_login_at = NOW() */
    public function updateLastLogin(int $id_user): void {
        $sql = "UPDATE users SET last_login_at = NOW() WHERE id_user = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id_user, PDO::PARAM_INT);
        $stmt->execute();
    }

    /** ¿El email está usado por otro usuario distinto a $excludeId? */
    public function isEmailTakenByOther(string $email, int $excludeId): bool {
        $sql = "SELECT 1 FROM users WHERE email = :email AND id_user <> :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':email' => trim(mb_strtolower($email)),
            ':id'    => $excludeId
        ]);
        return (bool) $stmt->fetch();
    }

    /** Actualiza nombre y email */
    public function updateProfile(int $id_user, string $name, string $email): bool {
        $name  = trim($name);
        $email = trim(mb_strtolower($email));

        if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) return false;
        if ($this->isEmailTakenByOther($email, $id_user)) return false;

        $sql = "UPDATE users
                SET name = :name, email = :email, updated_at = NOW()
                WHERE id_user = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':name'=>$name, ':email'=>$email, ':id'=>$id_user]);
    }

    /* ========= Autenticación completa ========= */

    /**
     * Autentica por email y password.
     * Retorna array de usuario si OK, o null si credenciales inválidas / inactivo.
     */
    public function authenticate(string $email, string $password): ?array {
        $user = $this->findByEmail($email);
        if (!$user) return null;

        // Verifica estado activo (1 = activo)
        if (isset($user['status']) && (int)$user['status'] !== 1) {
            return null;
        }

        if (!isset($user['password_hash']) || !password_verify($password, $user['password_hash'])) {
            return null;
        }

        return $user;
    }

    /** Actualiza el hash de contraseña por id_user */
    public function updatePasswordById(int $id_user, string $hash): bool {
        $sql = "UPDATE users SET password_hash = :pwd WHERE id_user = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':pwd' => $hash, ':id' => $id_user]);
    }
}
