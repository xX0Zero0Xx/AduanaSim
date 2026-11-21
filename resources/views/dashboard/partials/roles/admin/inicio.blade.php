<section class="aduana-role-home">
    <div class="aduana-home__intro">
        <div><span class="aduana-eyebrow aduana-eyebrow--muted">VISTA GENERAL · ADMINISTRADOR</span><h3>Panel de administración</h3><p>Desde aquí podrás gestionar las cuentas, organizar equipos y controlar los módulos disponibles para los capturistas.</p></div>
        <div class="aduana-home__stamp"><span>AS</span><small>ADMIN</small></div>
    </div>
    <div class="aduana-stat-grid">
        <article class="aduana-stat-card"><span class="aduana-stat-card__label">Usuarios registrados</span><strong>{{ $registeredUserCount }}</strong><small>Cuenta(s) en el sistema</small></article>
        <article class="aduana-stat-card"><span class="aduana-stat-card__label">Equipos creados</span><strong>—</strong><small>Sin datos disponibles</small></article>
        <article class="aduana-stat-card"><span class="aduana-stat-card__label">Documentos generados</span><strong>—</strong><small>Sin datos disponibles</small></article>
        <article class="aduana-stat-card"><span class="aduana-stat-card__label">Módulos activos</span><strong>—</strong><small>Configuración pendiente</small></article>
    </div>
    <div class="aduana-role-section-title"><div><h4>Administración rápida</h4><p>Accesos a las principales áreas de configuración.</p></div></div>
    <div class="aduana-module-grid aduana-module-grid--admin">
        <article class="aduana-module-card"><div class="aduana-module-card__icon aduana-module-card__icon--navy">♙</div><span class="aduana-module-card__kicker">CUENTAS Y PERFILES</span><h4>Usuarios</h4><p>Alta, edición, inhabilitación y administración de roles.</p><button class="aduana-text-action" type="button" @click="tab = 'usuarios'">Ver sección <span>→</span></button></article>
        <article class="aduana-module-card"><div class="aduana-module-card__icon aduana-module-card__icon--teal">♧</div><span class="aduana-module-card__kicker">TRABAJO COLABORATIVO</span><h4>Equipos</h4><p>Organiza a los capturistas y administra sus integrantes.</p><button class="aduana-text-action" type="button" @click="tab = 'equipos'">Ver sección <span>→</span></button></article>
        <article class="aduana-module-card"><div class="aduana-module-card__icon aduana-module-card__icon--gold">▦</div><span class="aduana-module-card__kicker">CONTROL DE ACCESO</span><h4>Módulos</h4><p>Configura la disponibilidad de Pedimentos, COVE y DODA.</p><button class="aduana-text-action" type="button" @click="tab = 'modulos'">Ver sección <span>→</span></button></article>
    </div>
    <div class="aduana-notice"><span class="aduana-notice__icon">i</span><div><strong>Panel administrativo en preparación</strong><p>Los indicadores y controles se conectarán a la base de datos en la etapa de implementación funcional.</p></div></div>
</section>
