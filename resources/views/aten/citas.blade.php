@extends('theme.default')
@section('content')

@push('scripts')
    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\CitasCreateFormRequest', '#create-form'); !!}
    {!! JsValidator::formRequest('App\Http\Requests\CitasUpdateFormRequest', '#update-form'); !!}
    <script src="{!! asset('theme/js/customjs/controlsite.js') !!}"></script>
    <script src="{!! asset('theme/js/customjs/citas.js') !!}"></script>
@endpush
@if(Session::get('tab_current'))
<input type="hidden" id="tab" value="{{ Session::get('tab_current') }}">
@endif
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-5 col-md-8 col-sm-12 col-xs-12">
            <h4 class="page-title">{!! $opcion->descripcion !!}</h4>
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
                <section>
                    <div class="sttabs tabs-style-bar">
                        <nav>
                            <ul>
                                <li id="li-section-bar-1" class="tab-current"><a href="#section-bar-1" class="sticon ti-calendar"><span>Nueva cita</span></a></li>
                                <li id="li-section-bar-2" class=""><a href="#section-bar-2" class="sticon icon-list"><span>Listado de citas</span></a></li>
                                <!-- <li class=""><a href="#section-bar-3" class="sticon ti-stats-up"><span>Analytics</span></a></li>
                                <li class=""><a href="#section-bar-4" class="sticon ti-upload"><span>Upload</span></a></li>
                                <li class=""><a href="#section-bar-5" class="sticon ti-settings"><span>Settings</span></a></li> -->
                            </ul>
                        </nav>
                        <div class="content-wrap">
                            <section id="section-bar-1" class="content-current">
                                <div class="panel panel-inverse">
                                    <div class="panel-heading"><i  class="{{ $opcion->icono }}"></i>&nbsp;&nbsp;Informaci&oacute;n de la cita</div>
                                    <div class="panel-wrapper collapse in" aria-expanded="true">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="well">
                                                        <form action="{{ route('aten.create_cit') }}" method="post" id="create-form">
                                                            @csrf
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
                                                            <div class="form-body">
                                                                <div class="row" style="display: none;">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Fecha registro:</label>
                                                                            <input readonly type="text" id="fer_cit" name="fer_cit" class="form-control" value="{{ $datenow }}">
                                                                            <span class="text-danger">@error('fer_cit') {{ $message }} @enderror</span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Hora registro</label>
                                                                            <input readonly type="text" id="hrc_cit" name="hrc_cit" class="form-control" value="{{ $timenow }}">
                                                                            <span class="text-danger">@error('hrc_cit') {{ $message }} @enderror</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <label class="control-label">Fecha cita</label>
                                                                        <div class="input-group" style="margin-bottom: 25px;">
                                                                            <input type="text" id="fec_cit" name="fec_cit" class="form-control datecita withadon" data-control="hor_cit" autocomplete="off" placeholder="yyyy-mm-dd" value="{{ old('fec_cit') }}">
                                                                            <div class="input-group-addon">
                                                                                <span class="glyphicon glyphicon-th"></span>
                                                                            </div>
                                                                        </div>
                                                                        <span class="text-danger">@error('fec_cit') {{ $message }} @enderror</span>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="control-label">Hora cita</label>
                                                                        {{-- <div class="input-group clockpicker" style="margin-bottom: 25px;">
                                                                            <input type="text" id="hor_cit" name="hor_cit" class="form-control withadon" autocomplete="off" value="{{ old('hor_cit') }}">
                                                                            <span class="input-group-addon">
                                                                                <span class="glyphicon glyphicon-time"></span>
                                                                            </span>
                                                                        </div> --}}
                                                                        <select id="hor_cit" name="hor_cit" class="form-control selectpicker show-tick dropdown" data-dropup-auto="false" data-live-search="true" data-size="3" title="Seleccione...">
                                                                            @foreach($allTimes as $theTime)
                                                                                <option value="{{ $theTime }}">{{ $theTime }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <span class="text-danger">@error('hor_cit') {{ $message }} @enderror</span>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Paciente</label>
                                                                            <select id="ide_pac" name="ide_pac" class="form-control selectpicker show-tick dropdown" data-dropup-auto="false" data-live-search="true" data-size="3" title="Seleccione...">
                                                                                @if(count($pacientes) > 0)
                                                                                    @foreach($pacientes as $paciente)
                                                                                        <option data-subtext="{{ $paciente->ide_pac }}" value="{{ $paciente->ide_pac }}">{{ $paciente->nom_pac }} {{ $paciente->ape_pac }}</option>
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                            <span class="text-danger">@error('ide_pac') {{ $message }} @enderror</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Fonoaudiologo</label>
                                                                            <select id="ide_fon" name="ide_fon" class="form-control selectpicker show-tick dropdown" data-dropup-auto="false" data-live-search="true" data-size="3" title="Seleccione...">
                                                                                @if(count($fonoaudiologos) > 0)
                                                                                    @foreach($fonoaudiologos as $fonoaudiologo)
                                                                                        <option data-subtext="{{ $fonoaudiologo->usuarios_ide_usu }}" value="{{ $fonoaudiologo->ide_fon }}">{{ $fonoaudiologo->nom_usu }} {{ $fonoaudiologo->ape_usu }}</option>
                                                                                    @endforeach
                                                                                @endif
                                                                            </select>
                                                                            <span class="text-danger">@error('ide_fon') {{ $message }} @enderror</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-actions m-t-20">
                                                                <button type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Guardar cita</button>
                                                                <!-- <button type="button" class="btn btn-default">Cancelar</button> -->
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8">
                                                    <div class="well">
                                                        <input type="hidden" id="json_citas" value='@json($citas)'>
                                                        <div id="calendar"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section id="section-bar-2" class="">
                                <div id="div_table" class="row">
                                    <div class="col-lg-12">
                                        <div class="well">
                                            @if(isset($todas_citas))
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
                                                <h2>Lista de citas</h2>
                                                <table id="myTable" class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th class="cell_center">Id</th>
                                                            <th class="cell_center">Paciente</th>
                                                            <th class="cell_center">Fonoaudiologo</th>
                                                            <th class="cell_center">Fecha</th>
                                                            <th class="cell_center">Hora</th>
                                                            <th class="cell_center">Estado</th>
                                                            <th class="cell_center" style="width: 10%;">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(count($todas_citas) > 0)
                                                            @foreach($todas_citas as $cita)
                                                            <tr style="cursor: pointer;" class="cita_row" json-data='@json($cita)' data-control="hor_cit_edit">
                                                                @if($cita->est_cit != 'A')
                                                                    <td class="cell_center edit_row">{{ $cita->ide_cit }}</td>
                                                                    <td class="edit_row">{{ $cita->nom_pac }}</td>
                                                                    <td class="edit_row">{{ $cita->nom_usu }}</td>
                                                                    <td class="cell_center edit_row">{!! \Carbon\Carbon::createFromFormat('Y-m-d', $cita->fec_cit)->toFormattedDateString() !!}</td>
                                                                    <td class="cell_center edit_row">{!! \Carbon\Carbon::createFromFormat('H:i:s', $cita->hor_cit)->format('h:i:s A') !!}</td>
                                                                    <td class="cell_center edit_row">{{ $estados_citas[$cita->est_cit] }}</td>
                                                                    <td class="cell_center">
                                                                        <button type="button" ide="{{ $cita->ide_cit }}" class="modify_row btn btn-info"><i class="fa fa-pencil-square"></i></button>
                                                                        {{-- &nbsp;&nbsp;
                                                                        <button type="button" ide="{{ $cita->ide_cit }}" class="delete_row btn btn-inverse"><i class="fa fa-trash-o"></i></button> --}}
                                                                    </td>
                                                                @else
                                                                    <td class="cell_center">{{ $cita->ide_cit }}</td>
                                                                    <td class="">{{ $cita->nom_pac }}</td>
                                                                    <td class="">{{ $cita->nom_usu }}</td>
                                                                    <td class="cell_center ">{!! \Carbon\Carbon::createFromFormat('Y-m-d', $cita->fec_cit)->toFormattedDateString() !!}</td>
                                                                    <td class="cell_center ">{!! \Carbon\Carbon::createFromFormat('H:i:s', $cita->hor_cit)->format('h:i:s A') !!}</td>
                                                                    <td class="cell_center ">{{ $estados_citas[$cita->est_cit] }}</td>
                                                                    <td class="cell_center">
                                                                        <button type="button" disabled="" ide="{{ $cita->ide_cit }}" class="modify_row btn btn-default"><i class="fa fa-pencil-square"></i></button>
                                                                        {{-- &nbsp;&nbsp;
                                                                        <button type="button" ide="{{ $cita->ide_cit }}" class="delete_row btn btn-inverse"><i class="fa fa-trash-o"></i></button> --}}
                                                                    </td>
                                                                @endif
                                                            </tr>
                                                            @endforeach
                                                        {{-- @else
                                                        <tr>
                                                            <td colspan="7">No hay informaci&oacute;n para mostrar</td>
                                                        </tr> --}}
                                                        @endif
                                                    </tbody>
                                                </table>
                                                {{-- <div class="pagination-blobk">
                                                    {{ $pacientes->links('layouts.paginationlinks') }}
                                                </div> --}}
                                                {{-- <form id="form_delete" action="{{ route('aten.delete_cit') }}" method="post" style="display: none;">
                                                    @csrf
                                                    <input type="hidden" id="input_delete" name="input_delete">
                                                </form> --}}
                                            @endif
                                        </div>
                                    </div>
                                </div>
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
                                                                    <input type="text" id="fec_cit_edit" name="fec_cit_edit" class="form-control datecita withadon" data-control="hor_cit_edit" autocomplete="off" placeholder="yyyy-mm-dd" value="{{ old('fec_cit_edit') }}">
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
                            </section>
                            <!-- <section id="section-bar-3" class="">
                                <h2>Tabbing 3</h2></section>
                            <section id="section-bar-4" class="">
                                <h2>Tabbing 4</h2></section>
                            <section id="section-bar-5" class="">
                                <h2>Tabbing 5</h2></section> -->
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
