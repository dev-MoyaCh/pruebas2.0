<?php

namespace Core;

/**
 * Clase abstracta base para todos los controladores.
 * Proporciona métodos para renderizar vistas y redirigir.
 */
abstract class Controller
{
    /**
     * Renderiza una vista dentro del layout.
     *
     * @param string $view Nombre de la vista (sin .php)
     * @param array  $data Datos que se pasarán a la vista
     */
    protected function render(string $view, array $data = []): void
    {
        // Extraer variables para que estén disponibles en la vista
        extract($data);

        $viewPath = __DIR__ . "/../views/{$view}.php";

        if (!file_exists($viewPath)) {
            die("Error: La vista '{$view}' no existe.");
        }

        // Incluir layout completo
        require __DIR__ . '/../views/layouts/header.php';
        require $viewPath;
        require __DIR__ . '/../views/layouts/footer.php';
    }

    /**
     * Redirige a otra URL.
     */
    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }
}