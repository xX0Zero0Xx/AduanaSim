<x-guest-layout>
    <main class="aduana-auth-shell">
        <section class="aduana-auth-brand-panel">
            <a href="{{ route('home') }}" class="aduana-auth-brand">
                <img src="{{ asset('images/aduanasim-logo.png') }}" alt="Logotipo de AduanaSim">
                <span><strong>AduanaSim</strong><small>Simulador de despacho aduanero</small></span>
            </a>
            <div class="aduana-auth-brand__message">
                <span class="aduana-eyebrow"><span></span> Formación en comercio exterior</span>
                <h1>Aprende<br>Practica<br><em>Domina el proceso</em></h1>
                <p>Un entorno académico para comprender la documentación de un despacho aduanero.</p>
            </div>
            <div class="aduana-auth-brand__foot">Plataformas academica</div>
        </section>
        <section class="aduana-auth-form-panel">
            <div class="aduana-auth-form-wrap">
                <div class="aduana-auth-mobile-brand"><img src="{{ asset('images/aduanasim-logo.png') }}" alt=""><strong>AduanaSim</strong></div>
                <span class="aduana-eyebrow aduana-eyebrow--muted">BIENVENIDO</span>
                <h2>Iniciar sesión</h2>
                <p class="aduana-auth-lead">Ingresa tus credenciales para acceder a tu espacio de trabajo.</p>
                <x-auth-session-status class="aduana-auth-status" :status="session('status')" />
                <form method="POST" action="{{ route('login') }}" class="aduana-auth-form">
                    @csrf
                    <div class="aduana-form-field">
                        <label for="email">Correo electrónico</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="nombre@aduanasim.com">
                        <x-input-error :messages="$errors->get('email')" class="aduana-field-error" />
                    </div>
                    <div class="aduana-form-field">
                        <label for="password">Contraseña</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Ingresa tu contraseña">
                        <x-input-error :messages="$errors->get('password')" class="aduana-field-error" />
                    </div>
                    <div class="aduana-auth-options">
                        <label class="aduana-checkbox"><input id="remember_me" type="checkbox" name="remember"><span>Recordar mi sesión</span></label>
                        @if (Route::has('password.request'))<a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>@endif
                    </div>
                    <button type="submit" class="aduana-auth-submit">Acceder <span aria-hidden="true">→</span></button>
                </form>
                <div class="aduana-auth-legal"><span>AduanaSim</span> · Simulador académico · Documento sin valor jurídico</div>
            </div>
        </section>
    </main>
</x-guest-layout>
