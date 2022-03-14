@extends('theme.default')
@section('content')

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-5 col-md-8 col-sm-12 col-xs-12">
            <h4 class="page-title">
                {!! $opcion->descripcion !!} - JUGAR&nbsp;&nbsp;&nbsp;
                <a href="/citas_fonoaudiologo/{{ base64_encode($opcion->id) }}" class="btn btn-info btn-outline">Volver a citas</a>
            </h4>
        </div>
        <div class="col-lg-7 col-md-4 col-sm-12 col-xs-12">
            <!-- <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20">
                <i class="ti-settings text-white"></i>
            </button> -->
            <!-- <a href="#" target="" class="btn btn-danger pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Buy Admin Now</a> -->
            <ol class="breadcrumb">
                <!-- <li><a href="#">Dashboard</a></li> -->
                <li class="active">{{ Session::get('desc_role') }}</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="white-box">

                {{-- @json($cita) --}}
                <div class="row">
                    <div class="col-md-3 col-xs-6 b-r"> <strong>Paciente</strong>
                        <br>
                        <p class="text-muted">{{ $cita->nom_pac }}</p>
                    </div>
                    <div class="col-md-3 col-xs-6 b-r"> <strong>Identificaci&oacute;n</strong>
                        <br>
                        <p class="text-muted">{{ $cita->pacientes_ide_pac }}</p>
                    </div>
                    <div class="col-md-3 col-xs-6 b-r"> <strong>Fecha</strong>
                        <br>
                        <p class="text-muted">{!! \Carbon\Carbon::createFromFormat('Y-m-d', $cita->fec_cit)->toFormattedDateString() !!}</p>
                    </div>
                    <div class="col-md-3 col-xs-6"> <strong>Hora</strong>
                        <br>
                        <p class="text-muted">{!! \Carbon\Carbon::createFromFormat('H:i:s', $cita->hor_cit)->format('h:i:s A') !!}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
