<section class="aduana-role-home">
    <div class="aduana-home__intro">
        <div>
            <span class="aduana-eyebrow aduana-eyebrow--muted">VISTA GENERAL · AGENTE</span>
            <h3>Panel de revisión y validación</h3>
            <p>Revisa los documentos enviados por los capturistas, registra observaciones y administra los equipos de trabajo.</p>
        </div>
        <div class="aduana-home__stamp"><span>AS</span><small>REVISIÓN</small></div>
    </div>

    @php $s = $agentStats ?? ['pendientes' => 0, 'validados' => 0, 'devueltos' => 0]; @endphp

    <div class="aduana-stat-grid aduana-stat-grid--three">
        <article class="aduana-stat-card">
            <span class="aduana-stat-card__label">Pendientes de revisión</span>
            <strong>{{ $s['pendientes'] }}</strong>
            <small>Documentos por atender</small>
        </article>
        <article class="aduana-stat-card">
            <span class="aduana-stat-card__label">Validados</span>
            <strong>{{ $s['validados'] }}</strong>
            <small>Revisiones aprobadas</small>
        </article>
        <article class="aduana-stat-card">
            <span class="aduana-stat-card__label">No validados</span>
            <strong>{{ $s['devueltos'] }}</strong>
            <small>Devueltos con observaciones</small>
        </article>
    </div>

    <div class="aduana-role-section-title">
        <div>
            <h4>Centro de validación</h4>
            <p>Selecciona una bandeja para consultar los documentos correspondientes.</p>
        </div>
    </div>

    <div class="aduana-module-grid">
        <article class="aduana-module-card">
            <div class="aduana-module-card__icon aduana-module-card__icon--gold">◷</div>
            <span class="aduana-module-card__kicker">ATENCIÓN REQUERIDA</span>
            <h4>Por revisar</h4>
            <p>{{ $s['pendientes'] }} documento(s) esperan una decisión de validación.</p>
            <a href="{{ route('agente.revisiones.index', 'pendientes') }}" class="aduana-text-action">Abrir bandeja <span>→</span></a>
        </article>
        <article class="aduana-module-card">
            <div class="aduana-module-card__icon aduana-module-card__icon--teal">✓</div>
            <span class="aduana-module-card__kicker">REVISIÓN CONCLUIDA</span>
            <h4>Validados</h4>
            <p>{{ $s['validados'] }} documento(s) aprobados en la revisión académica.</p>
            <a href="{{ route('agente.revisiones.index', 'validados') }}" class="aduana-text-action">Consultar <span>→</span></a>
        </article>
        <article class="aduana-module-card">
            <div class="aduana-module-card__icon aduana-module-card__icon--coral">↶</div>
            <span class="aduana-module-card__kicker">CON OBSERVACIONES</span>
            <h4>No validados</h4>
            <p>{{ $s['devueltos'] }} documento(s) devueltos para corrección.</p>
            <a href="{{ route('agente.revisiones.index', 'devueltos') }}" class="aduana-text-action">Ver devueltos <span>→</span></a>
        </article>
        <article class="aduana-module-card">
            <div class="aduana-module-card__icon aduana-module-card__icon--navy">♧</div>
            <span class="aduana-module-card__kicker">COLABORACIÓN</span>
            <h4>Equipos</h4>
            <p>Crea equipos e incorpora capturistas al trabajo en grupo.</p>
            <a href="{{ route('agente.equipos.index') }}" class="aduana-text-action">Gestionar equipos <span>→</span></a>
        </article>
        <article class="aduana-module-card">
            <div class="aduana-module-card__icon">▤</div>
            <span class="aduana-module-card__kicker">CONSULTA</span>
            <h4>Historial</h4>
            <p>Consulta todas las revisiones realizadas.</p>
            <a href="{{ route('agente.revisiones.index', 'historial') }}" class="aduana-text-action">Abrir historial <span>→</span></a>
        </article>
    </div>
</section>
