@extends('theme.default')
@section('content')

@push('scripts')
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
                            <li id="li-section-bar-1" class="tab-current"><a href="#section-bar-1" class="sticon ti-user"><span>Nuevo paciente</span></a></li>
                            <li id="li-section-bar-2" class=""><a href="#section-bar-2" class="sticon ti-folder"><span>Archivo de pacientes</span></a></li>
                            <!-- <li class=""><a href="#section-bar-3" class="sticon ti-stats-up"><span>Analytics</span></a></li>
                            <li class=""><a href="#section-bar-4" class="sticon ti-upload"><span>Upload</span></a></li>
                            <li class=""><a href="#section-bar-5" class="sticon ti-settings"><span>Settings</span></a></li> -->
                        </ul>
                    </nav>
                    <div class="content-wrap">
                        <section id="section-bar-1" class="content-current">
                            <div class="panel panel-inverse">
                                <div class="panel-heading"><i  class="{{ $opcion->icono }}"></i>&nbsp;&nbsp;Informaci&oacute;n del paciente</div>
                                <div class="panel-wrapper collapse in" aria-expanded="true">
                                    <div class="panel-body">
                                        <form action="{{ route('aten.create_pac') }}" method="post">
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
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label">Nombres</label>
                                                            <input type="text" id="nom_pac" name="nom_pac" class="form-control" placeholder="Ingrese nombres" value="{{ old('nom_pac') }}">
                                                            <span class="text-danger">@error('nom_pac') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label">Apellidos</label>
                                                            <input type="text" id="ape_pac" name="ape_pac" class="form-control" placeholder="Ingrese apellidos" value="{{ old('ape_pac') }}">
                                                            <span class="text-danger">@error('ape_pac') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Tipo identificaci&oacute;n</label>
                                                            <select id="tid_pac" name="tid_pac" class="form-control selectpicker show-tick" title="Seleccione...">
                                                                <option value="CC" {{ old('tid_pac') == "CC" ? 'selected' : '' }}>C&eacute;dula</option>
                                                                <option value="TI" {{ old('tid_pac') == "TI"  || old('tid_pac') == null ? 'selected' : '' }}>Tarjeta Identidad</option>
                                                                <option value="CE" {{ old('tid_pac') == "CE" ? 'selected' : '' }}>C&eacute;dula extranjer&iacute;a</option>
                                                                <option value="PS" {{ old('tid_pac') == "PS" ? 'selected' : '' }}>Pasaporte</option>
                                                                <option value="RC" {{ old('tid_pac') == "RC" ? 'selected' : '' }}>Registro Civ&iacute;l</option>
                                                            </select>
                                                            <span class="text-danger">@error('tid_pac') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Identificaci&oacute;n</label>
                                                            <input type="text" id="ide_pac" name="ide_pac" class="form-control onlyNumbers" placeholder="Ingrese identificaci&oacute;n" value="{{ old('ide_pac') }}">
                                                            <span class="text-danger">@error('ide_pac') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">G&eacute;nero</label>
                                                            <select id="sex_pac" name="sex_pac" class="form-control selectpicker show-tick" title="Seleccione...">
                                                                <option value="F" {{ old('sex_pac') == "F" || old('sex_pac') == null ? 'selected' : '' }}>Femenino</option>
                                                                <option value="M" {{ old('sex_pac') == "M" ? 'selected' : '' }}>Masculino</option>
                                                            </select>
                                                            <span class="text-danger">@error('sex_pac') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                                                        <label class="control-label">Fecha nacimiento</label>
                                                        <div style="position:relative">
                                                            <div class="input-group">
                                                                <input type="text" id="fec_pac" name="fec_pac" class="form-control datepicker" autocomplete="off" placeholder="yyyy-mm-dd" value="{{ old('fec_pac') }}">
                                                                <div class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-th"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span class="text-danger">@error('fec_pac') {{ $message }} @enderror</span>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label>Grado escolaridad</label>
                                                            <select id="gra_pac" name="gra_pac" class="form-control selectpicker show-tick" title="Seleccione...">
                                                                {{-- <option value="">--Seleccione--</option> --}}
                                                                <option value="1" {{ old('gra_pac') == "1" ? 'selected' : '' }}>Primero</option>
                                                                <option value="2" {{ old('gra_pac') == "2" ? 'selected' : '' }}>Segundo</option>
                                                                <option value="3" {{ old('gra_pac') == "3" ? 'selected' : '' }}>Tercero</option>
                                                                <option value="4" {{ old('gra_pac') == "4" ? 'selected' : '' }}>Cuarto</option>
                                                                <option value="5" {{ old('gra_pac') == "5" ? 'selected' : '' }}>Quinto</option>
                                                                <option value="6" {{ old('gra_pac') == "6" ? 'selected' : '' }}>Sexto</option>
                                                                <option value="7" {{ old('gra_pac') == "7" ? 'selected' : '' }}>Septimo</option>
                                                                <option value="8" {{ old('gra_pac') == "8" ? 'selected' : '' }}>Octavo</option>
                                                                <option value="9" {{ old('gra_pac') == "9" ? 'selected' : '' }}>Noveno</option>
                                                                <option value="10" {{ old('gra_pac') == "10" ? 'selected' : '' }}>D&eacute;cimo</option>
                                                                <option value="11" {{ old('gra_pac') == "11" ? 'selected' : '' }}>Und&eacute;cimo</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label>Acudiente</label>
                                                            <select id="ide_acu" name="ide_acu" class="form-control selectpicker show-tick" data-live-search="true" title="Seleccione...">
                                                                {{-- <option value="">--Seleccione--</option> --}}
                                                                @if(count($acudientes) > 0)
                                                                    @foreach($acudientes as $acudiente)
                                                                    <option value="{{ $acudiente->ide_acu }}" {{ old('ide_acu') == $acudiente->ide_acu ? 'selected' : '' }}>{{ $acudiente->nom_acu }} {{ $acudiente->ape_acu }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <span class="text-danger">@error('ide_acu') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions m-t-20">
                                                <button type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Guardar informaci&oacute;n del paciente</button>
                                                <!-- <button type="button" class="btn btn-default">Cancelar</button> -->
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section id="section-bar-2" class="">
                            <div id="div_table" class="row">
                                <div class="col-lg-12">
                                    @if(isset($pacientes))
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
                                        <h2>Lista de pacientes</h2>
                                        <table id="myTable" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="cell_center">Identificaci&oacute;n</th>
                                                    <th class="cell_center">Tipo Identificaci&oacute;n</th>
                                                    <th class="cell_center">Nombres</th>
                                                    <th class="cell_center">Apellidos</th>
                                                    <th class="cell_center">Fecha Nacimiento</th>
                                                    <th class="cell_center">Sexo Biol&oacute;gico</th>
                                                    <th class="cell_center">Grado Escolaridad</th>
                                                    <th class="cell_center" style="width: 10%;">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(count($pacientes) > 0)
                                                    @foreach($pacientes as $paciente)
                                                    <tr style="cursor: pointer;" json-data='@json($paciente)'>
                                                        <td class="cell_center edit_row">{{ $paciente->ide_pac }}</td>
                                                        <td class="cell_center edit_row">{{ $paciente->tid_pac }}</td>
                                                        <td class="edit_row">{{ $paciente->nom_pac }}</td>
                                                        <td class="edit_row">{{ $paciente->ape_pac }}</td>
                                                        <td class="cell_center edit_row">{{ $paciente->fec_pac }}</td>
                                                        <td class="cell_center edit_row">{{ $paciente->sex_pac }}</td>
                                                        <td class="cell_center edit_row">{{ $paciente->gra_pac }}</td>
                                                        <td class="cell_center">
                                                            <button type="button" ide="{{ $paciente->ide_pac }}" class="modify_row btn btn-info"><i class="fa fa-pencil-square"></i></button>
                                                            &nbsp;&nbsp;
                                                            <button type="button" ide="{{ $paciente->ide_pac }}" class="delete_row btn btn-inverse"><i class="fa fa-trash-o"></i></button>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                {{-- @else
                                                <tr>
                                                    <td colspan="8">No hay informaci&oacute;n para mostrar</td>
                                                </tr> --}}
                                                @endif
                                            </tbody>
                                        </table>
                                        {{-- <div class="pagination-blobk">
                                            {{ $pacientes->links('layouts.paginationlinks') }}
                                        </div> --}}
                                        <form id="form_delete" action="{{ route('aten.delete_pac') }}" method="post" style="display: none;">
                                            @csrf
                                            <input type="hidden" id="input_delete" name="input_delete">
                                        </form>
                                    @endif
                                </div>
                            </div>
                            <div id="div_edit_form" class="panel panel-info" style="display: none;">
                                <div class="panel-heading"><i  class="{{ $opcion->icono }}"></i>&nbsp;&nbsp;Actualizar informaci&oacute;n del paciente</div>
                                <div class="panel-wrapper collapse in" aria-expanded="true">
                                    <div class="panel-body">
                                        <form action="{{ route('aten.update_pac') }}" method="post">
                                            @csrf

                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label">Nombres</label>
                                                            <input type="text" id="nom_pac_edit" name="nom_pac_edit" class="form-control" placeholder="Ingrese nombres" value="{{ old('nom_pac_edit') }}">
                                                            <span class="text-danger">@error('nom_pac_edit') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label">Apellidos</label>
                                                            <input type="text" id="ape_pac_edit" name="ape_pac_edit" class="form-control" placeholder="Ingrese apellidos" value="{{ old('ape_pac_edit') }}">
                                                            <span class="text-danger">@error('ape_pac_edit') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Tipo identificaci&oacute;n</label>
                                                            <select id="tid_pac_edit" name="tid_pac_edit" class="form-control selectpicker show-tick" title="Seleccione...">
                                                                <option value="CC" {{ old('tid_pac_edit') == "CC" ? 'selected' : '' }}>C&eacute;dula</option>
                                                                <option value="TI" {{ old('tid_pac_edit') == "TI" ? 'selected' : '' }}>Tarjeta Identidad</option>
                                                                <option value="CE" {{ old('tid_pac_edit') == "CE" ? 'selected' : '' }}>C&eacute;dula extranjer&iacute;a</option>
                                                                <option value="PS" {{ old('tid_pac_edit') == "PS" ? 'selected' : '' }}>Pasaporte</option>
                                                                <option value="RC" {{ old('tid_pac_edit') == "RC" ? 'selected' : '' }}>Registro Civ&iacute;l</option>
                                                            </select>
                                                            <span class="text-danger">@error('tid_pac_edit') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Identificaci&oacute;n</label>
                                                            <input readonly type="text" id="ide_pac_edit" name="ide_pac_edit" class="form-control onlyNumbers" placeholder="Ingrese identificaci&oacute;n" value="{{ old('ide_pac_edit') }}">
                                                            <span class="text-danger">@error('ide_pac_edit') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">G&eacute;nero</label>
                                                            <select id="sex_pac_edit" name="sex_pac_edit" class="form-control selectpicker show-tick" title="Seleccione...">
                                                                <option value="F" {{ old('sex_pac_edit') == "F" ? 'selected' : '' }}>Femenino</option>
                                                                <option value="M" {{ old('sex_pac_edit') == "M" ? 'selected' : '' }}>Masculino</option>
                                                            </select>
                                                            <span class="text-danger">@error('sex_pac_edit') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                                                        <label class="control-label">Fecha nacimiento</label>
                                                        <div style="position:relative">
                                                            <div class="input-group">
                                                                <input type="text" id="fec_pac_edit" name="fec_pac_edit" class="form-control datepicker" autocomplete="off" placeholder="yyyy-mm-dd" value="{{ old('fec_pac_edit') }}">
                                                                <div class="input-group-addon">
                                                                    <span class="glyphicon glyphicon-th"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span class="text-danger">@error('fec_pac_edit') {{ $message }} @enderror</span>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label>Grado escolaridad</label>
                                                            <select id="gra_pac_edit" name="gra_pac_edit" class="form-control selectpicker show-tick" title="Seleccione...">
                                                                {{-- <option value="">--Seleccione--</option> --}}
                                                                <option value="1" {{ old('gra_pac_edit') == "1" ? 'selected' : '' }}>Primero</option>
                                                                <option value="2" {{ old('gra_pac_edit') == "2" ? 'selected' : '' }}>Segundo</option>
                                                                <option value="3" {{ old('gra_pac_edit') == "3" ? 'selected' : '' }}>Tercero</option>
                                                                <option value="4" {{ old('gra_pac_edit') == "4" ? 'selected' : '' }}>Cuarto</option>
                                                                <option value="5" {{ old('gra_pac_edit') == "5" ? 'selected' : '' }}>Quinto</option>
                                                                <option value="6" {{ old('gra_pac_edit') == "6" ? 'selected' : '' }}>Sexto</option>
                                                                <option value="7" {{ old('gra_pac_edit') == "7" ? 'selected' : '' }}>Septimo</option>
                                                                <option value="8" {{ old('gra_pac_edit') == "8" ? 'selected' : '' }}>Octavo</option>
                                                                <option value="9" {{ old('gra_pac_edit') == "9" ? 'selected' : '' }}>Noveno</option>
                                                                <option value="10" {{ old('gra_pac_edit') == "10" ? 'selected' : '' }}>D&eacute;cimo</option>
                                                                <option value="11" {{ old('gra_pac_edit') == "11" ? 'selected' : '' }}>Und&eacute;cimo</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label>Acudiente</label>
                                                            <select id="acudientes_ide_acu_edit" name="acudientes_ide_acu_edit" class="form-control selectpicker show-tick" data-live-search="true" title="Seleccione...">
                                                                {{-- <option value="">--Seleccione--</option> --}}
                                                                @if(count($acudientes) > 0)
                                                                    @foreach($acudientes as $acudiente)
                                                                    <option value="{{ $acudiente->ide_acu }}" {{ old('acudientes_ide_acu_edit') == $acudiente->ide_acu ? 'selected' : '' }}>{{ $acudiente->nom_acu }} {{ $acudiente->ape_acu }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <span class="text-danger">@error('acudientes_ide_acu_edit') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions m-t-20">
                                                <button type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Actualizar informaci&oacute;n del paciente</button>
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
