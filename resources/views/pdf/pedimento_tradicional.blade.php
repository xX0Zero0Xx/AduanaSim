<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Pedimento {{ $pedimento->folio }} — Tradicional</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 9px; color: #111; }
        h1 { font-size: 14px; margin: 0 0 4px; text-align: center; }
        .meta { text-align: center; margin-bottom: 10px; color: #444; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
        th, td { border: 1px solid #333; padding: 3px 5px; vertical-align: top; }
        th { background: #eee; font-size: 8px; text-transform: uppercase; }
        .section { font-weight: bold; background: #dfe6ec; }
        .label { color: #555; font-size: 8px; }
        .sim { text-align: center; font-size: 8px; color: #666; margin-top: 12px; }
        .w50 { width: 50%; }
        .w25 { width: 25%; }
        .w33 { width: 33%; }
    </style>
</head>
<body>
    <h1>PEDIMENTO (FORMATO TRADICIONAL — SIMULACIÓN ACADÉMICA)</h1>
    <div class="meta">AduanaSim · Folio {{ $pedimento->folio }} · Página 1</div>

    <table>
        <tr class="section"><td colspan="4">CABECERA</td></tr>
        <tr>
            <td class="w25"><span class="label">Núm. pedimento</span><br><strong>{{ $pedimento->folio }}</strong></td>
            <td class="w25"><span class="label">T. oper.</span><br>{{ strtoupper($pedimento->tipo_operacion) }}</td>
            <td class="w25"><span class="label">Cve. pedimento</span><br>{{ $pedimento->clave_pedimento }}</td>
            <td class="w25"><span class="label">Régimen</span><br>{{ $pedimento->regimen_clave }}</td>
        </tr>
        <tr>
            <td><span class="label">Destino</span><br>{{ $pedimento->destino_clave }}</td>
            <td><span class="label">Tipo de cambio</span><br>{{ $pedimento->tipo_cambio }}</td>
            <td><span class="label">Peso bruto</span><br>{{ $pedimento->peso_bruto }}</td>
            <td><span class="label">Aduana / ES</span><br>{{ $pedimento->aduana_clave }} / {{ $pedimento->seccion_aduanera }}</td>
        </tr>
        <tr>
            <td><span class="label">Medio transporte</span><br>{{ $pedimento->medio_transporte_clave }}</td>
            <td><span class="label">Entrada/Salida</span><br>{{ $pedimento->medio_entrada_clave }}</td>
            <td><span class="label">Arribo</span><br>{{ $pedimento->medio_arribo_clave }}</td>
            <td><span class="label">Salida</span><br>{{ $pedimento->medio_salida_clave }}</td>
        </tr>
        <tr>
            <td><span class="label">Valor dólares</span><br>{{ number_format($pedimento->valor_dolares, 2) }}</td>
            <td><span class="label">Valor aduana</span><br>{{ number_format($pedimento->valor_aduana, 2) }}</td>
            <td><span class="label">Precio pagado / comercial</span><br>{{ number_format($pedimento->precio_pagado ?: $pedimento->valor_comercial, 2) }}</td>
            <td><span class="label">Moneda / Incoterm</span><br>{{ $pedimento->moneda_clave }} / {{ $pedimento->incoterm_clave }}</td>
        </tr>
    </table>

    <table>
        <tr class="section"><td colspan="2">DATOS DEL IMPORTADOR / EXPORTADOR</td></tr>
        <tr>
            <td class="w50"><span class="label">RFC</span><br>{{ $pedimento->rfc_operador }}</td>
            <td class="w50"><span class="label">Nombre / razón social</span><br>{{ $pedimento->nombre_operador }}</td>
        </tr>
        <tr>
            <td><span class="label">CURP</span><br>{{ $pedimento->curp_operador }}</td>
            <td><span class="label">Domicilio</span><br>{{ $pedimento->domicilio_operador }}</td>
        </tr>
    </table>

    <table>
        <tr class="section"><td colspan="5">INCREMENTABLES</td></tr>
        <tr>
            <td><span class="label">Val. seguros</span><br>{{ number_format($pedimento->val_seguros, 2) }}</td>
            <td><span class="label">Seguros</span><br>{{ number_format($pedimento->seguros, 2) }}</td>
            <td><span class="label">Fletes</span><br>{{ number_format($pedimento->fletes, 2) }}</td>
            <td><span class="label">Embalajes</span><br>{{ number_format($pedimento->embalajes, 2) }}</td>
            <td><span class="label">Otros</span><br>{{ number_format($pedimento->otros_incrementables, 2) }}</td>
        </tr>
    </table>

    <table>
        <tr class="section"><td colspan="3">CÓDIGOS Y BULTOS</td></tr>
        <tr>
            <td><span class="label">Código aceptación</span><br>{{ $pedimento->codigo_aceptacion }}</td>
            <td><span class="label">Código de barras</span><br>{{ $pedimento->codigo_barras_pedimento }}</td>
            <td><span class="label">Marcas / total bultos</span><br>{{ $pedimento->marcas_bultos }} ({{ $pedimento->total_bultos }})</td>
        </tr>
    </table>

    <table>
        <tr class="section"><td colspan="3">PROVEEDOR / COMPRADOR Y CFDI</td></tr>
        <tr>
            <td><span class="label">ID fiscal / nombre</span><br>{{ $pedimento->proveedor_id_fiscal }} · {{ $pedimento->proveedor_nombre }}</td>
            <td><span class="label">Domicilio</span><br>{{ $pedimento->proveedor_domicilio }}</td>
            <td><span class="label">Vinculación</span><br>{{ $pedimento->vinculacion }}</td>
        </tr>
        <tr>
            <td><span class="label">CFDI / doc.</span><br>{{ $pedimento->cfdi_numero }}</td>
            <td><span class="label">Fecha</span><br>{{ optional($pedimento->cfdi_fecha)->format('d/m/Y') }}</td>
            <td><span class="label">Val. mon. / factor / USD</span><br>{{ $pedimento->cfdi_valor_moneda }} / {{ $pedimento->cfdi_factor_moneda }} / {{ $pedimento->cfdi_valor_dolares }}</td>
        </tr>
    </table>

    <table>
        <tr class="section"><td colspan="4">AGENTE ADUANAL</td></tr>
        <tr>
            <td><span class="label">Nombre</span><br>{{ $pedimento->agente_nombre }}</td>
            <td><span class="label">RFC</span><br>{{ $pedimento->agente_rfc }}</td>
            <td><span class="label">CURP</span><br>{{ $pedimento->agente_curp }}</td>
            <td><span class="label">Patente</span><br>{{ $pedimento->agente_patente ?: $pedimento->patente }}</td>
        </tr>
    </table>

    <table>
        <tr class="section">
            <td>#</td><td>Fracción / NICO</td><td>Descripción</td><td>Cant. / UMC</td><td>V. com.</td><td>V. adu.</td><td>P.O.</td>
        </tr>
        @foreach ($pedimento->partidas as $part)
            <tr>
                <td>{{ $part->secuencia }}</td>
                <td>{{ $part->fraccion }} / {{ $part->nico }}</td>
                <td>{{ $part->descripcion }}</td>
                <td>{{ $part->cantidad }} {{ $part->umc ?: $part->unidad }}</td>
                <td>{{ number_format($part->valor_comercial, 2) }}</td>
                <td>{{ number_format($part->valor_aduana, 2) }}</td>
                <td>{{ $part->pais_origen_clave }}</td>
            </tr>
        @endforeach
    </table>

    @if ($pedimento->observaciones)
        <p><strong>Observaciones:</strong> {{ $pedimento->observaciones }}</p>
    @endif

    <div class="sim">Documento generado por AduanaSim con fines académicos. Sin validez oficial ante el SAT.</div>
</body>
</html>
