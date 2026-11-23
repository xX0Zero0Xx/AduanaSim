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
                    <span class="aduana-eyebrow aduana-eyebrow--muted">Revisión · <?php echo e(strtoupper($tipo)); ?></span>
                    <h3><?php echo e($doc->folio); ?></h3>
                    <p>
                        <?php echo $__env->make('agente.partials.estatus-badge', ['estatus'=>$doc->estatus,'etiqueta'=>$doc->etiquetaEstatus()], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        · Capturista: <?php echo e($doc->user->name ?? '—'); ?>

                        · Enviado: <?php echo e(optional($doc->enviado_at)->format('d/m/Y H:i') ?: '—'); ?>

                    </p>
                </div>
                <div class="aduana-btn-row">
                    <a href="<?php echo e(route('agente.revisiones.index', $doc->estatus === 'validado' ? 'validados' : ($doc->estatus === 'devuelto' ? 'devueltos' : 'pendientes'))); ?>" class="aduana-btn aduana-btn--ghost">← Bandeja</a>
                    <?php if($tipo === 'pedimento'): ?>
                        <a href="<?php echo e(route('capturista.pedimentos.pdf', [$doc, 'tradicional'])); ?>" class="aduana-btn" target="_blank">PDF tradicional</a>
                        <a href="<?php echo e(route('capturista.pedimentos.pdf', [$doc, 'simplificado'])); ?>" class="aduana-btn" target="_blank">PDF simplificado</a>
                    <?php elseif($tipo === 'cove'): ?>
                        <a href="<?php echo e(route('capturista.coves.pdf', $doc)); ?>" class="aduana-btn" target="_blank">PDF COVE</a>
                    <?php elseif($tipo === 'doda'): ?>
                        <a href="<?php echo e(route('capturista.dodas.pdf', $doc)); ?>" class="aduana-btn" target="_blank">PDF DODA</a>
                    <?php endif; ?>
                </div>
            </div>

            <?php if(session('status')): ?>
                <div class="aduana-alert aduana-alert--ok"><?php echo e(session('status')); ?></div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
                <div class="aduana-alert aduana-alert--danger">
                    <ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
                </div>
            <?php endif; ?>

            <div class="aduana-detail-grid">
                <?php if($tipo === 'pedimento'): ?>
                    <div><span class="aduana-label">Operación</span><strong><?php echo e($doc->tipo_operacion); ?> · <?php echo e($doc->clave_pedimento); ?> / <?php echo e($doc->regimen_clave); ?></strong></div>
                    <div><span class="aduana-label">Aduana</span><strong><?php echo e($doc->aduana_clave); ?></strong></div>
                    <div><span class="aduana-label">RFC / Nombre</span><strong><?php echo e($doc->rfc_operador); ?> · <?php echo e($doc->nombre_operador); ?></strong></div>
                    <div><span class="aduana-label">Valores USD / Aduana / Comercial</span><strong><?php echo e(number_format($doc->valor_dolares,2)); ?> / <?php echo e(number_format($doc->valor_aduana,2)); ?> / <?php echo e(number_format($doc->valor_comercial,2)); ?></strong></div>
                    <div><span class="aduana-label">Proveedor</span><strong><?php echo e($doc->proveedor_nombre); ?></strong></div>
                    <div><span class="aduana-label">Partidas</span><strong><?php echo e($doc->partidas->count()); ?></strong></div>
                <?php elseif($tipo === 'cove'): ?>
                    <div><span class="aduana-label">Emisor</span><strong><?php echo e($doc->emisor_rfc); ?> · <?php echo e($doc->emisor_nombre); ?></strong></div>
                    <div><span class="aduana-label">Destinatario</span><strong><?php echo e($doc->destinatario_rfc); ?> · <?php echo e($doc->destinatario_nombre); ?></strong></div>
                    <div><span class="aduana-label">Moneda / Valor total</span><strong><?php echo e($doc->moneda_clave); ?> · <?php echo e(number_format($doc->valor_total,2)); ?></strong></div>
                    <div><span class="aduana-label">Pedimento vinculado</span><strong><?php echo e(optional($doc->pedimento)->folio ?: '—'); ?></strong></div>
                    <div><span class="aduana-label">Facturas</span><strong><?php echo e($doc->facturas->count()); ?></strong></div>
                    <div><span class="aduana-label">Mercancías</span><strong><?php echo e($doc->mercancias->count()); ?></strong></div>
                <?php elseif($tipo === 'doda'): ?>
                    <div><span class="aduana-label">Aduana / Patente</span><strong><?php echo e($doc->aduana_clave); ?> · <?php echo e($doc->patente); ?></strong></div>
                    <div><span class="aduana-label">N° operación</span><strong><?php echo e($doc->numero_operacion); ?></strong></div>
                    <div><span class="aduana-label">Fecha operación</span><strong><?php echo e(optional($doc->fecha_operacion)->format('d/m/Y')); ?></strong></div>
                    <div><span class="aduana-label">Medio / Placa</span><strong><?php echo e($doc->medio_transporte_clave); ?> · <?php echo e($doc->placa_o_identificacion); ?></strong></div>
                    <div><span class="aduana-label">Pedimentos asociados</span><strong><?php echo e($doc->pedimentos->count()); ?></strong></div>
                <?php endif; ?>
            </div>

            <?php if($doc->observaciones): ?>
                <p class="mt-3"><strong>Observaciones del capturista:</strong> <?php echo e($doc->observaciones); ?></p>
            <?php endif; ?>
            <?php if($doc->observaciones_revision): ?>
                <p class="mt-2"><strong>Observaciones de revisión:</strong> <?php echo e($doc->observaciones_revision); ?></p>
            <?php endif; ?>

            <?php if($doc->estatus === 'enviado'): ?>
                <div class="aduana-module-card mt-6" style="max-width:640px">
                    <h4>Decisión de revisión</h4>
                    <p class="text-sm text-slate-500 mb-3">Valida el documento o devuélvelo con observaciones para que el capturista lo corrija.</p>

                    <form method="POST" action="<?php echo e(route('agente.revisiones.validar', [$tipo, $doc->id])); ?>" class="mb-4">
                        <?php echo csrf_field(); ?>
                        <label class="aduana-label">Observaciones (opcional al validar)</label>
                        <textarea name="observaciones_revision" class="aduana-input" rows="2" placeholder="Comentario breve de aprobación"><?php echo e(old('observaciones_revision')); ?></textarea>
                        <button type="submit" class="aduana-btn aduana-btn--primary mt-2">✓ Validar documento</button>
                    </form>

                    <form method="POST" action="<?php echo e(route('agente.revisiones.devolver', [$tipo, $doc->id])); ?>">
                        <?php echo csrf_field(); ?>
                        <label class="aduana-label">Observaciones para devolver (obligatorias)</label>
                        <textarea name="observaciones_revision" class="aduana-input" rows="3" required placeholder="Indica qué debe corregir el capturista"><?php echo e(old('observaciones_revision')); ?></textarea>
                        <button type="submit" class="aduana-btn aduana-btn--danger mt-2">↶ Devolver con observaciones</button>
                    </form>
                </div>
            <?php elseif($doc->estatus === 'validado'): ?>
                <div class="aduana-alert aduana-alert--ok mt-4">Documento validado<?php echo e($doc->validado_at ? ' el '.$doc->validado_at->format('d/m/Y H:i') : ''); ?>.</div>
                <form method="POST" action="<?php echo e(route('agente.revisiones.devolver', [$tipo, $doc->id])); ?>" class="mt-3" style="max-width:640px">
                    <?php echo csrf_field(); ?>
                    <label class="aduana-label">¿Necesitas revertir? Indica motivo de devolución</label>
                    <textarea name="observaciones_revision" class="aduana-input" rows="2" required></textarea>
                    <button type="submit" class="aduana-btn aduana-btn--danger mt-2">Devolver de nuevo</button>
                </form>
            <?php elseif($doc->estatus === 'devuelto'): ?>
                <div class="aduana-alert aduana-alert--danger mt-4">Documento devuelto. El capturista debe corregirlo y reenviarlo.</div>
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
<?php /**PATH /home/lozada/AduanaSim/resources/views/agente/revisiones/show.blade.php ENDPATH**/ ?>