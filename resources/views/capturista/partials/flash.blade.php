@if (session('status'))
    <div class="aduana-alert aduana-alert--ok" role="status">{{ session('status') }}</div>
@endif
@if (session('error'))
    <div class="aduana-alert aduana-alert--danger" role="alert">{{ session('error') }}</div>
@endif
@if ($errors->any())
    <div class="aduana-alert aduana-alert--danger" role="alert">
        <strong>Revisa los datos:</strong>
        <ul class="mt-1 list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
