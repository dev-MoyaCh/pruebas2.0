<?php

/**
 * Front Controller — Punto de entrada único de la aplicación.
 * Carga el autoloader y despacha la solicitud.
 */

// Autoloader simple con PSR-4 básico
spl_autoload_register(function (string $class): void {
    // Controllers\ProductoController → controllers/ProductoController.php
    // Models\Producto                → models/Producto.php
    // Config\Database                → config/Database.php
    // Core\App                       → core/App.php

    $file = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';

    // Convertir namespace a minúsculas para la carpeta
    $parts = explode('/', $file);
    $lastIndex = count($parts) - 1;

    // La carpeta (namespace) va en minúscula, la clase mantiene su nombre
    $folder = dirname($file);
    $folderLower = strtolower($folder);
    $fileName = basename($file);
    $file = $folderLower . '/' . $fileName;

    if (file_exists($file)) {
        require_once $file;
    }
});

use Core\App;

$app = new App();
$app->run();