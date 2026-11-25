<x-app-layout>
    <div class="aduana-dashboard">
        <section class="aduana-module-view">
            <div class="aduana-module-view__heading">
                <div>
                    <span class="aduana-eyebrow aduana-eyebrow--muted">Detalle de pedimento</span>
                    <h3>{{ $pedimento->folio }}</h3>
                    <p>
                        @include('capturista.partials.estatus-badge', ['estatus' => $pedimento->estatus, 'etiqueta' => $pedimento->etiquetaEstatus()])
                        · {{ ucfirst($pedimento->tipo) }} · {{ ucfirst($pedimento->tipo_operacion) }}
                    </p>
                </div>
                <div class="aduana-actions-row">

<!-- <a href="{{ route('capturista.historial.index') }}" class="aduana-btn aduana-btn--ghost">← Volver a Mis documentos</a> -->

<a href="{{ route('dashboard', ['tab' => 'pedimentos']) }}" class="aduana-btn aduana-btn--ghost inline-flex items-center"> ← Volver al panel </a>

                    <!-- <a href="{{ route('capturista.pedimentos.index') }}" class="aduana-btn aduana-btn--ghost">← Lista</a> -->


                    @if ($pedimento->puedeEditarse())
                        <a href="{{ route('capturista.pedimentos.edit', $pedimento) }}" class="aduana-btn">Editar</a>
                    @endif
                    @if ($pedimento->puedeVerPdf())
                        <a href="{{ route('capturista.pedimentos.pdf', [$pedimento, 'tradicional']) }}" target="_blank" class="aduana-btn">PDF tradicional</a>
                        <a href="{{ route('capturista.pedimentos.pdf', [$pedimento, 'simplificado']) }}" target="_blank" class="aduana-btn">PDF simplificado</a>
                    @endif
                    @if ($pedimento->puedeEnviarse())
                        <form method="POST" action="{{ route('capturista.pedimentos.enviar', $pedimento) }}" onsubmit="return confirm('¿Enviar a validación académica?')">
                            @csrf
                            <button type="submit" class="aduana-btn aduana-btn--primary">Enviar a validación</button>
                        </form>
                    @endif
                    @if ($pedimento->estatus === 'borrador')
                        <form method="POST" action="{{ route('capturista.pedimentos.destroy', $pedimento) }}" onsubmit="return confirm('¿Eliminar este borrador?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="aduana-btn aduana-btn--danger">Eliminar</button>
                        </form>
                    @endif
                </div>
            </div>

            @include('capturista.partials.flash')

            @if ($pedimento->observaciones_revision)
                <div class="aduana-alert aduana-alert--warn">
                    <strong>Observaciones de revisión:</strong>
                    <p>{{ $pedimento->observaciones_revision }}</p>
                </div>
            @endif

            <div class="aduana-detail-grid">
                <div><span class="label">Aduana / sección</span><strong>{{ $pedimento->aduana_clave ?: '—' }} / {{ $pedimento->seccion_aduanera ?: '—' }}</strong></div>
                <div><span class="label">Cve. pedimento / régimen</span><strong>{{ $pedimento->clave_pedimento ?: '—' }} / {{ $pedimento->regimen_clave ?: '—' }}</strong></div>
                <div><span class="label">Destino / tipo cambio</span><strong>{{ $pedimento->destino_clave ?: '—' }} / {{ $pedimento->tipo_cambio ?: '—' }}</strong></div>
                <div><span class="label">Peso bruto</span><strong>{{ $pedimento->peso_bruto ?: '—' }}</strong></div>
                <div><span class="label">RFC / nombre</span><strong>{{ $pedimento->rfc_operador ?: '—' }} · {{ $pedimento->nombre_operador ?: '—' }}</strong></div>
                <div><span class="label">CURP</span><strong>{{ $pedimento->curp_operador ?: '—' }}</strong></div>
                <div><span class="label">Domicilio</span><strong>{{ $pedimento->domicilio_operador ?: '—' }}</strong></div>
                <div><span class="label">Medio transporte</span><strong>{{ $pedimento->medio_transporte_clave ?: '—' }}</strong></div>
                <div><span class="label">Valores (USD / aduana / comercial)</span><strong>{{ number_format($pedimento->valor_dolares,2) }} / {{ number_format($pedimento->valor_aduana,2) }} / {{ number_format($pedimento->valor_comercial,2) }}</strong></div>
                <div><span class="label">Moneda / Incoterm</span><strong>{{ $pedimento->moneda_clave ?: '—' }} / {{ $pedimento->incoterm_clave ?: '—' }}</strong></div>
                <div><span class="label">Proveedor</span><strong>{{ $pedimento->proveedor_nombre ?: '—' }} ({{ $pedimento->proveedor_id_fiscal }})</strong></div>
                <div><span class="label">Agente</span><strong>{{ $pedimento->agente_nombre ?: '—' }} · Pat. {{ $pedimento->agente_patente ?: $pedimento->patente }}</strong></div>
                <div><span class="label">Capturista</span><strong>{{ $pedimento->user->name ?? '—' }}</strong></div>
            </div>

            @if ($pedimento->observaciones)
                <p class="mt-4 text-sm"><strong>Observaciones:</strong> {{ $pedimento->observaciones }}</p>
            @endif

            <div class="aduana-role-section-title mt-6">
                <div><h4>Partidas ({{ $pedimento->partidas->count() }})</h4></div>
            </div>
            <div class="aduana-table-wrap">
                <table class="aduana-table">
                    <thead>
                        <tr>
                            <th>#</th><th>Fracción</th><th>NICO</th><th>Descripción</th>
                            <th>Cant.</th><th>UMC</th><th>V. comercial</th><th>V. aduana</th><th>Origen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pedimento->partidas as $partida)
                            <tr>
                                <td>{{ $partida->secuencia }}</td>
                                <td>{{ $partida->fraccion }}</td>
                                <td>{{ $partida->nico }}</td>
                                <td>{{ $partida->descripcion }}</td>
                                <td>{{ $partida->cantidad }}</td>
                                <td>{{ $partida->umc ?: $partida->unidad }}</td>
                                <td>{{ number_format($partida->valor_comercial, 2) }}</td>
                                <td>{{ number_format($partida->valor_aduana, 2) }}</td>
                                <td>{{ $partida->pais_origen_clave }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="9" class="text-center text-slate-500">Sin partidas.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-app-layout>
