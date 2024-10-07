<?php

class Entity
{
    protected static $pdo;

    public static function getPDO()
    {
        if (!self::$pdo) {
            self::$pdo = Database::connect();
        }
        return self::$pdo;
    }

    // Пример метода fetchAll()
    protected static function fetchAll($sql, $params = [])
    {
        $stmt = self::getPDO()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Пример метода execute()
    protected static function execute($sql, $params = [])
    {
        $stmt = self::getPDO()->prepare($sql);
        return $stmt->execute($params);
    }
}
