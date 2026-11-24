<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>COVE {{ $cove->folio }}</title>
    <style>
        @page { margin: 10mm 10mm; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 8px; color: #0b1f33; margin: 0; }
        .header {
            background: #0b1f33; color: #fff; padding: 8px 10px; margin-bottom: 0;
        }
        .header-inner { width: 100%; border-collapse: collapse; }
        .header-inner td { border: none; vertical-align: middle; padding: 0; }
        .header .brand { font-size: 14px; font-weight: bold; letter-spacing: 0.5px; }
        .header .brand span { color: #5eead4; }
        .header .title { text-align: center; }
        .header .title h1 { margin: 0; font-size: 11px; font-weight: bold; }
        .header .title p { margin: 2px 0 0; font-size: 7.5px; color: #94a3b8; }
        .header .right { text-align: right; font-size: 7px; color: #94a3b8; }
        .bar {
            background: #0d9488; color: #fff; text-align: center; font-size: 7.5px;
            padding: 3px; font-weight: bold; letter-spacing: 0.3px; margin-bottom: 6px;
        }
        .sec {
            background: #e6f7f5; border: 1px solid #0d9488; border-bottom: none;
            font-weight: bold; font-size: 8px; padding: 3px 5px; color: #0b1f33;
            text-transform: uppercase;
        }
        table.g { width: 100%; border-collapse: collapse; margin-bottom: 5px; table-layout: fixed; }
        table.g td, table.g th { border: 1px solid #94a3b8; padding: 3px 5px; vertical-align: top; }
        .lbl { display: block; font-size: 6px; color: #64748b; text-transform: uppercase; }
        .val { font-size: 8.5px; font-weight: bold; color: #0b1f33; min-height: 10px; }
        .val-n { font-size: 8.5px; font-weight: bold; text-align: right; }
        .ctr { text-align: center; }
        .num { text-align: right; }
        .tiny { font-size: 7px; }
        .warn {
            margin-top: 10px; border: 1.5px solid #0d9488; background: #f0fdfa;
            padding: 6px; text-align: center; font-size: 8.5px; font-weight: bold;
        }
        .foot {
            margin-top: 8px; border-top: 2px solid #0b1f33; padding-top: 6px;
            width: 100%; border-collapse: collapse; font-size: 6.5px; color: #64748b;
        }
        .foot td { border: none; vertical-align: top; }
        img.logo { height: 32px; }
    </style>
</head>
<body>
    <div class="header">
        <table class="header-inner">
            <tr>
                <td style="width:22%">
                    @php $logo = public_path('images/aduanasim-logo1.png'); @endphp
                    @if (file_exists($logo))
                        <img class="logo" src="{{ $logo }}" alt="AduanaSim">
                    @else
                        <div class="brand">ADUANA<span>SIM</span></div>
                    @endif
                </td>
                <td class="title" style="width:56%">
                    <h1>Información de Valor y de Comercialización</h1>
                    <p>Ventanilla digital mexicana de comercio exterior · Promoción o solicitud en materia de comercio</p>
                </td>
                <td class="right" style="width:22%">
                    Simulación académica<br>{{ now()->format('d/m/Y H:i') }}
                </td>
            </tr>
        </table>
    </div>
    <div class="bar">DOCUMENTO SIN VALOR JUDICIAL · COVE ACADÉMICO ADUANASIM</div>

    <div class="sec">Datos del Acuse de Valor</div>
    <table class="g">
        <tr>
            <td style="width:28%"><span class="lbl">Folio COVE</span><span class="val">{{ $cove->folio }}</span></td>
            <td style="width:24%"><span class="lbl">Tipo de operación</span><span class="val">{{ optional($cove->pedimento)->tipo_operacion ?: 'importacion' }}</span></td>
            <td style="width:24%"><span class="lbl">Relación de facturas</span><span class="val">{{ $cove->facturas->isEmpty() ? 'SIN RELACIÓN DE FACTURAS' : $cove->facturas->count().' factura(s)' }}</span></td>
            <td style="width:24%"><span class="lbl">No. de factura</span><span class="val">{{ optional($cove->facturas->first())->numero_factura ?: '—' }}</span></td>
        </tr>
        <tr>
            <td><span class="lbl">Tipo de figura</span><span class="val">Capturista / Agente (simulado)</span></td>
            <td><span class="lbl">Fecha exp.</span><span class="val">{{ optional(optional($cove->facturas->first())->fecha_factura)->format('d/m/Y') ?: optional($cove->created_at)->format('d/m/Y') }}</span></td>
            <td colspan="2"><span class="lbl">Observaciones</span><span class="val">{{ $cove->observaciones ?: '—' }}</span></td>
        </tr>
        <tr>
            <td colspan="2"><span class="lbl">Pedimento vinculado</span><span class="val">{{ optional($cove->pedimento)->folio ?: 'Sin pedimento vinculado' }}</span></td>
            <td><span class="lbl">Moneda</span><span class="val">{{ $cove->moneda_clave }}</span></td>
            <td><span class="lbl">Valor total</span><span class="val-n">{{ number_format((float)$cove->valor_total, 2) }}</span></td>
        </tr>
    </table>

    <div class="sec">RFC con permisos de consulta / Emisor</div>
    <table class="g">
        <tr>
            <td style="width:30%"><span class="lbl">RFC de consulta / Emisor</span><span class="val">{{ $cove->emisor_rfc }}</span></td>
            <td style="width:70%"><span class="lbl">Nombre o Razón social</span><span class="val">{{ $cove->emisor_nombre }}</span></td>
        </tr>
    </table>

    <div class="sec">Datos de la factura</div>
    <table class="g">
        <tr style="background:#f8fafc">
            <th style="width:28%">No. factura</th>
            <th style="width:22%">Fecha</th>
            <th style="width:20%">Moneda</th>
            <th style="width:30%">Valor</th>
        </tr>
        @forelse($cove->facturas as $f)
            <tr>
                <td class="val">{{ $f->numero_factura }}</td>
                <td>{{ optional($f->fecha_factura)->format('d/m/Y') }}</td>
                <td class="ctr">{{ $f->moneda_clave }}</td>
                <td class="num val">{{ number_format((float)$f->valor, 2) }}</td>
            </tr>
        @empty
            <tr><td colspan="4" class="ctr tiny">Sin facturas registradas</td></tr>
        @endforelse
    </table>

    <div class="sec">Datos generales del proveedor (emisor)</div>
    <table class="g">
        <tr>
            <td style="width:25%"><span class="lbl">Tipo de identificador</span><span class="val">RFC / TAX ID</span></td>
            <td style="width:30%"><span class="lbl">Tax ID / RFC / CURP</span><span class="val">{{ $cove->emisor_rfc }}</span></td>
            <td style="width:45%"><span class="lbl">Nombre(s) o Razón Social</span><span class="val">{{ $cove->emisor_nombre }}</span></td>
        </tr>
    </table>

    <div class="sec">Datos generales del destinatario</div>
    <table class="g">
        <tr>
            <td style="width:25%"><span class="lbl">Tipo de identificador</span><span class="val">RFC</span></td>
            <td style="width:30%"><span class="lbl">Tax ID / RFC / CURP</span><span class="val">{{ $cove->destinatario_rfc }}</span></td>
            <td style="width:45%"><span class="lbl">Nombre(s) o Razón Social</span><span class="val">{{ $cove->destinatario_nombre }}</span></td>
        </tr>
    </table>

    <div class="sec">Datos de la mercancía</div>
    <table class="g">
        <tr style="background:#f8fafc">
            <th class="ctr" style="width:6%">#</th>
            <th style="width:34%">Descripción genérica</th>
            <th class="ctr" style="width:12%">Clave UMC</th>
            <th class="ctr" style="width:12%">Cantidad</th>
            <th class="ctr" style="width:12%">Fracción</th>
            <th class="ctr" style="width:12%">Valor unit.</th>
            <th class="ctr" style="width:12%">Valor total</th>
        </tr>
        @forelse($cove->mercancias as $m)
            <tr>
                <td class="ctr">{{ $m->secuencia }}</td>
                <td class="tiny">{{ $m->descripcion }}</td>
                <td class="ctr">{{ $m->unidad }}</td>
                <td class="num">{{ number_format((float)$m->cantidad, 3) }}</td>
                <td class="ctr">{{ $m->fraccion }}</td>
                <td class="num">{{ $m->cantidad > 0 ? number_format((float)$m->valor / (float)$m->cantidad, 6) : '0.00' }}</td>
                <td class="num">{{ number_format((float)$m->valor, 2) }}</td>
            </tr>
        @empty
            <tr><td colspan="7" class="ctr tiny">Sin mercancías registradas</td></tr>
        @endforelse
    </table>

    <div class="warn">DOCUMENTO SIN VALOR JUDICIAL — Simulación académica AduanaSim</div>

    <table class="foot">
        <tr>
            <td style="width:33%"><strong style="color:#0b1f33">ADUANASIM</strong><br>Simulador académico</td>
            <td style="width:34%; text-align:center">Estatus: {{ $cove->etiquetaEstatus() }}<br>Folio {{ $cove->folio }}</td>
            <td style="width:33%; text-align:right">Generado {{ now()->format('d/m/Y H:i:s') }}</td>
        </tr>
    </table>
</body>
</html>
