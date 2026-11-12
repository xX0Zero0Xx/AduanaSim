<section class="aduana-role-home">
    <div class="aduana-home__intro"><div><span class="aduana-eyebrow aduana-eyebrow--muted">VISTA GENERAL · AGENTE</span><h3>Panel de revisión y validación</h3><p>Revisa los documentos enviados por los capturistas, registra observaciones y conserva el historial de tus decisiones.</p></div><div class="aduana-home__stamp"><span>AS</span><small>REVISIÓN</small></div></div>
    <div class="aduana-stat-grid aduana-stat-grid--three">
        <article class="aduana-stat-card"><span class="aduana-stat-card__label">Pendientes de revisión</span><strong>—</strong><small>Documentos por atender</small></article>
        <article class="aduana-stat-card"><span class="aduana-stat-card__label">Validados</span><strong>—</strong><small>Revisiones aprobadas</small></article>
        <article class="aduana-stat-card"><span class="aduana-stat-card__label">No validados</span><strong>—</strong><small>Devueltos con observaciones</small></article>
    </div>
    <div class="aduana-role-section-title"><div><h4>Centro de validación</h4><p>Selecciona una bandeja para consultar los documentos correspondientes.</p></div></div>
    <div class="aduana-module-grid">
        <article class="aduana-module-card"><div class="aduana-module-card__icon aduana-module-card__icon--gold">◷</div><span class="aduana-module-card__kicker">ATENCIÓN REQUERIDA</span><h4>Por revisar</h4><p>Documentos que esperan una decisión de validación.</p><button class="aduana-text-action" type="button" @click="tab = 'pendientes'">Abrir bandeja <span>→</span></button></article>
        <article class="aduana-module-card"><div class="aduana-module-card__icon aduana-module-card__icon--teal">✓</div><span class="aduana-module-card__kicker">REVISIÓN CONCLUIDA</span><h4>Validados</h4><p>Consulta los documentos que cumplen con la revisión académica.</p><button class="aduana-text-action" type="button" @click="tab = 'validados'">Consultar <span>→</span></button></article>
        <article class="aduana-module-card"><div class="aduana-module-card__icon aduana-module-card__icon--navy">↶</div><span class="aduana-module-card__kicker">REQUIEREN CORRECCIÓN</span><h4>No validados</h4><p>Consulta documentos devueltos y las observaciones registradas.</p><button class="aduana-text-action" type="button" @click="tab = 'devueltos'">Consultar <span>→</span></button></article>
    </div>
    <div class="aduana-notice"><span class="aduana-notice__icon">i</span><div><strong>Criterio de revisión</strong><p>La validación de AduanaSim es académica y no equivale a una validación oficial de la autoridad aduanera.</p></div></div>
</section>
<?php /**PATH /home/lozada/Documentos/VS_Code/AduanaSim/resources/views/dashboard/partials/roles/agente/inicio.blade.php ENDPATH**/ ?>