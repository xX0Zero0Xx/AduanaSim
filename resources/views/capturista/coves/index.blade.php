<x-app-layout>
    <div class="aduana-dashboard">
        <section class="aduana-module-view">
            <div class="aduana-module-view__heading">
                <div>
                    <span class="aduana-eyebrow aduana-eyebrow--muted">COVE</span>
                    <h3>Comprobantes de valor electrónico</h3>
                    <p>Captura y consulta tus COVE académicos.</p>
                </div>
                <a href="{{ route('capturista.coves.create') }}" class="aduana-btn aduana-btn--primary">+ Nuevo COVE</a>
            </div>
            @include('capturista.partials.flash')
            <form method="GET" class="aduana-filter-bar">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Buscar folio o nombre…" class="aduana-input">
                <select name="estatus" class="aduana-input">
                    <option value="">Todos</option>
                    @foreach (['borrador','enviado','validado','devuelto'] as $e)
                        <option value="{{ $e }}" @selected(request('estatus')===$e)>{{ ucfirst($e) }}</option>
                    @endforeach
                </select>
                <button class="aduana-btn" type="submit">Filtrar</button>
                <a href="{{ route('dashboard') }}" class="aduana-btn aduana-btn--ghost">Panel</a>
            </form>
            @if ($coves->isEmpty())
                <div class="aduana-empty-state">
                    <div class="aduana-empty-state__icon">▧</div>
                    <strong>Sin COVE registrados</strong>
                    <p>Crea un comprobante de valor para practicar el flujo.</p>
                    <a href="{{ route('capturista.coves.create') }}" class="aduana-btn aduana-btn--primary mt-3">Crear COVE</a>
                </div>
            @else
                <div class="aduana-table-wrap">
                    <table class="aduana-table">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Emisor</th>
                                <th>Destinatario</th>
                                <th>Pedimento</th>
                                <th>Valor</th>
                                <th>Estatus</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coves as $c)
                                <tr>
                                    <td><a class="aduana-link" href="{{ route('capturista.coves.show', $c) }}">{{ $c->folio }}</a></td>
                                    <td>{{ $c->emisor_nombre ?: '—' }}</td>
                                    <td>{{ $c->destinatario_nombre ?: '—' }}</td>
                                    <td>{{ $c->pedimento->folio ?? '—' }}</td>
                                    <td>{{ number_format($c->valor_total, 2) }}</td>
                                    <td>@include('capturista.partials.estatus-badge', ['estatus'=>$c->estatus,'etiqueta'=>$c->etiquetaEstatus()])</td>
                                    <td class="aduana-table-actions">
                                        <a href="{{ route('capturista.coves.show', $c) }}">Ver</a>
                                        @if ($c->puedeEditarse())
                                            <a href="{{ route('capturista.coves.edit', $c) }}">Editar</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $coves->links() }}</div>
            @endif
        </section>
    </div>
</x-app-layout>
