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
                    <span class="aduana-eyebrow aduana-eyebrow--muted">Detalle de pedimento</span>
                    <h3><?php echo e($pedimento->folio); ?></h3>
                    <p>
                        <?php echo $__env->make('capturista.partials.estatus-badge', ['estatus' => $pedimento->estatus, 'etiqueta' => $pedimento->etiquetaEstatus()], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        · <?php echo e(ucfirst($pedimento->tipo)); ?> · <?php echo e(ucfirst($pedimento->tipo_operacion)); ?>

                    </p>
                </div>
                <div class="aduana-actions-row">

<!-- <a href="<?php echo e(route('capturista.historial.index')); ?>" class="aduana-btn aduana-btn--ghost">← Volver a Mis documentos</a> -->

<a href="<?php echo e(route('dashboard')); ?>" class="aduana-btn aduana-btn--ghost">← Volver al panel</a>

                    <!-- <a href="<?php echo e(route('capturista.pedimentos.index')); ?>" class="aduana-btn aduana-btn--ghost">← Lista</a> -->


                    <?php if($pedimento->puedeEditarse()): ?>
                        <a href="<?php echo e(route('capturista.pedimentos.edit', $pedimento)); ?>" class="aduana-btn">Editar</a>
                    <?php endif; ?>
                    <?php if($pedimento->puedeVerPdf()): ?>
                        <a href="<?php echo e(route('capturista.pedimentos.pdf', [$pedimento, 'tradicional'])); ?>" target="_blank" class="aduana-btn">PDF tradicional</a>
                        <a href="<?php echo e(route('capturista.pedimentos.pdf', [$pedimento, 'simplificado'])); ?>" target="_blank" class="aduana-btn">PDF simplificado</a>
                    <?php endif; ?>
                    <?php if($pedimento->puedeEnviarse()): ?>
                        <form method="POST" action="<?php echo e(route('capturista.pedimentos.enviar', $pedimento)); ?>" onsubmit="return confirm('¿Enviar a validación académica?')">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="aduana-btn aduana-btn--primary">Enviar a validación</button>
                        </form>
                    <?php endif; ?>
                    <?php if($pedimento->estatus === 'borrador'): ?>
                        <form method="POST" action="<?php echo e(route('capturista.pedimentos.destroy', $pedimento)); ?>" onsubmit="return confirm('¿Eliminar este borrador?')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="aduana-btn aduana-btn--danger">Eliminar</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            <?php echo $__env->make('capturista.partials.flash', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <?php if($pedimento->observaciones_revision): ?>
                <div class="aduana-alert aduana-alert--warn">
                    <strong>Observaciones de revisión:</strong>
                    <p><?php echo e($pedimento->observaciones_revision); ?></p>
                </div>
            <?php endif; ?>

            <div class="aduana-detail-grid">
                <div><span class="label">Aduana / sección</span><strong><?php echo e($pedimento->aduana_clave ?: '—'); ?> / <?php echo e($pedimento->seccion_aduanera ?: '—'); ?></strong></div>
                <div><span class="label">Cve. pedimento / régimen</span><strong><?php echo e($pedimento->clave_pedimento ?: '—'); ?> / <?php echo e($pedimento->regimen_clave ?: '—'); ?></strong></div>
                <div><span class="label">Destino / tipo cambio</span><strong><?php echo e($pedimento->destino_clave ?: '—'); ?> / <?php echo e($pedimento->tipo_cambio ?: '—'); ?></strong></div>
                <div><span class="label">Peso bruto</span><strong><?php echo e($pedimento->peso_bruto ?: '—'); ?></strong></div>
                <div><span class="label">RFC / nombre</span><strong><?php echo e($pedimento->rfc_operador ?: '—'); ?> · <?php echo e($pedimento->nombre_operador ?: '—'); ?></strong></div>
                <div><span class="label">CURP</span><strong><?php echo e($pedimento->curp_operador ?: '—'); ?></strong></div>
                <div><span class="label">Domicilio</span><strong><?php echo e($pedimento->domicilio_operador ?: '—'); ?></strong></div>
                <div><span class="label">Medio transporte</span><strong><?php echo e($pedimento->medio_transporte_clave ?: '—'); ?></strong></div>
                <div><span class="label">Valores (USD / aduana / comercial)</span><strong><?php echo e(number_format($pedimento->valor_dolares,2)); ?> / <?php echo e(number_format($pedimento->valor_aduana,2)); ?> / <?php echo e(number_format($pedimento->valor_comercial,2)); ?></strong></div>
                <div><span class="label">Moneda / Incoterm</span><strong><?php echo e($pedimento->moneda_clave ?: '—'); ?> / <?php echo e($pedimento->incoterm_clave ?: '—'); ?></strong></div>
                <div><span class="label">Proveedor</span><strong><?php echo e($pedimento->proveedor_nombre ?: '—'); ?> (<?php echo e($pedimento->proveedor_id_fiscal); ?>)</strong></div>
                <div><span class="label">Agente</span><strong><?php echo e($pedimento->agente_nombre ?: '—'); ?> · Pat. <?php echo e($pedimento->agente_patente ?: $pedimento->patente); ?></strong></div>
                <div><span class="label">Capturista</span><strong><?php echo e($pedimento->user->name ?? '—'); ?></strong></div>
            </div>

            <?php if($pedimento->observaciones): ?>
                <p class="mt-4 text-sm"><strong>Observaciones:</strong> <?php echo e($pedimento->observaciones); ?></p>
            <?php endif; ?>

            <div class="aduana-role-section-title mt-6">
                <div><h4>Partidas (<?php echo e($pedimento->partidas->count()); ?>)</h4></div>
            </div>
            <div class="aduana-table-wrap">
                <table class="aduana-table">
                    <thead>
                        <tr>
                            <th>#</th><th>Fracción</th><th>NICO</th><th>Descripción</th>
                            <th>Cant.</th><th>UMC</th><th>V. comercial</th><th>V. aduana</th><th>Origen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $pedimento->partidas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partida): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($partida->secuencia); ?></td>
                                <td><?php echo e($partida->fraccion); ?></td>
                                <td><?php echo e($partida->nico); ?></td>
                                <td><?php echo e($partida->descripcion); ?></td>
                                <td><?php echo e($partida->cantidad); ?></td>
                                <td><?php echo e($partida->umc ?: $partida->unidad); ?></td>
                                <td><?php echo e(number_format($partida->valor_comercial, 2)); ?></td>
                                <td><?php echo e(number_format($partida->valor_aduana, 2)); ?></td>
                                <td><?php echo e($partida->pais_origen_clave); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="9" class="text-center text-slate-500">Sin partidas.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
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
<?php /**PATH /home/lozada/AduanaSim/resources/views/capturista/pedimentos/show.blade.php ENDPATH**/ ?>