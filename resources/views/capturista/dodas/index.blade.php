<x-app-layout>
    <div class="aduana-dashboard">
        <section class="aduana-module-view">
            <div class="aduana-module-view__heading">
                <div>
                    <span class="aduana-eyebrow aduana-eyebrow--muted">DODA</span>
                    <h3>Documento de operación para despacho</h3>
                    <p>Asocia pedimentos y genera la representación académica del DODA.</p>
                </div>
                <a href="{{ route('capturista.dodas.create') }}" class="aduana-btn aduana-btn--primary">+ Nuevo DODA</a>
            </div>
            @include('capturista.partials.flash')
            <form method="GET" class="aduana-filter-bar">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Buscar folio…" class="aduana-input">
                <select name="estatus" class="aduana-input">
                    <option value="">Todos</option>
                    @foreach (['borrador','enviado','validado','devuelto'] as $e)
                        <option value="{{ $e }}" @selected(request('estatus')===$e)>{{ ucfirst($e) }}</option>
                    @endforeach
                </select>
                <button class="aduana-btn" type="submit">Filtrar</button>
                <a href="{{ route('dashboard') }}" class="aduana-btn aduana-btn--ghost">Panel</a>
            </form>
            @if ($dodas->isEmpty())
                <div class="aduana-empty-state">
                    <div class="aduana-empty-state__icon">▦</div>
                    <strong>Sin DODA</strong>
                    <p>Crea un DODA y asócialo a uno o más pedimentos.</p>
                    <a href="{{ route('capturista.dodas.create') }}" class="aduana-btn aduana-btn--primary mt-3">Crear DODA</a>
                </div>
            @else
                <div class="aduana-table-wrap">
                    <table class="aduana-table">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Aduana</th>
                                <th>Operación</th>
                                <th>Pedimentos</th>
                                <th>Estatus</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dodas as $d)
                                <tr>
                                    <td><a class="aduana-link" href="{{ route('capturista.dodas.show', $d) }}">{{ $d->folio }}</a></td>
                                    <td>{{ $d->aduana_clave ?: '—' }}</td>
                                    <td>{{ $d->numero_operacion ?: '—' }}</td>
                                    <td>{{ $d->pedimentos->pluck('folio')->join(', ') ?: '—' }}</td>
                                    <td>@include('capturista.partials.estatus-badge', ['estatus'=>$d->estatus,'etiqueta'=>$d->etiquetaEstatus()])</td>
                                    <td class="aduana-table-actions">
                                        <a href="{{ route('capturista.dodas.show', $d) }}">Ver</a>
                                        @if ($d->puedeEditarse())
                                            <a href="{{ route('capturista.dodas.edit', $d) }}">Editar</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $dodas->links() }}</div>
            @endif
        </section>
    </div>
</x-app-layout>
