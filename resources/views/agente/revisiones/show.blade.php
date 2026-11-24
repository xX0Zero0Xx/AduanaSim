<x-app-layout>
    @php
        $etiquetaEstatus = method_exists($doc, 'etiquetaEstatus')
            ? $doc->etiquetaEstatus()
            : ucfirst((string) $doc->estatus);

        $deptoId = $doc->user?->departamento_id;
    @endphp

    <div class="aduana-dashboard">
        <section class="aduana-module-view">
            <div class="aduana-module-view__heading">
                <div>
                    <span class="aduana-eyebrow aduana-eyebrow--muted">Revisión de {{ strtoupper($tipo) }}</span>
                    <h3>{{ $doc->folio ?? ('#' . $doc->id) }}</h3>
                    <p>
                        @include('agente.partials.estatus-badge', ['estatus' => $doc->estatus, 'etiqueta' => $etiquetaEstatus])
                        @if (!empty($doc->tipo))
                            · {{ ucfirst((string) $doc->tipo) }}
                        @endif
                        @if (!empty($doc->tipo_operacion))
                            · {{ ucfirst((string) $doc->tipo_operacion) }}
                        @endif
                    </p>
                </div>

                <div class="aduana-actions-row">
                    <a
                        href="{{ route('agente.revisiones.index', array_filter(['bandeja' => $doc->estatus === 'enviado' ? 'pendientes' : 'historial', 'departamento_id' => $deptoId])) }}"
                        class="aduana-btn aduana-btn--ghost"
                    >
                        ← Volver a revisiones
                    </a>
                    <a href="{{ route('dashboard') }}" class="aduana-btn aduana-btn--ghost">
                        ← Volver al panel
                    </a>
                </div>
            </div>

            @if (session('status'))
                <div class="aduana-alert aduana-alert--success">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="aduana-alert aduana-alert--warn">
                    <strong>Revisa los datos del formulario:</strong>
                    <ul class="mt-1 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (!empty($doc->observaciones_revision))
                <div class="aduana-alert aduana-alert--warn">
                    <strong>Observaciones de revisión:</strong>
                    <p>{{ $doc->observaciones_revision }}</p>
                </div>
            @endif

            {{-- DETALLE POR TIPO DE DOCUMENTO --}}
            @if ($tipo === 'pedimento')
                <div class="aduana-detail-grid">
                    <div><span class="label">Aduana / sección</span><strong>{{ $doc->aduana_clave ?: '—' }} / {{ $doc->seccion_aduanera ?: '—' }}</strong></div>
                    <div><span class="label">Cve. pedimento / régimen</span><strong>{{ $doc->clave_pedimento ?: '—' }} / {{ $doc->regimen_clave ?: '—' }}</strong></div>
                    <div><span class="label">Destino / tipo cambio</span><strong>{{ $doc->destino_clave ?: '—' }} / {{ $doc->tipo_cambio ?: '—' }}</strong></div>
                    <div><span class="label">Peso bruto</span><strong>{{ $doc->peso_bruto ?: '—' }}</strong></div>
                    <div><span class="label">RFC / nombre</span><strong>{{ $doc->rfc_operador ?: '—' }} · {{ $doc->nombre_operador ?: '—' }}</strong></div>
                    <div><span class="label">CURP</span><strong>{{ $doc->curp_operador ?: '—' }}</strong></div>
                    <div><span class="label">Domicilio</span><strong>{{ $doc->domicilio_operador ?: '—' }}</strong></div>
                    <div><span class="label">Medio transporte</span><strong>{{ $doc->medio_transporte_clave ?: '—' }}</strong></div>
                    <div>
                        <span class="label">Valores (USD / aduana / comercial)</span>
                        <strong>
                            {{ number_format((float) ($doc->valor_dolares ?? 0), 2) }} /
                            {{ number_format((float) ($doc->valor_aduana ?? 0), 2) }} /
                            {{ number_format((float) ($doc->valor_comercial ?? 0), 2) }}
                        </strong>
                    </div>
                    <div><span class="label">Moneda / Incoterm</span><strong>{{ $doc->moneda_clave ?: '—' }} / {{ $doc->incoterm_clave ?: '—' }}</strong></div>
                    <div><span class="label">Proveedor</span><strong>{{ $doc->proveedor_nombre ?: '—' }} ({{ $doc->proveedor_id_fiscal ?: '—' }})</strong></div>
                    <div><span class="label">Agente</span><strong>{{ $doc->agente_nombre ?: '—' }} · Pat. {{ $doc->agente_patente ?: ($doc->patente ?: '—') }}</strong></div>
                    <div><span class="label">Capturista / depto</span><strong>{{ $doc->user?->name ?? '—' }} ({{ $doc->user?->departamento?->clave ?? 'Sin depto' }})</strong></div>
                </div>

                @if (!empty($doc->observaciones))
                    <p class="mt-4 text-sm"><strong>Observaciones del capturista:</strong> {{ $doc->observaciones }}</p>
                @endif

                <div class="aduana-role-section-title mt-6">
                    <div><h4>Partidas ({{ $doc->partidas?->count() ?? 0 }})</h4></div>
                </div>
                <div class="aduana-table-wrap">
                    <table class="aduana-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Fracción</th>
                                <th>NICO</th>
                                <th>Descripción</th>
                                <th>Cant.</th>
                                <th>UMC</th>
                                <th>V. comercial</th>
                                <th>V. aduana</th>
                                <th>Origen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($doc->partidas ?? [] as $partida)
                                <tr>
                                    <td>{{ $partida->secuencia }}</td>
                                    <td>{{ $partida->fraccion }}</td>
                                    <td>{{ $partida->nico }}</td>
                                    <td>{{ $partida->descripcion }}</td>
                                    <td>{{ $partida->cantidad }}</td>
                                    <td>{{ $partida->umc ?: $partida->unidad }}</td>
                                    <td>{{ number_format((float) ($partida->valor_comercial ?? 0), 2) }}</td>
                                    <td>{{ number_format((float) ($partida->valor_aduana ?? 0), 2) }}</td>
                                    <td>{{ $partida->pais_origen_clave }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="9" class="text-center text-slate-500">Sin partidas.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            @elseif ($tipo === 'cove')
                <div class="aduana-detail-grid">
                    <div><span class="label">Emisor</span><strong>{{ $doc->emisor_nombre ?? '—' }}</strong></div>
                    <div><span class="label">Identificador / RFC</span><strong>{{ data_get($doc, 'emisor_rfc') ?? data_get($doc, 'emisor_identificacion') ?? '—' }}</strong></div>
                    <div><span class="label">Destinatario / receptor</span><strong>{{ data_get($doc, 'destinatario_nombre') ?? data_get($doc, 'receptor_nombre') ?? '—' }}</strong></div>
                    <div><span class="label">Pedimento vinculado</span><strong>{{ $doc->pedimento?->folio ?? 'No vinculado' }}</strong></div>
                    <div><span class="label">Moneda / valor total</span><strong>{{ data_get($doc, 'moneda_clave') ?? '—' }} · {{ number_format((float) (data_get($doc, 'valor_total') ?? data_get($doc, 'total') ?? 0), 2) }}</strong></div>
                    <div><span class="label">Capturista / depto</span><strong>{{ $doc->user?->name ?? '—' }} ({{ $doc->user?->departamento?->clave ?? 'Sin depto' }})</strong></div>
                </div>

                @if (!empty($doc->observaciones))
                    <p class="mt-4 text-sm"><strong>Observaciones del capturista:</strong> {{ $doc->observaciones }}</p>
                @endif

                <div class="aduana-role-section-title mt-6">
                    <div><h4>Facturas ({{ $doc->facturas?->count() ?? 0 }})</h4></div>
                </div>
                <div class="aduana-table-wrap">
                    <table class="aduana-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Número / folio</th>
                                <th>Fecha</th>
                                <th>Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($doc->facturas ?? [] as $idx => $factura)
                                <tr>
                                    <td>{{ $idx + 1 }}</td>
                                    <td>{{ data_get($factura, 'numero') ?? data_get($factura, 'folio') ?? '—' }}</td>
                                    <td>{{ data_get($factura, 'fecha') ?? '—' }}</td>
                                    <td>{{ number_format((float) (data_get($factura, 'monto') ?? data_get($factura, 'total') ?? 0), 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-slate-500">Sin facturas registradas.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="aduana-role-section-title mt-6">
                    <div><h4>Mercancías ({{ $doc->mercancias?->count() ?? 0 }})</h4></div>
                </div>
                <div class="aduana-table-wrap">
                    <table class="aduana-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Descripción</th>
                                <th>Cantidad</th>
                                <th>Unidad</th>
                                <th>Valor unitario</th>
                                <th>Valor total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($doc->mercancias ?? [] as $idx => $mercancia)
                                <tr>
                                    <td>{{ $idx + 1 }}</td>
                                    <td>{{ data_get($mercancia, 'descripcion') ?? '—' }}</td>
                                    <td>{{ data_get($mercancia, 'cantidad') ?? '—' }}</td>
                                    <td>{{ data_get($mercancia, 'unidad') ?? data_get($mercancia, 'umc') ?? '—' }}</td>
                                    <td>{{ number_format((float) (data_get($mercancia, 'valor_unitario') ?? data_get($mercancia, 'precio_unitario') ?? 0), 2) }}</td>
                                    <td>{{ number_format((float) (data_get($mercancia, 'valor_total') ?? data_get($mercancia, 'importe') ?? 0), 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-slate-500">Sin mercancías registradas.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            @elseif ($tipo === 'doda')
                <div class="aduana-detail-grid">
                    <div><span class="label">Folio DODA</span><strong>{{ $doc->folio ?? '—' }}</strong></div>
                    <div><span class="label">Identificación transporte</span><strong>{{ $doc->transporte_identificacion ?? '—' }}</strong></div>
                    <div><span class="label">Tipo / medio transporte</span><strong>{{ data_get($doc, 'transporte_tipo') ?? data_get($doc, 'medio_transporte_clave') ?? '—' }}</strong></div>
                    <div><span class="label">Aduana / sección</span><strong>{{ data_get($doc, 'aduana_clave') ?? '—' }} / {{ data_get($doc, 'seccion_aduanera') ?? '—' }}</strong></div>
                    <div><span class="label">Candados / sellos</span><strong>{{ data_get($doc, 'candados') ?? data_get($doc, 'sellos') ?? '—' }}</strong></div>
                    <div><span class="label">Capturista / depto</span><strong>{{ $doc->user?->name ?? '—' }} ({{ $doc->user?->departamento?->clave ?? 'Sin depto' }})</strong></div>
                </div>

                @if (!empty($doc->observaciones))
                    <p class="mt-4 text-sm"><strong>Observaciones del capturista:</strong> {{ $doc->observaciones }}</p>
                @endif

                <div class="aduana-role-section-title mt-6">
                    <div><h4>Pedimentos asociados ({{ $doc->pedimentos?->count() ?? 0 }})</h4></div>
                </div>
                <div class="aduana-table-wrap">
                    <table class="aduana-table">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Operador</th>
                                <th>Aduana</th>
                                <th>Estatus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($doc->pedimentos ?? [] as $ped)
                                <tr>
                                    <td><strong>{{ $ped->folio }}</strong></td>
                                    <td>{{ $ped->nombre_operador ?? '—' }}</td>
                                    <td>{{ $ped->aduana_clave ?? '—' }}</td>
                                    <td>{{ $ped->estatus ?? '—' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-slate-500">Sin pedimentos asociados.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif

            {{-- ACCIONES DE REVISIÓN DEL AGENTE --}}
            @if ($doc->estatus === 'enviado')
                <div class="aduana-role-section-title mt-6">
                    <div><h4>Dictamen de revisión</h4></div>
                </div>

                <div class="aduana-choice-grid mt-3">
                    <form method="POST" action="{{ route('agente.revisiones.validar', [$tipo, $doc->id]) }}" class="aduana-choice-card space-y-3">
                        @csrf
                        <h4>Validar documento</h4>
                        <p>Marca este documento como validado y registra observaciones si lo consideras necesario.</p>
                        <div>
                            <label class="block text-xs mb-1" for="obs-validar">Observaciones (opcional)</label>
                            <textarea id="obs-validar" name="observaciones" rows="2" class="w-full rounded border border-slate-700 bg-slate-900/60 p-2 text-sm">{{ old('observaciones') }}</textarea>
                        </div>
                        <button type="submit" class="aduana-btn aduana-btn--primary">Validar documento</button>
                    </form>

                    <form method="POST" action="{{ route('agente.revisiones.devolver', [$tipo, $doc->id]) }}" class="aduana-choice-card space-y-3">
                        @csrf
                        <h4>Devolver a corrección</h4>
                        <p>Regresa el documento al capturista con el motivo de devolución para que lo corrija.</p>
                        <div>
                            <label class="block text-xs mb-1" for="obs-devolver">Motivo de devolución</label>
                            <textarea id="obs-devolver" name="observaciones" rows="2" required class="w-full rounded border border-slate-700 bg-slate-900/60 p-2 text-sm">{{ old('observaciones') }}</textarea>
                        </div>
                        <button type="submit" class="aduana-btn aduana-btn--danger">Devolver documento</button>
                    </form>
                </div>
            @endif
        </section>
    </div>
</x-app-layout>