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
    <?php
        $etiquetaEstatus = method_exists($doc, 'etiquetaEstatus')
            ? $doc->etiquetaEstatus()
            : ucfirst((string) $doc->estatus);

        $deptoId = $doc->user?->departamento_id;
    ?>

    <div class="aduana-dashboard">
        <section class="aduana-module-view">
            <div class="aduana-module-view__heading">
                <div>
                    <span class="aduana-eyebrow aduana-eyebrow--muted">Revisión de <?php echo e(strtoupper($tipo)); ?></span>
                    <h3><?php echo e($doc->folio ?? ('#' . $doc->id)); ?></h3>
                    <p>
                        <?php echo $__env->make('agente.partials.estatus-badge', ['estatus' => $doc->estatus, 'etiqueta' => $etiquetaEstatus], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <?php if(!empty($doc->tipo)): ?>
                            · <?php echo e(ucfirst((string) $doc->tipo)); ?>

                        <?php endif; ?>
                        <?php if(!empty($doc->tipo_operacion)): ?>
                            · <?php echo e(ucfirst((string) $doc->tipo_operacion)); ?>

                        <?php endif; ?>
                    </p>
                </div>

                <div class="aduana-actions-row">
                    <a
                        href="<?php echo e(route('agente.revisiones.index', array_filter(['bandeja' => $doc->estatus === 'enviado' ? 'pendientes' : 'historial', 'departamento_id' => $deptoId]))); ?>"
                        class="aduana-btn aduana-btn--ghost"
                    >
                        ← Volver a revisiones
                    </a>
                    <a href="<?php echo e(route('dashboard')); ?>" class="aduana-btn aduana-btn--ghost">
                        ← Volver al panel
                    </a>
                </div>
            </div>

            <?php if(session('status')): ?>
                <div class="aduana-alert aduana-alert--success">
                    <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="aduana-alert aduana-alert--warn">
                    <strong>Revisa los datos del formulario:</strong>
                    <ul class="mt-1 list-disc list-inside text-sm">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if(!empty($doc->observaciones_revision)): ?>
                <div class="aduana-alert aduana-alert--warn">
                    <strong>Observaciones de revisión:</strong>
                    <p><?php echo e($doc->observaciones_revision); ?></p>
                </div>
            <?php endif; ?>

            
            <?php if($tipo === 'pedimento'): ?>
                <div class="aduana-detail-grid">
                    <div><span class="label">Aduana / sección</span><strong><?php echo e($doc->aduana_clave ?: '—'); ?> / <?php echo e($doc->seccion_aduanera ?: '—'); ?></strong></div>
                    <div><span class="label">Cve. pedimento / régimen</span><strong><?php echo e($doc->clave_pedimento ?: '—'); ?> / <?php echo e($doc->regimen_clave ?: '—'); ?></strong></div>
                    <div><span class="label">Destino / tipo cambio</span><strong><?php echo e($doc->destino_clave ?: '—'); ?> / <?php echo e($doc->tipo_cambio ?: '—'); ?></strong></div>
                    <div><span class="label">Peso bruto</span><strong><?php echo e($doc->peso_bruto ?: '—'); ?></strong></div>
                    <div><span class="label">RFC / nombre</span><strong><?php echo e($doc->rfc_operador ?: '—'); ?> · <?php echo e($doc->nombre_operador ?: '—'); ?></strong></div>
                    <div><span class="label">CURP</span><strong><?php echo e($doc->curp_operador ?: '—'); ?></strong></div>
                    <div><span class="label">Domicilio</span><strong><?php echo e($doc->domicilio_operador ?: '—'); ?></strong></div>
                    <div><span class="label">Medio transporte</span><strong><?php echo e($doc->medio_transporte_clave ?: '—'); ?></strong></div>
                    <div>
                        <span class="label">Valores (USD / aduana / comercial)</span>
                        <strong>
                            <?php echo e(number_format((float) ($doc->valor_dolares ?? 0), 2)); ?> /
                            <?php echo e(number_format((float) ($doc->valor_aduana ?? 0), 2)); ?> /
                            <?php echo e(number_format((float) ($doc->valor_comercial ?? 0), 2)); ?>

                        </strong>
                    </div>
                    <div><span class="label">Moneda / Incoterm</span><strong><?php echo e($doc->moneda_clave ?: '—'); ?> / <?php echo e($doc->incoterm_clave ?: '—'); ?></strong></div>
                    <div><span class="label">Proveedor</span><strong><?php echo e($doc->proveedor_nombre ?: '—'); ?> (<?php echo e($doc->proveedor_id_fiscal ?: '—'); ?>)</strong></div>
                    <div><span class="label">Agente</span><strong><?php echo e($doc->agente_nombre ?: '—'); ?> · Pat. <?php echo e($doc->agente_patente ?: ($doc->patente ?: '—')); ?></strong></div>
                    <div><span class="label">Capturista / depto</span><strong><?php echo e($doc->user?->name ?? '—'); ?> (<?php echo e($doc->user?->departamento?->clave ?? 'Sin depto'); ?>)</strong></div>
                </div>

                <?php if(!empty($doc->observaciones)): ?>
                    <p class="mt-4 text-sm"><strong>Observaciones del capturista:</strong> <?php echo e($doc->observaciones); ?></p>
                <?php endif; ?>

                <div class="aduana-role-section-title mt-6">
                    <div><h4>Partidas (<?php echo e($doc->partidas?->count() ?? 0); ?>)</h4></div>
                </div>
                <div class="aduana-table-wrap">
                    <table class="aduana-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Fracción</th>
                                <th>NICO</th>
                                <th>Descripción</th>
                                <th>Cant.</th>
                                <th>UMC</th>
                                <th>V. comercial</th>
                                <th>V. aduana</th>
                                <th>Origen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $doc->partidas ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partida): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($partida->secuencia); ?></td>
                                    <td><?php echo e($partida->fraccion); ?></td>
                                    <td><?php echo e($partida->nico); ?></td>
                                    <td><?php echo e($partida->descripcion); ?></td>
                                    <td><?php echo e($partida->cantidad); ?></td>
                                    <td><?php echo e($partida->umc ?: $partida->unidad); ?></td>
                                    <td><?php echo e(number_format((float) ($partida->valor_comercial ?? 0), 2)); ?></td>
                                    <td><?php echo e(number_format((float) ($partida->valor_aduana ?? 0), 2)); ?></td>
                                    <td><?php echo e($partida->pais_origen_clave); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="9" class="text-center text-slate-500">Sin partidas.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            <?php elseif($tipo === 'cove'): ?>
                <div class="aduana-detail-grid">
                    <div><span class="label">Emisor</span><strong><?php echo e($doc->emisor_nombre ?? '—'); ?></strong></div>
                    <div><span class="label">Identificador / RFC</span><strong><?php echo e(data_get($doc, 'emisor_rfc') ?? data_get($doc, 'emisor_identificacion') ?? '—'); ?></strong></div>
                    <div><span class="label">Destinatario / receptor</span><strong><?php echo e(data_get($doc, 'destinatario_nombre') ?? data_get($doc, 'receptor_nombre') ?? '—'); ?></strong></div>
                    <div><span class="label">Pedimento vinculado</span><strong><?php echo e($doc->pedimento?->folio ?? 'No vinculado'); ?></strong></div>
                    <div><span class="label">Moneda / valor total</span><strong><?php echo e(data_get($doc, 'moneda_clave') ?? '—'); ?> · <?php echo e(number_format((float) (data_get($doc, 'valor_total') ?? data_get($doc, 'total') ?? 0), 2)); ?></strong></div>
                    <div><span class="label">Capturista / depto</span><strong><?php echo e($doc->user?->name ?? '—'); ?> (<?php echo e($doc->user?->departamento?->clave ?? 'Sin depto'); ?>)</strong></div>
                </div>

                <?php if(!empty($doc->observaciones)): ?>
                    <p class="mt-4 text-sm"><strong>Observaciones del capturista:</strong> <?php echo e($doc->observaciones); ?></p>
                <?php endif; ?>

                <div class="aduana-role-section-title mt-6">
                    <div><h4>Facturas (<?php echo e($doc->facturas?->count() ?? 0); ?>)</h4></div>
                </div>
                <div class="aduana-table-wrap">
                    <table class="aduana-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Número / folio</th>
                                <th>Fecha</th>
                                <th>Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $doc->facturas ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $factura): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($idx + 1); ?></td>
                                    <td><?php echo e(data_get($factura, 'numero') ?? data_get($factura, 'folio') ?? '—'); ?></td>
                                    <td><?php echo e(data_get($factura, 'fecha') ?? '—'); ?></td>
                                    <td><?php echo e(number_format((float) (data_get($factura, 'monto') ?? data_get($factura, 'total') ?? 0), 2)); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="4" class="text-center text-slate-500">Sin facturas registradas.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="aduana-role-section-title mt-6">
                    <div><h4>Mercancías (<?php echo e($doc->mercancias?->count() ?? 0); ?>)</h4></div>
                </div>
                <div class="aduana-table-wrap">
                    <table class="aduana-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Descripción</th>
                                <th>Cantidad</th>
                                <th>Unidad</th>
                                <th>Valor unitario</th>
                                <th>Valor total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $doc->mercancias ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $mercancia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($idx + 1); ?></td>
                                    <td><?php echo e(data_get($mercancia, 'descripcion') ?? '—'); ?></td>
                                    <td><?php echo e(data_get($mercancia, 'cantidad') ?? '—'); ?></td>
                                    <td><?php echo e(data_get($mercancia, 'unidad') ?? data_get($mercancia, 'umc') ?? '—'); ?></td>
                                    <td><?php echo e(number_format((float) (data_get($mercancia, 'valor_unitario') ?? data_get($mercancia, 'precio_unitario') ?? 0), 2)); ?></td>
                                    <td><?php echo e(number_format((float) (data_get($mercancia, 'valor_total') ?? data_get($mercancia, 'importe') ?? 0), 2)); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="6" class="text-center text-slate-500">Sin mercancías registradas.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            <?php elseif($tipo === 'doda'): ?>
                <div class="aduana-detail-grid">
                    <div><span class="label">Folio DODA</span><strong><?php echo e($doc->folio ?? '—'); ?></strong></div>
                    <div><span class="label">Identificación transporte</span><strong><?php echo e($doc->transporte_identificacion ?? '—'); ?></strong></div>
                    <div><span class="label">Tipo / medio transporte</span><strong><?php echo e(data_get($doc, 'transporte_tipo') ?? data_get($doc, 'medio_transporte_clave') ?? '—'); ?></strong></div>
                    <div><span class="label">Aduana / sección</span><strong><?php echo e(data_get($doc, 'aduana_clave') ?? '—'); ?> / <?php echo e(data_get($doc, 'seccion_aduanera') ?? '—'); ?></strong></div>
                    <div><span class="label">Candados / sellos</span><strong><?php echo e(data_get($doc, 'candados') ?? data_get($doc, 'sellos') ?? '—'); ?></strong></div>
                    <div><span class="label">Capturista / depto</span><strong><?php echo e($doc->user?->name ?? '—'); ?> (<?php echo e($doc->user?->departamento?->clave ?? 'Sin depto'); ?>)</strong></div>
                </div>

                <?php if(!empty($doc->observaciones)): ?>
                    <p class="mt-4 text-sm"><strong>Observaciones del capturista:</strong> <?php echo e($doc->observaciones); ?></p>
                <?php endif; ?>

                <div class="aduana-role-section-title mt-6">
                    <div><h4>Pedimentos asociados (<?php echo e($doc->pedimentos?->count() ?? 0); ?>)</h4></div>
                </div>
                <div class="aduana-table-wrap">
                    <table class="aduana-table">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Operador</th>
                                <th>Aduana</th>
                                <th>Estatus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $doc->pedimentos ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ped): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><strong><?php echo e($ped->folio); ?></strong></td>
                                    <td><?php echo e($ped->nombre_operador ?? '—'); ?></td>
                                    <td><?php echo e($ped->aduana_clave ?? '—'); ?></td>
                                    <td><?php echo e($ped->estatus ?? '—'); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="4" class="text-center text-slate-500">Sin pedimentos asociados.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            
            <?php if($doc->estatus === 'enviado'): ?>
                <div class="aduana-role-section-title mt-6">
                    <div><h4>Dictamen de revisión</h4></div>
                </div>

                <div class="aduana-choice-grid mt-3">
                    <form method="POST" action="<?php echo e(route('agente.revisiones.validar', [$tipo, $doc->id])); ?>" class="aduana-choice-card space-y-3">
                        <?php echo csrf_field(); ?>
                        <h4>Validar documento</h4>
                        <p>Marca este documento como validado y registra observaciones si lo consideras necesario.</p>
                        <div>
                            <label class="block text-xs mb-1" for="obs-validar">Observaciones (opcional)</label>
                            <textarea id="obs-validar" name="observaciones" rows="2" class="w-full rounded border border-slate-700 bg-slate-900/60 p-2 text-sm"><?php echo e(old('observaciones')); ?></textarea>
                        </div>
                        <button type="submit" class="aduana-btn aduana-btn--primary">Validar documento</button>
                    </form>

                    <form method="POST" action="<?php echo e(route('agente.revisiones.devolver', [$tipo, $doc->id])); ?>" class="aduana-choice-card space-y-3">
                        <?php echo csrf_field(); ?>
                        <h4>Devolver a corrección</h4>
                        <p>Regresa el documento al capturista con el motivo de devolución para que lo corrija.</p>
                        <div>
                            <label class="block text-xs mb-1" for="obs-devolver">Motivo de devolución</label>
                            <textarea id="obs-devolver" name="observaciones" rows="2" required class="w-full rounded border border-slate-700 bg-slate-900/60 p-2 text-sm"><?php echo e(old('observaciones')); ?></textarea>
                        </div>
                        <button type="submit" class="aduana-btn aduana-btn--danger">Devolver documento</button>
                    </form>
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
<?php endif; ?><?php /**PATH /home/lozada/AduanaSim/resources/views/agente/revisiones/show.blade.php ENDPATH**/ ?>