<x-app-layout>
    <div class="aduana-dashboard">
        <section class="aduana-module-view">
            <div class="aduana-module-view__heading">
                <div>
                    <span class="aduana-eyebrow aduana-eyebrow--muted">Nuevo ejercicio</span>
                    <h3>Captura de pedimento</h3>
                    <p>Completa la cabecera y las partidas. Se guardará como borrador.</p>
                </div>

<!-- <a href="{{ route('dashboard') }}" class="aduana-btn aduana-btn--ghost">← Volver al panel</a> -->

                <!-- <a href="{{ route('capturista.pedimentos.index') }}" class="aduana-btn aduana-btn--ghost">← Lista</a> -->
            </div>

            @include('capturista.partials.flash')

            <form method="POST" action="{{ route('capturista.pedimentos.store') }}" class="aduana-form">
                @csrf
                @include('capturista.pedimentos._form')
                <div class="aduana-form-actions">
                    <button type="submit" class="aduana-btn aduana-btn--primary">Guardar borrador</button>
                    <a href="{{ route('dashboard') }}" class="aduana-btn aduana-btn--ghost">Cancelar</a>
                </div>
            </form>
        </section>
    </div>
</x-app-layout>
