<x-app-layout>
    <div class="aduana-dashboard">
        <section class="aduana-module-view">
            <div class="aduana-module-view__heading">
                <div>
                    <span class="aduana-eyebrow aduana-eyebrow--muted">Centro de validación</span>
                    <h3>{{ $titulo }}</h3>
                    <p>
                        @if ($bandeja === 'historial')
                            Documentos con estatus <strong>Validado</strong> o <strong>Devuelto</strong>.
                        @else
                            Filtra por departamento y tipo de documento.
                        @endif
                    </p>
                </div>
                <a href="{{ route('dashboard', ['tab' => $bandeja === 'historial' ? 'historial' : ($bandeja === 'validados' ? 'validados' : 'pendientes')]) }}" class="aduana-btn aduana-btn--ghost">← Panel</a>
            </div>

            @if (session('status'))
                <div class="aduana-alert aduana-alert--ok">{{ session('status') }}</div>
            @endif

            <form method="GET" class="aduana-filter-bar">
                <select name="departamento_id" class="aduana-input">
                    <option value="">Todos los departamentos</option>
                    @foreach ($departamentos as $dep)
                        <option value="{{ $dep->id }}" @selected((string)$departamentoId === (string)$dep->id)>
                            {{ $dep->clave }} — {{ $dep->nombre }}
                        </option>
                    @endforeach
                </select>
                <select name="tipo" class="aduana-input">
                    <option value="todos" @selected($tipo==='todos')>Todos los tipos</option>
                    <option value="pedimento" @selected($tipo==='pedimento')>Pedimentos</option>
                    <option value="cove" @selected($tipo==='cove')>COVE</option>
                    <option value="doda" @selected($tipo==='doda')>DODA</option>
                </select>
                <button class="aduana-btn" type="submit">Filtrar</button>
            </form>

            @if ($items->isEmpty())
                <div class="aduana-empty-state">
                    <div class="aduana-empty-state__icon">◷</div>
                    <strong>Sin documentos en esta bandeja</strong>
                    <p>Ajusta el filtro de departamento o espera envíos de capturistas.</p>
                </div>
            @else
                <div class="aduana-table-wrap">
                    <table class="aduana-table">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Folio</th>
                                <th>Departamento</th>
                                <th>Propietario</th>
                                <th>Estatus</th>
                                <th>Actualizado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item['tipo'] }}</td>
                                    <td><strong>{{ $item['folio'] }}</strong></td>
                                    <td>{{ $item['departamento'] }}</td>
                                    <td>{{ $item['capturista'] }}</td>
                                    <td>@include('agente.partials.estatus-badge', ['estatus'=>$item['estatus'],'etiqueta'=>$item['etiqueta']])</td>
                                    <td>{{ $item['fecha']?->format('d/m/Y H:i') }}</td>
                                    <td><a class="aduana-link" href="{{ $item['url'] }}">Ver</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </div>
</x-app-layout>
