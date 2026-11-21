@php
    $map = [
        'borrador' => 'aduana-badge--muted',
        'enviado' => 'aduana-badge--warn',
        'validado' => 'aduana-badge--ok',
        'devuelto' => 'aduana-badge--danger',
    ];
    $class = $map[$estatus] ?? 'aduana-badge--muted';
@endphp
<span class="aduana-badge {{ $class }}">{{ $etiqueta ?? ucfirst($estatus) }}</span>
