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
                    <span class="aduana-eyebrow aduana-eyebrow--muted">Historial</span>
                    <h3>Mis documentos</h3>
                    <p>Consulta pedimentos, COVE y DODA propios o de tu equipo.</p>
                </div>
                <a href="<?php echo e(route('dashboard')); ?>" class="aduana-btn aduana-btn--ghost">Panel</a>
            </div>

            <form method="GET" class="aduana-filter-bar">
                <select name="tipo" class="aduana-input">
                    <option value="todos" <?php if($tipo==='todos'): echo 'selected'; endif; ?>>Todos</option>
                    <option value="pedimento" <?php if($tipo==='pedimento'): echo 'selected'; endif; ?>>Pedimentos</option>
                    <option value="cove" <?php if($tipo==='cove'): echo 'selected'; endif; ?>>COVE</option>
                    <option value="doda" <?php if($tipo==='doda'): echo 'selected'; endif; ?>>DODA</option>
                </select>
                <select name="estatus" class="aduana-input">
                    <option value="">Cualquier estatus</option>
                    <?php $__currentLoopData = ['borrador','enviado','validado','devuelto']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($e); ?>" <?php if($estatus===$e): echo 'selected'; endif; ?>><?php echo e(ucfirst($e)); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <button class="aduana-btn" type="submit">Filtrar</button>
            </form>

            <?php if($items->isEmpty()): ?>
                <div class="aduana-empty-state">
                    <div class="aduana-empty-state__icon">◷</div>
                    <strong>Sin documentos</strong>
                    <p>Cuando captures pedimentos, COVE o DODA aparecerán aquí.</p>
                </div>
            <?php else: ?>
                <div class="aduana-table-wrap">
                    <table class="aduana-table">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Folio</th>
                                <th>Detalle</th>
                                <th>Estatus</th>
                                <th>Actualizado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($item['tipo']); ?></td>
                                    <td><?php echo e($item['folio']); ?></td>
                                    <td><?php echo e($item['extra'] ?: '—'); ?></td>
                                    <td><?php echo $__env->make('capturista.partials.estatus-badge', ['estatus'=>$item['estatus'],'etiqueta'=>$item['etiqueta']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></td>
                                    <td><?php echo e($item['fecha']->format('d/m/Y H:i')); ?></td>
                                    <td><a class="aduana-link" href="<?php echo e($item['url']); ?>">Abrir</a></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
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
<?php /**PATH /home/lozada/Escritorio/AduanaSim/resources/views/capturista/historial/index.blade.php ENDPATH**/ ?>