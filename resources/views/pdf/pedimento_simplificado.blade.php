<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Pedimento {{ $pedimento->folio }} — Simplificado</title>
    <style>
        @page { margin: 12mm 10mm; }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 8.5px;
            color: #000;
            margin: 0;
            position: relative;
        }
        .watermark {
            position: fixed;
            top: 40%;
            left: 10%;
            width: 80%;
            text-align: center;
            font-size: 26px;
            color: #c9c9c9;
            transform: rotate(-28deg);
            z-index: 0;
            font-weight: bold;
            opacity: 0.45;
            letter-spacing: 2px;
        }
        .content { position: relative; z-index: 1; }
        .header {
            border: 1.5px solid #000;
            padding: 5px;
            text-align: center;
            margin-bottom: 6px;
        }
        .header h1 { margin: 0; font-size: 12px; letter-spacing: 1px; }
        .header p { margin: 2px 0 0; font-size: 7.5px; }
        .band {
            background: #e8e8e8;
            border: 1px solid #000;
            border-bottom: none;
            font-weight: bold;
            font-size: 8px;
            padding: 2px 4px;
            text-transform: uppercase;
        }
        table.grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
            table-layout: fixed;
        }
        table.grid td, table.grid th {
            border: 1px solid #000;
            padding: 3px 4px;
            vertical-align: top;
        }
        .lbl { display:block; font-size:6.5px; color:#333; text-transform:uppercase; }
        .val { font-size: 9px; font-weight: bold; }
        .val-n { font-size: 9px; font-weight: bold; text-align: right; }
        .footer-leyenda {
            margin-top: 12px;
            border: 1.5px solid #000;
            padding: 6px;
            text-align: center;
            font-size: 10px;
            font-weight: bold;
        }
        .footer-meta { text-align: center; font-size: 6.5px; color: #444; margin-top: 4px; }
        .tiny { font-size: 7px; }
        .num { text-align: right; }
        .ctr { text-align: center; }
    </style>
</head>
<body>
    <div class="watermark">DOCUMENTO SIN VALOR JUDICIAL</div>

    <div class="content">
        <div class="header">
            <h1>PEDIMENTO — FORMATO SIMPLIFICADO</h1>
            <p>AduanaSim · Folio {{ $pedimento->folio }} · {{ strtoupper($pedimento->tipo_operacion ?? '') }} · {{ now()->format('d/m/Y') }}</p>
        </div>

        <div class="band">Identificación</div>
        <table class="grid">
            <tr>
                <td style="width:22%"><span class="lbl">Núm. pedimento</span><span class="val">{{ $pedimento->folio }}</span></td>
                <td style="width:13%"><span class="lbl">Cve. ped.</span><span class="val">{{ $pedimento->clave_pedimento }}</span></td>
                <td style="width:13%"><span class="lbl">Régimen</span><span class="val">{{ $pedimento->regimen_clave }}</span></td>
                <td style="width:13%"><span class="lbl">Aduana</span><span class="val">{{ $pedimento->aduana_clave }}</span></td>
                <td style="width:13%"><span class="lbl">Patente</span><span class="val">{{ $pedimento->patente }}</span></td>
                <td style="width:13%"><span class="lbl">Destino</span><span class="val">{{ $pedimento->destino_clave }}</span></td>
                <td style="width:13%"><span class="lbl">T. cambio</span><span class="val-n">{{ number_format((float)$pedimento->tipo_cambio, 4) }}</span></td>
            </tr>
        </table>

        <div class="band">Importador / exportador</div>
        <table class="grid">
            <tr>
                <td style="width:25%"><span class="lbl">RFC</span><span class="val">{{ $pedimento->rfc_operador }}</span></td>
                <td style="width:75%"><span class="lbl">Nombre</span><span class="val">{{ $pedimento->nombre_operador }}</span></td>
            </tr>
            <tr>
                <td colspan="2"><span class="lbl">Domicilio</span><span class="val">{{ $pedimento->domicilio_operador }}</span></td>
            </tr>
        </table>

        <div class="band">Valores y transporte</div>
        <table class="grid">
            <tr>
                <td style="width:16%"><span class="lbl">Valor USD</span><span class="val-n">{{ number_format((float)$pedimento->valor_dolares, 2) }}</span></td>
                <td style="width:16%"><span class="lbl">Valor aduana</span><span class="val-n">{{ number_format((float)$pedimento->valor_aduana, 2) }}</span></td>
                <td style="width:16%"><span class="lbl">Comercial</span><span class="val-n">{{ number_format((float)$pedimento->valor_comercial, 2) }}</span></td>
                <td style="width:12%"><span class="lbl">Moneda</span><span class="val">{{ $pedimento->moneda_clave }}</span></td>
                <td style="width:12%"><span class="lbl">Incoterm</span><span class="val">{{ $pedimento->incoterm_clave }}</span></td>
                <td style="width:14%"><span class="lbl">P. origen</span><span class="val">{{ $pedimento->pais_origen_clave }}</span></td>
                <td style="width:14%"><span class="lbl">Medio</span><span class="val">{{ $pedimento->medio_transporte_clave }}</span></td>
            </tr>
            <tr>
                <td><span class="lbl">Fletes</span><span class="val-n">{{ number_format((float)$pedimento->fletes, 2) }}</span></td>
                <td><span class="lbl">Seguros</span><span class="val-n">{{ number_format((float)$pedimento->seguros, 2) }}</span></td>
                <td><span class="lbl">Embalajes</span><span class="val-n">{{ number_format((float)$pedimento->embalajes, 2) }}</span></td>
                <td colspan="2"><span class="lbl">Peso bruto (kg)</span><span class="val-n">{{ number_format((float)$pedimento->peso_bruto, 3) }}</span></td>
                <td colspan="2"><span class="lbl">Bultos</span><span class="val">{{ $pedimento->total_bultos }} — {{ $pedimento->marcas_bultos }}</span></td>
            </tr>
        </table>

        <div class="band">Proveedor y agente</div>
        <table class="grid">
            <tr>
                <td style="width:50%"><span class="lbl">Proveedor</span><span class="val">{{ $pedimento->proveedor_nombre }}</span></td>
                <td style="width:25%"><span class="lbl">ID fiscal</span><span class="val">{{ $pedimento->proveedor_id_fiscal }}</span></td>
                <td style="width:25%"><span class="lbl">Agente / patente</span><span class="val">{{ $pedimento->agente_nombre }} ({{ $pedimento->agente_patente }})</span></td>
            </tr>
        </table>

        <div class="band">Partidas</div>
        <table class="grid">
            <tr>
                <th style="width:5%">#</th>
                <th style="width:12%">Fracción</th>
                <th style="width:35%">Descripción</th>
                <th style="width:12%">Cantidad</th>
                <th style="width:10%">UM</th>
                <th style="width:13%">V. comercial</th>
                <th style="width:13%">V. aduana</th>
            </tr>
            @forelse ($pedimento->partidas as $p)
                <tr>
                    <td class="ctr">{{ $p->secuencia }}</td>
                    <td class="ctr">{{ $p->fraccion }}</td>
                    <td class="tiny">{{ $p->descripcion }}</td>
                    <td class="num">{{ number_format((float)$p->cantidad, 3) }}</td>
                    <td class="ctr">{{ $p->unidad ?: $p->umc }}</td>
                    <td class="num">{{ number_format((float)$p->valor_comercial, 2) }}</td>
                    <td class="num">{{ number_format((float)$p->valor_aduana, 2) }}</td>
                </tr>
            @empty
                <tr><td colspan="7" class="ctr tiny">Sin partidas</td></tr>
            @endforelse
        </table>

        @if ($pedimento->observaciones)
            <div class="band">Observaciones</div>
            <table class="grid"><tr><td class="tiny">{{ $pedimento->observaciones }}</td></tr></table>
        @endif

        <div class="footer-leyenda">DOCUMENTO SIN VALOR JUDICIAL</div>
        <div class="footer-meta">
            Simulación académica AduanaSim · No constituye pedimento oficial · Estatus: {{ $pedimento->etiquetaEstatus() }} · {{ now()->format('d/m/Y H:i:s') }}
        </div>
    </div>
</body>
</html>
