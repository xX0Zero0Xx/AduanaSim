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
                    <span class="aduana-eyebrow aduana-eyebrow--muted">DODA</span>
                    <h3>Documento de operación para despacho</h3>
                    <p>Asocia pedimentos y genera la representación académica del DODA.</p>
                </div>
                <a href="<?php echo e(route('capturista.dodas.create')); ?>" class="aduana-btn aduana-btn--primary">+ Nuevo DODA</a>
            </div>
            <?php echo $__env->make('capturista.partials.flash', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <form method="GET" class="aduana-filter-bar">
                <input type="search" name="q" value="<?php echo e(request('q')); ?>" placeholder="Buscar folio…" class="aduana-input">
                <select name="estatus" class="aduana-input">
                    <option value="">Todos</option>
                    <?php $__currentLoopData = ['borrador','enviado','validado','devuelto']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($e); ?>" <?php if(request('estatus')===$e): echo 'selected'; endif; ?>><?php echo e(ucfirst($e)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <button class="aduana-btn" type="submit">Filtrar</button>
                <a href="<?php echo e(route('dashboard')); ?>" class="aduana-btn aduana-btn--ghost">Panel</a>
            </form>
            <?php if($dodas->isEmpty()): ?>
                <div class="aduana-empty-state">
                    <div class="aduana-empty-state__icon">▦</div>
                    <strong>Sin DODA</strong>
                    <p>Crea un DODA y asócialo a uno o más pedimentos.</p>
                    <a href="<?php echo e(route('capturista.dodas.create')); ?>" class="aduana-btn aduana-btn--primary mt-3">Crear DODA</a>
                </div>
            <?php else: ?>
                <div class="aduana-table-wrap">
                    <table class="aduana-table">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Aduana</th>
                                <th>Operación</th>
                                <th>Pedimentos</th>
                                <th>Estatus</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $dodas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><a class="aduana-link" href="<?php echo e(route('capturista.dodas.show', $d)); ?>"><?php echo e($d->folio); ?></a></td>
                                    <td><?php echo e($d->aduana_clave ?: '—'); ?></td>
                                    <td><?php echo e($d->numero_operacion ?: '—'); ?></td>
                                    <td><?php echo e($d->pedimentos->pluck('folio')->join(', ') ?: '—'); ?></td>
                                    <td><?php echo $__env->make('capturista.partials.estatus-badge', ['estatus'=>$d->estatus,'etiqueta'=>$d->etiquetaEstatus()], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></td>
                                    <td class="aduana-table-actions">
                                        <a href="<?php echo e(route('capturista.dodas.show', $d)); ?>">Ver</a>
                                        <?php if($d->puedeEditarse()): ?>
                                            <a href="<?php echo e(route('capturista.dodas.edit', $d)); ?>">Editar</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-4"><?php echo e($dodas->links()); ?></div>
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
<?php /**PATH /home/lozada/Escritorio/AduanaSim/resources/views/capturista/dodas/index.blade.php ENDPATH**/ ?>