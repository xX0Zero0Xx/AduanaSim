<section class="aduana-role-home">
    <?php
        $totalUsuarios = \App\Models\User::count();
        $totalAdmins = \App\Models\User::where('rol', 'admin')->where('activo', true)->count();
        $totalAgentes = \App\Models\User::where('rol', 'agente')->where('activo', true)->count();
        $totalCapturistas = \App\Models\User::where('rol', 'capturista')->where('activo', true)->count();
    ?>
    <div class="aduana-home__intro">
        <div><span class="aduana-eyebrow aduana-eyebrow--muted">VISTA GENERAL · ADMINISTRADOR</span><h3>Panel de administración</h3><p>Desde aquí podrás gestionar las cuentas, revisar la configuración y controlar los módulos disponibles para los capturistas.</p></div>
    </div>
    <div class="aduana-stat-grid">
        <article class="aduana-stat-card"><span class="aduana-stat-card__label">Usuarios registrados</span><strong><?php echo e($totalUsuarios); ?></strong><small>Total de cuentas</small></article>
        <article class="aduana-stat-card"><span class="aduana-stat-card__label">Admins activos</span><strong><?php echo e($totalAdmins); ?></strong><small>Administración técnica</small></article>
        <article class="aduana-stat-card"><span class="aduana-stat-card__label">Agentes activos</span><strong><?php echo e($totalAgentes); ?></strong><small>Validación documental</small></article>
        <article class="aduana-stat-card"><span class="aduana-stat-card__label">Capturistas activos</span><strong><?php echo e($totalCapturistas); ?></strong><small>Usuarios de captura</small></article>
    </div>
    <div class="aduana-role-section-title"><div><h4>Administración rápida</h4><p>Accesos a las principales áreas de configuración.</p></div></div>
    <div class="aduana-module-grid aduana-module-grid--admin">
        <article class="aduana-module-card"><div class="aduana-module-card__icon aduana-module-card__icon--navy">♙</div><span class="aduana-module-card__kicker">CUENTAS Y PERFILES</span><h4>Usuarios</h4><p>Alta, edición, inhabilitación y administración de roles.</p><button class="aduana-text-action" type="button" @click="tab = 'usuarios'">Ver sección <span>→</span></button></article>
        <article class="aduana-module-card"><div class="aduana-module-card__icon aduana-module-card__icon--teal">◷</div><span class="aduana-module-card__kicker">SEGUIMIENTO</span><h4>Actividad</h4><p>Consulta el registro de actividad y cambios del sistema.</p><button class="aduana-text-action" type="button" @click="tab = 'auditoria'">Ver sección <span>→</span></button></article>
        <article class="aduana-module-card"><div class="aduana-module-card__icon aduana-module-card__icon--gold">▦</div><span class="aduana-module-card__kicker">CONTROL DE ACCESO</span><h4>Módulos</h4><p>Configura la disponibilidad de Pedimentos, Cove y Doda.</p><button class="aduana-text-action" type="button" @click="tab = 'modulos'">Ver sección <span>→</span></button></article>
    </div>
    <div class="aduana-notice"><span class="aduana-notice__icon">i</span><div><strong>Panel administrativo en preparación</strong><p>Los indicadores y controles se conectarán a la base de datos en la etapa de implementación funcional.</p></div></div>
</section>
<?php /**PATH /home/lozada/Descargas/V3/AduanaSim/resources/views/dashboard/partials/roles/admin/inicio.blade.php ENDPATH**/ ?>