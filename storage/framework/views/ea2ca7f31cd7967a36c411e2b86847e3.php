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
        <section class="aduana-module-view" style="max-width:1100px;margin:0 auto">
            <div class="aduana-module-view__heading" style="align-items:center">
                <div style="text-align:center;width:100%">
                    <span class="aduana-eyebrow aduana-eyebrow--muted">Organización</span>
                    <h3 style="margin-top:4px">Usuarios capturista</h3>
                    <p style="max-width:520px;margin:6px auto 0;color:#94a3b8">
                        Crea un departamento y luego registra capturistas. El correo y la contraseña se generan automáticamente.
                    </p>
                </div>
            </div>
            <div style="text-align:center;margin-bottom:1.25rem">
                <a href="<?php echo e(route('dashboard', ['tab' => 'usuarios'])); ?>" class="aduana-btn aduana-btn--ghost">← Volver al panel</a>
            </div>

            <?php if(session('status')): ?>
                <div class="aduana-alert aduana-alert--ok" style="max-width:720px;margin:0 auto 1rem"><?php echo e(session('status')); ?></div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
                <div class="aduana-alert aduana-alert--danger" style="max-width:720px;margin:0 auto 1rem">
                    <ul style="margin:0;padding-left:1.1rem"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
                </div>
            <?php endif; ?>

            
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;align-items:stretch;max-width:1000px;margin:0 auto">
                
                <article class="aduana-module-card" style="margin:0;display:flex;flex-direction:column;min-height:100%;height:100%;box-sizing:border-box">
                    <span class="aduana-module-card__kicker">PASO 1</span>
                    <h4 style="margin:6px 0 4px">Nuevo departamento</h4>
                    <p style="font-size:0.85rem;color:#94a3b8;margin-bottom:1rem;min-height:2.4em">Ejemplo de clave: <strong>8MSC9</strong></p>

                    <form method="POST" action="<?php echo e(route('agente.departamentos.store')); ?>" class="aduana-form-stack" style="flex:1;display:flex;flex-direction:column">
                        <?php echo csrf_field(); ?>
                        <div>
                            <label class="aduana-label">Clave</label>
                            <input type="text" name="clave" class="aduana-input" required maxlength="40" value="<?php echo e(old('clave')); ?>" placeholder="8MSC9">
                        </div>
                        <div>
                            <label class="aduana-label">Nombre</label>
                            <input type="text" name="nombre" class="aduana-input" required value="<?php echo e(old('nombre')); ?>" placeholder="Grupo matutino">
                        </div>
                        <div>
                            <label class="aduana-label">Descripción (opcional)</label>
                            <input type="text" name="descripcion" class="aduana-input" value="<?php echo e(old('descripcion')); ?>">
                        </div>
                        <div style="flex:1"></div>
                        <button type="submit" class="aduana-btn aduana-btn--primary" style="width:100%;margin-top:auto">Crear departamento</button>
                    </form>

                </article>

                
                <article class="aduana-module-card" style="margin:0;display:flex;flex-direction:column;min-height:100%;height:100%;box-sizing:border-box">
                    <span class="aduana-module-card__kicker">PASO 2</span>
                    <h4 style="margin:6px 0 4px">Nuevo capturista</h4>
                    <p style="font-size:0.85rem;color:#94a3b8;margin-bottom:1rem;min-height:2.4em">
                        
                        Contraseña: <code>AduanaSim@UPTex2026</code>
                    </p>

                    <?php if($departamentos->where('activo', true)->isEmpty()): ?>
                        <div class="aduana-empty-state" style="padding:1.5rem 0.5rem;flex:1;display:flex;flex-direction:column;justify-content:center">
                            <strong>Crea un departamento primero</strong>
                            <p style="font-size:0.85rem">Sin departamento no se puede registrar capturistas.</p>
                        </div>
                    <?php else: ?>
                        <form method="POST" action="<?php echo e(route('agente.usuarios.store')); ?>" class="aduana-form-stack" style="flex:1;display:flex;flex-direction:column">
                            <?php echo csrf_field(); ?>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem">
                                <div>
                                    <label class="aduana-label">Primer nombre *</label>
                                    <input type="text" name="primer_nombre" class="aduana-input" required value="<?php echo e(old('primer_nombre')); ?>" placeholder="Juan">
                                </div>
                                <div>
                                    <label class="aduana-label">Segundo nombre</label>
                                    <input type="text" name="segundo_nombre" class="aduana-input" value="<?php echo e(old('segundo_nombre')); ?>" placeholder="Opcional">
                                </div>
                            </div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem">
                                <div>
                                    <label class="aduana-label">Apellido paterno *</label>
                                    <input type="text" name="apellido_paterno" class="aduana-input" required value="<?php echo e(old('apellido_paterno')); ?>" placeholder="Pérez">
                                </div>
                                <div>
                                    <label class="aduana-label">Apellido materno *</label>
                                    <input type="text" name="apellido_materno" class="aduana-input" required value="<?php echo e(old('apellido_materno')); ?>" placeholder="García">
                                </div>
                            </div>
                            <div>
                                <label class="aduana-label">Departamento *</label>
                                <select name="departamento_id" class="aduana-input" required>
                                    <option value="">Seleccionar…</option>
                                    <?php $__currentLoopData = $departamentos->where('activo', true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($dep->id); ?>" <?php if((string)old('departamento_id', $departamentoId)===(string)$dep->id): echo 'selected'; endif; ?>>
                                            <?php echo e($dep->clave); ?> — <?php echo e($dep->nombre); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div style="flex:1"></div>
                            <button type="submit" class="aduana-btn aduana-btn--primary" style="width:100%;margin-top:auto">Crear capturista</button>
                        </form>
                    <?php endif; ?>
                </article>
            </div>

            
            <div style="max-width:1000px;margin:2rem auto 0">
                <div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:0.75rem;margin-bottom:0.75rem">
                    <div>
                        <h4 style="margin:0">Capturistas registrados</h4>
                        <p style="margin:4px 0 0;font-size:0.85rem;color:#94a3b8">Filtra por departamento</p>
                    </div>
                    <form method="GET" class="aduana-filter-bar" style="margin:0">
                        <select name="departamento_id" class="aduana-input" onchange="this.form.submit()">
                            <option value="">Todos los departamentos</option>
                            <?php $__currentLoopData = $departamentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dep): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($dep->id); ?>" <?php if((string)$departamentoId === (string)$dep->id): echo 'selected'; endif; ?>>
                                    <?php echo e($dep->clave); ?> — <?php echo e($dep->nombre); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </form>
                </div>

                <?php if($capturistas->isEmpty()): ?>
                    <div class="aduana-empty-state">
                        <strong>Sin capturistas</strong>
                        <p>Crea un departamento y luego un usuario capturista.</p>
                    </div>
                <?php else: ?>
                    <div class="aduana-table-wrap">
                        <table class="aduana-table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Departamento</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $capturistas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><strong><?php echo e($u->name); ?></strong></td>
                                        <td><?php echo e($u->email); ?></td>
                                        <td><?php echo e($u->departamento?->clave ?? '—'); ?></td>
                                        <td><?php echo e($u->activo ? 'Activo' : 'Suspendido'); ?></td>
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
<?php endif; ?>
<?php /**PATH /home/lozada/AduanaSim/resources/views/agente/usuarios/index.blade.php ENDPATH**/ ?>