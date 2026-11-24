<x-app-layout>
    <div class="aduana-dashboard">
        <section class="aduana-module-view">
            <div class="aduana-module-view__heading">
                <div>
                    <span class="aduana-eyebrow aduana-eyebrow--muted">Colaboración</span>
                    <h3>Equipos agrupados</h3>
                    <p>
                        Todos los equipos agrupados por departamento.
                        @if (!empty($departamento))
                            · Filtro: <strong>{{ $departamento->clave }}</strong>
                        @endif
                    </p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('agente.equipos.create') }}" class="aduana-btn aduana-btn--primary">+ Crear equipo</a>
                    <a href="{{ route('dashboard') }}" class="aduana-btn aduana-btn--ghost">← Volver al Panel</a>
                </div>
            </div>

            @if (session('status'))
                <div class="aduana-alert aduana-alert--ok mb-4">{{ session('status') }}</div>
            @endif

            @if ($gruposEquipos->isEmpty())
                <div class="aduana-empty-state">
                    <div class="aduana-empty-state__icon">♧</div>
                    <strong>Sin equipos</strong>
                    <p>Crea el primer equipo de trabajo para asignar capturistas.</p>
                </div>
            @else
                @foreach ($gruposEquipos as $nombreGrupo => $lista)
                    <div class="mb-8">
                        <div class="aduana-section-heading mb-3">
                            <h3>{{ $nombreGrupo }}</h3>
                            <span class="aduana-eyebrow aduana-eyebrow--muted">{{ $lista->count() }} {{ $lista->count() === 1 ? 'equipo' : 'equipos' }}</span>
                        </div>

                        <div class="aduana-module-grid">
                            @foreach ($lista as $equipo)
                                <article class="aduana-module-card">
                                    <div class="aduana-module-card__icon aduana-module-card__icon--navy">♧</div>
                                    <span class="aduana-module-card__kicker">{{ $equipo->activo ? 'Activo' : 'Inactivo' }}</span>
                                    <h4>{{ $equipo->nombre }}</h4>
                                    <p>{{ $equipo->descripcion ?: 'Sin descripción' }}</p>
                                    <div class="aduana-stat-grid aduana-stat-grid--three mt-3">
                                        <div class="aduana-stat-card"><span class="aduana-stat-card__label">Miembros</span><strong>{{ $stats[$equipo->id]['miembros'] ?? 0 }}</strong></div>
                                        <div class="aduana-stat-card"><span class="aduana-stat-card__label">Pedimentos</span><strong>{{ $stats[$equipo->id]['pedimentos'] ?? 0 }}</strong></div>
                                        <div class="aduana-stat-card"><span class="aduana-stat-card__label">COVE/DODA</span><strong>{{ ($stats[$equipo->id]['coves'] ?? 0) + ($stats[$equipo->id]['dodas'] ?? 0) }}</strong></div>
                                    </div>
                                    <a href="{{ route('agente.equipos.show', $equipo) }}" class="aduana-text-action mt-3">Administrar <span>→</span></a>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif
        </section>
    </div>
</x-app-layout>