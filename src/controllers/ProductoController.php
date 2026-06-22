<?php

namespace Controllers;

use Core\Controller;
use Models\Producto;

class ProductoController extends Controller
{
    private Producto $model;

    public function __construct()
    {
        $this->model = new Producto();
    }

    /**
     * Lista todos los productos y muestra el formulario de creación.
     */
    public function index(): void
    {
        $productos = $this->model->getAll();
        $mensaje   = $_SESSION['mensaje'] ?? null;
        unset($_SESSION['mensaje']);

        $this->render('productos', [
            'title'     => 'Productos',
            'productos' => $productos,
            'mensaje'   => $mensaje,
        ]);
    }

    /**
     * Crea un nuevo producto (POST).
     */
    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('index.php?controller=productos&action=index');
            return;
        }

        $codigo      = trim($_POST['codigo'] ?? '');
        $nombre      = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $precio      = (float) ($_POST['precio'] ?? 0);
        $stock       = (int) ($_POST['stock'] ?? 0);

        // Validación básica
        if ($codigo === '' || $nombre === '' || $precio < 0 || $stock < 0) {
            $_SESSION['mensaje'] = ['type' => 'error', 'text' => '❌ Todos los campos son obligatorios.'];
            $this->redirect('index.php?controller=productos&action=index');
            return;
        }

        try {
            $this->model->create($codigo, $nombre, $descripcion, $precio, $stock);
            $_SESSION['mensaje'] = ['type' => 'success', 'text' => '✅ Producto agregado correctamente.'];
        } catch (\PDOException $e) {
            if ($e->getCode() == 23000) {
                $_SESSION['mensaje'] = ['type' => 'error', 'text' => '❌ El código ya existe.'];
            } else {
                $_SESSION['mensaje'] = ['type' => 'error', 'text' => '❌ Error al guardar.'];
            }
        }

        $this->redirect('index.php?controller=productos&action=index');
    }

    /**
     * Elimina un producto (GET con confirmación).
     */
    public function delete(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        if ($id > 0) {
            $this->model->delete($id);
            $_SESSION['mensaje'] = ['type' => 'success', 'text' => '🗑️ Producto eliminado.'];
        }

        $this->redirect('index.php?controller=productos&action=index');
    }
}
