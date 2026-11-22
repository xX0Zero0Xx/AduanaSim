<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Pedimento {{ $pedimento->folio }} — Tradicional</title>
    <style>
        @page { margin: 12mm 10mm; }
        * { box-sizing: border-box; }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 8px;
            color: #000;
            margin: 0;
            position: relative;
        }
        .watermark {
            position: fixed;
            top: 42%;
            left: 8%;
            width: 84%;
            text-align: center;
            font-size: 28px;
            color: #c9c9c9;
            transform: rotate(-28deg);
            z-index: 0;
            letter-spacing: 2px;
            font-weight: bold;
            opacity: 0.45;
        }
        .content { position: relative; z-index: 1; }
        .header {
            border: 1.5px solid #000;
            padding: 4px 6px;
            margin-bottom: 4px;
        }
        .header-title {
            text-align: center;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 1px;
            margin: 0;
        }
        .header-sub {
            text-align: center;
            font-size: 7.5px;
            margin: 2px 0 0;
        }
        .band {
            background: #e8e8e8;
            border: 1px solid #000;
            border-bottom: none;
            font-weight: bold;
            font-size: 7.5px;
            padding: 2px 4px;
            text-transform: uppercase;
        }
        table.grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
            table-layout: fixed;
        }
        table.grid th, table.grid td {
            border: 1px solid #000;
            padding: 2px 3px;
            vertical-align: top;
            word-wrap: break-word;
        }
        table.grid th {
            background: #f0f0f0;
            font-size: 6.5px;
            font-weight: bold;
            text-transform: uppercase;
            text-align: left;
        }
        .lbl {
            display: block;
            font-size: 6px;
            color: #333;
            text-transform: uppercase;
            margin-bottom: 1px;
        }
        .val { font-size: 8px; font-weight: bold; min-height: 10px; }
        .val-n { font-size: 8px; font-weight: bold; text-align: right; }
        .tiny { font-size: 6.5px; }
        .footer-leyenda {
            margin-top: 10px;
            border: 1.5px solid #000;
            padding: 6px;
            text-align: center;
            font-size: 9px;
            font-weight: bold;
            letter-spacing: 0.5px;
            background: #fff;
        }
        .footer-meta {
            margin-top: 4px;
            text-align: center;
            font-size: 6.5px;
            color: #444;
        }
        .partidas th { text-align: center; font-size: 6px; }
        .partidas td { font-size: 7px; }
        .num { text-align: right; }
        .ctr { text-align: center; }
    </style>
</head>
<body>
    <div class="watermark">DOCUMENTO SIN VALOR JUDICIAL</div>

    <div class="content">
        <div class="header">
            <p class="header-title">PEDIMENTO ADUANERO — FORMATO TRADICIONAL</p>
            <p class="header-sub">
                AduanaSim · Simulador académico · Folio {{ $pedimento->folio }}
                · {{ strtoupper($pedimento->tipo_operacion ?? '') }}
                · {{ now()->format('d/m/Y H:i') }}
            </p>
        </div>

        {{-- Bloque identificación (Hoja 1 estilo) --}}
        <div class="band">1. Identificación del pedimento</div>
        <table class="grid">
            <tr>
                <td style="width:18%"><span class="lbl">Núm. pedimento</span><span class="val">{{ $pedimento->folio }}</span></td>
                <td style="width:12%"><span class="lbl">T. operación</span><span class="val">{{ strtoupper(substr($pedimento->tipo_operacion ?? '', 0, 3)) }}</span></td>
                <td style="width:12%"><span class="lbl">Cve. pedimento</span><span class="val">{{ $pedimento->clave_pedimento }}</span></td>
                <td style="width:12%"><span class="lbl">Régimen</span><span class="val">{{ $pedimento->regimen_clave }}</span></td>
                <td style="width:12%"><span class="lbl">Destino</span><span class="val">{{ $pedimento->destino_clave }}</span></td>
                <td style="width:14%"><span class="lbl">Tipo de cambio</span><span class="val-n">{{ number_format((float)$pedimento->tipo_cambio, 4) }}</span></td>
                <td style="width:20%"><span class="lbl">Peso bruto (kg)</span><span class="val-n">{{ number_format((float)$pedimento->peso_bruto, 3) }}</span></td>
            </tr>
            <tr>
                <td><span class="lbl">Aduana</span><span class="val">{{ $pedimento->aduana_clave }}</span></td>
                <td><span class="lbl">Sección</span><span class="val">{{ $pedimento->seccion_aduanera }}</span></td>
                <td><span class="lbl">Patente</span><span class="val">{{ $pedimento->patente }}</span></td>
                <td colspan="2"><span class="lbl">Medio transporte / entrada</span><span class="val">{{ $pedimento->medio_transporte_clave }} / {{ $pedimento->medio_entrada_clave }}</span></td>
                <td><span class="lbl">Arribo</span><span class="val">{{ $pedimento->medio_arribo_clave }}</span></td>
                <td><span class="lbl">Salida</span><span class="val">{{ $pedimento->medio_salida_clave }}</span></td>
            </tr>
        </table>

        <div class="band">2. Datos del importador / exportador</div>
        <table class="grid">
            <tr>
                <td style="width:22%"><span class="lbl">RFC</span><span class="val">{{ $pedimento->rfc_operador }}</span></td>
                <td style="width:48%"><span class="lbl">Nombre / razón social</span><span class="val">{{ $pedimento->nombre_operador }}</span></td>
                <td style="width:30%"><span class="lbl">CURP</span><span class="val">{{ $pedimento->curp_operador }}</span></td>
            </tr>
            <tr>
                <td colspan="3"><span class="lbl">Domicilio</span><span class="val">{{ $pedimento->domicilio_operador }}</span></td>
            </tr>
        </table>

        <div class="band">3. Valores, incrementables y moneda</div>
        <table class="grid">
            <tr>
                <td style="width:16%"><span class="lbl">Valor dólares</span><span class="val-n">{{ number_format((float)$pedimento->valor_dolares, 2) }}</span></td>
                <td style="width:16%"><span class="lbl">Valor aduana</span><span class="val-n">{{ number_format((float)$pedimento->valor_aduana, 2) }}</span></td>
                <td style="width:16%"><span class="lbl">Precio pagado</span><span class="val-n">{{ number_format((float)($pedimento->precio_pagado ?: $pedimento->valor_comercial), 2) }}</span></td>
                <td style="width:16%"><span class="lbl">Valor comercial</span><span class="val-n">{{ number_format((float)$pedimento->valor_comercial, 2) }}</span></td>
                <td style="width:12%"><span class="lbl">Moneda</span><span class="val">{{ $pedimento->moneda_clave }}</span></td>
                <td style="width:12%"><span class="lbl">Incoterm</span><span class="val">{{ $pedimento->incoterm_clave }}</span></td>
                <td style="width:12%"><span class="lbl">País origen</span><span class="val">{{ $pedimento->pais_origen_clave }}</span></td>
            </tr>
            <tr>
                <td><span class="lbl">Val. seguros</span><span class="val-n">{{ number_format((float)$pedimento->val_seguros, 2) }}</span></td>
                <td><span class="lbl">Seguros</span><span class="val-n">{{ number_format((float)$pedimento->seguros, 2) }}</span></td>
                <td><span class="lbl">Fletes</span><span class="val-n">{{ number_format((float)$pedimento->fletes, 2) }}</span></td>
                <td><span class="lbl">Embalajes</span><span class="val-n">{{ number_format((float)$pedimento->embalajes, 2) }}</span></td>
                <td colspan="2"><span class="lbl">Otros incrementables</span><span class="val-n">{{ number_format((float)$pedimento->otros_incrementables, 2) }}</span></td>
                <td><span class="lbl">País destino</span><span class="val">{{ $pedimento->pais_destino_clave }}</span></td>
            </tr>
        </table>

        <div class="band">4. Códigos, bultos y proveedor / comprador</div>
        <table class="grid">
            <tr>
                <td style="width:25%"><span class="lbl">Código de aceptación</span><span class="val">{{ $pedimento->codigo_aceptacion }}</span></td>
                <td style="width:25%"><span class="lbl">Código de barras</span><span class="val">{{ $pedimento->codigo_barras_pedimento }}</span></td>
                <td style="width:30%"><span class="lbl">Marcas de bultos</span><span class="val">{{ $pedimento->marcas_bultos }}</span></td>
                <td style="width:20%"><span class="lbl">Total bultos</span><span class="val-n">{{ $pedimento->total_bultos }}</span></td>
            </tr>
            <tr>
                <td><span class="lbl">ID fiscal proveedor</span><span class="val">{{ $pedimento->proveedor_id_fiscal }}</span></td>
                <td colspan="2"><span class="lbl">Nombre proveedor / comprador</span><span class="val">{{ $pedimento->proveedor_nombre }}</span></td>
                <td><span class="lbl">Vinculación</span><span class="val">{{ $pedimento->vinculacion }}</span></td>
            </tr>
            <tr>
                <td colspan="4"><span class="lbl">Domicilio proveedor</span><span class="val">{{ $pedimento->proveedor_domicilio }}</span></td>
            </tr>
        </table>

        <div class="band">5. CFDI / documento de valor y agente aduanal</div>
        <table class="grid">
            <tr>
                <td style="width:18%"><span class="lbl">CFDI / factura</span><span class="val">{{ $pedimento->cfdi_numero }}</span></td>
                <td style="width:14%"><span class="lbl">Fecha</span><span class="val">{{ optional($pedimento->cfdi_fecha)->format('d/m/Y') }}</span></td>
                <td style="width:16%"><span class="lbl">Valor moneda</span><span class="val-n">{{ number_format((float)$pedimento->cfdi_valor_moneda, 2) }}</span></td>
                <td style="width:14%"><span class="lbl">Factor</span><span class="val-n">{{ number_format((float)$pedimento->cfdi_factor_moneda, 6) }}</span></td>
                <td style="width:16%"><span class="lbl">Valor USD</span><span class="val-n">{{ number_format((float)$pedimento->cfdi_valor_dolares, 2) }}</span></td>
                <td style="width:22%"><span class="lbl">Patente agente</span><span class="val">{{ $pedimento->agente_patente }}</span></td>
            </tr>
            <tr>
                <td colspan="3"><span class="lbl">Nombre agente</span><span class="val">{{ $pedimento->agente_nombre }}</span></td>
                <td colspan="2"><span class="lbl">RFC agente</span><span class="val">{{ $pedimento->agente_rfc }}</span></td>
                <td><span class="lbl">CURP agente</span><span class="val">{{ $pedimento->agente_curp }}</span></td>
            </tr>
        </table>

        <div class="band">6. Partidas / mercancías</div>
        <table class="grid partidas">
            <thead>
                <tr>
                    <th style="width:4%">Seq</th>
                    <th style="width:10%">Fracción</th>
                    <th style="width:4%">NICO</th>
                    <th style="width:28%">Descripción</th>
                    <th style="width:8%">Cant.</th>
                    <th style="width:6%">UM</th>
                    <th style="width:10%">V. comercial</th>
                    <th style="width:10%">V. aduana</th>
                    <th style="width:8%">P. unit.</th>
                    <th style="width:6%">P. orig.</th>
                    <th style="width:6%">Mét.</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pedimento->partidas as $p)
                    <tr>
                        <td class="ctr">{{ $p->secuencia }}</td>
                        <td class="ctr">{{ $p->fraccion }}</td>
                        <td class="ctr">{{ $p->nico }}</td>
                        <td class="tiny">{{ $p->descripcion }}@if($p->marca) · {{ $p->marca }} {{ $p->modelo }}@endif</td>
                        <td class="num">{{ number_format((float)$p->cantidad, 3) }}</td>
                        <td class="ctr">{{ $p->unidad ?: $p->umc }}</td>
                        <td class="num">{{ number_format((float)$p->valor_comercial, 2) }}</td>
                        <td class="num">{{ number_format((float)$p->valor_aduana, 2) }}</td>
                        <td class="num">{{ number_format((float)$p->precio_unitario, 4) }}</td>
                        <td class="ctr">{{ $p->pais_origen_clave }}</td>
                        <td class="ctr">{{ $p->metodo_valoracion }}</td>
                    </tr>
                @empty
                    <tr><td colspan="11" class="ctr tiny">Sin partidas capturadas</td></tr>
                @endforelse
            </tbody>
        </table>

        @if ($pedimento->observaciones)
            <div class="band">7. Observaciones</div>
            <table class="grid">
                <tr><td class="tiny">{{ $pedimento->observaciones }}</td></tr>
            </table>
        @endif

        <div class="footer-leyenda">DOCUMENTO SIN VALOR JUDICIAL</div>
        <div class="footer-meta">
            Simulación académica AduanaSim · No constituye pedimento oficial ni produce efectos ante la autoridad aduanera ·
            Estatus: {{ $pedimento->etiquetaEstatus() }} · Generado {{ now()->format('d/m/Y H:i:s') }}
        </div>
    </div>
</body>
</html>
