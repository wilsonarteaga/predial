<!DOCTYPE html>
<html>
<head>
    <title>Factura predial</title>
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

        body { font-family: 'LATAM Sans'; padding: 10px; margin: 10px; }
		div.page { width:100%; padding-top: 5%; padding-bottom: 100px; margin: 0 auto; }
        th, td { border: 1px solid #000000; }
        table { border-collapse: collapse; font-size: 80%; width: 100%; }
        td { padding: 3px; }
        th { padding: 5px; background-color: #f3efef; }
		p.header { width: 100%; text-align:center; font-weight: bold; padding: 0px; margin: 0px; }
		h3.title { width: 100%; text-align:right; }
		table.titles tr td { border: 0px;  font-size: 80%; }

		table.info-predio tr th { white-space: nowrap; font-size: 70%; }
		table.info-predio tr td { text-align:center; font-size: 60%; }

        table.info-pagos tr th { white-space: nowrap; font-size: 70%; }
		table.info-pagos tr td { text-align:right; font-size: 60%; }
		table.info-pagos tr.totales th { text-align:right; }

        table.info-resumen tr th { white-space: nowrap; font-size: 80%; }
		table.info-resumen tr td { white-space: nowrap; font-size: 80%; }

		table.info-alcaldia tr td { border: 0px; text-align: center; font-size: 80%; }

		table.info-codigo-barras tr td { border: 0px; text-align: center; font-size: 80%; }

        .info { font-size: 70%; }
		.negrilla {font-weight: bold;}
		.marca-agua { color: #c0c0c0;}

    </style>
</head>
<body>
	<div class="page">
		<p class="header">
            SECRETARIA DE HACIENDA
        <p class="header">
            IMPUESTO PREDIAL UNIFICADO
        <p class="header">
            FACTURA DE COBRO</p>
		<table class="titles" style="width: 100%; margin-top: 30px;">
			<tr>
				<td style="width: 80%;">
					<h3 class="title">Fecha emisi&oacute;n:</h3>
				</td>
				<td>
					{{ $fecha }} {{ $hora }}
				</td>
			</tr>
			<tr>
				<td>
					<h3 class="title">No. factura:</h3>
				</td>
				<td>
					{{ $numero }}
				</td>
			</tr>
		</table>
		<table class="info-predio" style="width: 100%; margin-top: 15px;">
			<tr>
				<th style="width: 15%;">C&oacute;digo catastral</th>
				<th style="width: 19%;">Nuevo c&oacute;digo catastral</th>
				<th style="width: 10%;">Nit. / C.C.</th>
				<th style="width: 14%;">No. recibo ant.</th>
				<th style="width: 14%;">&Aacute;rea Ha.</th>
				<th style="width: 14%;">&Aacute;rea M2.</th>
				<th style="width: 14%;">&Aacute;rea Cont.</th>
			</tr>
			<tr>
				<td>{{ $predio->codigo_predio }}</td>
				<td>{{ $predio->codigo_predio }}</td>
				<td>{{ $predio->identificaciones }}</td>
				<td>{{ $ultimo_pago->factura_pago }}</td>
				<td>{{ number_format($predio->area_hectareas, 2) }}</td>
				<td>{{ number_format($predio->area_metros, 2) }}</td>
				<td>{{ number_format($predio->area_construida, 2) }}</td>
			</tr>
			<tr>
				<th colspan="3">Propietario</th>
				<th colspan="4">Direcci&oacute;n</th>
			</tr>
			<tr>
				<td colspan="3">{{ $predio->propietarios }}</td>
                <td colspan="4">{{ $predio->direccion }}</td>
			</tr>
        </table>
        <table class="info-predio" style="width: 100%; margin-top: 0px;">
			<tr>
                <th style="width: 20%;">A&ntilde;os a pagar</th>
                <th style="width: 20%;">Aval&uacute;o</th>
				<th style="width: 20%;">&Uacute;ltimo a&ntilde;o pago</th>
				<th style="width: 20%;">Fecha pago</th>
				<th style="width: 20%;">Valor pagado</th>
			</tr>
            <tr>
                <td>{{ $predio->anios_a_pagar }}</td>
				<td>@money($predio->avaluo)</td>
                <td>{{ $ultimo_pago->ultimo_anio }}</td>
                <td>{{ $ultimo_pago->fecha_pago }}</td>
                <td>@money($ultimo_pago->valor_pago)</td>
            </tr>
		</table>
		<table class="info-pagos" style="width: 100%; margin-top: 10px;">
			<tr>
				<th>A&Ntilde;O</th>
				<th>%M<br />TAR</th>
				<th>AVAL&Uacute;O</th>
				<th>IMPUESTO</th>
				<th>INTER&Eacute;S</th>
				<th>DSCTO</th>
				<th>14</th>
				<th>DSCTO</th>
				<th></th>
				<th>Otros</th>
				<th>TOTAL</th>
			</tr>
			<!----------------------------->
            @if(count($lista_pagos) > 0)
                @php($suma_impuesto = 0)
                @php($suma_interes = 0)
                @php($suma_descuento_interes = 0)
                @php($suma_catorce = 0)
                @php($suma_desctuento_14 = 0)
                @php($suma_blanco = 0)
                @php($suma_otros = 0)
                @php($suma_total = 0)
                @foreach($lista_pagos as $pago)
                <tr>
                    <td>{{ $pago->anio }}</td>
                    <td>@money($pago->m_tar)</td>
                    <td>@money($pago->avaluo)</td>
                    <td>@money($pago->impuesto)</td>
                    <td>@money($pago->interes)</td>
                    <td>@money($pago->descuento_interes)</td>
                    <td>@money($pago->catorce)</td>
                    <td>@money($pago->desctuento_14)</td>
                    <td>@money($pago->blanco)</td>
                    <td>@money($pago->otros)</td>
                    <td>@money($pago->total)</td>
                </tr>
                @php($suma_impuesto += $pago->impuesto)
                @php($suma_interes += $pago->interes)
                @php($suma_descuento_interes += $pago->descuento_interes)
                @php($suma_catorce += $pago->catorce)
                @php($suma_desctuento_14 += $pago->desctuento_14)
                @php($suma_blanco += $pago->blanco)
                @php($suma_otros += $pago->otros)
                @php($suma_total += $pago->total)
                @endforeach
                <!----------------------------->
                <tr class="totales">
                    <th colspan="3">TOTALES</th>
                    <th>@money($suma_impuesto)</th>
                    <th>@money($suma_interes)</th>
                    <th>@money($suma_descuento_interes)</th>
                    <th>@money($suma_catorce)</th>
                    <th>@money($suma_desctuento_14)</th>
                    <th>@money($suma_blanco)</th>
                    <th>@money($suma_otros)</th>
                    <th>@money($suma_total)</th>
                </tr>
            @else
            <tr>
                <td colspan="11" style="text-align: center;">No hay informaci&oacute;n disponible</td>
            </tr>
            @endif
		</table>
		<div class="negrilla info" style="padding-top: 30px; padding-bottom: 20px; width: 100%; text-align: center;">
			USUARIO
		</div>
		<div class="info" style="padding-bottom: 30px; width: 100%; text-align: center;">
			ESTA FACTURA PRESTA MERITO EJECUTIVO CONFORME AL ART. 828 DEL E.T.
		</div>
        @if(count($lista_pagos) > 0)
		<hr style="border: 1px dashed #000;
			border-style: none none dashed;
			color: #fff;
			background-color: #fff;" />
		<table class="info-resumen" style="width: 100%; margin-top: 5px;">
			<tr>
				<th>Predio</th>
				<td>{{ $predio->codigo_predio }}</th>
				<th>A&ntilde;os a pagar</th>
				<td>{{ $predio->anios_a_pagar }}</td>
				<th>N&uacute;mero factura</th>
				<td class="negrilla" style="font-size: 130%;">202203807</td>
			</tr>
			<tr>
				<th>Propietario</th>
				<td colspan="5">{{ $predio->propietarios }}</th>
			</tr>
			<tr>
				<th>Direcci&oacute;n</th>
				<td colspan="5">{{ $predio->direccion }}</th>
			</tr>
		</table>
		<table class="info-alcaldia" style="width: 100%; margin-top: 10px;">
			<tr>
				<td>ALCALDIA DE SESQUILE</td>
				<td>NIT 899.999.415-2</th>
				<td>IMPUESTO PREDIAL UNIFICADO</td>
			</tr>
		</table>
		<table class="info-codigo-barras" style="width: 100%; margin-top: 40px;">
			<tr>
				<td style="width: 50%;">BARRAS</td>
				<td>
					<table style="width: 100%; font-size: 120%;">
						<tr><td class="negrilla">Pague hasta 30/03/2022</td></tr>
						<tr><td>Descuento 15%</td></tr>
						<tr><td class="negrilla">@money($suma_total)</td></tr>
					</table>
				</td>
				<td class="marca-agua">SELLO BANCO</td>
			</tr>
		</table>
        @else
        <table class="info-resumen" style="width: 100%; margin-top: 5px;">
            <tr>
                <td style="text-align: center;">NO HAY INFORMACI&Oacute;N DISPONIBLE PARA REALIZAR PAGO</td>
            </tr>
        </table>
        @endif
	</div>
</body>
</html>
