
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
                    @include('dashboard.partials.roles.' . $rol . '.inicio', [
                        'registeredUserCount' => $registeredUserCount,
                        'stats' => $stats ?? null,
                    ])
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
                            @if ($key === 'usuarios')
                                @include('dashboard.partials.roles.admin.usuarios', [
                                    'titulo' => $data[0],
                                    'descripcion' => $data[1],
                                    'icono' => $data[2],
                                    'mensaje' => 'Todavía no hay registros para mostrar.'
                                ])
                            @else
                                @include('dashboard.partials.estado-vacio', [
                                    'titulo' => $data[0],
                                    'descripcion' => $data[1],
                                    'icono' => $data[2],
                                    'mensaje' => 'Todavía no hay registros para mostrar.'
                                ])
                            @endif
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

            @elseif ($key === 'pedimentos')
                <div class="aduana-module-view">
                    <div class="aduana-module-view__heading">
                        <div>
                            <span class="aduana-eyebrow aduana-eyebrow--muted">Módulo de pedimentos</span>
                            <h3>Pedimentos</h3>
                            <p>Elabora, consulta y administra ejercicios de pedimentos dentro del simulador.</p>
                        </div>
                    </div>
                    <div class="aduana-choice-grid">
                        <a href="{{ route('capturista.pedimentos.create') }}" class="aduana-choice-card" style="text-decoration:none;color:inherit">
                            <h4>Nuevo pedimento</h4>
                            <p>Captura cabecera, partidas y valores. Se guarda como borrador.</p>
                            <span class="aduana-status">Disponible</span>
                        </a>
                        <a href="{{ route('capturista.pedimentos.index') }}" class="aduana-choice-card" style="text-decoration:none;color:inherit">
                            <h4>Mis pedimentos</h4>
                            <p>Consulta el historial, edita borradores y envía a validación.</p>
                            <span class="aduana-status">Disponible</span>
                        </a>
                    </div>
                </div>

            @elseif ($key === 'cove')
                <div class="aduana-module-view">
                    <div class="aduana-module-view__heading">
                        <div>
                            <span class="aduana-eyebrow aduana-eyebrow--muted">COVE</span>
                            <h3>Comprobante de valor electrónico</h3>
                            <p>Captura emisores, facturas y mercancías; opcionalmente vincula un pedimento.</p>
                        </div>
                    </div>
                    <div class="aduana-choice-grid">
                        <a href="{{ route('capturista.coves.create') }}" class="aduana-choice-card" style="text-decoration:none;color:inherit">
                            <h4>Nuevo COVE</h4>
                            <p>Inicia la captura del comprobante de valor.</p>
                            <span class="aduana-status">Disponible</span>
                        </a>
                        <a href="{{ route('capturista.coves.index') }}" class="aduana-choice-card" style="text-decoration:none;color:inherit">
                            <h4>Mis COVE</h4>
                            <p>Lista, edita y envía a validación.</p>
                            <span class="aduana-status">Disponible</span>
                        </a>
                    </div>
                </div>

            @elseif ($key === 'doda')
                <div class="aduana-module-view">
                    <div class="aduana-module-view__heading">
                        <div>
                            <span class="aduana-eyebrow aduana-eyebrow--muted">DODA</span>
                            <h3>Documento de operación para despacho</h3>
                            <p>Asocia pedimentos y genera identificadores simulados (QR / barras).</p>
                        </div>
                    </div>
                    <div class="aduana-choice-grid">
                        <a href="{{ route('capturista.dodas.create') }}" class="aduana-choice-card" style="text-decoration:none;color:inherit">
                            <h4>Nuevo DODA</h4>
                            <p>Registra datos de despacho y pedimentos asociados.</p>
                            <span class="aduana-status">Disponible</span>
                        </a>
                        <a href="{{ route('capturista.dodas.index') }}" class="aduana-choice-card" style="text-decoration:none;color:inherit">
                            <h4>Mis DODA</h4>
                            <p>Consulta y gestiona tus documentos de despacho.</p>
                            <span class="aduana-status">Disponible</span>
                        </a>
                    </div>
                </div>

            @elseif ($key === 'historial')
                <div class="aduana-module-view">
                    <div class="aduana-module-view__heading">
                        <div>
                            <span class="aduana-eyebrow aduana-eyebrow--muted">Historial</span>
                            <h3>Mis documentos</h3>
                            <p>Vista unificada de pedimentos, COVE y DODA (propios o de tu equipo).</p>
                        </div>
                    </div>

                    @php $items = $historialItems ?? collect(); @endphp
                    @if ($items->isEmpty())
                        <div class="aduana-empty-state">
                            <div class="aduana-empty-state__icon">◷</div>
                            <strong>Sin documentos</strong>
                            <p>Cuando captures pedimentos, COVE o DODA aparecerán aquí.</p>
                        </div>
                    @else
                        <div class="aduana-table-wrap">
                            <table class="aduana-table">
                                <thead>
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Folio</th>
                                        <th>Detalle</th>
                                        <th>Estatus</th>
                                        <th>Actualizado</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $item)
                                        <tr>
                                            <td>{{ $item['tipo'] }}</td>
                                            <td><strong>{{ $item['folio'] }}</strong></td>
                                            <td>{{ $item['extra'] ?: '—' }}</td>
                                            <td>@include('capturista.partials.estatus-badge', ['estatus' => $item['estatus'], 'etiqueta' => $item['etiqueta']])</td>
                                            <td>{{ $item['fecha']?->format('d/m/Y H:i') }}</td>
                                            <td><a class="aduana-link" href="{{ $item['url'] }}">Abrir</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

            @elseif ($key === 'equipo')
                <div class="aduana-module-view">
                    <div class="aduana-module-view__heading">
                        <div>
                            <span class="aduana-eyebrow aduana-eyebrow--muted">Colaboración</span>
                            <h3>Mi equipo</h3>
                            <p>Integrantes y documentos compartidos con tu equipo de trabajo.</p>
                        </div>
                    </div>

                    @php
                        $listaEquipos = $equipos ?? collect();
                        $statsEq = $statsPorEquipo ?? [];
                    @endphp

                    @if ($listaEquipos->isEmpty())
                        <div class="aduana-empty-state">
                            <div class="aduana-empty-state__icon">♧</div>
                            <strong>Sin equipo asignado</strong>
                            <p>Un administrador o agente puede asignarte a un equipo de trabajo.</p>
                        </div>
                    @else
                        <div class="aduana-module-grid">
                            @foreach ($listaEquipos as $equipo)
                                <article class="aduana-module-card">
                                    <div class="aduana-module-card__icon aduana-module-card__icon--navy">♧</div>
                                    <span class="aduana-module-card__kicker">{{ $equipo->pivot->rol_en_equipo ?? 'miembro' }}</span>
                                    <h4>{{ $equipo->nombre }}</h4>
                                    <p>{{ $equipo->descripcion ?: 'Sin descripción' }}</p>
                                    <div class="aduana-stat-grid aduana-stat-grid--three mt-3">
                                        <div class="aduana-stat-card">
                                            <span class="aduana-stat-card__label">Pedimentos</span>
                                            <strong>{{ $statsEq[$equipo->id]['pedimentos'] ?? 0 }}</strong>
                                        </div>
                                        <div class="aduana-stat-card">
                                            <span class="aduana-stat-card__label">COVE</span>
                                            <strong>{{ $statsEq[$equipo->id]['coves'] ?? 0 }}</strong>
                                        </div>
                                        <div class="aduana-stat-card">
                                            <span class="aduana-stat-card__label">DODA</span>
                                            <strong>{{ $statsEq[$equipo->id]['dodas'] ?? 0 }}</strong>
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <strong class="text-sm">Integrantes</strong>
                                        <ul class="aduana-simple-list mt-2">
                                            @foreach ($equipo->users as $member)
                                                <li>
                                                    {{ $member->name }}
                                                    <small class="text-slate-500">· {{ $member->rol }} @if(!$member->activo) (suspendido) @endif</small>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @endif
                </div>

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
