<?php
    $p = $pedimento ?? null;
    $partidas = old('partidas', isset($pedimento) ? $pedimento->partidas->map(fn ($row) => [
        'fraccion' => $row->fraccion, 'nico' => $row->nico, 'descripcion' => $row->descripcion,
        'cantidad' => $row->cantidad, 'unidad' => $row->unidad, 'umc' => $row->umc,
        'cantidad_umc' => $row->cantidad_umc, 'umt' => $row->umt, 'cantidad_umt' => $row->cantidad_umt,
        'metodo_valoracion' => $row->metodo_valoracion, 'vinculacion' => $row->vinculacion,
        'valor_comercial' => $row->valor_comercial, 'valor_aduana' => $row->valor_aduana,
        'precio_unitario' => $row->precio_unitario, 'val_adu_usd' => $row->val_adu_usd,
        'pais_origen_clave' => $row->pais_origen_clave, 'pais_vendedor_clave' => $row->pais_vendedor_clave,
        'marca' => $row->marca, 'modelo' => $row->modelo, 'codigo_producto' => $row->codigo_producto,
        'observaciones_partida' => $row->observaciones_partida,
    ])->toArray() : [[]]);
    if (count($partidas) === 0) { $partidas = [[]]; }
    $v = fn($field, $default = '') => old($field, $p->$field ?? $default);
?>


<div class="aduana-form-section">
    <h4 class="aduana-form-section__title">1. Cabecera del pedimento</h4>
    <div class="aduana-form-grid">
        <div class="aduana-field">
            <label>Tipo de formato</label>
            <select name="tipo" class="aduana-input" required>
                <option value="tradicional" <?php if($v('tipo','tradicional')==='tradicional'): echo 'selected'; endif; ?>>Tradicional (completo)</option>
                <option value="simplificado" <?php if($v('tipo')==='simplificado'): echo 'selected'; endif; ?>>Simplificado</option>
            </select>
        </div>
        <div class="aduana-field">
            <label>T. operación</label>
            <select name="tipo_operacion" class="aduana-input" required>
                <option value="importacion" <?php if($v('tipo_operacion','importacion')==='importacion'): echo 'selected'; endif; ?>>Importación</option>
                <option value="exportacion" <?php if($v('tipo_operacion')==='exportacion'): echo 'selected'; endif; ?>>Exportación</option>
            </select>
        </div>
        <div class="aduana-field">
            <label>Cve. pedimento</label>
            <select name="clave_pedimento" class="aduana-input">
                <option value="">—</option>
                <?php $__currentLoopData = $catalogos['claves_pedimento']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($item->clave); ?>" <?php if($v('clave_pedimento')==$item->clave): echo 'selected'; endif; ?>><?php echo e($item->clave); ?> · <?php echo e($item->nombre); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="aduana-field">
            <label>Régimen</label>
            <select name="regimen_clave" class="aduana-input">
                <option value="">—</option>
                <?php $__currentLoopData = $catalogos['regimenes']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($item->clave); ?>" <?php if($v('regimen_clave')==$item->clave): echo 'selected'; endif; ?>><?php echo e($item->clave); ?> · <?php echo e($item->nombre); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="aduana-field">
            <label>Destino</label>
            <select name="destino_clave" class="aduana-input">
                <option value="">—</option>
                <?php $__currentLoopData = $catalogos['destinos']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($item->clave); ?>" <?php if($v('destino_clave')==$item->clave): echo 'selected'; endif; ?>><?php echo e($item->clave); ?> · <?php echo e($item->nombre); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="aduana-field">
            <label>Tipo de cambio</label>
            <input type="number" step="0.000001" name="tipo_cambio" class="aduana-input" value="<?php echo e($v('tipo_cambio')); ?>">
        </div>
        <div class="aduana-field">
            <label>Peso bruto (kg)</label>
            <input type="number" step="0.001" name="peso_bruto" class="aduana-input" value="<?php echo e($v('peso_bruto')); ?>">
        </div>
        <div class="aduana-field">
            <label>Aduana / ES</label>
            <select name="aduana_clave" class="aduana-input">
                <option value="">—</option>
                <?php $__currentLoopData = $catalogos['aduanas']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($item->clave); ?>" <?php if($v('aduana_clave')==$item->clave): echo 'selected'; endif; ?>><?php echo e($item->clave); ?> · <?php echo e($item->nombre); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="aduana-field">
            <label>Sección aduanera despacho</label>
            <input type="text" name="seccion_aduanera" class="aduana-input" value="<?php echo e($v('seccion_aduanera')); ?>" maxlength="20">
        </div>
        <div class="aduana-field">
            <label>Patente</label>
            <input type="text" name="patente" class="aduana-input" value="<?php echo e($v('patente')); ?>" maxlength="20">
        </div>
        <div class="aduana-field">
            <label>Equipo (opcional)</label>
            <select name="equipo_id" class="aduana-input">
                <option value="">Sin equipo</option>
                <?php $__currentLoopData = $equipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($eq->id); ?>" <?php if($v('equipo_id')==$eq->id): echo 'selected'; endif; ?>><?php echo e($eq->nombre); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>
</div>


<div class="aduana-form-section">
    <h4 class="aduana-form-section__title">2. Medios de transporte</h4>
    <div class="aduana-form-grid">
        <div class="aduana-field">
            <label>Medio (general)</label>
            <select name="medio_transporte_clave" class="aduana-input">
                <option value="">—</option>
                <?php $__currentLoopData = $catalogos['medios']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($item->clave); ?>" <?php if($v('medio_transporte_clave')==$item->clave): echo 'selected'; endif; ?>><?php echo e($item->clave); ?> · <?php echo e($item->nombre); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="aduana-field">
            <label>Entrada / salida</label>
            <select name="medio_entrada_clave" class="aduana-input">
                <option value="">—</option>
                <?php $__currentLoopData = $catalogos['medios']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($item->clave); ?>" <?php if($v('medio_entrada_clave')==$item->clave): echo 'selected'; endif; ?>><?php echo e($item->clave); ?> · <?php echo e($item->nombre); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="aduana-field">
            <label>Arribo</label>
            <select name="medio_arribo_clave" class="aduana-input">
                <option value="">—</option>
                <?php $__currentLoopData = $catalogos['medios']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($item->clave); ?>" <?php if($v('medio_arribo_clave')==$item->clave): echo 'selected'; endif; ?>><?php echo e($item->clave); ?> · <?php echo e($item->nombre); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="aduana-field">
            <label>Salida</label>
            <select name="medio_salida_clave" class="aduana-input">
                <option value="">—</option>
                <?php $__currentLoopData = $catalogos['medios']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($item->clave); ?>" <?php if($v('medio_salida_clave')==$item->clave): echo 'selected'; endif; ?>><?php echo e($item->clave); ?> · <?php echo e($item->nombre); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>
</div>


<div class="aduana-form-section">
    <h4 class="aduana-form-section__title">3. Valores</h4>
    <div class="aduana-form-grid">
        <div class="aduana-field"><label>Valor dólares</label><input type="number" step="0.01" name="valor_dolares" class="aduana-input" value="<?php echo e($v('valor_dolares')); ?>"></div>
        <div class="aduana-field"><label>Valor aduana</label><input type="number" step="0.01" name="valor_aduana" class="aduana-input" value="<?php echo e($v('valor_aduana')); ?>"></div>
        <div class="aduana-field"><label>Precio pagado / valor comercial</label><input type="number" step="0.01" name="precio_pagado" class="aduana-input" value="<?php echo e($v('precio_pagado')); ?>"></div>
        <div class="aduana-field"><label>Valor comercial (suma partidas)</label><input type="number" step="0.01" name="valor_comercial" class="aduana-input" value="<?php echo e($v('valor_comercial')); ?>"></div>
        <div class="aduana-field">
            <label>Moneda</label>
            <select name="moneda_clave" class="aduana-input">
                <option value="">—</option>
                <?php $__currentLoopData = $catalogos['monedas']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($item->clave); ?>" <?php if($v('moneda_clave')==$item->clave): echo 'selected'; endif; ?>><?php echo e($item->clave); ?> · <?php echo e($item->nombre); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="aduana-field">
            <label>Incoterm</label>
            <select name="incoterm_clave" class="aduana-input">
                <option value="">—</option>
                <?php $__currentLoopData = $catalogos['incoterms']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($item->clave); ?>" <?php if($v('incoterm_clave')==$item->clave): echo 'selected'; endif; ?>><?php echo e($item->clave); ?> · <?php echo e($item->nombre); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>
</div>


<div class="aduana-form-section">
    <h4 class="aduana-form-section__title">4. Datos del importador / exportador</h4>
    <div class="aduana-form-grid">
        <div class="aduana-field"><label>RFC</label><input type="text" name="rfc_operador" class="aduana-input" value="<?php echo e($v('rfc_operador')); ?>" maxlength="20"></div>
        <div class="aduana-field"><label>Nombre / razón social</label><input type="text" name="nombre_operador" class="aduana-input" value="<?php echo e($v('nombre_operador')); ?>"></div>
        <div class="aduana-field"><label>CURP</label><input type="text" name="curp_operador" class="aduana-input" value="<?php echo e($v('curp_operador')); ?>" maxlength="20"></div>
        <div class="aduana-field aduana-field--full"><label>Domicilio</label><input type="text" name="domicilio_operador" class="aduana-input" value="<?php echo e($v('domicilio_operador')); ?>"></div>
        <div class="aduana-field">
            <label>País origen</label>
            <select name="pais_origen_clave" class="aduana-input">
                <option value="">—</option>
                <?php $__currentLoopData = $catalogos['paises']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($item->clave): ?><option value="<?php echo e($item->clave); ?>" <?php if($v('pais_origen_clave')==$item->clave): echo 'selected'; endif; ?>><?php echo e($item->clave); ?> · <?php echo e($item->nombre); ?></option><?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="aduana-field">
            <label>País destino</label>
            <select name="pais_destino_clave" class="aduana-input">
                <option value="">—</option>
                <?php $__currentLoopData = $catalogos['paises']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($item->clave): ?><option value="<?php echo e($item->clave); ?>" <?php if($v('pais_destino_clave')==$item->clave): echo 'selected'; endif; ?>><?php echo e($item->clave); ?> · <?php echo e($item->nombre); ?></option><?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
    </div>
</div>


<div class="aduana-form-section">
    <h4 class="aduana-form-section__title">5. Incrementables</h4>
    <div class="aduana-form-grid">
        <div class="aduana-field"><label>Val. seguros</label><input type="number" step="0.01" name="val_seguros" class="aduana-input" value="<?php echo e($v('val_seguros')); ?>"></div>
        <div class="aduana-field"><label>Seguros</label><input type="number" step="0.01" name="seguros" class="aduana-input" value="<?php echo e($v('seguros')); ?>"></div>
        <div class="aduana-field"><label>Fletes</label><input type="number" step="0.01" name="fletes" class="aduana-input" value="<?php echo e($v('fletes')); ?>"></div>
        <div class="aduana-field"><label>Embalajes</label><input type="number" step="0.01" name="embalajes" class="aduana-input" value="<?php echo e($v('embalajes')); ?>"></div>
        <div class="aduana-field"><label>Otros incrementables</label><input type="number" step="0.01" name="otros_incrementables" class="aduana-input" value="<?php echo e($v('otros_incrementables')); ?>"></div>
    </div>
</div>


<div class="aduana-form-section">
    <h4 class="aduana-form-section__title">6. Códigos, bultos y aceptación</h4>
    <div class="aduana-form-grid">
        <div class="aduana-field"><label>Código de aceptación</label><input type="text" name="codigo_aceptacion" class="aduana-input" value="<?php echo e($v('codigo_aceptacion')); ?>"></div>
        <div class="aduana-field"><label>Código de barras</label><input type="text" name="codigo_barras_pedimento" class="aduana-input" value="<?php echo e($v('codigo_barras_pedimento')); ?>"></div>
        <div class="aduana-field"><label>Marcas, números y total de bultos</label><input type="text" name="marcas_bultos" class="aduana-input" value="<?php echo e($v('marcas_bultos')); ?>"></div>
        <div class="aduana-field"><label>Total de bultos</label><input type="number" name="total_bultos" class="aduana-input" value="<?php echo e($v('total_bultos')); ?>"></div>
    </div>
</div>


<div class="aduana-form-section">
    <h4 class="aduana-form-section__title">7. Datos del proveedor o comprador</h4>
    <div class="aduana-form-grid">
        <div class="aduana-field"><label>ID fiscal</label><input type="text" name="proveedor_id_fiscal" class="aduana-input" value="<?php echo e($v('proveedor_id_fiscal')); ?>"></div>
        <div class="aduana-field"><label>Nombre / razón social</label><input type="text" name="proveedor_nombre" class="aduana-input" value="<?php echo e($v('proveedor_nombre')); ?>"></div>
        <div class="aduana-field aduana-field--full"><label>Domicilio</label><input type="text" name="proveedor_domicilio" class="aduana-input" value="<?php echo e($v('proveedor_domicilio')); ?>"></div>
        <div class="aduana-field"><label>Vinculación</label><input type="text" name="vinculacion" class="aduana-input" value="<?php echo e($v('vinculacion')); ?>" maxlength="5" placeholder="S/N"></div>
        <div class="aduana-field"><label>Núm. CFDI / doc. equivalente</label><input type="text" name="cfdi_numero" class="aduana-input" value="<?php echo e($v('cfdi_numero')); ?>"></div>
        <div class="aduana-field"><label>Fecha CFDI</label><input type="date" name="cfdi_fecha" class="aduana-input" value="<?php echo e($v('cfdi_fecha')); ?>"></div>
        <div class="aduana-field"><label>Val. mon. fact</label><input type="number" step="0.01" name="cfdi_valor_moneda" class="aduana-input" value="<?php echo e($v('cfdi_valor_moneda')); ?>"></div>
        <div class="aduana-field"><label>Factor mon.</label><input type="number" step="0.000001" name="cfdi_factor_moneda" class="aduana-input" value="<?php echo e($v('cfdi_factor_moneda')); ?>"></div>
        <div class="aduana-field"><label>Val. dólares CFDI</label><input type="number" step="0.01" name="cfdi_valor_dolares" class="aduana-input" value="<?php echo e($v('cfdi_valor_dolares')); ?>"></div>
    </div>
</div>


<div class="aduana-form-section">
    <h4 class="aduana-form-section__title">8. Agente / agencia aduanal</h4>
    <div class="aduana-form-grid">
        <div class="aduana-field"><label>Nombre o razón social</label><input type="text" name="agente_nombre" class="aduana-input" value="<?php echo e($v('agente_nombre')); ?>"></div>
        <div class="aduana-field"><label>RFC</label><input type="text" name="agente_rfc" class="aduana-input" value="<?php echo e($v('agente_rfc')); ?>"></div>
        <div class="aduana-field"><label>CURP</label><input type="text" name="agente_curp" class="aduana-input" value="<?php echo e($v('agente_curp')); ?>"></div>
        <div class="aduana-field"><label>Patente o autorización</label><input type="text" name="agente_patente" class="aduana-input" value="<?php echo e($v('agente_patente')); ?>"></div>
    </div>
</div>

<div class="aduana-form-section">
    <h4 class="aduana-form-section__title">9. Observaciones</h4>
    <textarea name="observaciones" rows="3" class="aduana-input"><?php echo e($v('observaciones')); ?></textarea>
</div>


<div class="aduana-form-section">
    <div class="aduana-role-section-title">
        <div>
            <h4 class="aduana-form-section__title" style="margin:0">10. Partidas (anexo)</h4>
            <p>Fracción, NICO, cantidades UMC/UMT, valores y datos comerciales.</p>
        </div>
        <button type="button" class="aduana-btn" onclick="addPartidaRow()">+ Partida</button>
    </div>
    <div class="aduana-table-wrap" id="partidas-wrap">
        <table class="aduana-table" id="partidas-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fracción</th>
                    <th>NICO</th>
                    <th>Descripción</th>
                    <th>Cant.</th>
                    <th>UMC</th>
                    <th>UMT</th>
                    <th>V. com.</th>
                    <th>V. adu.</th>
                    <th>P.O.</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $partidas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="partida-num"><?php echo e($i + 1); ?></td>
                        <td><input type="text" name="partidas[<?php echo e($i); ?>][fraccion]" value="<?php echo e($row['fraccion'] ?? ''); ?>" class="aduana-input aduana-input--sm"></td>
                        <td><input type="text" name="partidas[<?php echo e($i); ?>][nico]" value="<?php echo e($row['nico'] ?? ''); ?>" class="aduana-input aduana-input--sm"></td>
                        <td><input type="text" name="partidas[<?php echo e($i); ?>][descripcion]" value="<?php echo e($row['descripcion'] ?? ''); ?>" class="aduana-input"></td>
                        <td><input type="number" step="0.001" name="partidas[<?php echo e($i); ?>][cantidad]" value="<?php echo e($row['cantidad'] ?? ''); ?>" class="aduana-input aduana-input--sm"></td>
                        <td><input type="text" name="partidas[<?php echo e($i); ?>][umc]" value="<?php echo e($row['umc'] ?? ($row['unidad'] ?? '')); ?>" class="aduana-input aduana-input--sm" placeholder="Clave"></td>
                        <td><input type="text" name="partidas[<?php echo e($i); ?>][umt]" value="<?php echo e($row['umt'] ?? ''); ?>" class="aduana-input aduana-input--sm"></td>
                        <td><input type="number" step="0.01" name="partidas[<?php echo e($i); ?>][valor_comercial]" value="<?php echo e($row['valor_comercial'] ?? ''); ?>" class="aduana-input aduana-input--sm"></td>
                        <td><input type="number" step="0.01" name="partidas[<?php echo e($i); ?>][valor_aduana]" value="<?php echo e($row['valor_aduana'] ?? ''); ?>" class="aduana-input aduana-input--sm"></td>
                        <td><input type="text" name="partidas[<?php echo e($i); ?>][pais_origen_clave]" value="<?php echo e($row['pais_origen_clave'] ?? ''); ?>" class="aduana-input aduana-input--sm"></td>
                        <td><button type="button" class="aduana-btn aduana-btn--ghost" onclick="this.closest('tr').remove(); renumberPartidas()">✕</button></td>
                    </tr>
                    <input type="hidden" name="partidas[<?php echo e($i); ?>][unidad]" value="<?php echo e($row['unidad'] ?? ''); ?>">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>

<script>
let partidaIndex = <?php echo e(count($partidas)); ?>;
function addPartidaRow() {
    const tbody = document.querySelector('#partidas-table tbody');
    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td class="partida-num"></td>
        <td><input type="text" name="partidas[${partidaIndex}][fraccion]" class="aduana-input aduana-input--sm"></td>
        <td><input type="text" name="partidas[${partidaIndex}][nico]" class="aduana-input aduana-input--sm"></td>
        <td><input type="text" name="partidas[${partidaIndex}][descripcion]" class="aduana-input"></td>
        <td><input type="number" step="0.001" name="partidas[${partidaIndex}][cantidad]" class="aduana-input aduana-input--sm"></td>
        <td><input type="text" name="partidas[${partidaIndex}][umc]" class="aduana-input aduana-input--sm" placeholder="Clave"></td>
        <td><input type="text" name="partidas[${partidaIndex}][umt]" class="aduana-input aduana-input--sm"></td>
        <td><input type="number" step="0.01" name="partidas[${partidaIndex}][valor_comercial]" class="aduana-input aduana-input--sm"></td>
        <td><input type="number" step="0.01" name="partidas[${partidaIndex}][valor_aduana]" class="aduana-input aduana-input--sm"></td>
        <td><input type="text" name="partidas[${partidaIndex}][pais_origen_clave]" class="aduana-input aduana-input--sm"></td>
        <td><button type="button" class="aduana-btn aduana-btn--ghost" onclick="this.closest('tr').remove(); renumberPartidas()">✕</button></td>`;
    tbody.appendChild(tr);
    partidaIndex++;
    renumberPartidas();
}
function renumberPartidas() {
    document.querySelectorAll('#partidas-table tbody tr').forEach((tr, i) => {
        const num = tr.querySelector('.partida-num');
        if (num) num.textContent = i + 1;
    });
}
</script>
<?php /**PATH /home/lozada/AduanaSim/resources/views/capturista/pedimentos/_form.blade.php ENDPATH**/ ?>