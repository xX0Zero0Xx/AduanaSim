<section class="aduana-role-home">
    <div class="aduana-home__intro">
        <div>
            <span class="aduana-eyebrow aduana-eyebrow--muted">VISTA GENERAL · AGENTE</span>
            <h3>Panel de revisión y validación</h3>
            <p>Selecciona un departamento en cada apartado para filtrar documentos, usuarios o equipos.</p>
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
            <small>Aprobados</small>
        </article>
        <article class="aduana-stat-card">
            <span class="aduana-stat-card__label">Devueltos</span>
            <strong>{{ $s['devueltos'] }}</strong>
            <small>Con observaciones</small>
        </article>
    </div>

    <div class="aduana-role-section-title">
        <div>
            <h4>Accesos rápidos</h4>
            <p>Cada módulo inicia con el listado de departamentos para filtrar.</p>
        </div>
    </div>

    <div class="aduana-module-grid">
        <article class="aduana-module-card">
            <div class="aduana-module-card__icon aduana-module-card__icon--gold">◷</div>
            <span class="aduana-module-card__kicker">BANDEJA</span>
            <h4>Por revisar</h4>
            <p>{{ $s['pendientes'] }} pendiente(s). Filtra por departamento en el apartado.</p>
            <button type="button" class="aduana-text-action" @click="tab = 'pendientes'">Elegir departamento <span>→</span></button>
        </article>
        
        <article class="aduana-module-card">
            <div class="aduana-module-card__icon aduana-module-card__icon--navy">♙</div>
            <span class="aduana-module-card__kicker">ORGANIZACIÓN</span>
            <h4>Usuarios</h4>
            <p>Departamentos y capturistas asociados.</p>
            <button type="button" class="aduana-text-action" @click="tab = 'usuarios'">Elegir departamento <span>→</span></button>
        </article>
        <article class="aduana-module-card">
            <div class="aduana-module-card__icon">▤</div>
            <span class="aduana-module-card__kicker">CONSULTA</span>
            <h4>Historial</h4>
            <p>Vista rápida en el panel (sin salir).</p>
            <button type="button" class="aduana-text-action" @click="tab = 'historial'">Ver historial <span>→</span></button>
        </article>
        <article class="aduana-module-card">
            <div class="aduana-module-card__icon aduana-module-card__icon--navy">♧</div>
            <span class="aduana-module-card__kicker">COLABORACIÓN</span>
            <h4>Equipos</h4>
            <p>Filtra equipos por departamento de sus miembros.</p>
            <button type="button" class="aduana-text-action" @click="tab = 'equipos'">Elegir departamento <span>→</span></button>
        </article>
    </div>
</section>
