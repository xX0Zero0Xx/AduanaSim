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
                    <span class="aduana-eyebrow aduana-eyebrow--muted">Detalle COVE</span>
                    <h3><?php echo e($cove->folio); ?></h3>
                    <p><?php echo $__env->make('capturista.partials.estatus-badge', ['estatus'=>$cove->estatus,'etiqueta'=>$cove->etiquetaEstatus()], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></p>
                </div>
                <div class="aduana-actions-row">

<a href="<?php echo e(route('dashboard')); ?>" class="aduana-btn aduana-btn--ghost">← Volver al panel</a>


                    <!-- <a href="<?php echo e(route('capturista.coves.index')); ?>" class="aduana-btn aduana-btn--ghost">← Lista</a> -->

                    <?php if($cove->puedeEditarse()): ?>
                        <a href="<?php echo e(route('capturista.coves.edit', $cove)); ?>" class="aduana-btn">Editar</a>
                    <?php endif; ?>
                    <?php if($cove->puedeEnviarse()): ?>
                        <form method="POST" action="<?php echo e(route('capturista.coves.enviar', $cove)); ?>" onsubmit="return confirm('¿Enviar a validación?')">
                            <?php echo csrf_field(); ?>
                            <button class="aduana-btn aduana-btn--primary">Enviar a validación</button>
                        </form>
                    <?php endif; ?>
                    <?php if($cove->estatus === 'borrador'): ?>
                        <form method="POST" action="<?php echo e(route('capturista.coves.destroy', $cove)); ?>" onsubmit="return confirm('¿Eliminar?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button class="aduana-btn aduana-btn--danger">Eliminar</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
            <?php echo $__env->make('capturista.partials.flash', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php if($cove->observaciones_revision): ?>
                <div class="aduana-alert aduana-alert--warn"><strong>Revisión:</strong> <?php echo e($cove->observaciones_revision); ?></div>
            <?php endif; ?>
            <div class="aduana-detail-grid">
                <div><span class="label">Pedimento</span><strong><?php echo e($cove->pedimento->folio ?? '—'); ?></strong></div>
                <div><span class="label">Emisor</span><strong><?php echo e($cove->emisor_nombre ?: '—'); ?> (<?php echo e($cove->emisor_rfc); ?>)</strong></div>
                <div><span class="label">Destinatario</span><strong><?php echo e($cove->destinatario_nombre ?: '—'); ?> (<?php echo e($cove->destinatario_rfc); ?>)</strong></div>
                <div><span class="label">Moneda / Valor</span><strong><?php echo e($cove->moneda_clave ?: '—'); ?> · <?php echo e(number_format($cove->valor_total, 2)); ?></strong></div>
            </div>
            <div class="aduana-role-section-title mt-6"><div><h4>Facturas</h4></div></div>
            <div class="aduana-table-wrap">
                <table class="aduana-table">
                    <thead><tr><th>Número</th><th>Fecha</th><th>Valor</th><th>Moneda</th></tr></thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $cove->facturas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($f->numero_factura); ?></td>
                                <td><?php echo e(optional($f->fecha_factura)->format('d/m/Y')); ?></td>
                                <td><?php echo e(number_format($f->valor, 2)); ?></td>
                                <td><?php echo e($f->moneda_clave); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="4" class="text-center text-slate-500">Sin facturas</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="aduana-role-section-title mt-6"><div><h4>Mercancías</h4></div></div>
            <div class="aduana-table-wrap">
                <table class="aduana-table">
                    <thead><tr><th>#</th><th>Descripción</th><th>Cant.</th><th>Unidad</th><th>Valor</th><th>Fracción</th></tr></thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $cove->mercancias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($m->secuencia); ?></td>
                                <td><?php echo e($m->descripcion); ?></td>
                                <td><?php echo e($m->cantidad); ?></td>
                                <td><?php echo e($m->unidad); ?></td>
                                <td><?php echo e(number_format($m->valor, 2)); ?></td>
                                <td><?php echo e($m->fraccion); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="6" class="text-center text-slate-500">Sin mercancías</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
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
<?php /**PATH /home/lozada/Escritorio/AduanaSim/resources/views/capturista/coves/show.blade.php ENDPATH**/ ?>