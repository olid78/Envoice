<?php
class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function register($name, $email, $password, $business_name) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (name, email, password_hash, business_name) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $email, $hash, $business_name]);
    }

    public function login($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            return true;
        }
        return false;
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($id, $data) {
        $fields = [];
        $values = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = ?";
            $values[] = $value;
        }
        $values[] = $id;
        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }

    public static function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public static function logout() {
        session_destroy();
    }
}
