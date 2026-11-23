<x-app-layout>
    <div class="aduana-dashboard">
        <section class="aduana-module-view">
            <div class="aduana-module-view__heading">
                <div>
                    <span class="aduana-eyebrow aduana-eyebrow--muted">Colaboración</span>
                    <h3>Gestión de equipos</h3>
                    <p>Crea equipos, asigna capturistas y organiza el trabajo académico.</p>
                </div>
                <a href="{{ route('dashboard', ['tab' => 'equipos']) }}" class="aduana-btn aduana-btn--ghost">← Panel</a>
            </div>

            @if (session('status'))
                <div class="aduana-alert aduana-alert--ok">{{ session('status') }}</div>
            @endif

            <div class="aduana-module-card mb-6" style="max-width:520px">
                <h4>Nuevo equipo</h4>
                <form method="POST" action="{{ route('agente.equipos.store') }}" class="aduana-form-stack">
                    @csrf
                    <div>
                        <label class="aduana-label">Nombre</label>
                        <input type="text" name="nombre" class="aduana-input" required value="{{ old('nombre') }}" placeholder="Ej. Grupo mañana A">
                    </div>
                    <div>
                        <label class="aduana-label">Descripción</label>
                        <input type="text" name="descripcion" class="aduana-input" value="{{ old('descripcion') }}" placeholder="Opcional">
                    </div>
                    <button type="submit" class="aduana-btn aduana-btn--primary">Crear equipo</button>
                </form>
            </div>

            @if ($equipos->isEmpty())
                <div class="aduana-empty-state">
                    <div class="aduana-empty-state__icon">♧</div>
                    <strong>Sin equipos</strong>
                    <p>Crea el primer equipo de trabajo para asignar capturistas.</p>
                </div>
            @else
                <div class="aduana-module-grid">
                    @foreach ($equipos as $equipo)
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
            @endif
        </section>
    </div>
</x-app-layout>
