<x-app-layout>
    <div class="aduana-dashboard">
        <section class="aduana-module-view">
            <div class="aduana-module-view__heading">
                <div>
                    <span class="aduana-eyebrow aduana-eyebrow--muted">Edición</span>
                    <h3>COVE {{ $cove->folio }}</h3>
                </div>
            </div>
            @include('capturista.partials.flash')
            <form method="POST" action="{{ route('capturista.coves.update', $cove) }}" class="aduana-form">
                @csrf
                @method('PUT')
                @include('capturista.coves._form')
                <div class="aduana-form-actions">
                    <button type="submit" class="aduana-btn aduana-btn--primary">Guardar cambios</button>
                    <a href="{{ route('dashboard', ['tab' => 'cove']) }}" class="aduana-btn aduana-btn--ghost inline-flex items-center">Cancelar</a>
                </div>
            </form>
        </section>
    </div>
</x-app-layout>
