<?php

namespace Models;

use Core\Model;

class Producto extends Model
{
    /**
     * Obtiene todos los productos ordenados por nombre.
     */
    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM productos ORDER BY nombre ASC");
        return $stmt->fetchAll();
    }

    /**
     * Busca un producto por su ID.
     */
    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM productos WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Crea un nuevo producto.
     */
    public function create(string $codigo, string $nombre, string $descripcion, float $precio, int $stock): bool
    {
        $stmt = $this->db->prepare(
            "INSERT INTO productos (codigo, nombre, descripcion, precio, stock) 
             VALUES (:codigo, :nombre, :descripcion, :precio, :stock)"
        );
        return $stmt->execute([
            'codigo'      => $codigo,
            'nombre'      => $nombre,
            'descripcion' => $descripcion,
            'precio'      => $precio,
            'stock'       => $stock,
        ]);
    }

    /**
     * Elimina un producto por su ID.
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM productos WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Actualiza el stock de un producto (suma o resta).
     *
     * @param int $id       ID del producto
     * @param int $cantidad Cantidad positiva (sumar) o negativa (restar)
     */
    public function updateStock(int $id, int $cantidad): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE productos SET stock = stock + :cantidad WHERE id = :id"
        );
        return $stmt->execute(['cantidad' => $cantidad, 'id' => $id]);
    }

    /**
     * Obtiene estadísticas generales del inventario.
     */
    public function getStats(): array
    {
        return [
            'totalProductos'  => $this->db->query("SELECT COUNT(*) FROM productos")->fetchColumn(),
            'totalStock'      => (int) $this->db->query("SELECT COALESCE(SUM(stock), 0) FROM productos")->fetchColumn(),
            'totalVendidas'   => (int) $this->db->query("SELECT COALESCE(SUM(cantidad), 0) FROM movimientos WHERE tipo='venta'")->fetchColumn(),
            'valorInventario' => (float) $this->db->query("SELECT COALESCE(SUM(precio * stock), 0) FROM productos")->fetchColumn(),
        ];
    }
}