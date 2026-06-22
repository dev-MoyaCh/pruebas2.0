<div class="stats">
    <div class="stat-box">
        <h3><?= $stats['totalProductos'] ?></h3>
        <p>📦 Productos registrados</p>
    </div>
    <div class="stat-box">
        <h3><?= $stats['totalStock'] ?></h3>
        <p>📊 Unidades en stock</p>
    </div>
    <div class="stat-box">
        <h3><?= $stats['totalVendidas'] ?></h3>
        <p>💰 Unidades vendidas</p>
    </div>
    <div class="stat-box">
        <h3>$<?= number_format($stats['valorInventario'], 2) ?></h3>
        <p>💵 Valor del inventario</p>
    </div>
</div>

<div class="card" style="margin-top: 30px;">
    <h2>⚡ Accesos rápidos</h2>
    <div style="display: flex; gap: 15px; margin-top: 15px; flex-wrap: wrap;">
        <a href="index.php?controller=productos&action=index" class="btn-link">📦 Gestionar Productos</a>
        <a href="index.php?controller=movimientos&action=index" class="btn-link">🔄 Registrar Movimiento</a>
        <a href="index.php?controller=movimientos&action=historial" class="btn-link">📜 Ver Historial</a>
    </div>
</div>