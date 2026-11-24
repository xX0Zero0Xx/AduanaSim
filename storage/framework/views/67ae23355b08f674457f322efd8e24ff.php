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
                    <h3>Crear equipo</h3>
                    <p>Registra un nuevo equipo y revisa el listado breve de los ya existentes.</p>
                </div>
                <a href="<?php echo e(route('dashboard', ['tab' => 'equipos'])); ?>" class="aduana-btn aduana-btn--ghost">← Volver al Panel</a>
            </div>

            <?php if(session('status')): ?>
                <div class="aduana-alert aduana-alert--ok mb-4"><?php echo e(session('status')); ?></div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="aduana-alert aduana-alert--error mb-4">
                    <ul class="list-disc pl-5">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="aduana-module-grid">
                <article class="aduana-module-card">
                    <h4>Nuevo equipo</h4>
                    <form method="POST" action="<?php echo e(route('agente.equipos.store')); ?>" class="aduana-form-stack mt-3">
                        <?php echo csrf_field(); ?>
                        <div>
                            <label class="aduana-label">Nombre</label>
                            <input type="text" name="nombre" class="aduana-input" required value="<?php echo e(old('nombre')); ?>" placeholder="Ej. Grupo mañana A">
                        </div>
                        <div>
                            <label class="aduana-label">Descripción</label>
                            <input type="text" name="descripcion" class="aduana-input" value="<?php echo e(old('descripcion')); ?>" placeholder="Opcional">
                        </div>
                        <button type="submit" class="aduana-btn aduana-btn--primary">Crear equipo</button>
                    </form>
                </article>

                <article class="aduana-module-card">
                    <h4>Equipos existentes</h4>
                    <?php if($equiposExistentes->isEmpty()): ?>
                        <p class="mt-3">No hay equipos registrados aún.</p>
                    <?php else: ?>
                        <ul class="aduana-simple-list mt-3">
                            <?php $__currentLoopData = $equiposExistentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="py-1.5 border-b flex items-center justify-between gap-2">
                                    <span><?php echo e($item['nombre']); ?></span>
                                    <span class="aduana-eyebrow aduana-eyebrow--muted"><?php echo e($item['departamento']); ?></span>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    <?php endif; ?>
                </article>
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
<?php endif; ?><?php /**PATH /home/lozada/AduanaSim/resources/views/agente/equipos/create.blade.php ENDPATH**/ ?>