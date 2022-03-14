<!DOCTYPE html>
<html>
<head>
    <title>Reporte</title>
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

        body {
            font-family: 'LATAM Sans';
            padding: 10px; margin: 10px;
        }

        th, td {
            border: 1px solid #000000;
        }
        table {border-collapse: collapse; font-size: 80%; width: 100%;}
        td    {padding: 3px;}
        th    {padding: 5px;}

    </style>
</head>
<body>

    <h1>DislexGames</h1>
    <span>Fecha: {{ $fecha }}</span><br />
    <span>Hora: {{ $hora }}</span><br />
    <span>Identificación: {{ Session::get('userid') }}</span><br />
    <span>Nombre: {{ Session::get('username') }} {{ Session::get('userlastname') }}</span><br /><br />
    <table>
        <tr>
            <th colspan="8">Reporte Desarrollo de Actividades Juego DislexGames</th>
        </tr>
        <tr>
            <th>Identificaci&oacute;n</th>
            <th>Tipo Identificaci&oacute;n</th>
            <th>Paciente</th>
            <th>Fecha Nacimiento</th>
            <th>Sexo Biol&oacute;gico</th>
            <th>Grado Escolaridad</th>
            <th>Nivel</th>
            <th>Puntaje</th>
        </tr>
        @if(count($pacientes) > 0)
            @foreach($pacientes as $paciente)
            <tr>
                <td style="text-align: center;">{{ $paciente->ide_pac }}</td>
                <td style="text-align: center;">{{ $paciente->tid_pac }}</td>
                <td>{{ $paciente->nom_pac }} {{ $paciente->ape_pac }}</td>
                <td style="text-align: center;">{{ $paciente->fec_pac }}</td>
                <td style="text-align: center;">{{ $paciente->sex_pac }}</td>
                <td style="text-align: center;">{{ $paciente->gra_pac }}</td>
                <td style="text-align: center;">{{ $paciente->mod_jue }}</td>
                <td style="text-align: center;">{{ $paciente->p }}</td>
            </tr>
            @endforeach

            <h2>Promedio: {{ $promedio }}</h2><br>
            <h2>Diagnostico: {{$observacion}}</h2>

        @else
        <tr>
            <td colspan="8">No hay informaci&oacute;n para mostrar</td>
        </tr>
        @endif
    </table>
    <br>
    <table>
        <tr>
            <td><b>Nivel Pre Diagn&oacute;stico de Dislexia</b></td>
            <td><b>Número de Preguntas Acertadas</b></td>
        </tr>
        <tr>
            <td>Nulo</td>
            <td>5</td>
        </tr>
        <tr>
            <td>Bajo</td>
            <td>4</td>
        </tr>
        <tr>
            <td>Medio</td>
            <td>2-3</td>
        </tr>
        <tr>
            <td>Alto</td>
            <td>0-1</td>
        </tr>
    </table>
</body>
</html>
