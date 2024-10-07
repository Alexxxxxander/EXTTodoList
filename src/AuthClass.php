<?php
require_once __DIR__ . '/../config/database.php';

class AuthClass {
    public static function register($username, $password) {
        $db = Database::connect();
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Проверка на существующего пользователя
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        if ($stmt->fetch()) {
            return false; // Пользователь с таким именем уже существует
        }

        $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
        return $stmt->execute([
            'username' => $username,
            'password' => $hashedPassword
        ]);
    }

    public static function login($username, $password) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            return true;
        }
        return false;
    }



    public static function logout() {
        session_start();
        session_destroy();
    }
}
