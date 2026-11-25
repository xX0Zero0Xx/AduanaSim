<x-app-layout>

    {{-- Encabezado principal: títulos centrados, botón a la derecha --}}
<div
    class="aduana-module-view__heading pb-6 border-b border-slate-700/60"
    style="display: grid; grid-template-columns: 1fr auto 1fr; align-items: center; gap: 1rem;"
>
    {{-- Espaciador izquierdo para equilibrar el centrado --}}
    <div aria-hidden="true"></div>

    {{-- Títulos y descripción centrados --}}
    <div class="text-center space-y-1.5" style="text-align: center;">
        <span class="aduana-eyebrow aduana-eyebrow--muted inline-block" style="font-size: 0.85rem;">
            Administrar equipo · {{ $equipo->activo ? 'Activo' : 'Inactivo' }}
        </span>
        <h3 class="font-bold tracking-tight" style="font-size: 2rem; line-height: 1.2;">
            {{ $equipo->nombre }}
        </h3>
        <p class="text-slate-400 max-w-2xl mx-auto" style="font-size: 0.95rem;">
            {{ $equipo->descripcion ?: 'Sin descripción asignada.' }}
        </p>
    </div>

    {{-- Botón a la derecha --}}
    <div style="justify-self: end;">
        <a href="{{ route('dashboard', ['tab' => 'equipos']) }}" class="aduana-btn aduana-btn--ghost inline-flex items-center">
            ← Volver a equipos
        </a>
    </div>
</div>

            {{-- Alertas de estado o validación --}}
            @if (session('status'))
                <div class="aduana-alert aduana-alert--ok p-4 rounded-lg">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="aduana-alert aduana-alert--error p-4 rounded-lg space-y-1">
                    <p class="font-medium text-sm">Revisa los siguientes campos:</p>
                    <ul class="list-disc pl-5 text-sm space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Métricas rápidas del equipo --}}
            <div class="aduana-stat-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <div class="aduana-stat-card p-5 space-y-1.5">
                    <span class="aduana-stat-card__label block text-xs uppercase tracking-wider">Integrantes</span>
                    <strong class="text-2xl font-bold block">{{ $equipo->users->count() }}</strong>
                </div>
                <div class="aduana-stat-card p-5 space-y-1.5">
                    <span class="aduana-stat-card__label block text-xs uppercase tracking-wider">Pedimentos en conjunto</span>
                    <strong class="text-2xl font-bold block">{{ $stats['pedimentos'] ?? 0 }}</strong>
                </div>
                <div class="aduana-stat-card p-5 space-y-1.5">
                    <span class="aduana-stat-card__label block text-xs uppercase tracking-wider">COVEs en conjunto</span>
                    <strong class="text-2xl font-bold block">{{ $stats['coves'] ?? 0 }}</strong>
                </div>
                <div class="aduana-stat-card p-5 space-y-1.5">
                    <span class="aduana-stat-card__label block text-xs uppercase tracking-wider">DODAs en conjunto</span>
                    <strong class="text-2xl font-bold block">{{ $stats['dodas'] ?? 0 }}</strong>
                </div>
            </div>

            {{-- Preparación de datos para incorporación --}}
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

            {{-- Bloque principal: Formulario de alta (izquierda) + Plantilla actual (derecha) --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-7 items-start">

                {{-- Formulario para agregar integrante (bien espaciado) --}}
                <article
                    class="aduana-module-card lg:col-span-5 p-6 space-y-5"
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
                    }"
                >
                    <div class="space-y-1.5 pb-3 border-b border-slate-200/70">
                        <span class="aduana-module-card__kicker block">Incorporación</span>
                        <h4 class="text-lg font-semibold">Agregar integrante</h4>
                        <p class="text-sm text-slate-500">
                            Primero selecciona un departamento y luego elige un capturista disponible.
                        </p>
                    </div>

                    @if ($disponibles->isEmpty())
                        <div class="aduana-empty-state p-6 text-center space-y-2">
                            <strong class="block">Sin capturistas disponibles</strong>
                            <p class="text-sm text-slate-500">
                                Todos los capturistas activos ya pertenecen al equipo o no hay capturistas registrados.
                            </p>
                        </div>
                    @else
                        <form
                            method="POST"
                            action="{{ route('agente.equipos.attach', $equipo) }}"
                            class="space-y-6 pt-1"
                        >
                            @csrf

                            <div class="space-y-2">
                                <label for="departamento_id" class="aduana-label block font-medium">
                                    1. Departamento
                                </label>
                                <select
                                    id="departamento_id"
                                    name="departamento_id"
                                    class="aduana-input w-full py-2.5 px-3"
                                    x-model="deptoId"
                                    @change="onDeptoChange()"
                                    required
                                >
                                    <option value="">— Selecciona un departamento —</option>
                                    @foreach ($departamentos as $dep)
                                        <option value="{{ $dep->id }}">
                                            {{ $dep->clave ? "{$dep->clave} — {$dep->nombre}" : $dep->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label for="user_id" class="aduana-label block font-medium">
                                    2. Capturista del departamento
                                </label>
                                <select
                                    id="user_id"
                                    name="user_id"
                                    class="aduana-input w-full py-2.5 px-3"
                                    x-model="selectedUserId"
                                    :disabled="!deptoId"
                                    required
                                >
                                    <option
                                        value=""
                                        x-text="deptoId ? '— Selecciona un capturista —' : '— Primero elige un departamento —'"
                                    ></option>
                                    <template x-for="cap in filtrados" :key="cap.id">
                                        <option :value="cap.id" x-text="`${cap.name} (${cap.email})`"></option>
                                    </template>
                                </select>
                                <p
                                    class="text-xs text-slate-400 pt-1"
                                    x-show="deptoId && filtrados.length === 0"
                                    x-cloak
                                >
                                    No hay capturistas disponibles en este departamento.
                                </p>
                            </div>

                            <div class="space-y-2">
                                <label for="rol_en_equipo" class="aduana-label block font-medium">
                                    3. Rol en el equipo
                                </label>
                                <select
                                    id="rol_en_equipo"
                                    name="rol_en_equipo"
                                    class="aduana-input w-full py-2.5 px-3"
                                >
                                    <option value="miembro" @selected(old('rol_en_equipo', 'miembro') === 'miembro')>
                                        Miembro
                                    </option>
                                    <option value="lider" @selected(old('rol_en_equipo') === 'lider')>
                                        Líder
                                    </option>
                                </select>
                            </div>

                            <div class="pt-3 border-t border-slate-200/60">
                                <button
                                    type="submit"
                                    class="aduana-btn aduana-btn--primary w-full justify-center py-2.5 px-4"
                                    :disabled="!selectedUserId"
                                >
                                    + Agregar al equipo
                                </button>
                            </div>
                        </form>
                    @endif
                </article>

                {{-- Integrantes actuales y expulsión --}}
                <article class="aduana-module-card lg:col-span-7 p-6 space-y-5">
                    <div class="space-y-1.5 pb-3 border-b border-slate-200/70">
                        <span class="aduana-module-card__kicker block">Plantilla actual</span>
                        <h4 class="text-lg font-semibold">Integrantes del equipo ({{ $equipo->users->count() }})</h4>
                        <p class="text-sm text-slate-500">
                            Consulta quiénes forman parte del equipo o expulsa a un integrante cuando sea necesario.
                        </p>
                    </div>

                    @if ($equipo->users->isEmpty())
                        <div class="aduana-empty-state p-8 text-center space-y-2">
                            <div class="aduana-empty-state__icon text-xl">∅</div>
                            <strong class="block">Equipo sin integrantes</strong>
                            <p class="text-sm text-slate-500">
                                Usa el formulario de incorporación para agregar capturistas.
                            </p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-slate-200 text-xs uppercase tracking-wider text-slate-500">
                                        <th class="py-3 px-4">Nombre</th>
                                        <th class="py-3 px-4">Correo</th>
                                        <th class="py-3 px-4">Rol en equipo</th>
                                        <th class="py-3 px-4 text-right">Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200/70">
                                    @foreach ($equipo->users as $miembro)
                                        @php
                                            $rolEquipo = $miembro->pivot->rol_en_equipo ?? 'miembro';
                                        @endphp
                                        <tr class="hover:bg-slate-50/50 transition-colors">
                                            <td class="py-3.5 px-4 font-medium">{{ $miembro->name }}</td>
                                            <td class="py-3.5 px-4 text-sm text-slate-600">{{ $miembro->email }}</td>
                                            <td class="py-3.5 px-4">
                                                <span class="aduana-eyebrow aduana-eyebrow--muted inline-block">
                                                    {{ $rolEquipo === 'lider' ? 'Líder' : 'Miembro' }}
                                                </span>
                                            </td>
                                            <td class="py-3.5 px-4 text-right">
                                                <form
                                                    method="POST"
                                                    action="{{ route('agente.equipos.detach', [$equipo, $miembro]) }}"
                                                    onsubmit="return confirm('¿Expulsar a {{ addslashes($miembro->name) }} del equipo «{{ addslashes($equipo->nombre) }}»?');"
                                                    class="inline"
                                                >
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

            {{-- Zona de peligro separada del resto --}}
            <div class="pt-4 border-t border-slate-200/70">
                <article class="aduana-module-card p-6 max-w-2xl space-y-4 border border-red-200/80">
                    <div class="space-y-1">
                        <span class="aduana-module-card__kicker block" style="color: #b91c1c;">Zona de peligro</span>
                        <h4 class="text-lg font-semibold">Eliminar equipo</h4>
                        <p class="text-sm text-slate-500">
                            Se desvincularán todos los integrantes y se eliminará el registro del equipo.
                        </p>
                    </div>

                    <form
                        method="POST"
                        action="{{ route('agente.equipos.destroy', $equipo) }}"
                        onsubmit="return confirm('¿Seguro que deseas eliminar el equipo «{{ addslashes($equipo->nombre) }}»?');"
                        class="pt-2"
                    >
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            class="aduana-btn py-2.5 px-4"
                            style="background-color: #dc2626; color: #ffffff; border: 1px solid #b91c1c;"
                        >
                            Eliminar equipo
                        </button>
                    </form>
                </article>
            </div>

        </section>
    </div>
</x-app-layout>