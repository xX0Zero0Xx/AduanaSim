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
    <div class="aduana-dashboard py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-8">
        <section class="aduana-module-view space-y-8">

            
            <div
                class="aduana-module-view__heading pb-6 border-b border-slate-700/60"
                style="display: grid; grid-template-columns: 1fr auto 1fr; align-items: center; gap: 1rem;"
            >
                <div aria-hidden="true"></div>

                <div class="text-center space-y-1.5" style="text-align: center;">
                    <span class="aduana-eyebrow aduana-eyebrow--muted inline-block" style="font-size: 0.85rem;">
                        Colaboración
                    </span>
                    <h3 class="font-bold tracking-tight" style="font-size: 2rem; line-height: 1.2;">
                        Crear equipo
                    </h3>
                    <p class="text-slate-400 max-w-2xl mx-auto" style="font-size: 0.95rem;">
                        Registra un nuevo equipo y revisa el listado de los ya existentes.
                    </p>
                </div>

                <div style="justify-self: end;">
                    <a href="<?php echo e(route('dashboard', ['tab' => 'equipos'])); ?>" class="aduana-btn aduana-btn--ghost inline-flex items-center">
                        ← Volver al Panel
                    </a>
                </div>
            </div>

            
            <?php if(session('status')): ?>
                <div class="aduana-alert aduana-alert--ok p-4 rounded-lg">
                    <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="aduana-alert aduana-alert--error p-4 rounded-lg space-y-1">
                    <p class="font-medium text-sm">Revisa los siguientes campos:</p>
                    <ul class="list-disc pl-5 text-sm space-y-0.5">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            
            <article class="aduana-module-card p-6 space-y-5">
                <div class="space-y-1 pb-3 border-b border-slate-700/60">
                    <span class="aduana-module-card__kicker block">Registro</span>
                    <h4 class="text-lg font-semibold">Nuevo equipo</h4>
                    <p class="text-sm text-slate-400">
                        Completa los datos básicos para crear el equipo.
                    </p>
                </div>

                <form
                    method="POST"
                    action="<?php echo e(route('agente.equipos.store')); ?>"
                    class="pt-1"
                    style="display: grid; grid-template-columns: minmax(220px, 2fr) minmax(220px, 2fr) auto; align-items: end; gap: 1.25rem;"
                >
                    <?php echo csrf_field(); ?>

                    <div class="space-y-2" style="min-width: 0;">
                        <label for="nombre" class="aduana-label block font-medium">Nombre</label>
                        <input
                            id="nombre"
                            type="text"
                            name="nombre"
                            class="aduana-input w-full py-2.5 px-3"
                            style="width: 100%; max-width: 100%;"
                            required
                            value="<?php echo e(old('nombre')); ?>"
                            placeholder="Ej. Grupo mañana A"
                        >
                    </div>

                    <div class="space-y-2" style="min-width: 0;">
                        <label for="descripcion" class="aduana-label block font-medium">Descripción</label>
                        <input
                            id="descripcion"
                            type="text"
                            name="descripcion"
                            class="aduana-input w-full py-2.5 px-3"
                            style="width: 100%; max-width: 100%;"
                            value="<?php echo e(old('descripcion')); ?>"
                            placeholder="Opcional"
                        >
                    </div>

                    <div style="flex-shrink: 0;">
                        <button
                            type="submit"
                            class="aduana-btn aduana-btn--primary py-2.5 px-5 whitespace-nowrap"
                        >
                            Crear equipo
                        </button>
                    </div>
                </form>
            </article>

            
            <div class="aduana-module-card p-6 space-y-5">
                <div class="flex items-center justify-between gap-4 pb-3 border-b border-slate-700/60">
                    <div>
                        <span class="aduana-module-card__kicker block">Directorio</span>
                        <h4 class="text-lg font-semibold">Equipos existentes</h4>
                    </div>
                    <span class="aduana-eyebrow aduana-eyebrow--muted shrink-0">
                        <?php echo e($equiposExistentes->count()); ?> <?php echo e($equiposExistentes->count() === 1 ? 'equipo' : 'equipos'); ?>

                    </span>
                </div>

                <?php if($equiposExistentes->isEmpty()): ?>
                    <div class="aduana-empty-state p-8 text-center space-y-2">
                        <strong class="block">Sin equipos registrados</strong>
                        <p class="text-sm text-slate-400">No hay equipos registrados aún.</p>
                    </div>
                <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-700/70 text-xs uppercase tracking-wider text-slate-400">
                                    <th class="py-3.5 px-4">Equipo</th>
                                    <th class="py-3.5 px-4">Departamento / Clave</th>
                                    <th class="py-3.5 px-4">Descripción</th>
                                    <th class="py-3.5 px-4 text-center">Miembros</th>
                                    <th class="py-3.5 px-4 text-center">Pedimentos</th>
                                    <th class="py-3.5 px-4 text-center">COVEs</th>
                                    <th class="py-3.5 px-4 text-center">DODAs</th>
                                    <th class="py-3.5 px-4 text-right">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-700/50">
                                <?php $__currentLoopData = $equiposExistentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $equipoObj = $item['equipo'] ?? null;
                                    ?>
                                    <tr class="hover:bg-slate-800/40 transition-colors">
                                        <td class="py-4 px-4 font-semibold whitespace-nowrap">
                                            <?php echo e($item['nombre']); ?>

                                        </td>
                                        <td class="py-4 px-4 whitespace-nowrap">
                                            <span class="aduana-eyebrow aduana-eyebrow--muted inline-block">
                                                <?php echo e($item['departamento']); ?>

                                            </span>
                                        </td>
                                        <td class="py-4 px-4 text-sm text-slate-400 max-w-xs">
                                            <?php echo e($item['descripcion'] ?? 'Sin descripción'); ?>

                                        </td>
                                        <td class="py-4 px-4 text-center font-semibold tabular-nums">
                                            <?php echo e($item['miembros'] ?? 0); ?>

                                        </td>
                                        <td class="py-4 px-4 text-center font-semibold tabular-nums">
                                            <?php echo e($item['pedimentos'] ?? 0); ?>

                                        </td>
                                        <td class="py-4 px-4 text-center font-semibold tabular-nums">
                                            <?php echo e($item['coves'] ?? 0); ?>

                                        </td>
                                        <td class="py-4 px-4 text-center font-semibold tabular-nums">
                                            <?php echo e($item['dodas'] ?? 0); ?>

                                        </td>
                                        <td class="py-4 px-4 text-right whitespace-nowrap">
                                            <?php if($equipoObj): ?>
                                                <a
                                                    href="<?php echo e(route('agente.equipos.show', $equipoObj)); ?>"
                                                    class="aduana-text-action inline-flex items-center gap-1.5"
                                                >
                                                    <span>Administrar equipo</span>
                                                    <span aria-hidden="true">→</span>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-xs text-slate-500">—</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
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