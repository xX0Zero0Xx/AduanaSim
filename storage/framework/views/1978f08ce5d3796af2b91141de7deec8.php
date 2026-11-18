<?php
    $iconos = [
        'users' => '♙', 'users-round' => '♧', 'blocks' => '▦', 'book-open' => '▤',
        'history' => '◷', 'clipboard-check' => '✓', 'badge-check' => '✓',
        'message-square-warning' => '!', 'file-text' => '▤', 'receipt-text' => '▧',
        'qr-code' => '▦', 'folder-clock' => '◷',
    ];
?>
<section class="aduana-module-view">
    <div class="aduana-module-view__heading">
        <div>
            <span class="aduana-eyebrow aduana-eyebrow--muted"><?php echo e($accion ?? 'GESTIÓN ADUANASIM'); ?></span>
            <h3><?php echo e($titulo); ?></h3>
            <p><?php echo e($descripcion); ?></p>
        </div>
        <div class="aduana-module-view__symbol"><?php echo e($iconos[$icono ?? 'book-open'] ?? '▤'); ?></div>
    </div>
    <div class="aduana-empty-state">
        <div class="aduana-empty-state__icon"><?php echo e($iconos[$icono ?? 'book-open'] ?? '▤'); ?></div>
        <h4><?php echo e($mensaje ?? 'No hay información para mostrar.'); ?></h4>
        <p>Esta sección forma parte de la interfaz de AduanaSim. Los registros aparecerán aquí cuando se implemente su funcionalidad.</p>
        <?php if(!empty($accion) && $accion !== 'GESTIÓN ADUANASIM'): ?>
            <span class="aduana-status-pill"><?php echo e($accion); ?></span>
        <?php endif; ?>
    </div>
</section>
<?php /**PATH /home/lozada/Descargas/V3/AduanaSim/resources/views/dashboard/partials/estado-vacio.blade.php ENDPATH**/ ?>