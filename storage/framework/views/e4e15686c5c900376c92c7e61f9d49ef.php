<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="aduana-dashboard">
        <section class="aduana-module-view">
            <div class="aduana-module-view__heading">
                <div>
                    <span class="aduana-eyebrow aduana-eyebrow--muted">Detalle DODA</span>
                    <h3><?php echo e($doda->folio); ?></h3>
                    <p><?php echo $__env->make('capturista.partials.estatus-badge', ['estatus'=>$doda->estatus,'etiqueta'=>$doda->etiquetaEstatus()], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></p>
                </div>
                <div class="aduana-actions-row">
                    
<a href="<?php echo e(route('dashboard')); ?>" class="aduana-btn aduana-btn--ghost">← Volver al panel</a>

                    
                    <!-- <a href="<?php echo e(route('capturista.dodas.index')); ?>" class="aduana-btn aduana-btn--ghost">← Lista</a> -->

                    <?php if($doda->puedeEditarse()): ?>
                        <a href="<?php echo e(route('capturista.dodas.edit', $doda)); ?>" class="aduana-btn">Editar</a>
                    <?php endif; ?>
                    <?php if($doda->puedeEnviarse()): ?>
                        <form method="POST" action="<?php echo e(route('capturista.dodas.enviar', $doda)); ?>" onsubmit="return confirm('¿Enviar a validación?')">
                            <?php echo csrf_field(); ?>
                            <button class="aduana-btn aduana-btn--primary">Enviar a validación</button>
                        </form>
                    <?php endif; ?>
                    <?php if($doda->estatus === 'borrador'): ?>
                        <form method="POST" action="<?php echo e(route('capturista.dodas.destroy', $doda)); ?>" onsubmit="return confirm('¿Eliminar?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="aduana-btn aduana-btn--danger">Eliminar</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
            <?php echo $__env->make('capturista.partials.flash', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php if($doda->observaciones_revision): ?>
                <div class="aduana-alert aduana-alert--warn"><strong>Revisión:</strong> <?php echo e($doda->observaciones_revision); ?></div>
            <?php endif; ?>
            <div class="aduana-detail-grid">
                <div><span class="label">Aduana</span><strong><?php echo e($doda->aduana_clave ?: '—'); ?></strong></div>
                <div><span class="label">Patente</span><strong><?php echo e($doda->patente ?: '—'); ?></strong></div>
                <div><span class="label">Núm. operación</span><strong><?php echo e($doda->numero_operacion ?: '—'); ?></strong></div>
                <div><span class="label">Fecha</span><strong><?php echo e(optional($doda->fecha_operacion)->format('d/m/Y') ?: '—'); ?></strong></div>
                <div><span class="label">Transporte</span><strong><?php echo e($doda->medio_transporte_clave ?: '—'); ?></strong></div>
                <div><span class="label">Placa / ID</span><strong><?php echo e($doda->placa_o_identificacion ?: '—'); ?></strong></div>
            </div>

            <div class="aduana-role-section-title mt-6"><div><h4>Pedimentos asociados</h4></div></div>
            <ul class="aduana-simple-list">
                <?php $__empty_1 = true; $__currentLoopData = $doda->pedimentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <li><a class="aduana-link" href="<?php echo e(route('capturista.pedimentos.show', $p)); ?>"><?php echo e($p->folio); ?></a> — <?php echo e($p->nombre_operador ?: 'Sin operador'); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <li class="text-slate-500">Ninguno</li>
                <?php endif; ?>
            </ul>

            <div class="aduana-role-section-title mt-6"><div><h4>Identificadores simulados</h4></div></div>
            <div class="aduana-info-strip">
                <strong>Cadena QR (académica)</strong>
                <span class="font-mono text-xs break-all"><?php echo e($doda->cadena_qr ?: 'Se genera al guardar'); ?></span>
            </div>
            <div class="aduana-info-strip aduana-info-strip--gold mt-2">
                <strong>Código de barras (simulado)</strong>
                <span class="font-mono"><?php echo e($doda->codigo_barras ?: '—'); ?></span>
            </div>
            <p class="text-xs text-slate-500 mt-2">Estos identificadores son solo para práctica académica y no tienen validez oficial ante el SAT.</p>
        </section>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /home/lozada/Escritorio/AduanaSim/resources/views/capturista/dodas/show.blade.php ENDPATH**/ ?>