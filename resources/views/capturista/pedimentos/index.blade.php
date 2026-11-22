<x-app-layout>
    <div class="aduana-dashboard">
        <section class="aduana-module-view">
            <div class="aduana-module-view__heading">
                <div>
                    <span class="aduana-eyebrow aduana-eyebrow--muted">Módulo de pedimentos</span>
                    <h3>Mis pedimentos</h3>
                    <p>Elabora, consulta y envía a validación tus ejercicios de pedimento.</p>
                </div>

<a href="{{ route('dashboard') }}" class="aduana-btn aduana-btn--ghost">Volver al panel</a>
            </div>

            @include('capturista.partials.flash')

            <form method="GET" class="aduana-filter-bar">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Buscar folio, RFC o nombre…" class="aduana-input">
                <select name="estatus" class="aduana-input">
                    <option value="">Todos los estatus</option>
                    @foreach (['borrador' => 'Borrador', 'enviado' => 'En validación', 'validado' => 'Validado', 'devuelto' => 'Devuelto'] as $k => $v)
                        <option value="{{ $k }}" @selected(request('estatus') === $k)>{{ $v }}</option>
                    @endforeach
                </select>
                <!-- <button type="submit" class="aduana-btn">Filtrar</button> -->
                
<a href="{{ route('capturista.pedimentos.create') }}" class="aduana-btn aduana-btn--primary">+ Nuevo pedimento</a>

            </form>

            @if ($pedimentos->isEmpty())
                <div class="aduana-empty-state">
                    <div class="aduana-empty-state__icon">▤</div>
                    <strong>Aún no tienes pedimentos</strong>
                    <p>Crea tu primer ejercicio de captura para comenzar la práctica.</p>
                    <a href="{{ route('capturista.pedimentos.create') }}" class="aduana-btn aduana-btn--primary mt-3">Crear pedimento</a>
                </div>
            @else
                <div class="aduana-table-wrap">
                    <table class="aduana-table">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Tipo</th>
                                <th>Operación</th>
                                <th>Operador</th>
                                <th>Valor aduana</th>
                                <th>Estatus</th>
                                <th>Actualizado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pedimentos as $p)
                                <tr>
                                    <td><a href="{{ route('capturista.pedimentos.show', $p) }}" class="aduana-link">{{ $p->folio }}</a></td>
                                    <td>{{ ucfirst($p->tipo) }}</td>
                                    <td>{{ ucfirst($p->tipo_operacion) }}</td>
                                    <td>{{ $p->nombre_operador ?: '—' }}</td>
                                    <td>{{ number_format($p->valor_aduana, 2) }}</td>
                                    <td>@include('capturista.partials.estatus-badge', ['estatus' => $p->estatus, 'etiqueta' => $p->etiquetaEstatus()])</td>
                                    <td>{{ $p->updated_at->format('d/m/Y H:i') }}</td>
                                    <td class="aduana-table-actions">
                                        <a href="{{ route('capturista.pedimentos.show', $p) }}">Ver</a>
                                        @if ($p->puedeEditarse())
                                            <!-- <a href="{{ route('capturista.pedimentos.edit', $p) }}">Editar</a> -->
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $pedimentos->links() }}</div>
            @endif
        </section>
    </div>
</x-app-layout>
