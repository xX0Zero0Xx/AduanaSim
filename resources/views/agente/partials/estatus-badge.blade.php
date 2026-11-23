@php
    $map = [
        'borrador' => 'aduana-badge aduana-badge--muted',
        'enviado' => 'aduana-badge aduana-badge--warn',
        'validado' => 'aduana-badge aduana-badge--ok',
        'devuelto' => 'aduana-badge aduana-badge--danger',
    ];
    $class = $map[$estatus ?? ''] ?? 'aduana-badge';
@endphp
<span class="{{ $class }}">{{ $etiqueta ?? ucfirst($estatus ?? '') }}</span>
