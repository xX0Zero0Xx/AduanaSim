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
                    <span class="aduana-eyebrow aduana-eyebrow--muted">Colaboración</span>
                    <h3>Equipos agrupados</h3>
                    <p>
                        Todos los equipos agrupados por departamento.
                        <?php if(!empty($departamento)): ?>
                            · Filtro: <strong><?php echo e($departamento->clave); ?></strong>
                        <?php endif; ?>
                    </p>
                </div>
                <div class="flex gap-2">
                    <a href="<?php echo e(route('agente.equipos.create')); ?>" class="aduana-btn aduana-btn--primary">+ Crear equipo</a>
                    <a href="<?php echo e(route('dashboard')); ?>" class="aduana-btn aduana-btn--ghost">← Volver al Panel</a>
                </div>
            </div>

            <?php if(session('status')): ?>
                <div class="aduana-alert aduana-alert--ok mb-4"><?php echo e(session('status')); ?></div>
            <?php endif; ?>

            <?php if($gruposEquipos->isEmpty()): ?>
                <div class="aduana-empty-state">
                    <div class="aduana-empty-state__icon">♧</div>
                    <strong>Sin equipos</strong>
                    <p>Crea el primer equipo de trabajo para asignar capturistas.</p>
                </div>
            <?php else: ?>
                <?php $__currentLoopData = $gruposEquipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nombreGrupo => $lista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="mb-8">
                        <div class="aduana-section-heading mb-3">
                            <h3><?php echo e($nombreGrupo); ?></h3>
                            <span class="aduana-eyebrow aduana-eyebrow--muted"><?php echo e($lista->count()); ?> <?php echo e($lista->count() === 1 ? 'equipo' : 'equipos'); ?></span>
                        </div>

                        <div class="aduana-module-grid">
                            <?php $__currentLoopData = $lista; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $equipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <article class="aduana-module-card">
                                    <div class="aduana-module-card__icon aduana-module-card__icon--navy">♧</div>
                                    <span class="aduana-module-card__kicker"><?php echo e($equipo->activo ? 'Activo' : 'Inactivo'); ?></span>
                                    <h4><?php echo e($equipo->nombre); ?></h4>
                                    <p><?php echo e($equipo->descripcion ?: 'Sin descripción'); ?></p>
                                    <div class="aduana-stat-grid aduana-stat-grid--three mt-3">
                                        <div class="aduana-stat-card"><span class="aduana-stat-card__label">Miembros</span><strong><?php echo e($stats[$equipo->id]['miembros'] ?? 0); ?></strong></div>
                                        <div class="aduana-stat-card"><span class="aduana-stat-card__label">Pedimentos</span><strong><?php echo e($stats[$equipo->id]['pedimentos'] ?? 0); ?></strong></div>
                                        <div class="aduana-stat-card"><span class="aduana-stat-card__label">COVE/DODA</span><strong><?php echo e(($stats[$equipo->id]['coves'] ?? 0) + ($stats[$equipo->id]['dodas'] ?? 0)); ?></strong></div>
                                    </div>
                                    <a href="<?php echo e(route('agente.equipos.show', $equipo)); ?>" class="aduana-text-action mt-3">Administrar <span>→</span></a>
                                </article>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php endif; ?><?php /**PATH /home/lozada/AduanaSim/resources/views/agente/equipos/index.blade.php ENDPATH**/ ?>