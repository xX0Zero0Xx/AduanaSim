<x-app-layout>
    <div class="aduana-dashboard">
        <section class="aduana-module-view">
            <div class="aduana-module-view__heading">
                <div>
                    <span class="aduana-eyebrow aduana-eyebrow--muted">Nuevo Cove</span>
                    <h3>Captura de comprobante de valor</h3>
                </div>

<!-- <a href="{{ route('dashboard') }}" class="aduana-btn aduana-btn--ghost">← Volver al panel</a> -->

                <!-- <a href="{{ route('capturista.coves.index') }}" class="aduana-btn aduana-btn--ghost">← Lista</a> -->
            </div>
            @include('capturista.partials.flash')
            <form method="POST" action="{{ route('capturista.coves.store') }}" class="aduana-form">
                @csrf
                @include('capturista.coves._form')
                <div class="aduana-form-actions">
                    <button type="submit" class="aduana-btn aduana-btn--primary">Guardar borrador</button>
                    <a href="{{ route('dashboard') }}" class="aduana-btn aduana-btn--ghost">Cancelar</a>
                </div>
            </form>
        </section>
    </div>
</x-app-layout>
