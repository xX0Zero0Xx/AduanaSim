<x-app-layout>
    <div class="aduana-dashboard">
        <section class="aduana-module-view">
            <div class="aduana-module-view__heading">
                <div>
                    <span class="aduana-eyebrow aduana-eyebrow--muted">Colaboración</span>
                    <h3>Crear equipo</h3>
                    <p>Registra un nuevo equipo y revisa el listado breve de los ya existentes.</p>
                </div>
                <a href="{{ route('dashboard', ['tab' => 'equipos']) }}" class="aduana-btn aduana-btn--ghost">← Volver al Panel</a>
            </div>

            @if (session('status'))
                <div class="aduana-alert aduana-alert--ok mb-4">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="aduana-alert aduana-alert--error mb-4">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="aduana-module-grid">
                <article class="aduana-module-card">
                    <h4>Nuevo equipo</h4>
                    <form method="POST" action="{{ route('agente.equipos.store') }}" class="aduana-form-stack mt-3">
                        @csrf
                        <div>
                            <label class="aduana-label">Nombre</label>
                            <input type="text" name="nombre" class="aduana-input" required value="{{ old('nombre') }}" placeholder="Ej. Grupo mañana A">
                        </div>
                        <div>
                            <label class="aduana-label">Descripción</label>
                            <input type="text" name="descripcion" class="aduana-input" value="{{ old('descripcion') }}" placeholder="Opcional">
                        </div>
                        <button type="submit" class="aduana-btn aduana-btn--primary">Crear equipo</button>
                    </form>
                </article>

                <article class="aduana-module-card">
                    <h4>Equipos existentes</h4>
                    @if ($equiposExistentes->isEmpty())
                        <p class="mt-3">No hay equipos registrados aún.</p>
                    @else
                        <ul class="aduana-simple-list mt-3">
                            @foreach ($equiposExistentes as $item)
                                <li class="py-1.5 border-b flex items-center justify-between gap-2">
                                    <span>{{ $item['nombre'] }}</span>
                                    <span class="aduana-eyebrow aduana-eyebrow--muted">{{ $item['departamento'] }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </article>
            </div>
        </section>
    </div>
</x-app-layout>