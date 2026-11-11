<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'AduanaSim')); ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Alex+Brush&display=swap" rel="stylesheet">

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    </head>


<!-- Botón flotante para cambiar el tema -->
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
</div>


    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <?php echo $__env->make('layouts.navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Page Heading -->
            <?php if(isset($header)): ?>
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <?php echo e($header); ?>

                    </div>
                </header>
            <?php endif; ?>

            <!-- Page Content -->
            <main>
                <?php echo e($slot); ?>

            </main>
        </div>
    </body>
</html>
<?php /**PATH /home/lozada/Documentos/VS_Code/AduanaSim/resources/views/layouts/app.blade.php ENDPATH**/ ?>