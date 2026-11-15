
@php
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
@endphp

<x-app-layout>
    <div class="aduana-dashboard" x-data="{ tab: 'inicio' }">

        <section class="aduana-welcome aduana-welcome--role">
            <div class="aduana-welcome__copy">
                <span class="aduana-eyebrow">
                    <span></span> Entorno academico
                </span>

                <h1>{{ $panel['nombre'] }}</h1>
                <p>{{ $panel['descripcion'] }}</p>

                <div class="aduana-welcome__meta">
                    <span class="aduana-role-chip">{{ ucfirst($rol) }}</span>
                    <span>Bienvenido, {{ $user->name }}</span>
                </div>
            </div>

            <!--- <div class="aduana-welcome__mark" aria-hidden="true">
                <img src="{{ asset('images/aduanasim-logo.png') }}" alt="">
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

                    @foreach ($panel['tabs'] as $item)
                        <button
                            type="button"
                            role="tab"
                            id="tab-{{ $item['id'] }}"
                            :aria-selected="(tab === '{{ $item['id'] }}').toString()"
                            aria-controls="panel-{{ $item['id'] }}"
                            @click="tab = '{{ $item['id'] }}'"
                            :class="tab === '{{ $item['id'] }}' ? 'is-active' : ''"
                        >
                            <span class="aduana-tab-icon" aria-hidden="true">
                                {{ $item['icon'] }}
                            </span>
                            <span>{{ $item['label'] }}</span>
                        </button>
                    @endforeach

                </nav>
            </div>

            <div class="aduana-panel">

                {{-- INICIO --}}
                <div
                    x-cloak
                    x-show="tab === 'inicio'"
                    x-transition.opacity
                    role="tabpanel"
                    id="panel-inicio"
                    aria-labelledby="tab-inicio"
                    tabindex="0"
                >
                    @include('dashboard.partials.roles.' . $rol . '.inicio')
                </div>

                {{-- ADMIN --}}
                @if ($rol === 'admin')

                    @foreach ([
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
                    ] as $key => $data)

                        <div
                            x-cloak
                            x-show="tab === '{{ $key }}'"
                            x-transition.opacity
                            role="tabpanel"
                            id="panel-{{ $key }}"
                            aria-labelledby="tab-{{ $key }}"
                            tabindex="0"
                        >
                            @include('dashboard.partials.estado-vacio', [
                                'titulo' => $data[0],
                                'descripcion' => $data[1],
                                'icono' => $data[2],
                                'mensaje' => 'Todavía no hay registros para mostrar.'
                            ])
                        </div>

                    @endforeach

                {{-- AGENTE --}}
                @elseif ($rol === 'agente')

                    @foreach ([
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
                    ] as $key => $data)

                        <div
                            x-cloak
                            x-show="tab === '{{ $key }}'"
                            x-transition.opacity
                            role="tabpanel"
                            id="panel-{{ $key }}"
                            aria-labelledby="tab-{{ $key }}"
                            tabindex="0"
                        >
                            @include('dashboard.partials.estado-vacio', [
                                'titulo' => $data[0],
                                'descripcion' => $data[1],
                                'icono' => $data[2],
                                'mensaje' => $data[3]
                            ])
                        </div>

                    @endforeach

                
{{-- CAPTURISTA --}}
@else

    @foreach ([
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
    ] as $key => $data)

        <div
            x-cloak
            x-show="tab === '{{ $key }}'"
            x-transition.opacity
            role="tabpanel"
            id="panel-{{ $key }}"
            aria-labelledby="tab-{{ $key }}"
            tabindex="0"
        >

            @if ($key === 'modulo-ia')

                @include('dashboard.partials.modulo-ia.index')

            @elseif (in_array($key, ['pedimentos', 'cove', 'doda'], true))

                @include('dashboard.partials.estado-vacio', [
                    'titulo' => $data[0],
                    'descripcion' => $data[1],
                    'icono' => $data[2],
                    'mensaje' => 'El formulario de captura estará disponible en la siguiente etapa de desarrollo.',
                    'accion' => 'Módulo en preparación'
                ])

            @else

                @include('dashboard.partials.estado-vacio', [
                    'titulo' => $data[0],
                    'descripcion' => $data[1],
                    'icono' => $data[2],
                    'mensaje' => 'Todavía no hay información para mostrar.'
                ])

            @endif

        </div>

    @endforeach

@endif


                {{-- PERFIL --}}
                <div
                    x-cloak
                    x-show="tab === 'perfil'"
                    x-transition.opacity
                    role="tabpanel"
                    id="panel-perfil"
                    aria-labelledby="tab-perfil"
                    tabindex="0"
                >
                    @include('profile.partials.show-information-from', [
                        'user' => $user
                    ])
                </div>

            </div>
        </section>

        <footer class="aduana-footer">
            <span>AduanaSim</span> · Simulador académico de despacho aduanero
            <span class="aduana-footer__note">Documento sin valor jurídico</span>
        </footer>

    </div>
</x-app-layout>
