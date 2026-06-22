<?php

namespace Models;

use Core\Model;

class Movimiento extends Model
{
    /**
     * Obtiene todos los movimientos con información del producto (JOIN).
     */
    public function getAllWithProducto(): array
    {
        $stmt = $this->db->query("
            SELECT m.*, p.nombre, p.codigo 
            FROM movimientos m 
            JOIN productos p ON m.producto_id = p.id 
            ORDER BY m.fecha DESC
        ");
        return $stmt->fetchAll();
    }

    /**
     * Registra un nuevo movimiento y actualiza el stock automáticamente.
     * Usa una transacción para garantizar la integridad de los datos.
     *
     * @param int    $productoId  ID del producto
     * @param string $tipo        'ingreso' | 'salida' | 'venta'
     * @param int    $cantidad    Cantidad de unidades
     * @param string $motivo      Motivo del movimiento
     * @return array  ['success' => bool, 'message' => string]
     */
    public function registrar(int $productoId, string $tipo, int $cantidad, string $motivo): array
    {
        // Validar que el producto exista y obtener su stock actual
        $stmtProducto = $this->db->prepare("SELECT stock FROM productos WHERE id = :id");
        $stmtProducto->execute(['id' => $productoId]);
        $producto = $stmtProducto->fetch();

        if (!$producto) {
            return ['success' => false, 'message' => '❌ El producto no existe.'];
        }

        // Validar stock suficiente para salidas y ventas
        if (in_array($tipo, ['salida', 'venta']) && $cantidad > $producto['stock']) {
            return [
                'success' => false,
                'message' => "❌ Stock insuficiente. Disponible: {$producto['stock']}"
            ];
        }

        try {
            // Iniciar transacción
            $this->db->beginTransaction();

            // 1. Insertar el movimiento
            $stmtMov = $this->db->prepare(
                "INSERT INTO movimientos (producto_id, tipo, cantidad, motivo) 
                 VALUES (:producto_id, :tipo, :cantidad, :motivo)"
            );
            $stmtMov->execute([
                'producto_id' => $productoId,
                'tipo'        => $tipo,
                'cantidad'    => $cantidad,
                'motivo'      => $motivo,
            ]);

            // 2. Actualizar stock (ingreso suma, salida/venta resta)
            $cambio = ($tipo === 'ingreso') ? $cantidad : -$cantidad;

            $stmtStock = $this->db->prepare(
                "UPDATE productos SET stock = stock + :cambio WHERE id = :id"
            );
            $stmtStock->execute(['cambio' => $cambio, 'id' => $productoId]);

            // Confirmar transacción
            $this->db->commit();

            $tipoLabel = match($tipo) {
                'ingreso' => '📥 Ingreso',
                'salida'  => '📤 Salida',
                'venta'   => '💰 Venta',
                default   => $tipo,
            };

            return ['success' => true, 'message' => "✅ {$tipoLabel} registrado. Stock actualizado."];

        } catch (\Exception $e) {
            // Revertir en caso de error
            $this->db->rollBack();
            return ['success' => false, 'message' => '❌ Error al registrar: ' . $e->getMessage()];
        }
    }
}
