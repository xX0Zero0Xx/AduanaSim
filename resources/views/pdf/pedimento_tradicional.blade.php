<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Pedimento {{ $pedimento->folio }} — Tradicional</title>
    <style>
        @page { margin: 8mm 8mm; }
        * { box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 7.5px; color: #0b1f33; margin: 0; }
        .banner {
            background: #0b1f33; color: #fff; text-align: center;
            padding: 4px 6px; font-size: 7px; letter-spacing: 0.4px; margin-bottom: 4px;
        }
        .banner strong { color: #5eead4; }
        table.box { width: 100%; border-collapse: collapse; margin-bottom: 3px; table-layout: fixed; }
        table.box td, table.box th {
            border: 1px solid #0b1f33; padding: 2px 3px; vertical-align: top;
        }
        .sec {
            background: #0d9488; color: #fff; font-weight: bold; font-size: 7px;
            text-transform: uppercase; letter-spacing: 0.3px; padding: 2px 4px;
            border: 1px solid #0b1f33;
        }
        .sec-light { background: #e6f7f5; color: #0b1f33; font-weight: bold; font-size: 6.5px; text-transform: uppercase; }
        .lbl { display: block; font-size: 5.5px; color: #475569; text-transform: uppercase; margin-bottom: 1px; }
        .val { font-size: 8px; font-weight: bold; color: #0b1f33; min-height: 9px; }
        .val-n { font-size: 8px; font-weight: bold; text-align: right; }
        .ctr { text-align: center; }
        .num { text-align: right; }
        .tiny { font-size: 6.5px; }
        .head-row { width: 100%; border-collapse: collapse; margin-bottom: 3px; }
        .head-row td { border: 1px solid #0b1f33; padding: 3px 4px; vertical-align: middle; }
        .logo-cell { width: 18%; text-align: center; background: #f8fafc; }
        .logo-cell img { height: 36px; }
        .title-cell { width: 52%; text-align: center; }
        .title-cell h1 { margin: 0; font-size: 13px; color: #0b1f33; letter-spacing: 1px; }
        .title-cell .sub { font-size: 7px; color: #0d9488; font-weight: bold; margin-top: 2px; }
        .meta-cell { width: 30%; font-size: 6.5px; }
        .warn {
            margin-top: 6px; border: 1.5px solid #0d9488; background: #f0fdfa;
            padding: 5px; text-align: center; font-size: 8px; font-weight: bold; color: #0b1f33;
        }
        .foot { margin-top: 3px; text-align: center; font-size: 6px; color: #64748b; }
        .barcode-sim {
            font-family: DejaVu Sans Mono, monospace; font-size: 10px; letter-spacing: 1px;
            border: 1px solid #0b1f33; padding: 3px; text-align: center; background: #fff;
        }
        .cert-box {
            border: 2px solid #0d9488; text-align: center; padding: 8px 4px;
            background: #f0fdfa; font-weight: bold; color: #0d9488; font-size: 8px;
        }
    </style>
</head>
<body>
    <div class="banner">
        SIMULADOR ACADÉMICO ADUANASIM — <strong>DOCUMENTO DE PRUEBA, SIN VALIDEZ OFICIAL NI PARA PAGO</strong>
    </div>

    <table class="head-row">
        <tr>
            <td class="logo-cell">
                @php $logo = public_path('images/aduanasim-logo1.png'); @endphp
                @if (file_exists($logo))
                    <img src="{{ $logo }}" alt="AduanaSim">
                @else
                    <strong style="color:#0d9488;font-size:11px">ADUANASIM</strong>
                @endif
            </td>
            <td class="title-cell">
                <h1>PEDIMENTO</h1>
                <div class="sub">FORMATO TRADICIONAL · SIMULACIÓN ACADÉMICA</div>
            </td>
            <td class="meta-cell">
                <span class="lbl">Referencia AduanaSim</span>
                <span class="val">{{ $pedimento->folio }}</span>
                <span class="lbl" style="margin-top:3px">Página</span>
                <span class="val">1 de 1</span>
            </td>
        </tr>
    </table>

    <table class="box">
        <tr>
            <td style="width:22%"><span class="lbl">Núm. pedimento</span><span class="val">{{ $pedimento->folio }}</span></td>
            <td style="width:10%"><span class="lbl">T. oper.</span><span class="val">{{ strtoupper(substr($pedimento->tipo_operacion ?? 'IMP', 0, 3)) }}</span></td>
            <td style="width:12%"><span class="lbl">Cve. pedimento</span><span class="val">{{ $pedimento->clave_pedimento }}</span></td>
            <td style="width:12%"><span class="lbl">Régimen</span><span class="val">{{ $pedimento->regimen_clave }}</span></td>
            <td style="width:12%"><span class="lbl">Destino/origen</span><span class="val">{{ $pedimento->destino_clave }}</span></td>
            <td style="width:14%"><span class="lbl">Tipo cambio</span><span class="val-n">{{ number_format((float)$pedimento->tipo_cambio, 5) }}</span></td>
            <td style="width:18%"><span class="lbl">Peso bruto / Aduana E/S</span><span class="val">{{ number_format((float)$pedimento->peso_bruto, 3) }} · {{ $pedimento->aduana_clave }}</span></td>
        </tr>
        <tr>
            <td colspan="3"><span class="lbl">Medios de transporte</span><span class="val">ENTRADA: {{ $pedimento->medio_entrada_clave ?: $pedimento->medio_transporte_clave }} &nbsp; ARRIBO: {{ $pedimento->medio_arribo_clave }} &nbsp; SALIDA: {{ $pedimento->medio_salida_clave }}</span></td>
            <td colspan="2"><span class="lbl">Valor dólares</span><span class="val-n">{{ number_format((float)$pedimento->valor_dolares, 2) }}</span></td>
            <td><span class="lbl">Precio pagado / comercial</span><span class="val-n">{{ number_format((float)($pedimento->precio_pagado ?: $pedimento->valor_comercial), 2) }}</span></td>
            <td><span class="lbl">Valor aduana</span><span class="val-n">{{ number_format((float)$pedimento->valor_aduana, 2) }}</span></td>
        </tr>
    </table>

    <div class="sec">Datos del importador / exportador</div>
    <table class="box">
        <tr>
            <td style="width:22%"><span class="lbl">RFC</span><span class="val">{{ $pedimento->rfc_operador }}</span></td>
            <td style="width:48%"><span class="lbl">Nombre, denominación o razón social</span><span class="val">{{ $pedimento->nombre_operador }}</span></td>
            <td style="width:30%"><span class="lbl">CURP</span><span class="val">{{ $pedimento->curp_operador }}</span></td>
        </tr>
        <tr>
            <td colspan="3"><span class="lbl">Domicilio</span><span class="val">{{ $pedimento->domicilio_operador }}</span></td>
        </tr>
    </table>

    <table class="box">
        <tr class="sec-light">
            <td colspan="5" class="ctr">Incrementables</td>
            <td colspan="5" class="ctr">Valores decrementables</td>
        </tr>
        <tr>
            <td><span class="lbl">Val. seguros</span><span class="val-n">{{ number_format((float)$pedimento->val_seguros, 2) }}</span></td>
            <td><span class="lbl">Seguros</span><span class="val-n">{{ number_format((float)$pedimento->seguros, 2) }}</span></td>
            <td><span class="lbl">Fletes</span><span class="val-n">{{ number_format((float)$pedimento->fletes, 2) }}</span></td>
            <td><span class="lbl">Embalajes</span><span class="val-n">{{ number_format((float)$pedimento->embalajes, 2) }}</span></td>
            <td><span class="lbl">Otros</span><span class="val-n">{{ number_format((float)$pedimento->otros_incrementables, 2) }}</span></td>
            <td><span class="lbl">Transporte</span><span class="val-n">0.00</span></td>
            <td><span class="lbl">Seguro</span><span class="val-n">0.00</span></td>
            <td><span class="lbl">Carga</span><span class="val-n">0.00</span></td>
            <td><span class="lbl">Descarga</span><span class="val-n">0.00</span></td>
            <td><span class="lbl">Otros</span><span class="val-n">0.00</span></td>
        </tr>
    </table>

    <table class="box">
        <tr>
            <td style="width:22%"><span class="lbl">Código de aceptación simulado</span>
                <div class="barcode-sim">{{ $pedimento->codigo_aceptacion ?: 'SIM'.strtoupper(substr(md5($pedimento->folio),0,6)) }}</div>
            </td>
            <td style="width:22%"><span class="lbl">Código de barras simulado</span>
                <div class="barcode-sim">Ped. {{ substr(preg_replace('/\D/','',$pedimento->folio).'0000000', -7) }}</div>
            </td>
            <td style="width:36%"><span class="lbl">Sección aduanera de despacho</span><span class="val">{{ $pedimento->aduana_clave }} {{ $pedimento->seccion_aduanera ? '/ '.$pedimento->seccion_aduanera : '' }}</span></td>
            <td style="width:20%"><span class="lbl">Total de bultos</span><span class="val">{{ $pedimento->total_bultos ?: '—' }} · {{ $pedimento->marcas_bultos }}</span></td>
        </tr>
    </table>

    <div class="sec">Datos del proveedor o comprador</div>
    <table class="box">
        <tr>
            <td style="width:20%"><span class="lbl">ID. fiscal</span><span class="val">{{ $pedimento->proveedor_id_fiscal }}</span></td>
            <td style="width:40%"><span class="lbl">Nombre o razón social</span><span class="val">{{ $pedimento->proveedor_nombre }}</span></td>
            <td style="width:25%"><span class="lbl">Domicilio</span><span class="val">{{ $pedimento->proveedor_domicilio }}</span></td>
            <td style="width:15%"><span class="lbl">Vinc / Met</span><span class="val">{{ $pedimento->vinculacion }} / —</span></td>
        </tr>
        <tr>
            <td><span class="lbl">Núm. factura / documento</span><span class="val">{{ $pedimento->cfdi_numero }}</span></td>
            <td><span class="lbl">Fecha / Incoterm / Moneda</span><span class="val">{{ optional($pedimento->cfdi_fecha)->format('Y-m-d') }} | {{ $pedimento->incoterm_clave }} | {{ $pedimento->moneda_clave }}</span></td>
            <td colspan="2"><span class="lbl">Valor dólares factura</span><span class="val-n">{{ number_format((float)$pedimento->cfdi_valor_dolares, 2) }}</span></td>
        </tr>
    </table>

    <div class="sec">Partidas arancelarias</div>
    <table class="box">
        <tr class="sec-light">
            <td class="ctr" style="width:4%">No.</td>
            <td class="ctr" style="width:11%">Fracción</td>
            <td class="ctr" style="width:5%">NICO</td>
            <td style="width:30%">Descripción</td>
            <td class="ctr" style="width:9%">Cantidad</td>
            <td class="ctr" style="width:6%">UM</td>
            <td class="ctr" style="width:11%">V. unitario</td>
            <td class="ctr" style="width:12%">V. comercial</td>
            <td class="ctr" style="width:12%">V. aduana</td>
        </tr>
        @forelse($pedimento->partidas as $p)
            <tr>
                <td class="ctr">{{ $p->secuencia }}</td>
                <td class="ctr">{{ $p->fraccion }}</td>
                <td class="ctr">{{ $p->nico }}</td>
                <td class="tiny">{{ $p->descripcion }}</td>
                <td class="num">{{ number_format((float)$p->cantidad, 4) }}</td>
                <td class="ctr">{{ $p->unidad ?: $p->umc }}</td>
                <td class="num">{{ number_format((float)$p->precio_unitario, 2) }}</td>
                <td class="num">{{ number_format((float)$p->valor_comercial, 2) }}</td>
                <td class="num">{{ number_format((float)$p->valor_aduana, 2) }}</td>
            </tr>
        @empty
            <tr><td colspan="9" class="ctr tiny">Sin partidas capturadas</td></tr>
        @endforelse
    </table>

    <table class="box">
        <tr>
            <td style="width:55%">
                <span class="lbl">Agente aduanal / agencia</span>
                <span class="val">{{ $pedimento->agente_nombre }} · RFC: {{ $pedimento->agente_rfc }} · Patente: {{ $pedimento->agente_patente ?: $pedimento->patente }}</span>
            </td>
            <td style="width:20%" class="cert-box">CERTIFICACIONES<br><span style="font-size:7px;color:#0b1f33">SIMULACIÓN ACADÉMICA</span></td>
            <td style="width:25%">
                <span class="lbl">Estatus</span><span class="val">{{ $pedimento->etiquetaEstatus() }}</span>
                <span class="lbl">Capturista</span><span class="val">{{ $pedimento->user->name ?? '—' }}</span>
            </td>
        </tr>
    </table>

    @if($pedimento->observaciones)
        <div class="sec">Observaciones</div>
        <table class="box"><tr><td class="tiny">{{ $pedimento->observaciones }}</td></tr></table>
    @endif

    <div class="warn">DOCUMENTO SIN VALOR JUDICIAL — Solo fines académicos · No constituye pedimento oficial ni acredita pago</div>
    <div class="foot">AduanaSim · Generado {{ now()->format('d/m/Y H:i:s') }} · Folio {{ $pedimento->folio }}</div>
</body>
</html>
