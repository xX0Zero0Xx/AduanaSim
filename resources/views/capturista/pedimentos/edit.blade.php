<x-app-layout>
    <div class="aduana-dashboard">
        <section class="aduana-module-view">
            <div class="aduana-module-view__heading">
                <div>
                    <span class="aduana-eyebrow aduana-eyebrow--muted">Edición</span>
                    <h3>Pedimento {{ $pedimento->folio }}</h3>
                    <p>Actualiza la información y las partidas del ejercicio.</p>
                </div>
                <a href="{{ route('capturista.pedimentos.show', $pedimento) }}" class="aduana-btn aduana-btn--ghost">← Ver</a>
            </div>

            @include('capturista.partials.flash')

            <form method="POST" action="{{ route('capturista.pedimentos.update', $pedimento) }}" class="aduana-form">
                @csrf
                @method('PUT')
                @include('capturista.pedimentos._form')
                <div class="aduana-form-actions">
                    <button type="submit" class="aduana-btn aduana-btn--primary">Guardar cambios</button>
                    <a href="{{ route('capturista.pedimentos.show', $pedimento) }}" class="aduana-btn aduana-btn--ghost">Cancelar</a>
                </div>
            </form>
        </section>
    </div>
</x-app-layout>
