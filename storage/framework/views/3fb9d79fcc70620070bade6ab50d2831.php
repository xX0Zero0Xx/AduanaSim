<nav class="aduana-topbar" x-data="{ open: false }">
    <div class="aduana-topbar__inner">
        <a href="<?php echo e(route('dashboard')); ?>" class="aduana-brand" aria-label="AduanaSim, ir al panel principal">
            <img src="<?php echo e(asset('images/aduanasim-logo.png')); ?>" alt="Logotipo de AduanaSim" class="aduana-brand__logo">
            <span class="aduana-brand__copy">
                <span class="aduana-brand__name">AduanaSim</span>
                <span class="aduana-brand__tagline">Simulador de despacho aduanero</span>
            </span>
        </a>

        <div class="aduana-topbar__right">
            <span class="aduana-environment"><span></span> Entorno académico</span>
            <div class="aduana-user" x-data="{ userMenu: false }">
                <button type="button" class="aduana-user__trigger" @click="userMenu = !userMenu" @click.outside="userMenu = false" :aria-expanded="userMenu.toString()">
                    <span class="aduana-user__avatar"><?php echo e(mb_strtoupper(mb_substr(Auth::user()->name, 0, 1))); ?></span>
                    <span class="aduana-user__details">
                        <strong><?php echo e(Auth::user()->name); ?></strong>
                        <small>Mi cuenta</small>
                    </span>
                    <svg class="aduana-chevron" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.22 7.47a.75.75 0 0 1 1.06 0L10 11.19l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 8.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
                </button>
                <div x-cloak x-show="userMenu" x-transition.origin.top.right class="aduana-user__menu">
                    <a href="<?php echo e(route('profile.edit')); ?>">Configuración de perfil</a>
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit">Cerrar sesión</button>
                    </form>
                </div>
            </div>
            <button class="aduana-mobile-toggle" type="button" @click="open = !open" :aria-expanded="open.toString()" aria-label="Abrir menú de usuario">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </div>
    <div x-cloak x-show="open" x-transition class="aduana-mobile-menu">
        <div class="aduana-mobile-menu__user"><?php echo e(Auth::user()->name); ?><small><?php echo e(Auth::user()->email); ?></small></div>
        <a href="<?php echo e(route('profile.edit')); ?>">Configuración de perfil</a>
        <form method="POST" action="<?php echo e(route('logout')); ?>"><?php echo csrf_field(); ?><button type="submit">Cerrar sesión</button></form>
    </div>
</nav>
<?php /**PATH /home/lozada/AduanaSim/resources/views/layouts/navigation.blade.php ENDPATH**/ ?>