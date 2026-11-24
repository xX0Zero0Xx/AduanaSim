<x-app-layout>
    <div class="aduana-dashboard">
        <section class="aduana-module-view">
            <div class="aduana-module-view__heading">
                <div>
                    <span class="aduana-eyebrow aduana-eyebrow--muted">
                        Administrar equipo · {{ $equipo->activo ? 'Activo' : 'Inactivo' }}
                    </span>
                    <h3>{{ $equipo->nombre }}</h3>
                    <p>{{ $equipo->descripcion ?: 'Sin descripción asignada.' }}</p>
                </div>
                <a href="{{ route('dashboard', ['tab' => 'equipos']) }}" class="aduana-btn aduana-btn--ghost">
                    ← Volver a equipos
                </a>
            </div>

            @if (session('status'))
                <div class="aduana-alert aduana-alert--ok mb-4">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="aduana-alert aduana-alert--error mb-4">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Métricas rápidas del equipo por separado --}}
            <div class="aduana-stat-grid mb-6" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem;">
                <div class="aduana-stat-card">
                    <span class="aduana-stat-card__label">Integrantes</span>
                    <strong>{{ $equipo->users->count() }}</strong>
                </div>
                <div class="aduana-stat-card">
                    <span class="aduana-stat-card__label">Pedimentos realizados en conjunto</span>
                    <strong>{{ $stats['pedimentos'] ?? 0 }}</strong>
                </div>
                <div class="aduana-stat-card">
                    <span class="aduana-stat-card__label">COVEs realizados en conjunto</span>
                    <strong>{{ $stats['coves'] ?? 0 }}</strong>
                </div>
                <div class="aduana-stat-card">
                    <span class="aduana-stat-card__label">DODAs realizados en conjunto</span>
                    <strong>{{ $stats['dodas'] ?? 0 }}</strong>
                </div>
            </div>

            <div class="aduana-module-grid">
                {{-- Agregar integrante --}}
                <article class="aduana-module-card">
                    <span class="aduana-module-card__kicker">Incorporación</span>
                    <h4>Agregar integrante</h4>
                    <p>Selecciona un capturista activo para sumarlo a este equipo.</p>

                    @php
    $idsActuales = $equipo->users->pluck('id')->all();
    $disponibles = $capturistas->reject(fn ($c) => in_array($c->id, $idsActuales));

    $capturistasJson = $disponibles->map(fn ($c) => [
        'id' => $c->id,
        'name' => $c->name,
        'email' => $c->email,
        'departamento_id' => $c->departamento_id,
        'departamento' => $c->departamento?->clave ?? $c->departamento?->nombre ?? 'Sin departamento',
    ])->values();

    $oldUser = $disponibles->firstWhere('id', (int) old('user_id'));
    $oldDeptoId = old('departamento_id', $oldUser?->departamento_id ?? '');
@endphp

<article class="aduana-module-card"
    x-data="{
        deptoId: '{{ $oldDeptoId }}',
        selectedUserId: '{{ old('user_id', '') }}',
        capturistas: @js($capturistasJson),
        get filtrados() {
            if (!this.deptoId) return [];
            return this.capturistas.filter(c => String(c.departamento_id) === String(this.deptoId));
        },
        onDeptoChange() {
            if (!this.filtrados.some(c => String(c.id) === String(this.selectedUserId))) {
                this.selectedUserId = '';
            }
        }
    }">
    <span class="aduana-module-card__kicker">Incorporación</span>
    <h4>Agregar integrante</h4>
    <p>Primero selecciona un departamento y luego elige un capturista disponible.</p>

    @if ($disponibles->isEmpty())
        <div class="aduana-empty-state mt-4">
            <strong>Sin capturistas disponibles</strong>
            <p>Todos los capturistas activos ya pertenecen al equipo o no hay capturistas registrados.</p>
        </div>
    @else
        <form method="POST" action="{{ route('agente.equipos.attach', $equipo) }}" class="aduana-form-stack mt-4">
            @csrf

            <div>
                <label for="departamento_id" class="aduana-label">1. Departamento</label>
                <select id="departamento_id" name="departamento_id" class="aduana-input"
                    x-model="deptoId" @change="onDeptoChange()" required>
                    <option value="">— Selecciona un departamento —</option>
                    @foreach ($departamentos as $dep)
                        <option value="{{ $dep->id }}">
                            {{ $dep->clave ? "{$dep->clave} — {$dep->nombre}" : $dep->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="user_id" class="aduana-label">2. Capturista del departamento</label>
                <select id="user_id" name="user_id" class="aduana-input"
                    x-model="selectedUserId" :disabled="!deptoId" required>
                    <option value="" x-text="deptoId ? '— Selecciona un capturista —' : '— Primero elige un departamento —'"></option>
                    <template x-for="cap in filtrados" :key="cap.id">
                        <option :value="cap.id" x-text="`${cap.name} (${cap.email})`"></option>
                    </template>
                </select>
                <small class="text-slate-400" x-show="deptoId && filtrados.length === 0" x-cloak>
                    No hay capturistas disponibles en este departamento.
                </small>
            </div>

            <div>
                <label for="rol_en_equipo" class="aduana-label">Rol en el equipo</label>
                <select id="rol_en_equipo" name="rol_en_equipo" class="aduana-input">
                    <option value="miembro" @selected(old('rol_en_equipo', 'miembro') === 'miembro')>Miembro</option>
                    <option value="lider" @selected(old('rol_en_equipo') === 'lider')>Líder</option>
                </select>
            </div>

            <button type="submit" class="aduana-btn aduana-btn--primary" :disabled="!selectedUserId">
                + Agregar al equipo
            </button>
        </form>
    @endif
</article>

                {{-- Integrantes actuales y expulsión --}}
                <article class="aduana-module-card" style="grid-column: span 2;">
                    <span class="aduana-module-card__kicker">Plantilla actual</span>
                    <h4>Integrantes del equipo ({{ $equipo->users->count() }})</h4>
                    <p>Consulta quiénes forman parte del equipo o expulsa a un integrante cuando sea necesario.</p>

                    @if ($equipo->users->isEmpty())
                        <div class="aduana-empty-state mt-4">
                            <div class="aduana-empty-state__icon">∅</div>
                            <strong>Equipo sin integrantes</strong>
                            <p>Usa el formulario de la izquierda para agregar capturistas.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto mt-4">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b">
                                        <th class="py-2 px-3">Nombre</th>
                                        <th class="py-2 px-3">Correo</th>
                                        <th class="py-2 px-3">Rol en equipo</th>
                                        <th class="py-2 px-3 text-right">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($equipo->users as $miembro)
                                        @php
                                            $rolEquipo = $miembro->pivot->rol_en_equipo ?? 'miembro';
                                        @endphp
                                        <tr class="border-b">
                                            <td class="py-2.5 px-3 font-medium">{{ $miembro->name }}</td>
                                            <td class="py-2.5 px-3 text-sm">{{ $miembro->email }}</td>
                                            <td class="py-2.5 px-3">
                                                <span class="aduana-eyebrow aduana-eyebrow--muted">
                                                    {{ $rolEquipo === 'lider' ? 'Líder' : 'Miembro' }}
                                                </span>
                                            </td>
                                            <td class="py-2.5 px-3 text-right">
                                                <form method="POST"
                                                    action="{{ route('agente.equipos.detach', [$equipo, $miembro]) }}"
                                                    onsubmit="return confirm('¿Expulsar a {{ addslashes($miembro->name) }} del equipo «{{ addslashes($equipo->nombre) }}»?');"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="aduana-btn aduana-btn--ghost">
                                                        Expulsar
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </article>
            </div>

            {{-- Configuración del equipo y zona de peligro --}}
            <!-- <div class="aduana-module-grid mt-6">
                <article class="aduana-module-card">
                    <span class="aduana-module-card__kicker">Ajustes</span>
                    <h4>Editar datos del equipo</h4>
                    <form method="POST" action="{{ route('agente.equipos.update', $equipo) }}" class="aduana-form-stack mt-3">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="aduana-label">Nombre</label>
                            <input type="text" name="nombre" class="aduana-input" required
                                value="{{ old('nombre', $equipo->nombre) }}">
                        </div>

                        <div>
                            <label class="aduana-label">Descripción</label>
                            <input type="text" name="descripcion" class="aduana-input"
                                value="{{ old('descripcion', $equipo->descripcion) }}">
                        </div>

                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" name="activo" value="1" @checked(old('activo', $equipo->activo))>
                            <span>Equipo activo</span>
                        </label>

                        <button type="submit" class="aduana-btn aduana-btn--primary">Guardar cambios</button>
                    </form>
                </article> -->

                <article class="aduana-module-card">
                    <span class="aduana-module-card__kicker" style="color: #b91c1c;">Zona de peligro</span>
                    <h4>Eliminar equipo</h4>
                    <p>Se desvincularán todos los integrantes y se eliminará el registro del equipo.</p>

                    <form method="POST"
                        action="{{ route('agente.equipos.destroy', $equipo) }}"
                        onsubmit="return confirm('¿Seguro que deseas eliminar el equipo «{{ addslashes($equipo->nombre) }}»?');"
                        class="mt-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="aduana-btn"
                                style="background-color: #dc2626; color: #ffffff; border: 1px solid #b91c1c;">
                            Eliminar equipo
                        </button>
                    </form>
                </article>
            </div>
        </section>
    </div>
</x-app-layout>