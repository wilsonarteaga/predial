@extends('theme.default')
@section('content')

@push('scripts')
    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\CitasUpdateFormRequest', '#update-form'); !!}
    <script src="{!! asset('theme/js/customjs/controlsite.js') !!}"></script>
@endpush
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-5 col-md-8 col-sm-12 col-xs-12">
            <h4 class="page-title">
                {!! $opcion->descripcion !!}&nbsp;&nbsp;&nbsp;
                <a href="/citas/{{ base64_encode($opcion->id) }}" class="btn btn-info btn-outline">Volver a citas</a>
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
                @php
                    $estados_citas = array("P"=>"Pendiente", "C"=>"Cancelada", "A"=>"Atendida", "X"=>"No asistió");
                @endphp
                <div class="result">
                    @if(Session::get('success'))
                        <div class="alert alert-success">
                            {!! Session::get('success') !!}
                        </div>
                    @endif
                    @if(Session::get('fail'))
                        <div class="alert alert-danger">
                            {!! Session::get('fail') !!}
                        </div>
                    @endif
                </div>
                <section id="timeline_citas" class="cd-horizontal-timeline loaded" style="margin: 3em auto;">
                    <div class="timeline">
                        <div class="events-wrapper">
                            <div class="events" style="width: 1800px;">
                                <ol>
                                    @if(count($citas) > 0)
                                        @php
                                            $counter = 1;
                                            $margin = 0;
                                        @endphp
                                        @foreach($citas as $cita)
                                            <li>
                                                <a href="#0" data-date="{!! \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $cita->fec_cit . ' ' . $cita->hor_cit)->format('d/m/Y H:i:s') !!}" style="margin-left: {!! $margin !!}px; margin-right: {!! $margin !!}px;" class="older-event {{ $counter == 1 ? 'selected' : '' }}">
                                                    {!! \Carbon\Carbon::createFromFormat('Y-m-d', $cita->fec_cit)->format('j M') !!}
                                                </a>
                                            </li>
                                            @php
                                                $counter = $counter + 1;
                                                $margin = $margin + 60;
                                            @endphp
                                        @endforeach
                                    @endif
                                </ol>
                                <span class="filling-line" aria-hidden="true" style="transform: scaleX(0.277847);"></span>
                            </div>
                        </div>
                        <ul class="cd-timeline-navigation">
                            <li><a href="#0" class="prev inactive">Prev</a></li>
                            <li><a href="#0" class="next">Next</a></li>
                        </ul>
                    </div>
                    <div class="events-content" style="height: auto;">
                        <ol>
                            @if(count($citas) > 0)
                                @php
                                    $counter = 1;
                                @endphp
                                @foreach($citas as $cita)
                                    <li class=" {{ $counter == 1 ? 'selected' : '' }}" data-date="{!! \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $cita->fec_cit . ' ' . $cita->hor_cit)->format('d/m/Y H:i:s') !!}">
                                        <h2>
                                            {{-- <img class="img-responsive img-circle pull-left m-r-20 m-b-10" alt="user" src="../plugins/images/users/genu.jpg" width="60"> --}}
                                            {{ $cita->nom_pac }}
                                            <br>
                                            <small>{!! \Carbon\Carbon::createFromFormat('Y-m-d', $cita->fec_cit)->toFormattedDateString() !!}</small>
                                            <small class="text-muted" style="font-size: 55%;">{!! \Carbon\Carbon::createFromFormat('H:i:s', $cita->hor_cit)->format('h:i:s A') !!}</small>
                                            @if($cita->est_cit != 'A')
                                            <a href="javascript:void(0)" class="btn_update_cit btn btn-primary btn-outline pull-right" json-data='@json($cita)'>Modificar cita</a>
                                            @endif
                                        </h2>
                                        <hr class="m-t-10">
                                        <p class="m-t-10">
                                            <span class="text-info"><b>Fonoaudiologo:</b></span> <span>{{ $cita->nom_usu }} {{ $cita->ape_usu }}</span><br />
                                            <span class="text-info"><b>Estado:</b></span>
                                            @if($cita->est_cit == 'A')
                                            <span class="text-success"><b>{{ $estados_citas[$cita->est_cit] }}</b></span>
                                            @else
                                            <span class="text-danger">{{ $estados_citas[$cita->est_cit] }}</span>
                                            @endif
                                            <br />
                                            <span class="text-primary" style="font-size: 80%;">Fecha registro:
                                            {!! \Carbon\Carbon::createFromFormat('Y-m-d', $cita->fer_cit)->toFormattedDateString() !!}
                                            {!! \Carbon\Carbon::createFromFormat('H:i:s', $cita->hrc_cit)->format('h:i:s A') !!}</span>
                                        </p>
                                        <hr class="m-t-10">
                                    </li>
                                    @php
                                        $counter = $counter + 1;
                                    @endphp
                                @endforeach
                            @endif
                        </ol>
                    </div>
                    {{-- <a href="/citas/{{ base64_encode($opcion->id) }}" class="btn btn-info btn-outline m-t-20">Volver a Citas</a> --}}
                </section>
                <div id="div_edit_form" class="panel panel-info" style="display: none;">
                    <div class="panel-heading"><i  class="{{ $opcion->icono }}"></i>&nbsp;&nbsp;Actualizar informaci&oacute;n de cita</div>
                    <div class="panel-wrapper collapse in" aria-expanded="true">
                        <div class="panel-body" style="padding-bottom: 50px;">
                            <form action="{{ route('aten.update_cit') }}" method="post" id="update-form">
                                @csrf

                                <div class="form-body">
                                    <input type="hidden" id="ide_cit_edit" name="ide_cit_edit" value="{{ old('ide_cit_edit') }}">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label">Fecha registro:</label>
                                                <input readonly type="text" id="fer_cit_edit" name="fer_cit_edit" class="form-control" value="{{ old('fer_cit_edit') }}">
                                                <span class="text-danger">@error('fer_cit_edit') {{ $message }} @enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label">Hora registro</label>
                                                <input readonly type="text" id="hrc_cit_edit" name="hrc_cit_edit" class="form-control" value="{{ old('hrc_cita_edit') }}">
                                                <span class="text-danger">@error('hrc_cit_edit') {{ $message }} @enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label">Fecha cita</label>
                                                <div class="input-group" style="margin-bottom: 25px;">
                                                    <input type="text" id="fec_cit_edit" name="fec_cit_edit" class="form-control datecita withadon" autocomplete="off" placeholder="yyyy-mm-dd" value="{{ old('fec_cit_edit') }}">
                                                    <div class="input-group-addon">
                                                        <span class="glyphicon glyphicon-th"></span>
                                                    </div>
                                                </div>
                                                <span class="text-danger">@error('fec_cit_edit') {{ $message }} @enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label">Hora cita</label>
                                                {{-- <div class="input-group clockpicker" style="margin-bottom: 25px;">
                                                    <input type="text" id="hor_cit_edit" name="hor_cit_edit" class="form-control withadon" autocomplete="off" value="{{ old('hor_cit_edit') }}">
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
                                                </div> --}}
                                                <select id="hor_cit_edit" name="hor_cit_edit" class="form-control selectpicker show-tick dropdown" data-dropup-auto="false" data-live-search="true" data-size="3" title="Seleccione...">
                                                    @foreach($allTimes as $theTime)
                                                        <option value="{{ $theTime }}">{{ $theTime }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger">@error('hor_cit_edit') {{ $message }} @enderror</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label">Paciente</label>
                                                <input type="hidden" id="pacientes_ide_pac_edit" name="pacientes_ide_pac_edit" value="{{ old('pacientes_ide_pac_edit') }}">
                                                <input type="text" id="nom_pac_edit" name="nom_pac_edit" class="form-control" autocomplete="off" readonly="" value="{{ old('nom_pac_edit') }}">
                                                <span class="text-danger">@error('nom_pac_edit') {{ $message }} @enderror</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <div class="form-group">
                                                <label class="control-label">Fonoaudiologo</label>
                                                <select id="fonoaudiologos_ide_fon_edit" name="fonoaudiologos_ide_fon_edit" class="form-control selectpicker show-tick dropdown" data-dropup-auto="false" data-live-search="true" data-size="3" title="Seleccione...">
                                                    @if(count($fonoaudiologos) > 0)
                                                        @foreach($fonoaudiologos as $fonoaudiologo)
                                                            <option data-subtext="{{ $fonoaudiologo->usuarios_ide_usu }}" value="{{ $fonoaudiologo->ide_fon }}" {{ old('fonoaudiologos_ide_fon_edit') == $fonoaudiologo->ide_fon ? 'selected' : '' }}>{{ $fonoaudiologo->nom_usu }} {{ $fonoaudiologo->ape_usu }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <span class="text-danger">@error('fonoaudiologos_ide_fon_edit') {{ $message }} @enderror</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label>Estado</label>
                                                <select id="est_cit_edit" name="est_cit_edit" class="form-control selectpicker show-tick" data-size="3" title="Seleccione...">
                                                    @foreach($estados_citas as $clave => $valor)
                                                        <option value="{{ $clave }}" {{ old('est_cit_edit') == $clave ? 'selected' : '' }}>{{ $valor }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions m-t-20">
                                    <button type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Actualizar cita</button>
                                    <button id="btn_cancel_edit" type="button" class="btn btn-default"> <i class="fa fa-thumbs-down"></i> Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
