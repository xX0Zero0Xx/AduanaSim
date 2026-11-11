<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'AduanaSim')); ?> · Simulador de despacho aduanero</title>
    <link rel="preconnect" href="https://fonts.bunny.net"><link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="aduana-welcome-page">
    <header class="aduana-public-header">
        <a href="<?php echo e(route('home')); ?>" class="aduana-brand"><img src="<?php echo e(asset('images/aduanasim-logo.png')); ?>" alt="Logotipo AduanaSim" class="aduana-brand__logo"><span class="aduana-brand__copy"><strong class="aduana-brand__name">ADUANASIM</strong><small class="aduana-brand__tagline">Simulador de despacho aduanero</small></span></a>
        <nav class="aduana-public-nav">
            <?php if(auth()->guard()->check()): ?><a class="aduana-public-link" href="<?php echo e(route('dashboard')); ?>">Ir al panel</a><?php else: ?><a class="aduana-public-link" href="<?php echo e(route('login')); ?>">Iniciar sesión</a><?php endif; ?>
        </nav>
    </header>
    <main class="aduana-public-main">
        <section class="aduana-public-hero">
            <div class="aduana-public-hero__copy">
                <span class="aduana-eyebrow"><span></span> APRENDIZAJE · COMERCIO EXTERIOR Y ADUANAS</span>
                <h1>El despacho aduanero,<br><em>llevado a la práctica.</em></h1>
                <p>AduanaSim es un entorno de simulación académica para practicar la elaboración, organización y revisión de documentos relacionados con las operaciones aduaneras mexicanas.</p>
                <div class="aduana-public-actions">
                    <?php if(auth()->guard()->check()): ?><a href="<?php echo e(route('dashboard')); ?>" class="aduana-public-button">Acceder a mi espacio <span>→</span></a><?php else: ?><a href="<?php echo e(route('login')); ?>" class="aduana-public-button">Ingresar a AduanaSim <span>→</span></a><?php endif; ?>
                    <span class="aduana-public-note">Plataforma de uso académico</span>
                </div>
            </div>
            <div class="aduana-public-hero__art"><div class="aduana-public-orbit aduana-public-orbit--one"></div><div class="aduana-public-orbit aduana-public-orbit--two"></div><img src="<?php echo e(asset('images/aduanasim-logo.png')); ?>" alt="Escudo de AduanaSim"></div>
        </section>
        <section class="aduana-public-features">
            <article><span>01</span><div><h2>Documentación</h2><p>Práctica de pedimentos tradicionales y simplificados, COVE y DODA.</p></div></article>
            <article><span>02</span><div><h2>Colaboración</h2><p>Trabajo académico en equipos y seguimiento de documentos compartidos.</p></div></article>
            <article><span>03</span><div><h2>Validación</h2><p>Revisión de ejercicios con observaciones y retroalimentación.</p></div></article>
        </section>
        <div class="aduana-public-disclaimer"><strong>Entorno de simulación.</strong> Los documentos y códigos generados en AduanaSim son representaciones académicas sin valor jurídico y no sustituyen los trámites ni documentos oficiales.</div>
    </main>
    <footer class="aduana-public-footer"><span>ADUANASIM</span> · Simulador académico de despacho aduanero <span>© <?php echo e(date('Y')); ?></span></footer>
</body>
</html>
<?php /**PATH /home/lozada/Documentos/VS_Code/AduanaSim/resources/views/welcome.blade.php ENDPATH**/ ?>