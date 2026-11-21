<?php
    $selectedPedimentos = old('pedimento_ids', isset($doda) ? $doda->pedimentos->pluck('id')->all() : []);
?>


<div class="aduana-info-strip" style="margin-bottom:1rem">
    <strong>Autollenado desde pedimento</strong>
    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:8px;align-items:center">
        <input type="text" id="doda-lookup-folio" class="aduana-input" style="max-width:220px" placeholder="Folio del pedimento (ej. PT-…)">
        <button type="button" class="aduana-btn aduana-btn--primary" onclick="lookupPedimentoForDoda()">Cargar y asociar</button>
        <span id="doda-lookup-msg" class="text-sm" style="color:#71818b"></span>
    </div>
</div>
<script>
async function lookupPedimentoForDoda() {
    const folio = document.getElementById('doda-lookup-folio').value.trim();
    const msg = document.getElementById('doda-lookup-msg');
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
        set('aduana_clave', p.aduana_clave);
        set('patente', p.patente);
        set('medio_transporte_clave', p.medio_transporte_clave);
        // Marcar checkbox del pedimento
        let cb = document.querySelector(`input[name="pedimento_ids[]"][value="${p.id}"]`);
        if (!cb) {
            const list = document.querySelector('.aduana-check-list');
            if (list) {
                const label = document.createElement('label');
                label.className = 'aduana-check-item';
                label.innerHTML = `<input type="checkbox" name="pedimento_ids[]" value="${p.id}" checked>
                    <span><strong>${p.folio}</strong><small>${p.nombre_operador || 'Sin operador'} · cargado</small></span>`;
                list.prepend(label);
            }
        } else {
            cb.checked = true;
        }
        msg.textContent = 'Datos y asociación cargados desde ' + p.folio;
    } catch (e) {
        msg.textContent = 'Error al consultar el pedimento.';
    }
}
</script>



<div class="aduana-form-grid">
    <div class="aduana-field">
        <label>Aduana</label>
        <select name="aduana_clave" class="aduana-input">
            <option value="">—</option>
            <?php $__currentLoopData = $catalogos['aduanas']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($a->clave); ?>" <?php if(old('aduana_clave', $doda->aduana_clave ?? '') == $a->clave): echo 'selected'; endif; ?>><?php echo e($a->clave); ?> · <?php echo e($a->nombre); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="aduana-field">
        <label>Patente</label>
        <input type="text" name="patente" class="aduana-input" value="<?php echo e(old('patente', $doda->patente ?? '')); ?>">
    </div>
    <div class="aduana-field">
        <label>Número de operación</label>
        <input type="text" name="numero_operacion" class="aduana-input" value="<?php echo e(old('numero_operacion', $doda->numero_operacion ?? '')); ?>">
    </div>
    <div class="aduana-field">
        <label>Fecha de operación</label>
        <input type="date" name="fecha_operacion" class="aduana-input" value="<?php echo e(old('fecha_operacion', isset($doda) && $doda->fecha_operacion ? $doda->fecha_operacion->format('Y-m-d') : '')); ?>">
    </div>
    <div class="aduana-field">
        <label>Medio de transporte</label>
        <select name="medio_transporte_clave" class="aduana-input">
            <option value="">—</option>
            <?php $__currentLoopData = $catalogos['medios']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($m->clave); ?>" <?php if(old('medio_transporte_clave', $doda->medio_transporte_clave ?? '') == $m->clave): echo 'selected'; endif; ?>><?php echo e($m->clave); ?> · <?php echo e($m->nombre); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="aduana-field">
        <label>Placa / identificación</label>
        <input type="text" name="placa_o_identificacion" class="aduana-input" value="<?php echo e(old('placa_o_identificacion', $doda->placa_o_identificacion ?? '')); ?>">
    </div>
    <div class="aduana-field">
        <label>Equipo</label>
        <select name="equipo_id" class="aduana-input">
            <option value="">Sin equipo</option>
            <?php $__currentLoopData = $equipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($eq->id); ?>" <?php if(old('equipo_id', $doda->equipo_id ?? '') == $eq->id): echo 'selected'; endif; ?>><?php echo e($eq->nombre); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="aduana-field aduana-field--full">
        <label>Observaciones</label>
        <textarea name="observaciones" class="aduana-input" rows="2"><?php echo e(old('observaciones', $doda->observaciones ?? '')); ?></textarea>
    </div>
</div>

<div class="aduana-role-section-title mt-6">
    <div>
        <h4>Pedimentos asociados</h4>
        <p>Selecciona uno o más pedimentos que integrarán este DODA.</p>
    </div>
</div>

<div class="aduana-check-list">
    <?php $__empty_1 = true; $__currentLoopData = $pedimentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <label class="aduana-check-item">
            <input type="checkbox" name="pedimento_ids[]" value="<?php echo e($p->id); ?>" <?php if(in_array($p->id, $selectedPedimentos)): echo 'checked'; endif; ?>>
            <span>
                <strong><?php echo e($p->folio); ?></strong>
                <small><?php echo e($p->nombre_operador ?: 'Sin operador'); ?> · <?php echo e($p->estatus); ?></small>
            </span>
        </label>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="text-slate-500">No hay pedimentos disponibles. Crea uno primero.</p>
    <?php endif; ?>
</div>
<?php /**PATH /home/lozada/Escritorio/AduanaSim/resources/views/capturista/dodas/_form.blade.php ENDPATH**/ ?>