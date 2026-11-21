<?php
    $facturas = old('facturas', isset($cove) ? $cove->facturas->map(fn($f)=>[
        'numero_factura'=>$f->numero_factura,'fecha_factura'=>optional($f->fecha_factura)->format('Y-m-d'),
        'valor'=>$f->valor,'moneda_clave'=>$f->moneda_clave
    ])->toArray() : [['numero_factura'=>'','fecha_factura'=>'','valor'=>'','moneda_clave'=>'']]);
    $mercancias = old('mercancias', isset($cove) ? $cove->mercancias->map(fn($m)=>$m->only(['descripcion','cantidad','unidad','valor','fraccion']))->toArray() : [['descripcion'=>'','cantidad'=>'','unidad'=>'','valor'=>'','fraccion'=>'']]);
?>


<div class="aduana-info-strip" style="margin-bottom:1rem">
    <strong>Autollenado desde pedimento</strong>
    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:8px;align-items:center">
        <input type="text" id="cove-lookup-folio" class="aduana-input" style="max-width:220px" placeholder="Folio del pedimento (ej. PT-…)">
        <button type="button" class="aduana-btn aduana-btn--primary" onclick="lookupPedimentoForCove()">Cargar datos</button>
        <span id="cove-lookup-msg" class="text-sm" style="color:#71818b"></span>
    </div>
</div>
<script>
async function lookupPedimentoForCove() {
    const folio = document.getElementById('cove-lookup-folio').value.trim();
    const msg = document.getElementById('cove-lookup-msg');
    if (!folio) { msg.textContent = 'Escribe un folio.'; return; }
    msg.textContent = 'Buscando…';
    try {
        const res = await fetch(`<?php echo e(route('capturista.pedimentos.lookup')); ?>?folio=` + encodeURIComponent(folio), {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await res.json();
        if (!res.ok || !data.found) {
            msg.textContent = data.message || 'No encontrado';
            return;
        }
        const p = data.pedimento;
        const set = (name, val) => {
            const el = document.querySelector(`[name="${name}"]`);
            if (el && val != null && val !== '') el.value = val;
        };
        // Seleccionar pedimento en el select si existe
        const sel = document.querySelector('[name="pedimento_id"]');
        if (sel) {
            let opt = [...sel.options].find(o => o.value == p.id);
            if (!opt) {
                opt = new Option(p.folio + (p.nombre_operador ? ' · ' + p.nombre_operador : ''), p.id, true, true);
                sel.add(opt);
            } else {
                sel.value = p.id;
            }
        }
        set('emisor_rfc', p.proveedor_id_fiscal || p.rfc_operador);
        set('emisor_nombre', p.proveedor_nombre || '');
        set('destinatario_rfc', p.rfc_operador);
        set('destinatario_nombre', p.nombre_operador);
        set('moneda_clave', p.moneda_clave);
        // Mercancías desde partidas
        if (p.partidas && p.partidas.length) {
            const tbody = document.querySelector('#mercancias-table tbody');
            if (tbody) {
                tbody.innerHTML = '';
                p.partidas.forEach((m, i) => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `<td><input name="mercancias[${i}][descripcion]" value="${(m.descripcion||'').replace(/"/g,'&quot;')}" class="aduana-input"></td>
                        <td><input type="number" step="0.001" name="mercancias[${i}][cantidad]" value="${m.cantidad||''}" class="aduana-input aduana-input--sm"></td>
                        <td><input name="mercancias[${i}][unidad]" value="${m.unidad||''}" class="aduana-input aduana-input--sm"></td>
                        <td><input type="number" step="0.01" name="mercancias[${i}][valor]" value="${m.valor_comercial||''}" class="aduana-input aduana-input--sm"></td>
                        <td><input name="mercancias[${i}][fraccion]" value="${m.fraccion||''}" class="aduana-input aduana-input--sm"></td>
                        <td><button type="button" class="aduana-btn aduana-btn--ghost" onclick="this.closest('tr').remove()">✕</button></td>`;
                    tbody.appendChild(tr);
                });
                if (typeof mi !== 'undefined') mi = p.partidas.length;
            }
        }
        // Factura desde CFDI si hay
        if (p.cfdi_numero) {
            const ft = document.querySelector('#facturas-table tbody');
            if (ft && ft.rows.length) {
                const row = ft.rows[0];
                const inputs = row.querySelectorAll('input');
                if (inputs[0]) inputs[0].value = p.cfdi_numero;
                if (inputs[1] && p.cfdi_fecha) inputs[1].value = p.cfdi_fecha;
                if (inputs[2]) inputs[2].value = p.valor_comercial || '';
                if (inputs[3]) inputs[3].value = p.moneda_clave || '';
            }
        }
        msg.textContent = 'Datos cargados desde ' + p.folio;
    } catch (e) {
        msg.textContent = 'Error al consultar el pedimento.';
    }
}
</script>



<div class="aduana-form-grid">
    <div class="aduana-field">
        <label>Pedimento relacionado (opcional)</label>
        <select name="pedimento_id" class="aduana-input">
            <option value="">Sin pedimento</option>
            <?php $__currentLoopData = $pedimentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($p->id); ?>" <?php if(old('pedimento_id', $cove->pedimento_id ?? ($pedimento_id ?? '')) == $p->id): echo 'selected'; endif; ?>>
                    <?php echo e($p->folio); ?> <?php echo e($p->nombre_operador ? '· '.$p->nombre_operador : ''); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="aduana-field">
        <label>Equipo</label>
        <select name="equipo_id" class="aduana-input">
            <option value="">Sin equipo</option>
            <?php $__currentLoopData = $equipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($eq->id); ?>" <?php if(old('equipo_id', $cove->equipo_id ?? '') == $eq->id): echo 'selected'; endif; ?>><?php echo e($eq->nombre); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="aduana-field">
        <label>RFC emisor</label>
        <input type="text" name="emisor_rfc" class="aduana-input" value="<?php echo e(old('emisor_rfc', $cove->emisor_rfc ?? '')); ?>">
    </div>
    <div class="aduana-field">
        <label>Nombre emisor</label>
        <input type="text" name="emisor_nombre" class="aduana-input" value="<?php echo e(old('emisor_nombre', $cove->emisor_nombre ?? '')); ?>">
    </div>
    <div class="aduana-field">
        <label>RFC destinatario</label>
        <input type="text" name="destinatario_rfc" class="aduana-input" value="<?php echo e(old('destinatario_rfc', $cove->destinatario_rfc ?? '')); ?>">
    </div>
    <div class="aduana-field">
        <label>Nombre destinatario</label>
        <input type="text" name="destinatario_nombre" class="aduana-input" value="<?php echo e(old('destinatario_nombre', $cove->destinatario_nombre ?? '')); ?>">
    </div>
    <div class="aduana-field">
        <label>Moneda</label>
        <select name="moneda_clave" class="aduana-input">
            <option value="">—</option>
            <?php $__currentLoopData = $catalogos['monedas']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($m->clave); ?>" <?php if(old('moneda_clave', $cove->moneda_clave ?? '') == $m->clave): echo 'selected'; endif; ?>><?php echo e($m->clave); ?> · <?php echo e($m->nombre); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="aduana-field aduana-field--full">
        <label>Observaciones</label>
        <textarea name="observaciones" class="aduana-input" rows="2"><?php echo e(old('observaciones', $cove->observaciones ?? '')); ?></textarea>
    </div>
</div>

<div class="aduana-role-section-title mt-6">
    <div><h4>Facturas</h4></div>
    <button type="button" class="aduana-btn" onclick="addFactura()">+ Factura</button>
</div>
<div class="aduana-table-wrap">
    <table class="aduana-table" id="facturas-table">
        <thead><tr><th>Número</th><th>Fecha</th><th>Valor</th><th>Moneda</th><th></th></tr></thead>
        <tbody>
            <?php $__currentLoopData = $facturas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><input name="facturas[<?php echo e($i); ?>][numero_factura]" value="<?php echo e($f['numero_factura'] ?? ''); ?>" class="aduana-input"></td>
                    <td><input type="date" name="facturas[<?php echo e($i); ?>][fecha_factura]" value="<?php echo e($f['fecha_factura'] ?? ''); ?>" class="aduana-input"></td>
                    <td><input type="number" step="0.01" name="facturas[<?php echo e($i); ?>][valor]" value="<?php echo e($f['valor'] ?? ''); ?>" class="aduana-input aduana-input--sm"></td>
                    <td><input name="facturas[<?php echo e($i); ?>][moneda_clave]" value="<?php echo e($f['moneda_clave'] ?? ''); ?>" class="aduana-input aduana-input--sm"></td>
                    <td><button type="button" class="aduana-btn aduana-btn--ghost" onclick="this.closest('tr').remove()">✕</button></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>

<div class="aduana-role-section-title mt-6">
    <div><h4>Mercancías</h4></div>
    <button type="button" class="aduana-btn" onclick="addMercancia()">+ Mercancía</button>
</div>
<div class="aduana-table-wrap">
    <table class="aduana-table" id="mercancias-table">
        <thead><tr><th>Descripción</th><th>Cant.</th><th>Unidad</th><th>Valor</th><th>Fracción</th><th></th></tr></thead>
        <tbody>
            <?php $__currentLoopData = $mercancias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><input name="mercancias[<?php echo e($i); ?>][descripcion]" value="<?php echo e($m['descripcion'] ?? ''); ?>" class="aduana-input"></td>
                    <td><input type="number" step="0.001" name="mercancias[<?php echo e($i); ?>][cantidad]" value="<?php echo e($m['cantidad'] ?? ''); ?>" class="aduana-input aduana-input--sm"></td>
                    <td><input name="mercancias[<?php echo e($i); ?>][unidad]" value="<?php echo e($m['unidad'] ?? ''); ?>" class="aduana-input aduana-input--sm"></td>
                    <td><input type="number" step="0.01" name="mercancias[<?php echo e($i); ?>][valor]" value="<?php echo e($m['valor'] ?? ''); ?>" class="aduana-input aduana-input--sm"></td>
                    <td><input name="mercancias[<?php echo e($i); ?>][fraccion]" value="<?php echo e($m['fraccion'] ?? ''); ?>" class="aduana-input aduana-input--sm"></td>
                    <td><button type="button" class="aduana-btn aduana-btn--ghost" onclick="this.closest('tr').remove()">✕</button></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>

<script>
let fi = <?php echo e(count($facturas)); ?>, mi = <?php echo e(count($mercancias)); ?>;
function addFactura() {
    const t = document.querySelector('#facturas-table tbody');
    const tr = document.createElement('tr');
    tr.innerHTML = `<td><input name="facturas[${fi}][numero_factura]" class="aduana-input"></td>
        <td><input type="date" name="facturas[${fi}][fecha_factura]" class="aduana-input"></td>
        <td><input type="number" step="0.01" name="facturas[${fi}][valor]" class="aduana-input aduana-input--sm"></td>
        <td><input name="facturas[${fi}][moneda_clave]" class="aduana-input aduana-input--sm"></td>
        <td><button type="button" class="aduana-btn aduana-btn--ghost" onclick="this.closest('tr').remove()">✕</button></td>`;
    t.appendChild(tr); fi++;
}
function addMercancia() {
    const t = document.querySelector('#mercancias-table tbody');
    const tr = document.createElement('tr');
    tr.innerHTML = `<td><input name="mercancias[${mi}][descripcion]" class="aduana-input"></td>
        <td><input type="number" step="0.001" name="mercancias[${mi}][cantidad]" class="aduana-input aduana-input--sm"></td>
        <td><input name="mercancias[${mi}][unidad]" class="aduana-input aduana-input--sm"></td>
        <td><input type="number" step="0.01" name="mercancias[${mi}][valor]" class="aduana-input aduana-input--sm"></td>
        <td><input name="mercancias[${mi}][fraccion]" class="aduana-input aduana-input--sm"></td>
        <td><button type="button" class="aduana-btn aduana-btn--ghost" onclick="this.closest('tr').remove()">✕</button></td>`;
    t.appendChild(tr); mi++;
}
</script>
<?php /**PATH /home/lozada/Escritorio/AduanaSim/resources/views/capturista/coves/_form.blade.php ENDPATH**/ ?>