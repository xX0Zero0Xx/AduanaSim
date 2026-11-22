<section class="aduana-role-home">
    <div class="aduana-home__intro">
        <div>
            <span class="aduana-eyebrow aduana-eyebrow--muted">VISTA GENERAL · CAPTURISTA</span>
            <h3>Tu espacio de prácticas</h3>
            <p>Elabora documentos, guarda avances como borrador y envía tus ejercicios al agente para su validación académica.</p>
        </div>
    </div>

    <div class="aduana-stat-grid aduana-stat-grid--three">
        <article class="aduana-stat-card">
            <span class="aduana-stat-card__label">Mis borradores</span>
            <strong>{{ $stats['borradores'] ?? 0 }}</strong>
            <small>Documentos en elaboración</small>
        </article>
        <article class="aduana-stat-card">
            <span class="aduana-stat-card__label">En validación</span>
            <strong>{{ $stats['enviados'] ?? 0 }}</strong>
            <small>En espera de revisión</small>
        </article>
        <article class="aduana-stat-card">
            <span class="aduana-stat-card__label">Documentos validados</span>
            <strong>{{ $stats['validados'] ?? 0 }}</strong>
            <small>Ejercicios revisados</small>
        </article>
    </div>

    <div class="aduana-role-section-title">
        <div>
            <h4>Crear un documento</h4>
            <p>Selecciona el tipo de documento que deseas preparar.</p>
        </div>
    </div>

    <div class="aduana-module-grid">
        <article class="aduana-module-card">
            <div class="aduana-module-card__icon aduana-module-card__icon--navy">▤</div>
            <span class="aduana-module-card__kicker">DOCUMENTACIÓN ADUANERA</span>
            <h4>Pedimentos</h4>
            <p>Práctica de pedimentos tradicionales y simplificados.</p>
            <a href="{{ route('capturista.pedimentos.index') }}" class="aduana-text-action">Abrir módulo <span>→</span></a>
        </article>
        <article class="aduana-module-card">
            <div class="aduana-module-card__icon aduana-module-card__icon--teal">▧</div>
            <span class="aduana-module-card__kicker">COMPROBANTE DE VALOR</span>
            <h4>Cove</h4>
            <p>Captura datos de valor y relaciónalos con un pedimento.</p>
            <a href="{{ route('capturista.coves.index') }}" class="aduana-text-action">Abrir módulo <span>→</span></a>
        </article>
        <article class="aduana-module-card">
            <div class="aduana-module-card__icon aduana-module-card__icon--gold">▦</div>
            <span class="aduana-module-card__kicker">DESPACHO ADUANERO</span>
            <h4>Doda</h4>
            <p>Prepara la información para la representación académica del DODA.</p>
            <a href="{{ route('capturista.dodas.index') }}" class="aduana-text-action">Abrir módulo <span>→</span></a>
        </article>
    </div>

    <div class="aduana-notice">
        <span class="aduana-notice__icon">i</span>
        <div>
            <strong>Trabajo en equipo</strong>
            <p>Los documentos compartidos pueden ser consultados por los integrantes de tu equipo. Usa la pestaña <em>Mi equipo</em> o <a href="{{ route('capturista.equipo.index') }}" class="aduana-link">abre la vista de equipos</a>.</p>
        </div>
    </div>
</section>
