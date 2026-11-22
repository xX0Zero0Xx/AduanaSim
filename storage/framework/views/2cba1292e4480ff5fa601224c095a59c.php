<?php
    $map = [
        'borrador' => 'aduana-badge--muted',
        'enviado' => 'aduana-badge--warn',
        'validado' => 'aduana-badge--ok',
        'devuelto' => 'aduana-badge--danger',
    ];
    $class = $map[$estatus] ?? 'aduana-badge--muted';
?>
<span class="aduana-badge <?php echo e($class); ?>"><?php echo e($etiqueta ?? ucfirst($estatus)); ?></span>
<?php /**PATH /home/lozada/Escritorio/AduanaSim/resources/views/capturista/partials/estatus-badge.blade.php ENDPATH**/ ?>