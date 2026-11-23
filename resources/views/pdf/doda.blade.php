<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>DODA {{ $doda->folio }}</title>
    <style>
        @page { margin: 10mm 10mm; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 8px; color: #0b1f33; margin: 0; }
        table.outer { width: 100%; border-collapse: collapse; border: 2px solid #0b1f33; }
        table.outer > tbody > tr > td { border: 1px solid #0b1f33; padding: 4px 6px; vertical-align: top; }
        .title-bar {
            background: #0b1f33; color: #fff; text-align: center;
            font-size: 11px; font-weight: bold; letter-spacing: 1px; padding: 6px;
        }
        .title-bar span { color: #5eead4; font-size: 7.5px; display: block; margin-top: 2px; font-weight: normal; letter-spacing: 0.3px; }
        .lbl { display: block; font-size: 6.5px; color: #475569; text-transform: uppercase; font-weight: bold; margin-bottom: 2px; }
        .val { font-size: 10px; font-weight: bold; color: #0b1f33; }
        .val-sm { font-size: 8px; font-weight: bold; }
        .qr-box {
            width: 110px; height: 110px; border: 2px dashed #0d9488;
            text-align: center; vertical-align: middle; margin: 0 auto;
            background: #f0fdfa; padding-top: 28px; font-size: 8px; color: #0d9488; font-weight: bold;
        }
        .sec-head {
            background: #e6f7f5; font-weight: bold; font-size: 7.5px;
            text-transform: uppercase; color: #0b1f33;
        }
        .mono { font-family: DejaVu Sans Mono, monospace; font-size: 7px; word-break: break-all; }
        .warn {
            margin-top: 8px; border: 1.5px solid #0d9488; background: #f0fdfa;
            padding: 6px; text-align: center; font-size: 8.5px; font-weight: bold;
        }
        .foot { text-align: center; font-size: 6.5px; color: #64748b; margin-top: 4px; }
        .brand-row { width: 100%; border-collapse: collapse; margin-bottom: 4px; }
        .brand-row td { border: none; vertical-align: middle; padding: 0 0 4px 0; }
        img.logo { height: 36px; }
        .tiny { font-size: 7px; }
        table.inner { width: 100%; border-collapse: collapse; }
        table.inner td { border: 1px solid #94a3b8; padding: 3px 4px; }
    </style>
</head>
<body>
    <table class="brand-row">
        <tr>
            <td style="width:40%">
                @php $logo = public_path('images/aduanasim-logo1.png'); @endphp
                @if (file_exists($logo))
                    <img class="logo" src="{{ $logo }}" alt="AduanaSim">
                @else
                    <strong style="color:#0d9488;font-size:14px">ADUANASIM</strong>
                @endif
            </td>
            <td style="width:60%; text-align:right; font-size:7.5px; color:#64748b">
                Simulador académico de despacho aduanero<br>
                {{ now()->format('d/m/Y H:i:s') }}
            </td>
        </tr>
    </table>

    <table class="outer">
        <tr>
            <td colspan="3" class="title-bar">
                DOCUMENTO DE OPERACIÓN PARA DESPACHO ADUANERO
                <span>Página 1 de 1 · Simulación AduanaSim</span>
            </td>
        </tr>
        <tr>
            <td style="width:38%">
                <span class="lbl">N° de integración</span>
                <span class="val">{{ $doda->numero_operacion ?: preg_replace('/\D/','',$doda->folio) ?: $doda->id }}</span>
            </td>
            <td style="width:32%">
                <span class="lbl">Patente o autorización</span>
                <span class="val">{{ $doda->patente ?: '—' }}</span>
            </td>
            <td style="width:30%; text-align:center" rowspan="3">
                <span class="lbl">Código de barras / QR DODA</span>
                <div class="qr-box">
                    QR DODA<br>
                    <span style="font-size:6.5px;color:#0b1f33">{{ $doda->folio }}</span>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <span class="lbl">Fecha de emisión</span>
                <span class="val">{{ optional($doda->fecha_operacion)->format('Y/m/d') ?: optional($doda->created_at)->format('Y/m/d H:i:s') }}</span>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <span class="lbl">N° total de pedimentos y/o avisos consolidados de la operación</span>
                <span class="val">{{ $doda->pedimentos->count() }}</span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="lbl">Contenedores / equipo / N° económico del vehículo</span>
                <span class="val-sm">{{ $doda->placa_o_identificacion ?: '—' }}</span>
                <div class="tiny" style="margin-top:3px">Medio: {{ $doda->medio_transporte_clave ?: '—' }}</div>
            </td>
            <td>
                <span class="lbl">Candados</span>
                <span class="val-sm">SIN CANDADOS</span>
            </td>
            <td>
                <span class="lbl">Sección aduanera de despacho</span>
                <span class="val">{{ $doda->aduana_clave ?: '—' }}</span>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <span class="lbl">Pedimentos asociados</span>
                @if($doda->pedimentos->isEmpty())
                    <div class="tiny">Sin pedimentos vinculados</div>
                @else
                    <table class="inner" style="margin-top:3px">
                        <tr class="sec-head">
                            <td style="width:8%">#</td>
                            <td style="width:40%">Folio</td>
                            <td style="width:26%">Operación</td>
                            <td style="width:26%">Estatus</td>
                        </tr>
                        @foreach($doda->pedimentos as $i => $p)
                            <tr>
                                <td style="text-align:center">{{ $i+1 }}</td>
                                <td><strong>{{ $p->folio }}</strong></td>
                                <td>{{ $p->tipo_operacion }}</td>
                                <td>{{ $p->etiquetaEstatus() }}</td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <span class="lbl">Cadena original</span>
                <div class="mono">
                    {{ $doda->cadena_qr ?: '||'.($doda->aduana_clave?:'000').'|'.($doda->patente?:'0').'|'.($doda->numero_operacion?:$doda->id).'|'.$doda->folio.'|'.optional($doda->fecha_operacion)->format('Y-m-d H:i:s').'||' }}
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <span class="lbl">Firma del representante legal, agente o apoderado</span>
                <div style="height:28px"></div>
                <span class="lbl">N° de serie del certificado (simulado)</span>
                <div class="mono">SIM-{{ str_pad((string)$doda->id, 12, '0', STR_PAD_LEFT) }}</div>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <span class="lbl">Sello digital (simulado)</span>
                <div class="mono">{{ $doda->codigo_barras ?: strtoupper(substr(hash('sha256', $doda->folio.'|'.$doda->id), 0, 96)) }}</div>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <span class="lbl">Sello del SAT (simulado — sin validez)</span>
                <div class="mono">{{ strtoupper(substr(hash('sha256', 'SAT|'.$doda->folio), 0, 96)) }}</div>
            </td>
        </tr>
        @if($doda->observaciones)
        <tr>
            <td colspan="3">
                <span class="lbl">Observaciones</span>
                <div class="tiny">{{ $doda->observaciones }}</div>
            </td>
        </tr>
        @endif
    </table>

    <div class="warn">DOCUMENTO SIN VALOR JUDICIAL — No constituye DODA oficial ni produce efectos ante la autoridad aduanera</div>
    <div class="foot">AduanaSim · Folio {{ $doda->folio }} · Estatus {{ $doda->etiquetaEstatus() }} · Generado {{ now()->format('d/m/Y H:i:s') }}</div>
</body>
</html>
