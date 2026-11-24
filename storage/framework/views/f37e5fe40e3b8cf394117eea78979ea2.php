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
                    <span class="aduana-eyebrow aduana-eyebrow--muted">
                        Administrar equipo · <?php echo e($equipo->activo ? 'Activo' : 'Inactivo'); ?>

                    </span>
                    <h3><?php echo e($equipo->nombre); ?></h3>
                    <p><?php echo e($equipo->descripcion ?: 'Sin descripción asignada.'); ?></p>
                </div>
                <a href="<?php echo e(route('dashboard', ['tab' => 'equipos'])); ?>" class="aduana-btn aduana-btn--ghost">
                    ← Volver a equipos
                </a>
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

            
            <div class="aduana-stat-grid mb-6" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem;">
                <div class="aduana-stat-card">
                    <span class="aduana-stat-card__label">Integrantes</span>
                    <strong><?php echo e($equipo->users->count()); ?></strong>
                </div>
                <div class="aduana-stat-card">
                    <span class="aduana-stat-card__label">Pedimentos realizados en conjunto</span>
                    <strong><?php echo e($stats['pedimentos'] ?? 0); ?></strong>
                </div>
                <div class="aduana-stat-card">
                    <span class="aduana-stat-card__label">COVEs realizados en conjunto</span>
                    <strong><?php echo e($stats['coves'] ?? 0); ?></strong>
                </div>
                <div class="aduana-stat-card">
                    <span class="aduana-stat-card__label">DODAs realizados en conjunto</span>
                    <strong><?php echo e($stats['dodas'] ?? 0); ?></strong>
                </div>
            </div>

            <div class="aduana-module-grid">
                
                <article class="aduana-module-card">
                    <span class="aduana-module-card__kicker">Incorporación</span>
                    <h4>Agregar integrante</h4>
                    <p>Selecciona un capturista activo para sumarlo a este equipo.</p>

                    <?php
                        $idsActuales = $equipo->users->pluck('id')->all();
                        $disponibles = $capturistas->reject(fn ($c) => in_array($c->id, $idsActuales));
                    ?>

                    <?php if($disponibles->isEmpty()): ?>
                        <div class="aduana-empty-state mt-4">
                            <strong>Sin capturistas disponibles</strong>
                            <p>Todos los capturistas activos ya pertenecen al equipo o no hay capturistas registrados.</p>
                        </div>
                    <?php else: ?>
                        <form method="POST" action="<?php echo e(route('agente.equipos.attach', $equipo)); ?>" class="aduana-form-stack mt-4">
                            <?php echo csrf_field(); ?>

                            <div>
                                <label for="user_id" class="aduana-label">Capturista</label>
                                <select id="user_id" name="user_id" class="aduana-input" required>
                                    <option value="">— Selecciona un capturista —</option>
                                    <?php $__currentLoopData = $disponibles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $capturista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($capturista->id); ?>" <?php if(old('user_id') == $capturista->id): echo 'selected'; endif; ?>>
                                            <?php echo e($capturista->name); ?> (<?php echo e($capturista->email); ?>)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div>
                                <label for="rol_en_equipo" class="aduana-label">Rol en el equipo</label>
                                <select id="rol_en_equipo" name="rol_en_equipo" class="aduana-input">
                                    <option value="miembro" <?php if(old('rol_en_equipo', 'miembro') === 'miembro'): echo 'selected'; endif; ?>>Miembro</option>
                                    <option value="lider" <?php if(old('rol_en_equipo') === 'lider'): echo 'selected'; endif; ?>>Líder</option>
                                </select>
                            </div>

                            <button type="submit" class="aduana-btn aduana-btn--primary">
                                + Agregar al equipo
                            </button>
                        </form>
                    <?php endif; ?>
                </article>

                
                <article class="aduana-module-card" style="grid-column: span 2;">
                    <span class="aduana-module-card__kicker">Plantilla actual</span>
                    <h4>Integrantes del equipo (<?php echo e($equipo->users->count()); ?>)</h4>
                    <p>Consulta quiénes forman parte del equipo o expulsa a un integrante cuando sea necesario.</p>

                    <?php if($equipo->users->isEmpty()): ?>
                        <div class="aduana-empty-state mt-4">
                            <div class="aduana-empty-state__icon">∅</div>
                            <strong>Equipo sin integrantes</strong>
                            <p>Usa el formulario de la izquierda para agregar capturistas.</p>
                        </div>
                    <?php else: ?>
                        <div class="overflow-x-auto mt-4">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b">
                                        <th class="py-2 px-3">Nombre</th>
                                        <th class="py-2 px-3">Correo</th>
                                        <th class="py-2 px-3">Rol en equipo</th>
                                        <th class="py-2 px-3 text-right">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $equipo->users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $miembro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $rolEquipo = $miembro->pivot->rol_en_equipo ?? 'miembro';
                                        ?>
                                        <tr class="border-b">
                                            <td class="py-2.5 px-3 font-medium"><?php echo e($miembro->name); ?></td>
                                            <td class="py-2.5 px-3 text-sm"><?php echo e($miembro->email); ?></td>
                                            <td class="py-2.5 px-3">
                                                <span class="aduana-eyebrow aduana-eyebrow--muted">
                                                    <?php echo e($rolEquipo === 'lider' ? 'Líder' : 'Miembro'); ?>

                                                </span>
                                            </td>
                                            <td class="py-2.5 px-3 text-right">
                                                <form method="POST"
                                                    action="<?php echo e(route('agente.equipos.detach', [$equipo, $miembro])); ?>"
                                                    onsubmit="return confirm('¿Expulsar a <?php echo e(addslashes($miembro->name)); ?> del equipo «<?php echo e(addslashes($equipo->nombre)); ?>»?');"
                                                    class="inline">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="aduana-btn aduana-btn--ghost">
                                                        Expulsar
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </article>
            </div>

            
            <!-- <div class="aduana-module-grid mt-6">
                <article class="aduana-module-card">
                    <span class="aduana-module-card__kicker">Ajustes</span>
                    <h4>Editar datos del equipo</h4>
                    <form method="POST" action="<?php echo e(route('agente.equipos.update', $equipo)); ?>" class="aduana-form-stack mt-3">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div>
                            <label class="aduana-label">Nombre</label>
                            <input type="text" name="nombre" class="aduana-input" required
                                value="<?php echo e(old('nombre', $equipo->nombre)); ?>">
                        </div>

                        <div>
                            <label class="aduana-label">Descripción</label>
                            <input type="text" name="descripcion" class="aduana-input"
                                value="<?php echo e(old('descripcion', $equipo->descripcion)); ?>">
                        </div>

                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" name="activo" value="1" <?php if(old('activo', $equipo->activo)): echo 'checked'; endif; ?>>
                            <span>Equipo activo</span>
                        </label>

                        <button type="submit" class="aduana-btn aduana-btn--primary">Guardar cambios</button>
                    </form>
                </article> -->

                <article class="aduana-module-card">
                    <span class="aduana-module-card__kicker" style="color: #b91c1c;">Zona de peligro</span>
                    <h4>Eliminar equipo</h4>
                    <p>Se desvincularán todos los integrantes y se eliminará el registro del equipo.</p>

                    <form method="POST"
                        action="<?php echo e(route('agente.equipos.destroy', $equipo)); ?>"
                        onsubmit="return confirm('¿Seguro que deseas eliminar el equipo «<?php echo e(addslashes($equipo->nombre)); ?>»?');"
                        class="mt-4">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit"
                                class="aduana-btn"
                                style="background-color: #dc2626; color: #ffffff; border: 1px solid #b91c1c;">
                            Eliminar equipo
                        </button>
                    </form>
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
<?php endif; ?><?php /**PATH /home/lozada/AduanaSim/resources/views/agente/equipos/show.blade.php ENDPATH**/ ?>