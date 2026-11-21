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
                    <span class="aduana-eyebrow aduana-eyebrow--muted">COVE</span>
                    <h3>Comprobantes de valor electrónico</h3>
                    <p>Captura y consulta tus COVE académicos.</p>
                </div>
                <a href="<?php echo e(route('capturista.coves.create')); ?>" class="aduana-btn aduana-btn--primary">+ Nuevo COVE</a>
            </div>
            <?php echo $__env->make('capturista.partials.flash', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <form method="GET" class="aduana-filter-bar">
                <input type="search" name="q" value="<?php echo e(request('q')); ?>" placeholder="Buscar folio o nombre…" class="aduana-input">
                <select name="estatus" class="aduana-input">
                    <option value="">Todos</option>
                    <?php $__currentLoopData = ['borrador','enviado','validado','devuelto']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($e); ?>" <?php if(request('estatus')===$e): echo 'selected'; endif; ?>><?php echo e(ucfirst($e)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <button class="aduana-btn" type="submit">Filtrar</button>
                <a href="<?php echo e(route('dashboard')); ?>" class="aduana-btn aduana-btn--ghost">Panel</a>
            </form>
            <?php if($coves->isEmpty()): ?>
                <div class="aduana-empty-state">
                    <div class="aduana-empty-state__icon">▧</div>
                    <strong>Sin COVE registrados</strong>
                    <p>Crea un comprobante de valor para practicar el flujo.</p>
                    <a href="<?php echo e(route('capturista.coves.create')); ?>" class="aduana-btn aduana-btn--primary mt-3">Crear COVE</a>
                </div>
            <?php else: ?>
                <div class="aduana-table-wrap">
                    <table class="aduana-table">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Emisor</th>
                                <th>Destinatario</th>
                                <th>Pedimento</th>
                                <th>Valor</th>
                                <th>Estatus</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $coves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><a class="aduana-link" href="<?php echo e(route('capturista.coves.show', $c)); ?>"><?php echo e($c->folio); ?></a></td>
                                    <td><?php echo e($c->emisor_nombre ?: '—'); ?></td>
                                    <td><?php echo e($c->destinatario_nombre ?: '—'); ?></td>
                                    <td><?php echo e($c->pedimento->folio ?? '—'); ?></td>
                                    <td><?php echo e(number_format($c->valor_total, 2)); ?></td>
                                    <td><?php echo $__env->make('capturista.partials.estatus-badge', ['estatus'=>$c->estatus,'etiqueta'=>$c->etiquetaEstatus()], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></td>
                                    <td class="aduana-table-actions">
                                        <a href="<?php echo e(route('capturista.coves.show', $c)); ?>">Ver</a>
                                        <?php if($c->puedeEditarse()): ?>
                                            <a href="<?php echo e(route('capturista.coves.edit', $c)); ?>">Editar</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-4"><?php echo e($coves->links()); ?></div>
            <?php endif; ?>
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
<?php /**PATH /home/lozada/Escritorio/AduanaSim/resources/views/capturista/coves/index.blade.php ENDPATH**/ ?>