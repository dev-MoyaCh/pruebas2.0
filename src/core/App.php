<?php

namespace Core;

/**
 * Router simple que interpreta la URL y despacha al controlador correcto.
 * URL esperada: index.php?controller=productos&action=index
 */
class App
{
    private string $controller;
    private string $action;
    private array  $params;

    public function __construct()
    {
        $this->controller = $_GET['controller'] ?? 'dashboard';
        $this->action     = $_GET['action']     ?? 'index';
        $this->params     = $_GET;
    }

    /**
     * Ejecuta el controlador y la acción correspondiente.
     */
    public function run(): void
    {
        // Normalizar nombre del controlador: "productos" → "ProductoController"
        $controllerName = ucfirst(rtrim($this->controller, 's')) . 'Controller';
        $controllerClass = "Controllers\\{$controllerName}";
        $action = $this->action;

        // Verificar que la clase del controlador existe
        if (!class_exists($controllerClass)) {
            die("Error: El controlador '{$controllerName}' no existe.");
        }

        $controller = new $controllerClass();

        // Verificar que el método existe
        if (!method_exists($controller, $action)) {
            die("Error: La acción '{$action}' no existe en {$controllerName}.");
        }

        // Ejecutar la acción
        $controller->$action();
    }
}
