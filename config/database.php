<?php
class Database {
    private static $pdo;

    public static function connect() {
        if (!self::$pdo) {
            $host = 'db';  // Используем имя сервиса MySQL из docker-compose.yml
            $dbname = 'todo_app';
            $username = 'root';
            $password = 'root_password';

            self::$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        }
        return self::$pdo;
    }
}
