<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'AduanaSim')); ?></title>
    <link rel="preconnect" href="https://fonts.bunny.net"><link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="aduana-welcome-page">
    <header class="aduana-public-header">
        <a href="<?php echo e(route('home')); ?>" class="aduana-brand"><img src="<?php echo e(asset('images/aduanasim-logo.png')); ?>" alt="Logotipo AduanaSim" class="aduana-brand__logo"><span class="aduana-brand__copy"><strong class="aduana-brand__name">AduanaSim</strong><small class="aduana-brand__tagline">Simulador de despacho aduanero</small></span></a>
        <nav class="aduana-public-nav">
            <?php if(auth()->guard()->check()): ?><a class="aduana-public-link" href="<?php echo e(route('dashboard')); ?>">Ir al panel</a><?php else: ?><a class="aduana-public-link" href="<?php echo e(route('login')); ?>">Iniciar sesión</a><?php endif; ?>
        </nav>
    </header>
    <main class="aduana-public-main">
        <section class="aduana-public-hero">
            <div class="aduana-public-hero__copy">
                <span class="aduana-eyebrow"><span></span> Comercio exterior y aduanas </span>
                <h1>Del papel a la práctica</h1>
                <p>AduanaSim es un entorno de simulación académica para practicar la elaboración, organización y revisión de documentos relacionados con las operaciones aduaneras mexicanas.</p>
                <div class="aduana-public-actions">
                    <?php if(auth()->guard()->check()): ?><a href="<?php echo e(route('dashboard')); ?>" class="aduana-public-button">Acceder a mi espacio <span>→</span></a><?php else: ?><a href="<?php echo e(route('login')); ?>" class="aduana-public-button">Ingresar a AduanaSim <span>→</span></a><?php endif; ?>
                    <span class="aduana-public-note">Plataforma de uso académico</span>
                </div>
            </div>
            <!--<div class="aduana-public-hero__art"><div class="aduana-public-orbit aduana-public-orbit--one"></div><div class="aduana-public-orbit aduana-public-orbit--two"></div><img src="<?php echo e(asset('images/aduanasim-logo.png')); ?>" alt="AduanaSim logo in a circular academic emblem with a shield, geometric lines, and a clean white and blue interface. The emblem is centered and includes the words AduanaSim and Simulador de despacho aduanero. The surrounding environment is a modern digital platform for learning customs procedures. The overall mood is professional, modern, and trustworthy."></div> Logo al, inicio-->
        </section>
        <section class="aduana-public-features">
            <article><div><h2>Documentación</h2><p>Práctica de pedimentos tradicionales y simplificados, Cove y Doda.</p></div></article>
            <article><div><h2>Colaboración</h2><p>Trabajo académico en equipos y seguimiento de documentos compartidos.</p></div></article>
            <article><div><h2>Validación</h2><p>Revisión de ejercicios con observaciones y retroalimentación.</p></div></article>
        </section>
        <div class="aduana-public-disclaimer"><strong>Entorno de simulación.</strong> Los documentos y códigos generados en AduanaSim son representaciones académicas sin valor jurídico y no sustituyen los trámites ni documentos oficiales.</div>
    </main>

<!-- Botón flotante para cambiar el tema
<div
    x-data="{
        darkMode: localStorage.getItem('aduanasim-theme') === 'dark',

        init() {
            document.documentElement.classList.toggle('dark', this.darkMode);
        },

        toggleTheme() {
            this.darkMode = !this.darkMode;

            document.documentElement.classList.toggle(
                'dark',
                this.darkMode
            );

            localStorage.setItem(
                'aduanasim-theme',
                this.darkMode ? 'dark' : 'light'
            );
        }
    }"
    class="fixed bottom-6 right-6 z-50"
>
    <button
        type="button"
        @click="toggleTheme()"
        class="flex h-12 w-12 items-center justify-center
            rounded-full shadow-lg transition-all duration-300
            bg-[#233147] text-white
            hover:bg-[#315A70] hover:scale-110
            dark:bg-[#C3A96D] dark:text-[#233147]
            dark:hover:bg-[#d4bd83]"
        :title="darkMode ? 'Cambiar a modo claro' : 'Cambiar a modo oscuro'"
        aria-label="Alternar modo claro y oscuro"
    >
        <svg
            x-show="!darkMode"
            xmlns="http://www.w3.org/2000/svg"
            width="22"
            height="22"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <circle cx="12" cy="12" r="4"/>
            <path d="M12 2v2"/>
            <path d="M12 20v2"/>
            <path d="m4.93 4.93 1.42 1.42"/>
            <path d="m17.65 17.65 1.42 1.42"/>
            <path d="M2 12h2"/>
            <path d="M20 12h2"/>
            <path d="m6.35 17.65-1.42 1.42"/>
            <path d="m19.07 4.93-1.42 1.42"/>
        </svg>

        <svg
            x-show="darkMode"
            x-cloak
            xmlns="http://www.w3.org/2000/svg"
            width="22"
            height="22"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <path d="M20.985 12.486a9 9 0 1 1-9.473-9.472c.405-.022.617.463.402.807a6.5 6.5 0 0 0 8.268 8.268c.344-.215.829-.003.803.397"/>
        </svg>
    </button>
</div> -->

    <footer class="aduana-public-footer"><span>ADUANASIM</span> · Simulador académico de despacho aduanero <span>© <?php echo e(date('Y')); ?></span></footer>
</body>
</html>
<?php /**PATH /home/lozada/Documentos/VS_Code/AduanaSim/resources/views/welcome.blade.php ENDPATH**/ ?>