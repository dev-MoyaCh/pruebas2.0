<?php if (!empty($mensaje)): ?>
    <div class="alert alert-<?= $mensaje['type'] ?>"><?= $mensaje['text'] ?></div>
<?php endif; ?>

<div class="card">
    <h2>🔄 Registrar nuevo movimiento</h2>
    <form method="POST" action="index.php?controller=movimientos&action=registrar">
        <div class="form-grid">
            <div class="form-group">
                <label>Producto:</label>
                <select name="producto_id" required>
                    <option value="">— Selecciona un producto —</option>
                    <?php foreach ($productos as $p): ?>
                        <option value="<?= $p['id'] ?>">
                            <?= htmlspecialchars($p['codigo'] . ' — ' . $p['nombre']) ?>
                            (Stock: <?= $p['stock'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Tipo de movimiento:</label>
                <select name="tipo" required>
                    <option value="ingreso">📥 Ingreso (suma al stock)</option>
                    <option value="salida">📤 Salida (resta del stock)</option>
                    <option value="venta">💰 Venta (resta del stock)</option>
                </select>
            </div>
            <div class="form-group">
                <label>Cantidad:</label>
                <input type="number" name="cantidad" min="1" placeholder="Cantidad" required>
            </div>
            <div class="form-group">
                <label>Motivo / Observación:</label>
                <input type="text" name="motivo" placeholder="Ej: Compra a proveedor, Venta a cliente...">
            </div>
        </div>
        <button type="submit">✅ Registrar movimiento</button>
    </form>
</div>