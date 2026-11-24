<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Pedimento {{ $pedimento->folio }} — Simplificado</title>
    <style>
        @page { margin: 10mm 10mm; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 8px; color: #0b1f33; margin: 0; }
        .top { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
        .top td { vertical-align: middle; border: none; padding: 0; }
        .brand { color: #0d9488; font-size: 16px; font-weight: bold; letter-spacing: 0.5px; }
        .brand span { color: #0b1f33; }
        .tagline { font-size: 7px; color: #64748b; }
        .right { text-align: right; font-size: 7.5px; color: #475569; }
        h1 { text-align: center; margin: 4px 0 2px; font-size: 14px; color: #0b1f33; letter-spacing: 1px; }
        .sim { text-align: center; color: #0d9488; font-size: 8px; font-weight: bold; margin-bottom: 8px; }
        .band {
            background: #e6f7f5; border: 1px solid #0d9488; border-bottom: none;
            color: #0b1f33; font-weight: bold; font-size: 8px; padding: 3px 6px;
            text-transform: uppercase; letter-spacing: 0.3px;
        }
        table.g { width: 100%; border-collapse: collapse; margin-bottom: 6px; table-layout: fixed; }
        table.g td, table.g th { border: 1px solid #94a3b8; padding: 3px 5px; vertical-align: top; }
        .lbl { display: block; font-size: 6px; color: #64748b; text-transform: uppercase; }
        .val { font-size: 9px; font-weight: bold; color: #0b1f33; }
        .val-n { font-size: 9px; font-weight: bold; text-align: right; }
        .ctr { text-align: center; }
        .num { text-align: right; }
        .tiny { font-size: 7px; }
        .warn {
            margin-top: 10px; border: 1.5px solid #0d9488; background: #f0fdfa;
            padding: 6px; text-align: center; font-size: 8.5px; font-weight: bold;
        }
        .foot { text-align: center; font-size: 6.5px; color: #64748b; margin-top: 4px; }
        img.logo { height: 40px; }
    </style>
</head>
<body>
    <table class="top">
        <tr>
            <td style="width:55%">
                @php $logo = public_path('images/aduanasim-logo1.png'); @endphp
                @if (file_exists($logo))
                    <img class="logo" src="{{ $logo }}" alt="AduanaSim">
                @else
                    <div class="brand">ADUANA<span>SIM</span></div>
                @endif
                <div class="tagline">Simulador de Pedimentos y COVE</div>
            </td>
            <td class="right" style="width:45%">
                <strong style="color:#0d9488">PEDIMENTO SIMPLIFICADO</strong><br>
                Fecha de generación: {{ now()->format('d/m/Y H:i') }}
            </td>
        </tr>
    </table>

    <h1>PEDIMENTO {{ $pedimento->folio }}</h1>
    <div class="sim">SIMULADOR ACADÉMICO — SIN VALIDEZ OFICIAL</div>

    <div class="band">Datos generales</div>
    <table class="g">
        <tr>
            <td style="width:25%"><span class="lbl">Folio AduanaSim</span><span class="val">{{ $pedimento->folio }}</span></td>
            <td style="width:20%"><span class="lbl">Clave de pedimento</span><span class="val">{{ $pedimento->clave_pedimento }}</span></td>
            <td style="width:15%"><span class="lbl">Régimen</span><span class="val">{{ $pedimento->regimen_clave }}</span></td>
            <td style="width:20%"><span class="lbl">Tipo de operación</span><span class="val">{{ $pedimento->tipo_operacion }}</span></td>
            <td style="width:20%"><span class="lbl">Estado</span><span class="val">{{ $pedimento->etiquetaEstatus() }}</span></td>
        </tr>
        <tr>
            <td><span class="lbl">Aduana</span><span class="val">{{ $pedimento->aduana_clave }}</span></td>
            <td><span class="lbl">Sección aduanera</span><span class="val">{{ $pedimento->seccion_aduanera ?: '—' }}</span></td>
            <td><span class="lbl">Patente</span><span class="val">{{ $pedimento->patente }}</span></td>
            <td><span class="lbl">Medio entrada</span><span class="val">{{ $pedimento->medio_entrada_clave ?: $pedimento->medio_transporte_clave }}</span></td>
            <td><span class="lbl">Peso bruto</span><span class="val-n">{{ number_format((float)$pedimento->peso_bruto, 3) }}</span></td>
        </tr>
        <tr>
            <td colspan="2"><span class="lbl">RFC / Nombre operador</span><span class="val">{{ $pedimento->rfc_operador }} · {{ $pedimento->nombre_operador }}</span></td>
            <td colspan="3"><span class="lbl">Domicilio</span><span class="val">{{ $pedimento->domicilio_operador }}</span></td>
        </tr>
    </table>

    <div class="band">Datos de factura / valor</div>
    <table class="g">
        <tr>
            <td style="width:20%"><span class="lbl">Número de factura</span><span class="val">{{ $pedimento->cfdi_numero }}</span></td>
            <td style="width:16%"><span class="lbl">Fecha factura</span><span class="val">{{ optional($pedimento->cfdi_fecha)->format('d/m/Y') }}</span></td>
            <td style="width:12%"><span class="lbl">Moneda</span><span class="val">{{ $pedimento->moneda_clave }}</span></td>
            <td style="width:16%"><span class="lbl">Tipo de cambio</span><span class="val-n">{{ number_format((float)$pedimento->tipo_cambio, 6) }}</span></td>
            <td style="width:18%"><span class="lbl">Valor comercial</span><span class="val-n">{{ number_format((float)$pedimento->valor_comercial, 2) }}</span></td>
            <td style="width:18%"><span class="lbl">Valor aduana / USD</span><span class="val-n">{{ number_format((float)$pedimento->valor_aduana, 2) }} / {{ number_format((float)$pedimento->valor_dolares, 2) }}</span></td>
        </tr>
        <tr>
            <td colspan="2"><span class="lbl">Proveedor</span><span class="val">{{ $pedimento->proveedor_nombre }}</span></td>
            <td colspan="2"><span class="lbl">ID fiscal</span><span class="val">{{ $pedimento->proveedor_id_fiscal }}</span></td>
            <td colspan="2"><span class="lbl">Incoterm / País origen-destino</span><span class="val">{{ $pedimento->incoterm_clave }} · {{ $pedimento->pais_origen_clave }} → {{ $pedimento->pais_destino_clave }}</span></td>
        </tr>
    </table>

    <div class="band">Partidas arancelarias</div>
    <table class="g">
        <tr style="background:#f1f5f9">
            <th class="ctr" style="width:5%">No.</th>
            <th class="ctr" style="width:12%">Fracción</th>
            <th class="ctr" style="width:6%">NICO</th>
            <th style="width:33%">Descripción de mercancía</th>
            <th class="ctr" style="width:12%">Cantidad</th>
            <th class="ctr" style="width:8%">Unidad</th>
            <th class="ctr" style="width:12%">Valor unitario</th>
            <th class="ctr" style="width:12%">Valor comercial</th>
        </tr>
        @forelse($pedimento->partidas as $p)
            <tr>
                <td class="ctr">{{ $p->secuencia }}</td>
                <td class="ctr">{{ $p->fraccion }}</td>
                <td class="ctr">{{ $p->nico }}</td>
                <td class="tiny">{{ $p->descripcion }}</td>
                <td class="num">{{ number_format((float)$p->cantidad, 4) }}</td>
                <td class="ctr">{{ $p->unidad ?: $p->umc }}</td>
                <td class="num">${{ number_format((float)$p->precio_unitario, 2) }}</td>
                <td class="num">${{ number_format((float)$p->valor_comercial, 2) }}</td>
            </tr>
            <tr>
                <td colspan="8" class="tiny" style="color:#64748b">
                    País origen: {{ $p->pais_origen_clave ?: '—' }}
                    | País vendedor: {{ $p->pais_vendedor_clave ?: '—' }}
                    | Marca: {{ $p->marca ?: '—' }} {{ $p->modelo }}
                </td>
            </tr>
        @empty
            <tr><td colspan="8" class="ctr tiny">Sin partidas</td></tr>
        @endforelse
    </table>

    @if($pedimento->observaciones)
        <div class="band">Observaciones</div>
        <table class="g"><tr><td class="tiny">{{ $pedimento->observaciones }}</td></tr></table>
    @endif

    <div class="warn">DOCUMENTO SIN VALOR JUDICIAL</div>
    <div class="foot">Documento generado por ADUANASIM para fines académicos. No constituye un pedimento oficial ni acredita el pago de contribuciones aduaneras.</div>
</body>
</html>
