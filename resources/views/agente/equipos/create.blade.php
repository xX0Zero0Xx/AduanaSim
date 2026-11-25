<x-app-layout>
    <div class="aduana-dashboard py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-8">
        <section class="aduana-module-view space-y-8">

            {{-- Encabezado principal: títulos centrados, botón a la derecha --}}
            <div
                class="aduana-module-view__heading pb-6 border-b border-slate-700/60"
                style="display: grid; grid-template-columns: 1fr auto 1fr; align-items: center; gap: 1rem;"
            >
                <div aria-hidden="true"></div>

                <div class="text-center space-y-1.5" style="text-align: center;">
                    <span class="aduana-eyebrow aduana-eyebrow--muted inline-block" style="font-size: 0.85rem;">
                        Colaboración
                    </span>
                    <h3 class="font-bold tracking-tight" style="font-size: 2rem; line-height: 1.2;">
                        Crear equipo
                    </h3>
                    <p class="text-slate-400 max-w-2xl mx-auto" style="font-size: 0.95rem;">
                        Registra un nuevo equipo y revisa el listado de los ya existentes.
                    </p>
                </div>

                <div style="justify-self: end;">
                    <a href="{{ route('dashboard', ['tab' => 'equipos']) }}" class="aduana-btn aduana-btn--ghost inline-flex items-center">
                        ← Volver al Panel
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

            {{-- Formulario a lo largo (en una sola fila horizontal) --}}
            <article class="aduana-module-card p-6 space-y-5">
                <div class="space-y-1 pb-3 border-b border-slate-700/60">
                    <span class="aduana-module-card__kicker block">Registro</span>
                    <h4 class="text-lg font-semibold">Nuevo equipo</h4>
                    <p class="text-sm text-slate-400">
                        Completa los datos básicos para crear el equipo.
                    </p>
                </div>

                <form
                    method="POST"
                    action="{{ route('agente.equipos.store') }}"
                    class="pt-1"
                    style="display: grid; grid-template-columns: minmax(220px, 2fr) minmax(220px, 2fr) auto; align-items: end; gap: 1.25rem;"
                >
                    @csrf

                    <div class="space-y-2" style="min-width: 0;">
                        <label for="nombre" class="aduana-label block font-medium">Nombre</label>
                        <input
                            id="nombre"
                            type="text"
                            name="nombre"
                            class="aduana-input w-full py-2.5 px-3"
                            style="width: 100%; max-width: 100%;"
                            required
                            value="{{ old('nombre') }}"
                            placeholder="Ej. Grupo mañana A"
                        >
                    </div>

                    <div class="space-y-2" style="min-width: 0;">
                        <label for="descripcion" class="aduana-label block font-medium">Descripción</label>
                        <input
                            id="descripcion"
                            type="text"
                            name="descripcion"
                            class="aduana-input w-full py-2.5 px-3"
                            style="width: 100%; max-width: 100%;"
                            value="{{ old('descripcion') }}"
                            placeholder="Opcional"
                        >
                    </div>

                    <div style="flex-shrink: 0;">
                        <button
                            type="submit"
                            class="aduana-btn aduana-btn--primary py-2.5 px-5 whitespace-nowrap"
                        >
                            Crear equipo
                        </button>
                    </div>
                </form>
            </article>

            {{-- Tabla central de equipos existentes --}}
            <div class="aduana-module-card p-6 space-y-5">
                <div class="flex items-center justify-between gap-4 pb-3 border-b border-slate-700/60">
                    <div>
                        <span class="aduana-module-card__kicker block">Directorio</span>
                        <h4 class="text-lg font-semibold">Equipos existentes</h4>
                    </div>
                    <span class="aduana-eyebrow aduana-eyebrow--muted shrink-0">
                        {{ $equiposExistentes->count() }} {{ $equiposExistentes->count() === 1 ? 'equipo' : 'equipos' }}
                    </span>
                </div>

                @if ($equiposExistentes->isEmpty())
                    <div class="aduana-empty-state p-8 text-center space-y-2">
                        <strong class="block">Sin equipos registrados</strong>
                        <p class="text-sm text-slate-400">No hay equipos registrados aún.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-700/70 text-xs uppercase tracking-wider text-slate-400">
                                    <th class="py-3.5 px-4">Equipo</th>
                                    <th class="py-3.5 px-4">Departamento / Clave</th>
                                    <th class="py-3.5 px-4">Descripción</th>
                                    <th class="py-3.5 px-4 text-center">Miembros</th>
                                    <th class="py-3.5 px-4 text-center">Pedimentos</th>
                                    <th class="py-3.5 px-4 text-center">COVEs</th>
                                    <th class="py-3.5 px-4 text-center">DODAs</th>
                                    <th class="py-3.5 px-4 text-right">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-700/50">
                                @foreach ($equiposExistentes as $item)
                                    @php
                                        $equipoObj = $item['equipo'] ?? null;
                                    @endphp
                                    <tr class="hover:bg-slate-800/40 transition-colors">
                                        <td class="py-4 px-4 font-semibold whitespace-nowrap">
                                            {{ $item['nombre'] }}
                                        </td>
                                        <td class="py-4 px-4 whitespace-nowrap">
                                            <span class="aduana-eyebrow aduana-eyebrow--muted inline-block">
                                                {{ $item['departamento'] }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-4 text-sm text-slate-400 max-w-xs">
                                            {{ $item['descripcion'] ?? 'Sin descripción' }}
                                        </td>
                                        <td class="py-4 px-4 text-center font-semibold tabular-nums">
                                            {{ $item['miembros'] ?? 0 }}
                                        </td>
                                        <td class="py-4 px-4 text-center font-semibold tabular-nums">
                                            {{ $item['pedimentos'] ?? 0 }}
                                        </td>
                                        <td class="py-4 px-4 text-center font-semibold tabular-nums">
                                            {{ $item['coves'] ?? 0 }}
                                        </td>
                                        <td class="py-4 px-4 text-center font-semibold tabular-nums">
                                            {{ $item['dodas'] ?? 0 }}
                                        </td>
                                        <td class="py-4 px-4 text-right whitespace-nowrap">
                                            @if ($equipoObj)
                                                <a
                                                    href="{{ route('agente.equipos.show', $equipoObj) }}"
                                                    class="aduana-text-action inline-flex items-center gap-1.5"
                                                >
                                                    <span>Administrar equipo</span>
                                                    <span aria-hidden="true">→</span>
                                                </a>
                                            @else
                                                <span class="text-xs text-slate-500">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </section>
    </div>
</x-app-layout>