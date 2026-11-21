<x-app-layout>
    <div class="aduana-dashboard">
        <section class="aduana-module-view">
            <div class="aduana-module-view__heading">
                <div>
                    <span class="aduana-eyebrow aduana-eyebrow--muted">Historial</span>
                    <h3>Mis documentos</h3>
                    <p>Consulta pedimentos, COVE y DODA propios o de tu equipo.</p>
                </div>
                <a href="{{ route('dashboard') }}" class="aduana-btn aduana-btn--ghost">Panel</a>
            </div>

            <form method="GET" class="aduana-filter-bar">
                <select name="tipo" class="aduana-input">
                    <option value="todos" @selected($tipo==='todos')>Todos</option>
                    <option value="pedimento" @selected($tipo==='pedimento')>Pedimentos</option>
                    <option value="cove" @selected($tipo==='cove')>COVE</option>
                    <option value="doda" @selected($tipo==='doda')>DODA</option>
                </select>
                <select name="estatus" class="aduana-input">
                    <option value="">Cualquier estatus</option>
                    @foreach (['borrador','enviado','validado','devuelto'] as $e)
                        <option value="{{ $e }}" @selected($estatus===$e)>{{ ucfirst($e) }}</option>
                    @endforeach
                </select>
                <button class="aduana-btn" type="submit">Filtrar</button>
            </form>

            @if ($items->isEmpty())
                <div class="aduana-empty-state">
                    <div class="aduana-empty-state__icon">◷</div>
                    <strong>Sin documentos</strong>
                    <p>Cuando captures pedimentos, COVE o DODA aparecerán aquí.</p>
                </div>
            @else
                <div class="aduana-table-wrap">
                    <table class="aduana-table">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Folio</th>
                                <th>Detalle</th>
                                <th>Estatus</th>
                                <th>Actualizado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item['tipo'] }}</td>
                                    <td>{{ $item['folio'] }}</td>
                                    <td>{{ $item['extra'] ?: '—' }}</td>
                                    <td>@include('capturista.partials.estatus-badge', ['estatus'=>$item['estatus'],'etiqueta'=>$item['etiqueta']])</td>
                                    <td>{{ $item['fecha']->format('d/m/Y H:i') }}</td>
                                    <td><a class="aduana-link" href="{{ $item['url'] }}">Abrir</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </div>
</x-app-layout>
