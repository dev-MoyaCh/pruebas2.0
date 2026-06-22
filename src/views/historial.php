<div class="card">
    <h2>📜 Historial de movimientos</h2>

    <?php if (empty($movimientos)): ?>
        <p style="text-align:center; color:#999; padding:20px;">No hay movimientos registrados.</p>
    <?php else: ?>
        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Producto</th>
                        <th>Tipo</th>
                        <th>Cantidad</th>
                        <th>Motivo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($movimientos as $m): ?>
                    <tr>
                        <td><?= date('d/m/Y H:i', strtotime($m['fecha'])) ?></td>
                        <td><?= htmlspecialchars($m['codigo'] . ' — ' . $m['nombre']) ?></td>
                        <td>
                            <span class="badge badge-<?= $m['tipo'] ?>">
                                <?= strtoupper($m['tipo']) ?>
                            </span>
                        </td>
                        <td><strong><?= $m['cantidad'] ?></strong></td>
                        <td><?= htmlspecialchars($m['motivo'] ?: '—') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>