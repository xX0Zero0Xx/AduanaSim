<div class="aduana-home">
    <div class="aduana-home__intro">
        <div>
            <span class="aduana-eyebrow aduana-eyebrow--muted">PANEL PRINCIPAL</span>
            <h3>Tu espacio de aprendizaje aduanero</h3>
            <p>Selecciona un módulo para comenzar a trabajar con los documentos de una operación de comercio exterior.</p>
        </div>
        <div class="aduana-home__stamp"><span>AS</span><small>ADUANASIM</small></div>
    </div>

    <div class="aduana-module-grid">
        <article class="aduana-module-card">
            <div class="aduana-module-card__icon aduana-module-card__icon--navy"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M7 3.75h7l5 5v11.5a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-13a2 2 0 0 1 2-2Z"/><path stroke-linecap="round" d="M14 4v5h5M8.5 14h7M8.5 17.5h7"/></svg></div>
            <span class="aduana-module-card__kicker">DOCUMENTACIÓN ADUANERA</span>
            <h4>Pedimentos</h4>
            <p>Elabora y consulta ejercicios de pedimentos tradicionales y simplificados.</p>
            <button type="button" class="aduana-text-action" @click="tab = 'pedimentos'">Ir al módulo <span aria-hidden="true">→</span></button>
        </article>
        <article class="aduana-module-card">
            <div class="aduana-module-card__icon aduana-module-card__icon--teal"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5.5A2.5 2.5 0 0 1 6.5 3H18a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6.5A2.5 2.5 0 0 1 4 18.5v-13Z"/><path stroke-linecap="round" d="M8 8h8M8 12h8M8 16h5"/></svg></div>
            <span class="aduana-module-card__kicker">COMPROBANTE DE VALOR</span>
            <h4>COVE</h4>
            <p>Practica la captura de comprobantes de valor electrónico y sus datos relacionados.</p>
            <button type="button" class="aduana-text-action" @click="tab = 'cove'">Ir al módulo <span aria-hidden="true">→</span></button>
        </article>
        <article class="aduana-module-card">
            <div class="aduana-module-card__icon aduana-module-card__icon--gold"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><rect x="4" y="4" width="16" height="16" rx="2"/><path stroke-linecap="round" d="M8 8h2v2H8zM14 8h2v2h-2zM8 14h2v2H8zM14 14h2v2h-2z"/></svg></div>
            <span class="aduana-module-card__kicker">DESPACHO ADUANERO</span>
            <h4>DODA</h4>
            <p>Consulta y prepara representaciones académicas del documento de despacho.</p>
            <button type="button" class="aduana-text-action" @click="tab = 'doda'">Ir al módulo <span aria-hidden="true">→</span></button>
        </article>
    </div>

    <div class="aduana-notice">
        <span class="aduana-notice__icon">i</span>
        <div><strong>Entorno de simulación académica</strong><p>Los documentos generados en AduanaSim son ejercicios educativos y no tienen validez jurídica ni sustituyen los trámites ante las autoridades aduaneras.</p></div>
    </div>
</div>
