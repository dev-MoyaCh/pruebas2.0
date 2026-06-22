<?php

namespace Core;

use Config\Database;
use PDO;

/**
 * Clase abstracta base para todos los modelos.
 * Proporciona acceso a la conexión PDO.
 */
abstract class Model
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
}