@extends('theme.default')
@section('content')

@push('scripts')
    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\RemisionesCreateFormRequest', '#create-form'); !!}
    {!! JsValidator::formRequest('App\Http\Requests\RemisionesUpdateFormRequest', '#update-form'); !!}
    <script src="{!! asset('theme/js/customjs/controlsite.js') !!}"></script>
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
        <div class="col-sm-12">
            <div class="white-box">
                <section>
                    <div class="sttabs tabs-style-bar">
                        <nav>
                            <ul>
                                <li id="li-section-bar-1" class="tab-current"><a href="#section-bar-1" class="sticon fa fa-ambulance"><span>Nueva remisi&oacute;n</span></a></li>
                                <li id="li-section-bar-2" class=""><a href="#section-bar-2" class="sticon icon-list"><span>Listado de remisiones</span></a></li>
                                <!-- <li class=""><a href="#section-bar-3" class="sticon ti-stats-up"><span>Analytics</span></a></li>
                                <li class=""><a href="#section-bar-4" class="sticon ti-upload"><span>Upload</span></a></li>
                                <li class=""><a href="#section-bar-5" class="sticon ti-settings"><span>Settings</span></a></li> -->
                            </ul>
                        </nav>
                        <div class="content-wrap">
                            <section id="section-bar-1" class="content-current">
                                <div class="panel panel-inverse">
                                    <div class="panel-heading"><i  class="{{ $opcion->icono }}"></i>&nbsp;&nbsp;Informaci&oacute;n de la remisi&oacute;n</div>
                                    <div class="panel-wrapper collapse in" aria-expanded="true">
                                        <div class="panel-body">
                                            <form action="{{ route('fono.create_rem') }}" method="post" id="create-form">
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
                                                    <!-- <h3 class="box-title">Informaci&oacute;n del paciente</h3> -->
                                                    <!-- <hr> -->
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
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
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
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
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Lugar a donde ser&aacute; remitido</label>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><i class="fa fa-hospital-o"></i></span>
                                                                    <input type="text" id="don_rem" name="don_rem" class="form-control withadon" value="{{ old('don_rem') }}">
                                                                    <span class="input-group-addon"><i class="fa fa-hospital-o"></i></span>
                                                                </div>
                                                                <span class="text-danger">@error('don_rem') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Motivo de remisi&oacute;n</label>
                                                                <textarea id="mot_rem" name="mot_rem" class="form-control" rows="6" style="resize: none;">{{ old('mot_rem') }}</textarea>
                                                                <span class="text-danger">@error('mot_rem') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-actions m-t-20">
                                                    <button type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Guardar informaci&oacute;n de remisi&oacute;n</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section id="section-bar-2" class="">
                                <div id="div_table" class="row">
                                    <div class="col-lg-12">
                                        <div class="well">
                                            @if(isset($remisiones))
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
                                                <h2>Lista de remisiones</h2>
                                                <table id="myTable" class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th class="cell_center">Id</th>
                                                            <th class="cell_center">Paciente</th>
                                                            <th class="cell_center">Fonoaudiologo</th>
                                                            <th class="cell_center">Lugar</th>
                                                            <th class="cell_center" style="width: 10%;">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(count($remisiones) > 0)
                                                            @foreach($remisiones as $remision)
                                                            <tr style="cursor: pointer;" json-data='@json($remision)'>
                                                                <td class="cell_center edit_row">{{ $remision->ide_rem }}</td>
                                                                <td class="edit_row">{{ $remision->nom_pac }} {{ $remision->ape_pac }}</td>
                                                                <td class="edit_row">{{ $remision->nom_usu }} {{ $remision->ape_usu }}</td>
                                                                <td class="edit_row">{{ $remision->don_rem }}</td>
                                                                <td class="cell_center">
                                                                    <button type="button" ide="{{ $remision->ide_rem }}" class="modify_row btn btn-info"><i class="fa fa-pencil-square"></i></button>
                                                                    &nbsp;&nbsp;
                                                                    <button type="button" ide="{{ $remision->ide_rem }}" class="delete_row btn btn-inverse"><i class="fa fa-trash-o"></i></button>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        {{-- @else
                                                        <tr>
                                                            <td colspan="5">No hay informaci&oacute;n para mostrar</td>
                                                        </tr> --}}
                                                        @endif
                                                    </tbody>
                                                </table>
                                                {{-- <div class="pagination-blobk">
                                                    {{ $pacientes->links('layouts.paginationlinks') }}
                                                </div> --}}
                                                <form id="form_delete" action="{{ route('fono.delete_rem') }}" method="post" style="display: none;">
                                                    @csrf
                                                    <input type="hidden" id="input_delete" name="input_delete">
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div id="div_edit_form" class="panel panel-info" style="display: none;">
                                    <div class="panel-heading"><i  class="{{ $opcion->icono }}"></i>&nbsp;&nbsp;Actualizar remisi&oacute;n</div>
                                    <div class="panel-wrapper collapse in" aria-expanded="true">
                                        <div class="panel-body">
                                            <form action="{{ route('fono.update_rem') }}" method="post" id="update-form">
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
                                                    <input type="hidden" id="ide_rem_edit" name="ide_rem_edit" value="{{ old('ide_rem_edit') }}">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Paciente</label>
                                                                <select id="pacientes_ide_pac_edit" name="pacientes_ide_pac_edit" class="form-control selectpicker show-tick dropdown" data-dropup-auto="false" data-live-search="true" data-size="3" title="Seleccione...">
                                                                    @if(count($pacientes) > 0)
                                                                        @foreach($pacientes as $paciente)
                                                                            <option data-subtext="{{ $paciente->ide_pac }}" value="{{ $paciente->ide_pac }}" {{ old('pacientes_ide_pac_edit') == $paciente->ide_pac ? 'selected' : '' }}>{{ $paciente->nom_pac }} {{ $paciente->ape_pac }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                                <span class="text-danger">@error('pacientes_ide_pac_edit') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
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
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Lugar a donde ser&aacute; remitido</label>
                                                                <div class="input-group">
                                                                    <span class="input-group-addon"><i class="fa fa-hospital-o"></i></span>
                                                                    <input type="text" id="don_rem_edit" name="don_rem_edit" class="form-control withadon" value="{{ old('don_rem_edit') }}">
                                                                    <span class="input-group-addon"><i class="fa fa-hospital-o"></i></span>
                                                                </div>
                                                                <span class="text-danger">@error('don_rem_edit') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Motivo de remisi&oacute;n</label>
                                                                <textarea id="mot_rem_edit" name="mot_rem_edit" class="form-control" rows="6" style="resize: none;">{{ old('mot_rem_edit') }}</textarea>
                                                                <span class="text-danger">@error('mot_rem_edit') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-actions m-t-20">
                                                    <button type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Actualizar informaci&oacute;n de remisi&oacute;n</button>
                                                    <button id="btn_cancel_edit" type="button" class="btn btn-default"> <i class="fa fa-thumbs-down"></i> Cancelar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
