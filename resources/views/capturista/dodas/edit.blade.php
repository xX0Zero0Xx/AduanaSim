<x-app-layout>
    <div class="aduana-dashboard">
        <section class="aduana-module-view">
            <div class="aduana-module-view__heading">
                <div>
                    <span class="aduana-eyebrow aduana-eyebrow--muted">Edición</span>
                    <h3>DODA {{ $doda->folio }}</h3>
                </div>
                <a href="{{ route('capturista.dodas.show', $doda) }}" class="aduana-btn aduana-btn--ghost">← Ver</a>
            </div>
            @include('capturista.partials.flash')
            <form method="POST" action="{{ route('capturista.dodas.update', $doda) }}" class="aduana-form">
                @csrf
                @method('PUT')
                @include('capturista.dodas._form')
                <div class="aduana-form-actions">
                    <button type="submit" class="aduana-btn aduana-btn--primary">Guardar cambios</button>
                </div>
            </form>
        </section>
    </div>
</x-app-layout>
