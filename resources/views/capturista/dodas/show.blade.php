<x-app-layout>
    <div class="aduana-dashboard">
        <section class="aduana-module-view">
            <div class="aduana-module-view__heading">
                <div>
                    <span class="aduana-eyebrow aduana-eyebrow--muted">Detalle DODA</span>
                    <h3>{{ $doda->folio }}</h3>
                    <p>@include('capturista.partials.estatus-badge', ['estatus'=>$doda->estatus,'etiqueta'=>$doda->etiquetaEstatus()])</p>
                </div>
                <div class="aduana-actions-row">
                    <a href="{{ route('capturista.dodas.index') }}" class="aduana-btn aduana-btn--ghost">← Lista</a>
                    @if ($doda->puedeEditarse())
                        <a href="{{ route('capturista.dodas.edit', $doda) }}" class="aduana-btn">Editar</a>
                    @endif
                    @if ($doda->puedeEnviarse())
                        <form method="POST" action="{{ route('capturista.dodas.enviar', $doda) }}" onsubmit="return confirm('¿Enviar a validación?')">
                            @csrf
                            <button class="aduana-btn aduana-btn--primary">Enviar a validación</button>
                        </form>
                    @endif
                    @if ($doda->estatus === 'borrador')
                        <form method="POST" action="{{ route('capturista.dodas.destroy', $doda) }}" onsubmit="return confirm('¿Eliminar?')">
                            @csrf @method('DELETE')
                            <button class="aduana-btn aduana-btn--danger">Eliminar</button>
                        </form>
                    @endif
                </div>
            </div>
            @include('capturista.partials.flash')
            @if ($doda->observaciones_revision)
                <div class="aduana-alert aduana-alert--warn"><strong>Revisión:</strong> {{ $doda->observaciones_revision }}</div>
            @endif
            <div class="aduana-detail-grid">
                <div><span class="label">Aduana</span><strong>{{ $doda->aduana_clave ?: '—' }}</strong></div>
                <div><span class="label">Patente</span><strong>{{ $doda->patente ?: '—' }}</strong></div>
                <div><span class="label">Núm. operación</span><strong>{{ $doda->numero_operacion ?: '—' }}</strong></div>
                <div><span class="label">Fecha</span><strong>{{ optional($doda->fecha_operacion)->format('d/m/Y') ?: '—' }}</strong></div>
                <div><span class="label">Transporte</span><strong>{{ $doda->medio_transporte_clave ?: '—' }}</strong></div>
                <div><span class="label">Placa / ID</span><strong>{{ $doda->placa_o_identificacion ?: '—' }}</strong></div>
            </div>

            <div class="aduana-role-section-title mt-6"><div><h4>Pedimentos asociados</h4></div></div>
            <ul class="aduana-simple-list">
                @forelse ($doda->pedimentos as $p)
                    <li><a class="aduana-link" href="{{ route('capturista.pedimentos.show', $p) }}">{{ $p->folio }}</a> — {{ $p->nombre_operador ?: 'Sin operador' }}</li>
                @empty
                    <li class="text-slate-500">Ninguno</li>
                @endforelse
            </ul>

            <div class="aduana-role-section-title mt-6"><div><h4>Identificadores simulados</h4></div></div>
            <div class="aduana-info-strip">
                <strong>Cadena QR (académica)</strong>
                <span class="font-mono text-xs break-all">{{ $doda->cadena_qr ?: 'Se genera al guardar' }}</span>
            </div>
            <div class="aduana-info-strip aduana-info-strip--gold mt-2">
                <strong>Código de barras (simulado)</strong>
                <span class="font-mono">{{ $doda->codigo_barras ?: '—' }}</span>
            </div>
            <p class="text-xs text-slate-500 mt-2">Estos identificadores son solo para práctica académica y no tienen validez oficial ante el SAT.</p>
        </section>
    </div>
</x-app-layout>
