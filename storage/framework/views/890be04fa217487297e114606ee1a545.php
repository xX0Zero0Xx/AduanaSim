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
                        Equipos agrupados
                    </h3>
                    <p class="text-slate-400 max-w-2xl mx-auto" style="font-size: 0.95rem;">
                        Todos los equipos registrados en una vista general.
                        <?php if(!empty($departamento)): ?>
                            · Filtro activo: <strong><?php echo e($departamento->clave); ?></strong>
                        <?php endif; ?>
                    </p>
                </div>

                <div class="flex items-center justify-end gap-3 flex-wrap" style="justify-self: end;">
                    <a href="<?php echo e(route('agente.equipos.create')); ?>" class="aduana-btn aduana-btn--primary inline-flex items-center">
                        + Crear equipo
                    </a>
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

            <?php
                $todosLosEquipos = collect();
                if (!$gruposEquipos->isEmpty()) {
                    foreach ($gruposEquipos as $nombreGrupo => $lista) {
                        foreach ($lista as $equipo) {
                            $todosLosEquipos->push([
                                'grupo' => $nombreGrupo,
                                'equipo' => $equipo,
                            ]);
                        }
                    }
                }
            ?>

            
            <?php if($todosLosEquipos->isEmpty()): ?>
                <div class="aduana-empty-state p-12 text-center space-y-3">
                    <div class="aduana-empty-state__icon text-3xl">♧</div>
                    <strong class="text-lg block">Sin equipos registrados</strong>
                    <p class="text-slate-400 max-w-md mx-auto">
                        Crea el primer equipo de trabajo para comenzar a asignar capturistas.
                    </p>
                    <div class="pt-3">
                        <a href="<?php echo e(route('agente.equipos.create')); ?>" class="aduana-btn aduana-btn--primary inline-flex items-center">
                            + Crear primer equipo
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="aduana-module-card p-6 space-y-5">
                    <div class="flex items-center justify-between gap-4 pb-3 border-b border-slate-700/60">
                        <div>
                            <span class="aduana-module-card__kicker block">Listado general</span>
                            <h4 class="text-lg font-semibold">Todos los equipos</h4>
                        </div>
                        <span class="aduana-eyebrow aduana-eyebrow--muted shrink-0">
                            <?php echo e($todosLosEquipos->count()); ?> <?php echo e($todosLosEquipos->count() === 1 ? 'equipo' : 'equipos'); ?>

                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-700/70 text-xs uppercase tracking-wider text-slate-400">
                                    <th class="py-3.5 px-4">Equipo</th>
                                    <th class="py-3.5 px-4">Departamento / Grupo</th>
                                    <th class="py-3.5 px-4">Descripción</th>
                                    <th class="py-3.5 px-4 text-center">Miembros</th>
                                    <th class="py-3.5 px-4 text-center">Pedimentos</th>
                                    <th class="py-3.5 px-4 text-center">COVEs</th>
                                    <th class="py-3.5 px-4 text-center">DODAs</th>
                                    <th class="py-3.5 px-4 text-right">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-700/50">
                                <?php $__currentLoopData = $todosLosEquipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fila): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $equipo = $fila['equipo'];
                                        $nombreGrupo = $fila['grupo'];
                                        $eqStats = $stats[$equipo->id] ?? [];
                                    ?>
                                    <tr class="hover:bg-slate-800/40 transition-colors">
                                        <td class="py-4 px-4 font-semibold whitespace-nowrap">
                                            <?php echo e($equipo->nombre); ?>

                                        </td>
                                        <td class="py-4 px-4 whitespace-nowrap">
                                            <span class="aduana-eyebrow aduana-eyebrow--muted inline-block">
                                                <?php echo e($nombreGrupo); ?>

                                            </span>
                                        </td>
                                        <td class="py-4 px-4 text-sm text-slate-400 max-w-xs">
                                            <?php echo e($equipo->descripcion ?: 'Sin descripción'); ?>

                                        </td>
                                        <td class="py-4 px-4 text-center font-semibold tabular-nums">
                                            <?php echo e($eqStats['miembros'] ?? 0); ?>

                                        </td>
                                        <td class="py-4 px-4 text-center font-semibold tabular-nums">
                                            <?php echo e($eqStats['pedimentos'] ?? 0); ?>

                                        </td>
                                        <td class="py-4 px-4 text-center font-semibold tabular-nums">
                                            <?php echo e($eqStats['coves'] ?? 0); ?>

                                        </td>
                                        <td class="py-4 px-4 text-center font-semibold tabular-nums">
                                            <?php echo e($eqStats['dodas'] ?? 0); ?>

                                        </td>
                                        <td class="py-4 px-4 text-right whitespace-nowrap">
                                            <a
                                                href="<?php echo e(route('agente.equipos.show', $equipo)); ?>"
                                                class="aduana-text-action inline-flex items-center gap-1.5"
                                            >
                                                <span>Administrar equipo</span>
                                                <span aria-hidden="true">→</span>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
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
<?php endif; ?><?php /**PATH /home/lozada/AduanaSim/resources/views/agente/equipos/index.blade.php ENDPATH**/ ?>