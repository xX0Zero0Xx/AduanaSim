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
                    <span class="aduana-eyebrow aduana-eyebrow--muted">Módulo de pedimentos</span>
                    <h3>Mis pedimentos</h3>
                    <p>Elabora, consulta y envía a validación tus ejercicios de pedimento.</p>
                </div>
                <a href="<?php echo e(route('capturista.pedimentos.create')); ?>" class="aduana-btn aduana-btn--primary">+ Nuevo pedimento</a>
            </div>

            <?php echo $__env->make('capturista.partials.flash', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <form method="GET" class="aduana-filter-bar">
                <input type="search" name="q" value="<?php echo e(request('q')); ?>" placeholder="Buscar folio, RFC o nombre…" class="aduana-input">
                <select name="estatus" class="aduana-input">
                    <option value="">Todos los estatus</option>
                    <?php $__currentLoopData = ['borrador' => 'Borrador', 'enviado' => 'En validación', 'validado' => 'Validado', 'devuelto' => 'Devuelto']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($k); ?>" <?php if(request('estatus') === $k): echo 'selected'; endif; ?>><?php echo e($v); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <button type="submit" class="aduana-btn">Filtrar</button>
                <a href="<?php echo e(route('dashboard')); ?>" class="aduana-btn aduana-btn--ghost">Volver al panel</a>
            </form>

            <?php if($pedimentos->isEmpty()): ?>
                <div class="aduana-empty-state">
                    <div class="aduana-empty-state__icon">▤</div>
                    <strong>Aún no tienes pedimentos</strong>
                    <p>Crea tu primer ejercicio de captura para comenzar la práctica.</p>
                    <a href="<?php echo e(route('capturista.pedimentos.create')); ?>" class="aduana-btn aduana-btn--primary mt-3">Crear pedimento</a>
                </div>
            <?php else: ?>
                <div class="aduana-table-wrap">
                    <table class="aduana-table">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Tipo</th>
                                <th>Operación</th>
                                <th>Operador</th>
                                <th>Valor aduana</th>
                                <th>Estatus</th>
                                <th>Actualizado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $pedimentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><a href="<?php echo e(route('capturista.pedimentos.show', $p)); ?>" class="aduana-link"><?php echo e($p->folio); ?></a></td>
                                    <td><?php echo e(ucfirst($p->tipo)); ?></td>
                                    <td><?php echo e(ucfirst($p->tipo_operacion)); ?></td>
                                    <td><?php echo e($p->nombre_operador ?: '—'); ?></td>
                                    <td><?php echo e(number_format($p->valor_aduana, 2)); ?></td>
                                    <td><?php echo $__env->make('capturista.partials.estatus-badge', ['estatus' => $p->estatus, 'etiqueta' => $p->etiquetaEstatus()], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></td>
                                    <td><?php echo e($p->updated_at->format('d/m/Y H:i')); ?></td>
                                    <td class="aduana-table-actions">
                                        <a href="<?php echo e(route('capturista.pedimentos.show', $p)); ?>">Ver</a>
                                        <?php if($p->puedeEditarse()): ?>
                                            <a href="<?php echo e(route('capturista.pedimentos.edit', $p)); ?>">Editar</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-4"><?php echo e($pedimentos->links()); ?></div>
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
<?php /**PATH /home/lozada/Escritorio/AduanaSim/resources/views/capturista/pedimentos/index.blade.php ENDPATH**/ ?>