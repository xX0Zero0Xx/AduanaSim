<?php
    $map = [
        'borrador' => 'aduana-badge aduana-badge--muted',
        'enviado' => 'aduana-badge aduana-badge--warn',
        'validado' => 'aduana-badge aduana-badge--ok',
        'devuelto' => 'aduana-badge aduana-badge--danger',
    ];
    $class = $map[$estatus ?? ''] ?? 'aduana-badge';
?>
<span class="<?php echo e($class); ?>"><?php echo e($etiqueta ?? ucfirst($estatus ?? '')); ?></span>
<?php /**PATH /home/lozada/AduanaSim/resources/views/agente/partials/estatus-badge.blade.php ENDPATH**/ ?>