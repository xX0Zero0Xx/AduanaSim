<x-app-layout>
    <div class="aduana-dashboard">
        <section class="aduana-module-view">
            <div class="aduana-module-view__heading">
                <div>
                    <span class="aduana-eyebrow aduana-eyebrow--muted">Colaboración</span>
                    <h3>Mi equipo de trabajo</h3>
                    <p>Consulta los equipos a los que perteneces y sus integrantes.</p>
                </div>
                <a href="{{ route('dashboard') }}" class="aduana-btn aduana-btn--ghost">Panel</a>
            </div>

            @if ($equipos->isEmpty())
                <div class="aduana-empty-state">
                    <div class="aduana-empty-state__icon">♧</div>
                    <strong>No perteneces a ningún equipo</strong>
                    <p>Un administrador o agente puede asignarte a un equipo de trabajo.</p>
                </div>
            @else
                <div class="aduana-module-grid">
                    @foreach ($equipos as $equipo)
                        <article class="aduana-module-card">
                            <div class="aduana-module-card__icon aduana-module-card__icon--navy">♧</div>
                            <span class="aduana-module-card__kicker">{{ $equipo->pivot->rol_en_equipo ?? 'miembro' }}</span>
                            <h4>{{ $equipo->nombre }}</h4>
                            <p>{{ $equipo->descripcion ?: 'Sin descripción' }}</p>
                            <div class="aduana-stat-grid aduana-stat-grid--three mt-3">
                                <div class="aduana-stat-card">
                                    <span class="aduana-stat-card__label">Pedimentos</span>
                                    <strong>{{ $statsPorEquipo[$equipo->id]['pedimentos'] ?? 0 }}</strong>
                                </div>
                                <div class="aduana-stat-card">
                                    <span class="aduana-stat-card__label">COVE</span>
                                    <strong>{{ $statsPorEquipo[$equipo->id]['coves'] ?? 0 }}</strong>
                                </div>
                                <div class="aduana-stat-card">
                                    <span class="aduana-stat-card__label">DODA</span>
                                    <strong>{{ $statsPorEquipo[$equipo->id]['dodas'] ?? 0 }}</strong>
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
        </section>
    </div>
</x-app-layout>
