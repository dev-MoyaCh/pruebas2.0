<?php

namespace Config;

use PDO;
use PDOException;

/**
 * Clase Singleton para la conexión a la base de datos.
 * Garantiza que solo exista UNA conexión durante todo el ciclo de vida.
 */
class Database
{
    private static ?Database $instance = null;
    private PDO $pdo;

    private function __construct()
    {
        $host = 'localhost';
        $db   = 'inventario';
        $user = 'root';
        $pass = ''; // ← Cambia según tu configuración

        try {
            $this->pdo = new PDO(
                "mysql:host=$host;dbname=$db;charset=utf8mb4",
                $user,
                $pass,
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]
            );
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    /** Prevenir clonación */
    private function __clone() {}

    /** Obtener la única instancia */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /** Obtener la conexión PDO */
    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}
