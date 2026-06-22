<?php if (!empty($mensaje)): ?>
    <div class="alert alert-<?= $mensaje['type'] ?>"><?= $mensaje['text'] ?></div>
<?php endif; ?>

<div class="card">
    <h2>➕ Agregar nuevo producto</h2>
    <form method="POST" action="index.php?controller=productos&action=create">
        <div class="form-grid">
            <div class="form-group">
                <label>Código:</label>
                <input type="text" name="codigo" placeholder="Ej: P003" required>
            </div>
            <div class="form-group">
                <label>Nombre:</label>
                <input type="text" name="nombre" placeholder="Nombre del producto" required>
            </div>
            <div class="form-group">
                <label>Precio:</label>
                <input type="number" step="0.01" min="0" name="precio" placeholder="0.00" required>
            </div>
            <div class="form-group">
                <label>Stock inicial:</label>
                <input type="number" min="0" name="stock" placeholder="0" required>
            </div>
        </div>
        <div class="form-group">
            <label>Descripción:</label>
            <textarea name="descripcion" placeholder="Descripción del producto..." rows="2"></textarea>
        </div>
        <button type="submit">💾 Guardar producto</button>
    </form>
</div>

<div class="card">
    <h2>📋 Listado de productos</h2>
    <?php if (empty($productos)): ?>
        <p style="text-align:center; color:#999; padding:20px;">No hay productos registrados.</p>
    <?php else: ?>
        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $p): ?>
                    <tr>
                        <td><code><?= htmlspecialchars($p['codigo']) ?></code></td>
                        <td><?= htmlspecialchars($p['nombre']) ?></td>
                        <td><?= htmlspecialchars($p['descripcion'] ?: '—') ?></td>
                        <td>$<?= number_format($p['precio'], 2) ?></td>
                        <td>
                            <strong class="<?= $p['stock'] <= 5 ? 'text-danger' : '' ?>">
                                <?= $p['stock'] ?>
                            </strong>
                        </td>
                        <td>
                            <a href="index.php?controller=productos&action=delete&id=<?= $p['id'] ?>"
                               onclick="return confirm('¿Estás seguro de eliminar este producto?')"
                               class="btn btn-danger">
                                🗑️ Eliminar
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>