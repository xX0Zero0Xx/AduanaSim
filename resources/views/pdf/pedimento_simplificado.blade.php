<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Pedimento {{ $pedimento->folio }} — Simplificado</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #111; }
        h1 { font-size: 14px; text-align: center; margin-bottom: 6px; }
        .meta { text-align: center; margin-bottom: 12px; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        th, td { border: 1px solid #444; padding: 4px 6px; }
        th { background: #eef2f5; font-size: 9px; }
        .sim { text-align: center; font-size: 8px; color: #666; margin-top: 16px; }
    </style>
</head>
<body>
    <h1>PEDIMENTO SIMPLIFICADO — SIMULACIÓN ACADÉMICA</h1>
    <div class="meta">AduanaSim · {{ $pedimento->folio }} · {{ strtoupper($pedimento->tipo_operacion) }}</div>

    <table>
        <tr>
            <th>Aduana</th><td>{{ $pedimento->aduana_clave }}</td>
            <th>Cve. / régimen</th><td>{{ $pedimento->clave_pedimento }} / {{ $pedimento->regimen_clave }}</td>
        </tr>
        <tr>
            <th>RFC operador</th><td>{{ $pedimento->rfc_operador }}</td>
            <th>Nombre</th><td>{{ $pedimento->nombre_operador }}</td>
        </tr>
        <tr>
            <th>Valor aduana</th><td>{{ number_format($pedimento->valor_aduana, 2) }}</td>
            <th>Valor dólares</th><td>{{ number_format($pedimento->valor_dolares, 2) }}</td>
        </tr>
        <tr>
            <th>Moneda / Incoterm</th><td>{{ $pedimento->moneda_clave }} / {{ $pedimento->incoterm_clave }}</td>
            <th>Medio transporte</th><td>{{ $pedimento->medio_transporte_clave }}</td>
        </tr>
        <tr>
            <th>Patente / agente</th><td colspan="3">{{ $pedimento->agente_patente ?: $pedimento->patente }} · {{ $pedimento->agente_nombre }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>#</th><th>Fracción</th><th>Descripción</th><th>Cantidad</th><th>V. comercial</th><th>V. aduana</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pedimento->partidas as $part)
                <tr>
                    <td>{{ $part->secuencia }}</td>
                    <td>{{ $part->fraccion }}</td>
                    <td>{{ $part->descripcion }}</td>
                    <td>{{ $part->cantidad }} {{ $part->umc ?: $part->unidad }}</td>
                    <td>{{ number_format($part->valor_comercial, 2) }}</td>
                    <td>{{ number_format($part->valor_aduana, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if ($pedimento->observaciones)
        <p><strong>Observaciones:</strong> {{ $pedimento->observaciones }}</p>
    @endif

    <div class="sim">Documento generado por AduanaSim con fines académicos. Sin validez oficial ante el SAT.</div>
</body>
</html>
