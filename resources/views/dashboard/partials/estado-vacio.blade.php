@php
    $iconos = [
        'users' => '♙', 'users-round' => '♧', 'blocks' => '▦', 'book-open' => '▤',
        'history' => '◷', 'clipboard-check' => '✓', 'badge-check' => '✓',
        'message-square-warning' => '!', 'file-text' => '▤', 'receipt-text' => '▧',
        'qr-code' => '▦', 'folder-clock' => '◷',
    ];
@endphp
<section class="aduana-module-view">
    <div class="aduana-module-view__heading">
        <div>
            <span class="aduana-eyebrow aduana-eyebrow--muted">{{ $accion ?? 'GESTIÓN ADUANASIM' }}</span>
            <h3>{{ $titulo }}</h3>
            <p>{{ $descripcion }}</p>
        </div>
        <div class="aduana-module-view__symbol">{{ $iconos[$icono ?? 'book-open'] ?? '▤' }}</div>
    </div>
    <div class="aduana-empty-state">
        <div class="aduana-empty-state__icon">{{ $iconos[$icono ?? 'book-open'] ?? '▤' }}</div>
        <h4>{{ $mensaje ?? 'No hay información para mostrar.' }}</h4>
        <p>Esta sección forma parte de la interfaz de AduanaSim. Los registros aparecerán aquí cuando se implemente su funcionalidad.</p>
        @if (!empty($accion) && $accion !== 'GESTIÓN ADUANASIM')
            <span class="aduana-status-pill">{{ $accion }}</span>
        @endif
    </div>
</section>
