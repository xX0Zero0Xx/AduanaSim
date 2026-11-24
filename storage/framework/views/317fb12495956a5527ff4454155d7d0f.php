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
                    <span class="aduana-eyebrow aduana-eyebrow--muted">Centro de validación</span>
                    <h3><?php echo e($titulo); ?></h3>
                    <p>
                        <?php if($bandeja === 'historial'): ?>
                            Documentos con estatus <strong>Validado</strong> o <strong>Devuelto</strong>.
                        <?php else: ?>
                            Filtra por departamento y tipo de documento.
                        <?php endif; ?>
                    </p>
                </div>
                <a href="<?php echo e(route('dashboard')); ?>" class="aduana-btn aduana-btn--ghost">← Volver al Panel</a>
            </div>

            <?php if(session('status')): ?>
                <div class="aduana-alert aduana-alert--ok"><?php echo e(session('status')); ?></div>
            <?php endif; ?>

            <form method="GET" class="aduana-filter-bar">
                <select name="departamento_id" class="aduana-input">
                    <option value="">Todos los departamentos</option>
                    <?php $__currentLoopData = $departamentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($dep->id); ?>" <?php if((string)$departamentoId === (string)$dep->id): echo 'selected'; endif; ?>>
                            <?php echo e($dep->clave); ?> — <?php echo e($dep->nombre); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <select name="tipo" class="aduana-input">
                    <option value="todos" <?php if($tipo==='todos'): echo 'selected'; endif; ?>>Todos los tipos</option>
                    <option value="pedimento" <?php if($tipo==='pedimento'): echo 'selected'; endif; ?>>Pedimentos</option>
                    <option value="cove" <?php if($tipo==='cove'): echo 'selected'; endif; ?>>Cove</option>
                    <option value="doda" <?php if($tipo==='doda'): echo 'selected'; endif; ?>>Doda</option>
                </select>
                <button class="aduana-btn" type="submit">Filtrar</button>
            </form>

            <?php if($items->isEmpty()): ?>
                <div class="aduana-empty-state">
                    <div class="aduana-empty-state__icon">◷</div>
                    <strong>Sin documentos en esta bandeja</strong>
                    <p>Ajusta el filtro de departamento o espera envíos de capturistas.</p>
                </div>
            <?php else: ?>
                <div class="aduana-table-wrap">
                    <table class="aduana-table">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Folio</th>
                                <th>Departamento</th>
                                <th>Propietario</th>
                                <th>Estatus</th>
                                <th>Actualizado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($item['tipo']); ?></td>
                                    <td><strong><?php echo e($item['folio']); ?></strong></td>
                                    <td><?php echo e($item['departamento']); ?></td>
                                    <td><?php echo e($item['capturista']); ?></td>
                                    <td><?php echo $__env->make('agente.partials.estatus-badge', ['estatus'=>$item['estatus'],'etiqueta'=>$item['etiqueta']], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></td>
                                    <td><?php echo e($item['fecha']?->format('d/m/Y H:i')); ?></td>
                                    <td><a class="aduana-link" href="<?php echo e($item['url']); ?>">Ver</a></td>
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
<?php /**PATH /home/lozada/AduanaSim/resources/views/agente/revisiones/index.blade.php ENDPATH**/ ?>