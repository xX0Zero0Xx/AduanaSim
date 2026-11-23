<x-app-layout>
    <div class="aduana-dashboard">
        <section class="aduana-module-view">
            <div class="aduana-module-view__heading">
                <div>
                    <span class="aduana-eyebrow aduana-eyebrow--muted">Revisión · {{ strtoupper($tipo) }}</span>
                    <h3>{{ $doc->folio }}</h3>
                    <p>
                        @include('agente.partials.estatus-badge', ['estatus'=>$doc->estatus,'etiqueta'=>$doc->etiquetaEstatus()])
                        · Capturista: {{ $doc->user->name ?? '—' }}
                        · Enviado: {{ optional($doc->enviado_at)->format('d/m/Y H:i') ?: '—' }}
                    </p>
                </div>
                <div class="aduana-btn-row">
                    <a href="{{ route('agente.revisiones.index', $doc->estatus === 'validado' ? 'validados' : ($doc->estatus === 'devuelto' ? 'devueltos' : 'pendientes')) }}" class="aduana-btn aduana-btn--ghost">← Bandeja</a>
                    @if ($tipo === 'pedimento')
                        <a href="{{ route('capturista.pedimentos.pdf', [$doc, 'tradicional']) }}" class="aduana-btn" target="_blank">PDF tradicional</a>
                        <a href="{{ route('capturista.pedimentos.pdf', [$doc, 'simplificado']) }}" class="aduana-btn" target="_blank">PDF simplificado</a>
                    @elseif ($tipo === 'cove')
                        <a href="{{ route('capturista.coves.pdf', $doc) }}" class="aduana-btn" target="_blank">PDF COVE</a>
                    @elseif ($tipo === 'doda')
                        <a href="{{ route('capturista.dodas.pdf', $doc) }}" class="aduana-btn" target="_blank">PDF DODA</a>
                    @endif
                </div>
            </div>

            @if (session('status'))
                <div class="aduana-alert aduana-alert--ok">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="aduana-alert aduana-alert--danger">
                    <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            <div class="aduana-detail-grid">
                @if ($tipo === 'pedimento')
                    <div><span class="aduana-label">Operación</span><strong>{{ $doc->tipo_operacion }} · {{ $doc->clave_pedimento }} / {{ $doc->regimen_clave }}</strong></div>
                    <div><span class="aduana-label">Aduana</span><strong>{{ $doc->aduana_clave }}</strong></div>
                    <div><span class="aduana-label">RFC / Nombre</span><strong>{{ $doc->rfc_operador }} · {{ $doc->nombre_operador }}</strong></div>
                    <div><span class="aduana-label">Valores USD / Aduana / Comercial</span><strong>{{ number_format($doc->valor_dolares,2) }} / {{ number_format($doc->valor_aduana,2) }} / {{ number_format($doc->valor_comercial,2) }}</strong></div>
                    <div><span class="aduana-label">Proveedor</span><strong>{{ $doc->proveedor_nombre }}</strong></div>
                    <div><span class="aduana-label">Partidas</span><strong>{{ $doc->partidas->count() }}</strong></div>
                @elseif ($tipo === 'cove')
                    <div><span class="aduana-label">Emisor</span><strong>{{ $doc->emisor_rfc }} · {{ $doc->emisor_nombre }}</strong></div>
                    <div><span class="aduana-label">Destinatario</span><strong>{{ $doc->destinatario_rfc }} · {{ $doc->destinatario_nombre }}</strong></div>
                    <div><span class="aduana-label">Moneda / Valor total</span><strong>{{ $doc->moneda_clave }} · {{ number_format($doc->valor_total,2) }}</strong></div>
                    <div><span class="aduana-label">Pedimento vinculado</span><strong>{{ optional($doc->pedimento)->folio ?: '—' }}</strong></div>
                    <div><span class="aduana-label">Facturas</span><strong>{{ $doc->facturas->count() }}</strong></div>
                    <div><span class="aduana-label">Mercancías</span><strong>{{ $doc->mercancias->count() }}</strong></div>
                @elseif ($tipo === 'doda')
                    <div><span class="aduana-label">Aduana / Patente</span><strong>{{ $doc->aduana_clave }} · {{ $doc->patente }}</strong></div>
                    <div><span class="aduana-label">N° operación</span><strong>{{ $doc->numero_operacion }}</strong></div>
                    <div><span class="aduana-label">Fecha operación</span><strong>{{ optional($doc->fecha_operacion)->format('d/m/Y') }}</strong></div>
                    <div><span class="aduana-label">Medio / Placa</span><strong>{{ $doc->medio_transporte_clave }} · {{ $doc->placa_o_identificacion }}</strong></div>
                    <div><span class="aduana-label">Pedimentos asociados</span><strong>{{ $doc->pedimentos->count() }}</strong></div>
                @endif
            </div>

            @if ($doc->observaciones)
                <p class="mt-3"><strong>Observaciones del capturista:</strong> {{ $doc->observaciones }}</p>
            @endif
            @if ($doc->observaciones_revision)
                <p class="mt-2"><strong>Observaciones de revisión:</strong> {{ $doc->observaciones_revision }}</p>
            @endif

            @if ($doc->estatus === 'enviado')
                <div class="aduana-module-card mt-6" style="max-width:640px">
                    <h4>Decisión de revisión</h4>
                    <p class="text-sm text-slate-500 mb-3">Valida el documento o devuélvelo con observaciones para que el capturista lo corrija.</p>

                    <form method="POST" action="{{ route('agente.revisiones.validar', [$tipo, $doc->id]) }}" class="mb-4">
                        @csrf
                        <label class="aduana-label">Observaciones (opcional al validar)</label>
                        <textarea name="observaciones_revision" class="aduana-input" rows="2" placeholder="Comentario breve de aprobación">{{ old('observaciones_revision') }}</textarea>
                        <button type="submit" class="aduana-btn aduana-btn--primary mt-2">✓ Validar documento</button>
                    </form>

                    <form method="POST" action="{{ route('agente.revisiones.devolver', [$tipo, $doc->id]) }}">
                        @csrf
                        <label class="aduana-label">Observaciones para devolver (obligatorias)</label>
                        <textarea name="observaciones_revision" class="aduana-input" rows="3" required placeholder="Indica qué debe corregir el capturista">{{ old('observaciones_revision') }}</textarea>
                        <button type="submit" class="aduana-btn aduana-btn--danger mt-2">↶ Devolver con observaciones</button>
                    </form>
                </div>
            @elseif ($doc->estatus === 'validado')
                <div class="aduana-alert aduana-alert--ok mt-4">Documento validado{{ $doc->validado_at ? ' el '.$doc->validado_at->format('d/m/Y H:i') : '' }}.</div>
                <form method="POST" action="{{ route('agente.revisiones.devolver', [$tipo, $doc->id]) }}" class="mt-3" style="max-width:640px">
                    @csrf
                    <label class="aduana-label">¿Necesitas revertir? Indica motivo de devolución</label>
                    <textarea name="observaciones_revision" class="aduana-input" rows="2" required></textarea>
                    <button type="submit" class="aduana-btn aduana-btn--danger mt-2">Devolver de nuevo</button>
                </form>
            @elseif ($doc->estatus === 'devuelto')
                <div class="aduana-alert aduana-alert--danger mt-4">Documento devuelto. El capturista debe corregirlo y reenviarlo.</div>
            @endif
        </section>
    </div>
</x-app-layout>
