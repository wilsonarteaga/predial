<!DOCTYPE html>
<html>
<head>
    <title>Factura acuerdo de pago predial</title>
    <style>
        @page {
            margin: 0;
        }
        * { padding: 0; margin: 0; }
        @font-face{
            font-family:"LATAM Sans";
            src:url({{ storage_path('fonts/latamsans/latam_sans_regular-webfont.woff') }}) format("woff"),url({{ storage_path('fonts/latamsans/latam_sans_regular-webfont.ttf') }}) format("truetype");
            font-weight:400;
            font-style:normal
        }

        @font-face{
            font-family:"LATAM Sans";
            src:url({{ storage_path('fonts/latamsans/latam_sans_regular_italic-webfont.woff') }}) format("woff"),url({{ storage_path('fonts/latamsans/latam_sans_regular_italic-webfont.ttf') }}) format("truetype");
            font-weight:400;
            font-style:italic
        }

        @font-face{
            font-family:"LATAM Sans";
            src:url({{ storage_path('fonts/latamsans/latam_sans_light-webfont.woff') }}) format("woff"),url({{ storage_path('fonts/latamsans/latam_sans_light-webfont.ttf') }}) format("truetype");
            font-weight:300;
            font-style:normal
        }

        @font-face{
            font-family:"LATAM Sans";
            src:url({{ storage_path('fonts/latamsans/latam_sans_light_italic-webfont.woff') }}) format("woff"),url({{ storage_path('fonts/latamsans/latam_sans_light_italic-webfont.ttf') }}) format("truetype");
            font-weight:300;
            font-style:italic
        }

        @font-face{
            font-family:"LATAM Sans";
            src:url({{ storage_path('fonts/latamsans/latam_sans_bold-webfont.woff') }}) format("woff"),url({{ storage_path('fonts/latamsans/latam_sans_bold-webfont.ttf') }}) format("truetype");
            font-weight:700;
            font-style:normal
        }

        @font-face{
            font-family:"LATAM Sans";
            src:url({{ storage_path('fonts/latamsans/latam_sans_bold_italic-webfont.woff') }}) format("woff"),url({{ storage_path('fonts/latamsans/latam_sans_bold_italic-webfont.ttf') }}) format("truetype");
            font-weight:700;
            font-style:italic
        }

        @font-face{
            font-family:"LATAM Sans Extended";
            src:url({{ storage_path('fonts/latamsans/latam_sans_extended-webfont.woff') }}) format("woff"),url({{ storage_path('fonts/latamsans/latam_sans_extended-webfont.ttf') }}) format("truetype");
            font-weight:400
        }

        html,
        body {
            font-family: 'LATAM Sans';
            padding: 10px;
            margin: 10px;
            /* margin:0;
            padding:0; */
            height:100%;
        }
        #container {
            min-height:100%;
            position:relative;
        }
        #header {
            padding:10px;
        }
        #body {
            padding:10px;
        }
        #footer {
            position:absolute;
            bottom:0;
            width:100%;
            height:35px;   /* Height of the footer */
            text-align: center;
            font-size: 80%;
            border-top: 1px solid #c0c0c0;
        }

		/* div.page { width:100%; padding-top: 5%; padding-bottom: 100px; margin: 0 auto; } */
        th, td { border: 1px solid #000000; }
        table { border-collapse: collapse; font-size: 80%; width: 100%; }
        td { padding: 1px; }
        th { padding: 1px; background-color: #f3efef; }
		p.header { width: 100%; text-align:center; font-weight: bold; padding: 0px; margin: 0px; font-size: 140%; }
        p.previa { color: tomato; width: 100%; text-align:left; font-weight: bold; padding: 0px; margin: 0px; }
		h3.title { width: 100%; text-align:left; }

        table.no-border tr td { border: 0px; }
        table.table-header tr td { border: 0px; }
		table.titles tr td { border: 0px; font-size: 80%; }

		table.info-predio tr th { border: 0px; background-color: #f3efef; }
		table.info-predio tr td { border: 0px; background-color: #f3efef; }
        table.info-predio tr th { white-space: nowrap; font-size: 73%; text-align: left; }
		table.info-predio tr td { text-align:left; font-size: 73%; }

        table.info-pagos tr th { white-space: nowrap; font-size: 70%; }
		table.info-pagos tr td { text-align:right; font-size: 70%; }
		table.info-pagos tr.totales th { text-align:right; }

        table.info-resumen tr th { white-space: nowrap; font-size: 80%; padding: 0px; }
		table.info-resumen tr td { white-space: nowrap; font-size: 80%; padding: 0px; padding-left: 3px; }

		table.info-alcaldia tr td { border: 0px; text-align: center; font-size: 80%; }

		table.info-codigo-barras tr td { border: 0px; text-align: center; font-size: 80%; }

        table.info-persona-barras tr th { width: 30%; border: 0px; text-align: left; white-space: nowrap; font-size: 110%; padding: 0px; background-color: #ffffff; }
        table.info-persona-barras tr td { border: 0px; text-align: left; white-space: nowrap; font-size: 110%; padding: 0px; background-color: #ffffff; }

        .info { font-size: 70%; }
		.negrilla {font-weight: bold;}
		.marca-agua { color: #c0c0c0;}

        .div-codigos {
            position: absolute;
            top: 37%;
        }

        .logo {
            position: absolute;
            top: 0px;
        }

    </style>
</head>
@php($numero_codigos = 1)
<body>
    <div id="container">
        <div id="header">
            <table class="table-header">
                <tr>
                    <td style="width: 10%; text-align: left; vertical-align: bottom; border: 0px solid black;">
                        <img class="logo" style="width: 90%; height: auto;" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/theme/plugins/images/'. $logo))) }}" alt="Logo" />
                    </td>
                    <td>
                        <table>
                            <tr>
                                <td>
                                    <p class="header" style="font-size: 87%;">
                                        LIQUIDACI&Oacute;N OFICIAL No. {{ $numero_factura_acuerdo }}
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="header" style="font-size: 92%;">
                                        FACTURA DE ACUERDO DE PAGO
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p class="header">
                                        ACUERDO DE PAGO N&Uacute;MERO {{ $acuerdo_pago->numero_acuerdo }}
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: justify; font-size: 85%;">
                                    <p>
                                        <br /><br /><br />
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div id="body">
            <table class="info-predio" style="width: 100%; margin-top: 15px;">
                <tr>
                    <th style="width: 15%;">C&Oacute;DIGO CATASTRAL:</th>
                    <td style="width: 35%;">{{ $predio->codigo_predio }}</td>
                    <th style="width: 15%;">C&Oacute;DIGO ANTERIOR:</th>
                    <td style="width: 35%;">{{ $predio->codigo_predio_anterior != null ? $predio->codigo_predio_anterior : '' }}</td>
                </tr>
                <tr>
                    <th>PROPIETARIO:</th>
                    <td>{{ $predio->propietarios }}</td>
                    <th>C.C. O NIT:</th>
                    <td>{{ $predio->identificaciones }}</td>
                </tr>
                <tr>
                    <th>DIRECCI&Oacute;N DE COBRO:</th>
                    <td></td>
                    <th>DIRECCI&Oacute;N:</th>
                    <td>{{ $predio->direccion }}</td>
                </tr>
            </table>
            <table class="info-predio" style="width: 100%; margin-top: 5px;">
                <tr>
                    <th style="width: 15%;">No RECIBO ANT</th>
                    <th style="width: 15%;">A&Ntilde;OS A PAGAR</th>
                    <th style="width: 15%;">PAGUE ANTES DE</th>
                    <th style="width: 5%;"></th>
                    <th>&Aacute;REA HA</th>
                    <td>{{ number_format($predio->area_hectareas, 0) }}</td>
                    <th>&Aacute;REA M2</th>
                    <td>{{ number_format($predio->area_metros, 0) }}</td>
                    <th>CONSTRUIDA</th>
                    <td>{{ number_format($predio->area_construida, 0) }}</td>
                </tr>
                <tr>
                    <td>{{ $ultima_cuota_pagada->factura_pago }}</td>
                    <td>{{ $predio->anios_a_pagar }}</td>
                    <td>{{ substr($fecha_pago_hasta, 0, 10) }}</td>
                    <td></td>
                    <th>&Uacute;LT CUOTA PAG</th>
                    <td>{{ $ultima_cuota_pagada->cuota_numero }}</td>
                    <th>FECHA PAG</th>
                    <td>{{ $ultima_cuota_pagada->fecha_pago }}</td>
                    <th>VALOR PAGADO</th>
                    <td>@money($ultima_cuota_pagada->valor_cuota)</td>
                </tr>
            </table>
            <table class="info-pagos" style="width: 100%; margin-top: 10px;">
                <tr>
                    <th colspan="7" style="text-align: center;">DETALLE DE PAGO</th>
                </tr>
                <tr>
                    <th>CUOTA</th>
                    <th>AVAL&Uacute;O</th>
                    <th>IMPUESTO</th>
                    <th>INTER&Eacute;S</th>
                    <th>BOMBEROS</th>
                    <th>INTER&Eacute;S AP</th>
                    <th>TOTAL</th>
                </tr>
                <!----------------------------->
                @if(count($lista_pagos) > 0)
                    @php($suma_impuesto = 0)
                    @php($suma_interes = 0)
                    @php($suma_bomberos = 0)
                    @php($suma_interes_acuerdo = 0)
                    @php($suma_total = 0)
                    @foreach($lista_pagos as $pago)
                    <tr>
                        <td style="text-align: center;">{{ $pago->cuota_numero }}</td>
                        <td>@money($pago->avaluo)</td>
                        <td>@money($pago->impuesto)</td>
                        <td>@money($pago->interes)</td>
                        <td>@money($pago->bomberos)</td>
                        <td>@money($pago->interes_acuerdo)</td>
                        <td>@money($pago->total)</td>
                    </tr>
                    @php($suma_impuesto += $pago->impuesto)
                    @php($suma_interes += $pago->interes)
                    @php($suma_bomberos += $pago->bomberos)
                    @php($suma_interes_acuerdo += $pago->interes_acuerdo)
                    @php($suma_total += $pago->total)
                    @endforeach
                    <!----------------------------->
                    <tr class="totales">
                        <th colspan="2">TOTALES</th>
                        <th>@money($suma_impuesto)</th>
                        <th>@money($suma_interes)</th>
                        <th>@money($suma_bomberos)</th>
                        <th>@money($suma_interes_acuerdo)</th>
                        <th>@money($suma_total)</th>
                    </tr>
                @else
                <tr>
                    <td colspan="7" style="text-align: center;">No hay informaci&oacute;n disponible</td>
                </tr>
                @endif
            </table>
            <div style="padding-top: 0px; padding-bottom: 60px; width: 100%; text-align: left; font-size: 70%;">
                Los intereses deber&aacute;n ser cancelados de acuerdo al valor causado por cada d&iacute;a calendario de retardo hasta la fecha efectiva de pago.
            </div>
            @if(count($lista_pagos) > 0)
                <div class="div-codigos">
                @php($labels = ['-ENTIDAD-', '-BANCO-'])
                @php($numero_boletas = 2)
                @for ($boletas = 0; $boletas < $numero_boletas; $boletas++)
                    @if($boletas == 0)
                    <div class="negrilla" style="padding-top: 0px; padding-bottom: 0px; width: 100%; text-align: center; font-size: 54%;">
                        <span style="width: 50%;">-USUARIO-</span>
                        <span style="width: 50%; text-align: center; position: relative; float: right;">
                            @if($fecha == 'INDEFINIDA')
                            {{ $fecha }}
                            @else
                            {{ $fecha }}, {{ $hora }}
                            @endif
                        </span>
                    </div>
                    @endif
                    @if($numero_codigos > 0 && !$facturaYaPagada)
                        <hr style="border: 1px dashed #000;
                            padding-top: 5px;
                            border-style: none none dashed;
                            color: #fff;
                            background-color: #fff;" />
                        <table class="no-border" style="width: 100%; font-size: 70%;">
                            <tr>
                                <td style="width: 50%;"></td>
                                <td class="negrilla">Formulario No</td>
                                <td>{{ $numero_factura_acuerdo }}</td>
                                <td class="negrilla">Referencia No</td>
                                <td>{{ str_pad($numero_factura_acuerdo, 24, "0", STR_PAD_LEFT) }}</td>
                            </tr>
                        </table>
                        <table class="info-codigo-barras" style="width: 100%; margin-top: 0px;">
                            @for ($x = 0; $x < $numero_codigos; $x++)
                                <tr>
                                    @if($x == 0)
                                    <td>
                                        <table class="info-persona-barras" style="width: 100%; margin-top: 0px;">
                                            <tr>
                                                <td colspan="2" style="padding-bottom: 10px;">
                                                    <img style="width: 20%; height: auto;" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/theme/plugins/images/santa-rosa-de-viterbo-factura-horizontal-color.png'))) }}" alt="Logo1" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>C&Oacute;DIGO CATASTRAL:</th>
                                                <td>{{ $predio->codigo_predio }}</td>
                                            </tr>
                                            <tr>
                                                <th>PROPIETARIO:</th>
                                                <td>{{ $predio->propietarios }}</td>
                                            </tr>
                                            <tr>
                                                <th>C.C. O NIT:</th>
                                                <td>{{ $predio->identificaciones }}</td>
                                            </tr>
                                            <tr>
                                                <th>DIRECCI&Oacute;N DE COBRO</th>
                                                <td>{{ $predio->direccion }}</td>
                                            </tr>
                                        </table>
                                        @if($numero_codigos == 1)
                                        <table class="info-persona-barras" style="width: 100%; margin-top: 10px;">
                                            <tr><th colspan="2">PUNTOS DE PAGO:</th></tr>
                                            <tr><th>BANCO DE BOGOTA</th><td>57600004-6</td></tr>
                                        </table>
                                        @endif
                                    </td>
                                    @else
                                    <td>
                                        <table class="info-persona-barras" style="width: 100%; margin-top: 0px;">
                                            <tr><th colspan="2">PUNTOS DE PAGO:</th></tr>
                                            <tr><th>BANCO DE BOGOTA</th><td>57600004-6</td></tr>
                                        </table>
                                    </td>
                                    @endif
                                    <td style="width: 53%; padding-top: 0px; border: 0px solid #000; text-align: center;">
                                        <table style="width: 100%; font-size: 110%;">
                                            <tr>
                                                <td class="negrilla">Pague hasta {{ substr($fecha_pago_hasta, 0, 10) }}</td>
                                                <td class="negrilla" style="font-size: 120%;">@money($valor_factura)</td>
                                            </tr>
                                        </table>
                                        @if($temporal == 0)
                                        <img style="padding-left: 5px; padding-top: 5px;" src="data:image/png;base64,{{ DNS1D::getBarcodePNG($barras, 'C128') }}" height="77" width="371" />
                                        <span style="width: 100%; font-size: 80%;">{{ $barras_texto }}</span>
                                        @endif
                                        @if($x + 1 == $numero_codigos)
                                        <table style="width: 100%; font-size: 110%; padding-top: 10px;">
                                            <tr>
                                                <td class="negrilla">{{ $labels[$boletas] }}</td>
                                                <td class="negrilla">
                                                    @if($fecha == 'INDEFINIDA')
                                                    {{ $fecha }}
                                                    @else
                                                    {{ $fecha }}, {{ $hora }}
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                        @endif
                                    </td>
                                </tr>
                            @endfor
                        </table>
                    @endif
                @endfor
                </div>
            @else
                <table class="info-resumen" style="width: 100%; margin-top: 5px;">
                    <tr>
                        <td style="text-align: center;">NO HAY INFORMACI&Oacute;N DISPONIBLE PARA REALIZAR PAGO</td>
                    </tr>
                </table>
            @endif
        </div>
        <div id="footer">
            <span style="display: block; font-size: 70%;">Dise&ntilde;ado e impreso por SISTEMAS ERPSOFT SAS</span>
            @if($temporal > 0 || $facturaYaPagada)
                <span style="color: tomato; font-size: 70%; display: block;">
                    @if($temporal > 0)
                    VISTA PREVIA FACTURA DE COBRO - Documento no v&aacute;lido para la ejecuci&oacute;n del pago de impuesto predial.
                    @elseif ($facturaYaPagada && $informativa != '1')
                    PAGO DE FACTURA YA REGISTRADO. El predio se encuentra a paz y salvo.
                    @endif
                </span>
            @endif
        </div>
    </div>
</body>
</html>
