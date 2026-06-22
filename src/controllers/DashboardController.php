<?php

namespace Controllers;

use Core\Controller;
use Models\Producto;

class DashboardController extends Controller
{
    private Producto $productoModel;

    public function __construct()
    {
        $this->productoModel = new Producto();
    }

    /**
     * Acción principal: muestra el dashboard con estadísticas.
     */
    public function index(): void
    {
        $stats = $this->productoModel->getStats();

        $this->render('dashboard', [
            'title' => 'Dashboard',
            'stats' => $stats,
        ]);
    }
}