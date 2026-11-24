<x-app-layout>
    <div class="aduana-dashboard">
        <section class="aduana-module-view" style="max-width:1100px;margin:0 auto">
            <div class="aduana-module-view__heading" style="align-items:center">
                <div style="text-align:center;width:100%">
                    <span class="aduana-eyebrow aduana-eyebrow--muted">Organización</span>
                    <h3 style="margin-top:4px">Usuarios capturista</h3>
                    <p style="max-width:520px;margin:6px auto 0;color:#94a3b8">
                        Crea un departamento y luego registra capturistas. El correo y la contraseña se generan automáticamente.
                    </p>
                </div>
            </div>
            <div style="text-align:center;margin-bottom:1.25rem">
                <a href="{{ route('dashboard', ['tab' => 'usuarios']) }}" class="aduana-btn aduana-btn--ghost">← Volver al panel</a>
            </div>

            @if (session('status'))
                <div class="aduana-alert aduana-alert--ok" style="max-width:720px;margin:0 auto 1rem">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="aduana-alert aduana-alert--danger" style="max-width:720px;margin:0 auto 1rem">
                    <ul style="margin:0;padding-left:1.1rem">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            {{-- Tarjetas simétricas --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;align-items:stretch;max-width:1000px;margin:0 auto">
                {{-- Departamento --}}
                <article class="aduana-module-card" style="margin:0;display:flex;flex-direction:column;min-height:100%;height:100%;box-sizing:border-box">
                    <span class="aduana-module-card__kicker">PASO 1</span>
                    <h4 style="margin:6px 0 4px">Nuevo departamento</h4>
                    <p style="font-size:0.85rem;color:#94a3b8;margin-bottom:1rem;min-height:2.4em">Ejemplo de clave: <strong>8MSC9</strong></p>

                    <form method="POST" action="{{ route('agente.departamentos.store') }}" class="aduana-form-stack" style="flex:1;display:flex;flex-direction:column">
                        @csrf
                        <div>
                            <label class="aduana-label">Clave</label>
                            <input type="text" name="clave" class="aduana-input" required maxlength="40" value="{{ old('clave') }}" placeholder="8MSC9">
                        </div>
                        <div>
                            <label class="aduana-label">Nombre</label>
                            <input type="text" name="nombre" class="aduana-input" required value="{{ old('nombre') }}" placeholder="Grupo matutino">
                        </div>
                        <div>
                            <label class="aduana-label">Descripción (opcional)</label>
                            <input type="text" name="descripcion" class="aduana-input" value="{{ old('descripcion') }}">
                        </div>
                        <div style="flex:1"></div>
                        <button type="submit" class="aduana-btn aduana-btn--primary" style="width:100%;margin-top:auto">Crear departamento</button>
                    </form>
{{--
                    <div style="margin-top:1.25rem;padding-top:1rem;border-top:1px solid rgba(148,163,184,0.2)">
                        <strong style="font-size:0.85rem">Departamentos</strong>
                        @if ($departamentos->isEmpty())
                            <p style="font-size:0.85rem;color:#94a3b8;margin-top:0.5rem">Aún no hay departamentos.</p>
                        @else
                            <ul class="aduana-simple-list" style="margin-top:0.5rem">
                                @foreach ($departamentos as $dep)
                                    <li>
                                        <strong>{{ $dep->clave }}</strong> — {{ $dep->nombre }}
                                        <small style="color:#94a3b8">({{ $dep->users()->where('rol','capturista')->count() }} capt.)</small>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
--}}
                </article>

                {{-- Capturista --}}
                <article class="aduana-module-card" style="margin:0;display:flex;flex-direction:column;min-height:100%;height:100%;box-sizing:border-box">
                    <span class="aduana-module-card__kicker">PASO 2</span>
                    <h4 style="margin:6px 0 4px">Nuevo capturista</h4>
                    <p style="font-size:0.85rem;color:#94a3b8;margin-bottom:1rem;min-height:2.4em">
                        {{-- Correo: <code>nombre.apellido@aduanasim.com</code><br> --}}
                        Contraseña: <code>AduanaSim@UPTex2026</code>
                    </p>

                    @if ($departamentos->where('activo', true)->isEmpty())
                        <div class="aduana-empty-state" style="padding:1.5rem 0.5rem;flex:1;display:flex;flex-direction:column;justify-content:center">
                            <strong>Crea un departamento primero</strong>
                            <p style="font-size:0.85rem">Sin departamento no se puede registrar capturistas.</p>
                        </div>
                    @else
                        <form method="POST" action="{{ route('agente.usuarios.store') }}" class="aduana-form-stack" style="flex:1;display:flex;flex-direction:column">
                            @csrf
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem">
                                <div>
                                    <label class="aduana-label">Primer nombre *</label>
                                    <input type="text" name="primer_nombre" class="aduana-input" required value="{{ old('primer_nombre') }}" placeholder="Juan">
                                </div>
                                <div>
                                    <label class="aduana-label">Segundo nombre</label>
                                    <input type="text" name="segundo_nombre" class="aduana-input" value="{{ old('segundo_nombre') }}" placeholder="Opcional">
                                </div>
                            </div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem">
                                <div>
                                    <label class="aduana-label">Apellido paterno *</label>
                                    <input type="text" name="apellido_paterno" class="aduana-input" required value="{{ old('apellido_paterno') }}" placeholder="Pérez">
                                </div>
                                <div>
                                    <label class="aduana-label">Apellido materno *</label>
                                    <input type="text" name="apellido_materno" class="aduana-input" required value="{{ old('apellido_materno') }}" placeholder="García">
                                </div>
                            </div>
                            <div>
                                <label class="aduana-label">Departamento *</label>
                                <select name="departamento_id" class="aduana-input" required>
                                    <option value="">Seleccionar…</option>
                                    @foreach ($departamentos->where('activo', true) as $dep)
                                        <option value="{{ $dep->id }}" @selected((string)old('departamento_id', $departamentoId)===(string)$dep->id)>
                                            {{ $dep->clave }} — {{ $dep->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div style="flex:1"></div>
                            <button type="submit" class="aduana-btn aduana-btn--primary" style="width:100%;margin-top:auto">Crear capturista</button>
                        </form>
                    @endif
                </article>
            </div>

            {{-- Lista --}}
            <div style="max-width:1000px;margin:2rem auto 0">
                <div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:0.75rem;margin-bottom:0.75rem">
                    <div>
                        <h4 style="margin:0">Capturistas registrados</h4>
                        <p style="margin:4px 0 0;font-size:0.85rem;color:#94a3b8">Filtra por departamento</p>
                    </div>
                    <form method="GET" class="aduana-filter-bar" style="margin:0">
                        <select name="departamento_id" class="aduana-input" onchange="this.form.submit()">
                            <option value="">Todos los departamentos</option>
                            @foreach ($departamentos as $dep)
                                <option value="{{ $dep->id }}" @selected((string)$departamentoId === (string)$dep->id)>
                                    {{ $dep->clave }} — {{ $dep->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                @if ($capturistas->isEmpty())
                    <div class="aduana-empty-state">
                        <strong>Sin capturistas</strong>
                        <p>Crea un departamento y luego un usuario capturista.</p>
                    </div>
                @else
                    <div class="aduana-table-wrap">
                        <table class="aduana-table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Departamento</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($capturistas as $u)
                                    <tr>
                                        <td><strong>{{ $u->name }}</strong></td>
                                        <td>{{ $u->email }}</td>
                                        <td>{{ $u->departamento?->clave ?? '—' }}</td>
                                        <td>{{ $u->activo ? 'Activo' : 'Suspendido' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </section>
    </div>
</x-app-layout>
