<?php

namespace Controllers;

use Core\Controller;
use Models\Movimiento;
use Models\Producto;

class MovimientoController extends Controller
{
    private Movimiento $movimientoModel;
    private Producto   $productoModel;

    public function __construct()
    {
        $this->movimientoModel = new Movimiento();
        $this->productoModel   = new Producto();
    }

    /**
     * Muestra el formulario de registro de movimientos.
     */
    public function index(): void
    {
        $productos = $this->productoModel->getAll();
        $mensaje   = $_SESSION['mensaje'] ?? null;
        unset($_SESSION['mensaje']);

        $this->render('movimientos', [
            'title'     => 'Movimientos',
            'productos' => $productos,
            'mensaje'   => $mensaje,
        ]);
    }

    /**
     * Registra un nuevo movimiento (POST).
     * Delega la lógica al modelo Movimiento (transacción + actualización de stock).
     */
    public function registrar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?controller=movimientos&action=index');
            return;
        }

        $productoId = (int) ($_POST['producto_id'] ?? 0);
        $tipo       = $_POST['tipo'] ?? '';
        $cantidad   = (int) ($_POST['cantidad'] ?? 0);
        $motivo     = trim($_POST['motivo'] ?? '');

        // Validación básica
        if ($productoId <= 0 || !in_array($tipo, ['ingreso', 'salida', 'venta']) || $cantidad <= 0) {
            $_SESSION['mensaje'] = ['type' => 'error', 'text' => '❌ Datos inválidos.'];
            $this->redirect('index.php?controller=movimientos&action=index');
            return;
        }

        // Delegar al modelo (maneja transacción y validación de stock)
        $resultado = $this->movimientoModel->registrar($productoId, $tipo, $cantidad, $motivo);

        $_SESSION['mensaje'] = [
            'type' => $resultado['success'] ? 'success' : 'error',
            'text' => $resultado['message'],
        ];

        $this->redirect('index.php?controller=movimientos&action=index');
    }

    /**
     * Muestra el historial completo de movimientos.
     */
    public function historial(): void
    {
        $movimientos = $this->movimientoModel->getAllWithProducto();

        $this->render('historial', [
            'title'       => 'Historial',
            'movimientos' => $movimientos,
        ]);
    }
}