<x-app-layout>
    <div class="aduana-dashboard">
        <section class="aduana-module-view">
            <div class="aduana-module-view__heading">
                <div>
                    <span class="aduana-eyebrow aduana-eyebrow--muted">Detalle COVE</span>
                    <h3>{{ $cove->folio }}</h3>
                    <p>@include('capturista.partials.estatus-badge', ['estatus'=>$cove->estatus,'etiqueta'=>$cove->etiquetaEstatus()])</p>
                </div>
                <div class="aduana-actions-row">
                    <a href="{{ route('dashboard') }}" class="aduana-btn aduana-btn--ghost">← Volver al Panel</a>
                    <a href="{{ route('capturista.coves.pdf', $cove) }}" class="aduana-btn" target="_blank">PDF Cove</a>
                    @if ($cove->puedeEditarse())
                        <a href="{{ route('capturista.coves.edit', $cove) }}" class="aduana-btn">Editar</a>
                    @endif
                    @if ($cove->puedeEnviarse())
                        <form method="POST" action="{{ route('capturista.coves.enviar', $cove) }}" onsubmit="return confirm('¿Enviar a validación?')">
                            @csrf
                            <button class="aduana-btn aduana-btn--primary">Enviar a validación</button>
                        </form>
                    @endif
                    @if ($cove->estatus === 'borrador')
                        <form method="POST" action="{{ route('capturista.coves.destroy', $cove) }}" onsubmit="return confirm('¿Eliminar?')">
                            @csrf @method('DELETE')
                            <button class="aduana-btn aduana-btn--danger">Eliminar</button>
                        </form>
                    @endif
                </div>
            </div>
            @include('capturista.partials.flash')
            @if ($cove->observaciones_revision)
                <div class="aduana-alert aduana-alert--warn"><strong>Revisión:</strong> {{ $cove->observaciones_revision }}</div>
            @endif
            <div class="aduana-detail-grid">
                <div><span class="label">Pedimento</span><strong>{{ $cove->pedimento->folio ?? '—' }}</strong></div>
                <div><span class="label">Emisor</span><strong>{{ $cove->emisor_nombre ?: '—' }} ({{ $cove->emisor_rfc }})</strong></div>
                <div><span class="label">Destinatario</span><strong>{{ $cove->destinatario_nombre ?: '—' }} ({{ $cove->destinatario_rfc }})</strong></div>
                <div><span class="label">Moneda / Valor</span><strong>{{ $cove->moneda_clave ?: '—' }} · {{ number_format($cove->valor_total, 2) }}</strong></div>
            </div>
            <div class="aduana-role-section-title mt-6"><div><h4>Facturas</h4></div></div>
            <div class="aduana-table-wrap">
                <table class="aduana-table">
                    <thead><tr><th>Número</th><th>Fecha</th><th>Valor</th><th>Moneda</th></tr></thead>
                    <tbody>
                        @forelse ($cove->facturas as $f)
                            <tr>
                                <td>{{ $f->numero_factura }}</td>
                                <td>{{ optional($f->fecha_factura)->format('d/m/Y') }}</td>
                                <td>{{ number_format($f->valor, 2) }}</td>
                                <td>{{ $f->moneda_clave }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-slate-500">Sin facturas</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="aduana-role-section-title mt-6"><div><h4>Mercancías</h4></div></div>
            <div class="aduana-table-wrap">
                <table class="aduana-table">
                    <thead><tr><th>#</th><th>Descripción</th><th>Cant.</th><th>Unidad</th><th>Valor</th><th>Fracción</th></tr></thead>
                    <tbody>
                        @forelse ($cove->mercancias as $m)
                            <tr>
                                <td>{{ $m->secuencia }}</td>
                                <td>{{ $m->descripcion }}</td>
                                <td>{{ $m->cantidad }}</td>
                                <td>{{ $m->unidad }}</td>
                                <td>{{ number_format($m->valor, 2) }}</td>
                                <td>{{ $m->fraccion }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center text-slate-500">Sin mercancías</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-app-layout>
