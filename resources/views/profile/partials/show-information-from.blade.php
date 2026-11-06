<section aria-labelledby="user-information-heading">
    <header>
        <h2 id="user-information-heading" class="text-lg font-medium text-gray-900">
            {{ __('Datos del usuario') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Información asociada a tu cuenta.') }}
        </p>
    </header>

    <dl class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div class="rounded-md bg-gray-50 p-4">
            <dt class="text-sm font-medium text-gray-500">{{ __('Nombre') }}</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ $user->name }}</dd>
        </div>

        <div class="rounded-md bg-gray-50 p-4">
            <dt class="text-sm font-medium text-gray-500">{{ __('Correo electrónico') }}</dt>
            <dd class="mt-1 break-all text-sm text-gray-900">{{ $user->email }}</dd>
        </div>

        <div class="rounded-md bg-gray-50 p-4">
            <dt class="text-sm font-medium text-gray-500">{{ __('Rol') }}</dt>
            <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($user->rol) }}</dd>
        </div>

        <div class="rounded-md bg-gray-50 p-4">
            <dt class="text-sm font-medium text-gray-500">{{ __('Fecha de registro') }}</dt>
            <dd class="mt-1 text-sm text-gray-900">
                {{ $user->created_at?->format('d/m/Y') ?? __('No disponible') }}
            </dd>
        </div>

        <div class="rounded-md bg-gray-50 p-4 sm:col-span-2">
            <dt class="text-sm font-medium text-gray-500">{{ __('Estado del correo') }}</dt>
            <dd class="mt-1 text-sm {{ $user->email_verified_at ? 'text-green-700' : 'text-amber-700' }}">
                {{ $user->email_verified_at ? __('Verificado') : __('Sin verificar') }}
            </dd>
        </div>
    </dl>
</section>
