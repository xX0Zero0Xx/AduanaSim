
<?php
    $rol = in_array($user->rol ?? null, ['admin', 'agente', 'capturista'], true)
        ? $user->rol
        : 'capturista';

    $configuracion = [
        'admin' => [
            'nombre' => 'Administración del sistema',
            'descripcion' => 'Control técnico de usuarios, permisos, catálogos y disponibilidad de los módulos.',
            'tabs' => [
                ['id' => 'inicio', 'label' => 'Resumen', 'icon' => '⌂'],
                ['id' => 'usuarios', 'label' => 'Usuarios', 'icon' => '♙'],
                ['id' => 'modulos', 'label' => 'Módulos', 'icon' => '▦'],
                ['id' => 'catalogos', 'label' => 'Catálogos', 'icon' => '▤'],
                ['id' => 'auditoria', 'label' => 'Actividad', 'icon' => '◷'],
                ['id' => 'perfil', 'label' => 'Mi perfil', 'icon' => '◎'],
            ],
        ],

        'agente' => [
            'nombre' => 'Centro de validación',
            'descripcion' => 'Revisa documentos, registra observaciones y administra los equipos de trabajo.',
            'tabs' => [
                ['id' => 'inicio', 'label' => 'Resumen', 'icon' => '⌂'],
                ['id' => 'pendientes', 'label' => 'Por revisar', 'icon' => '◷'],
                ['id' => 'validados', 'label' => 'Validados', 'icon' => '✓'],
                ['id' => 'devueltos', 'label' => 'No validados', 'icon' => '↶'],
                ['id' => 'historial', 'label' => 'Historial', 'icon' => '▤'],
                ['id' => 'equipos', 'label' => 'Equipos', 'icon' => '♧'],
                ['id' => 'perfil', 'label' => 'Mi perfil', 'icon' => '◎'],
            ],
        ],

        'capturista' => [
            'nombre' => 'Área de captura',
            'descripcion' => 'Elabora documentos aduaneros, trabaja con tu equipo y envía tus ejercicios a validación.',
            'tabs' => [
                ['id' => 'inicio', 'label' => 'Resumen', 'icon' => '⌂'],
                ['id' => 'pedimentos', 'label' => 'Pedimentos', 'icon' => '▤'],
                ['id' => 'cove', 'label' => 'COVE', 'icon' => '▧'],
                ['id' => 'doda', 'label' => 'DODA', 'icon' => '▦'],
                ['id' => 'modulo-ia', 'label' => 'Módulo IA', 'icon' => '✧'],
                ['id' => 'historial', 'label' => 'Mis documentos', 'icon' => '◷'],
                ['id' => 'equipo', 'label' => 'Mi equipo', 'icon' => '♧'],
                ['id' => 'perfil', 'label' => 'Mi perfil', 'icon' => '◎'],
            ],
        ],
    ];

    $panel = $configuracion[$rol];
?>

<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="aduana-dashboard" x-data="{ tab: 'inicio' }">

        <section class="aduana-welcome aduana-welcome--role">
            <div class="aduana-welcome__copy">
                <span class="aduana-eyebrow">
                    <span></span> Entorno academico
                </span>

                <h1><?php echo e($panel['nombre']); ?></h1>
                <p><?php echo e($panel['descripcion']); ?></p>

                <div class="aduana-welcome__meta">
                    <span class="aduana-role-chip"><?php echo e(ucfirst($rol)); ?></span>
                    <span>Bienvenido, <?php echo e($user->name); ?></span>
                </div>
            </div>

            <!--- <div class="aduana-welcome__mark" aria-hidden="true">
                <img src="<?php echo e(asset('images/aduanasim-logo.png')); ?>" alt="">
            </div> -->
        </section>

        <section class="aduana-workspace" aria-label="Espacio de trabajo">

            <div class="aduana-section-heading">
                <div>
                    <span class="aduana-eyebrow aduana-eyebrow--muted">
                        Panel de control
                    </span>
                    <h2>Espacio de trabajo</h2>
                </div>

                <span class="aduana-session-chip">
                    <span></span> Sesión activa
                </span>
            </div>

            <div class="aduana-tabs-wrap">
                <nav class="aduana-tabs" role="tablist" aria-label="Secciones de AduanaSim">

                    <?php $__currentLoopData = $panel['tabs']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button
                            type="button"
                            role="tab"
                            id="tab-<?php echo e($item['id']); ?>"
                            :aria-selected="(tab === '<?php echo e($item['id']); ?>').toString()"
                            aria-controls="panel-<?php echo e($item['id']); ?>"
                            @click="tab = '<?php echo e($item['id']); ?>'"
                            :class="tab === '<?php echo e($item['id']); ?>' ? 'is-active' : ''"
                        >
                            <span class="aduana-tab-icon" aria-hidden="true">
                                <?php echo e($item['icon']); ?>

                            </span>
                            <span><?php echo e($item['label']); ?></span>
                        </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </nav>
            </div>

            <div class="aduana-panel">

                
                <div
                    x-cloak
                    x-show="tab === 'inicio'"
                    x-transition.opacity
                    role="tabpanel"
                    id="panel-inicio"
                    aria-labelledby="tab-inicio"
                    tabindex="0"
                >
                    <?php echo $__env->make('dashboard.partials.roles.' . $rol . '.inicio', [
                        'registeredUserCount' => $registeredUserCount,
                    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>

                
                <?php if($rol === 'admin'): ?>

                    <?php $__currentLoopData = [
                        'usuarios' => [
                            'Usuarios',
                            'Administración de cuentas y perfiles de acceso.',
                            'users'
                        ],
                        'modulos' => [
                            'Disponibilidad de módulos',
                            'Controla el acceso de los capturistas a cada herramienta.',
                            'blocks'
                        ],
                        'catalogos' => [
                            'Catálogos aduaneros',
                            'Consulta los apéndices y catálogos que alimentan los formularios.',
                            'book-open'
                        ],
                        'auditoria' => [
                            'Actividad del sistema',
                            'Consulta las acciones relevantes realizadas dentro de AduanaSim.',
                            'history'
                        ],
                    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <div
                            x-cloak
                            x-show="tab === '<?php echo e($key); ?>'"
                            x-transition.opacity
                            role="tabpanel"
                            id="panel-<?php echo e($key); ?>"
                            aria-labelledby="tab-<?php echo e($key); ?>"
                            tabindex="0"
                        >
                            <?php if($key === 'usuarios'): ?>
                                <?php echo $__env->make('dashboard.partials.roles.admin.usuarios', [
                                    'titulo' => $data[0],
                                    'descripcion' => $data[1],
                                    'icono' => $data[2],
                                    'mensaje' => 'Todavía no hay registros para mostrar.'
                                ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            <?php else: ?>
                                <?php echo $__env->make('dashboard.partials.estado-vacio', [
                                    'titulo' => $data[0],
                                    'descripcion' => $data[1],
                                    'icono' => $data[2],
                                    'mensaje' => 'Todavía no hay registros para mostrar.'
                                ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            <?php endif; ?>
                        </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                
                <?php elseif($rol === 'agente'): ?>

                    <?php $__currentLoopData = [
                        'pendientes' => [
                            'Documentos por revisar',
                            'Documentos que los capturistas han enviado para validación.',
                            'clipboard-check',
                            'No hay documentos pendientes de revisión.'
                        ],
                        'validados' => [
                            'Documentos validados',
                            'Consulta los documentos que ya recibieron una validación académica.',
                            'badge-check',
                            'No hay documentos validados.'
                        ],
                        'devueltos' => [
                            'Documentos no validados',
                            'Documentos devueltos con observaciones para su corrección.',
                            'message-square-warning',
                            'No hay documentos devueltos.'
                        ],
                        'historial' => [
                            'Historial de revisiones',
                            'Consulta las revisiones realizadas y filtra por capturista o tipo de documento.',
                            'history',
                            'No hay revisiones registradas.'
                        ],
                        'equipos' => [
                            'Gestión de equipos',
                            'Crea equipos de trabajo, incorpora capturistas y organiza la colaboración entre grupos.',
                            'users-round',
                            'Todavía no hay equipos registrados. Puedes crear tu primer equipo.'
                        ],
                    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <div
                            x-cloak
                            x-show="tab === '<?php echo e($key); ?>'"
                            x-transition.opacity
                            role="tabpanel"
                            id="panel-<?php echo e($key); ?>"
                            aria-labelledby="tab-<?php echo e($key); ?>"
                            tabindex="0"
                        >
                            <?php echo $__env->make('dashboard.partials.estado-vacio', [
                                'titulo' => $data[0],
                                'descripcion' => $data[1],
                                'icono' => $data[2],
                                'mensaje' => $data[3]
                            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                

<?php else: ?>

    <?php $__currentLoopData = [
        'pedimentos' => [
            'Pedimentos',
            'Captura pedimentos tradicionales y simplificados para tus ejercicios.',
            'file-text'
        ],
        'cove' => [
            'Comprobante de Valor Electrónico (COVE)',
            'Prepara la información del comprobante de valor y relaciónala con un pedimento.',
            'receipt-text'
        ],
        'doda' => [
            'Documento de Operación para Despacho Aduanero (DODA)',
            'Prepara una representación académica de la información de despacho.',
            'qr-code'
        ],
        'modulo-ia' => [
            'Validación asistida por IA',
            'Analiza tus documentos, identifica inconsistencias y recibe sugerencias antes de enviarlos a revisión.',
            'sparkles'
        ],
        'historial' => [
            'Mis documentos',
            'Consulta tus documentos y los documentos compartidos por tus equipos.',
            'folder-clock'
        ],
        'equipo' => [
            'Mi equipo de trabajo',
            'Consulta los integrantes y documentos compartidos con tu equipo.',
            'users-round'
        ],
    ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <div
            x-cloak
            x-show="tab === '<?php echo e($key); ?>'"
            x-transition.opacity
            role="tabpanel"
            id="panel-<?php echo e($key); ?>"
            aria-labelledby="tab-<?php echo e($key); ?>"
            tabindex="0"
        >

            <?php if($key === 'modulo-ia'): ?>

                <?php echo $__env->make('dashboard.partials.modulo-ia.index', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <?php elseif(in_array($key, ['pedimentos', 'cove', 'doda'], true)): ?>

                <?php echo $__env->make('dashboard.partials.estado-vacio', [
                    'titulo' => $data[0],
                    'descripcion' => $data[1],
                    'icono' => $data[2],
                    'mensaje' => 'El formulario de captura estará disponible en la siguiente etapa de desarrollo.',
                    'accion' => 'Módulo en preparación'
                ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <?php else: ?>

                <?php echo $__env->make('dashboard.partials.estado-vacio', [
                    'titulo' => $data[0],
                    'descripcion' => $data[1],
                    'icono' => $data[2],
                    'mensaje' => 'Todavía no hay información para mostrar.'
                ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <?php endif; ?>

        </div>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php endif; ?>


                
                <div
                    x-cloak
                    x-show="tab === 'perfil'"
                    x-transition.opacity
                    role="tabpanel"
                    id="panel-perfil"
                    aria-labelledby="tab-perfil"
                    tabindex="0"
                >
                    <?php echo $__env->make('profile.partials.show-information-from', [
                        'user' => $user
                    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>

            </div>
        </section>

        <footer class="aduana-footer">
            <span>AduanaSim</span> · Simulador académico de despacho aduanero
            <span class="aduana-footer__note">Documento sin valor jurídico</span>
        </footer>

    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /home/lozada/Descargas/V3/AduanaSim/resources/views/dashboard.blade.php ENDPATH**/ ?>