<x-app-layout>
    <div class="aduana-dashboard">
        <section class="aduana-module-view">
            <div class="aduana-module-view__heading">
                <div>
                    <span class="aduana-eyebrow aduana-eyebrow--muted">Equipo</span>
                    <h3>{{ $equipo->nombre }}</h3>
                    <p>{{ $equipo->descripcion ?: 'Sin descripción' }} · {{ $equipo->activo ? 'Activo' : 'Inactivo' }}</p>
                </div>
                <a href="{{ route('agente.equipos.index') }}" class="aduana-btn aduana-btn--ghost">← Equipos</a>
            </div>

            @if (session('status'))
                <div class="aduana-alert aduana-alert--ok">{{ session('status') }}</div>
            @endif

            <div class="aduana-stat-grid aduana-stat-grid--three mb-4">
                <div class="aduana-stat-card"><span class="aduana-stat-card__label">Pedimentos</span><strong>{{ $stats['pedimentos'] }}</strong></div>
                <div class="aduana-stat-card"><span class="aduana-stat-card__label">COVE</span><strong>{{ $stats['coves'] }}</strong></div>
                <div class="aduana-stat-card"><span class="aduana-stat-card__label">DODA</span><strong>{{ $stats['dodas'] }}</strong></div>
            </div>

            <div class="aduana-module-card mb-6" style="max-width:560px">
                <h4>Datos del equipo</h4>
                <form method="POST" action="{{ route('agente.equipos.update', $equipo) }}" class="aduana-form-stack">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="aduana-label">Nombre</label>
                        <input type="text" name="nombre" class="aduana-input" required value="{{ old('nombre', $equipo->nombre) }}">
                    </div>
                    <div>
                        <label class="aduana-label">Descripción</label>
                        <input type="text" name="descripcion" class="aduana-input" value="{{ old('descripcion', $equipo->descripcion) }}">
                    </div>
                    <label class="inline-flex items-center gap-2 text-sm">
                        <input type="checkbox" name="activo" value="1" @checked(old('activo', $equipo->activo))>
                        Equipo activo
                    </label>
                    <button type="submit" class="aduana-btn aduana-btn--primary">Guardar cambios</button>
                </form>
            </div>

            <div class="aduana-module-card mb-6">
                <h4>Integrantes</h4>
                @if ($equipo->users->isEmpty())
                    <p class="text-sm text-slate-500">Aún no hay miembros en este equipo.</p>
                @else
                    <ul class="aduana-simple-list">
                        @foreach ($equipo->users as $member)
                            <li class="flex items-center justify-between gap-3">
                                <span>
                                    {{ $member->name }}
                                    <small class="text-slate-500">· {{ $member->email }} · {{ $member->pivot->rol_en_equipo }}</small>
                                </span>
                                <form method="POST" action="{{ route('agente.equipos.detach', [$equipo, $member]) }}" onsubmit="return confirm('¿Quitar a este miembro?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="aduana-link text-red-400">Quitar</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @endif

                <form method="POST" action="{{ route('agente.equipos.attach', $equipo) }}" class="aduana-filter-bar mt-4">
                    @csrf
                    <select name="user_id" class="aduana-input" required>
                        <option value="">Seleccionar capturista…</option>
                        @foreach ($capturistas as $c)
                            <option value="{{ $c->id }}" @selected(old('user_id')==$c->id)>{{ $c->name }} ({{ $c->email }})</option>
                        @endforeach
                    </select>
                    <select name="rol_en_equipo" class="aduana-input">
                        <option value="miembro">Miembro</option>
                        <option value="lider">Líder</option>
                    </select>
                    <button type="submit" class="aduana-btn aduana-btn--primary">Agregar</button>
                </form>
            </div>

            <form method="POST" action="{{ route('agente.equipos.destroy', $equipo) }}" onsubmit="return confirm('¿Eliminar este equipo de forma permanente?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="aduana-btn aduana-btn--danger">Eliminar equipo</button>
            </form>
        </section>
    </div>
</x-app-layout>
