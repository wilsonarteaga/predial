@extends('theme.default')
@section('content')

@push('scripts')
    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\AcudientesCreateFormRequest', '#create-form'); !!}
    {!! JsValidator::formRequest('App\Http\Requests\AcudientesUpdateFormRequest', '#update-form'); !!}
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
                                <li id="li-section-bar-1" class="tab-current"><a href="#section-bar-1" class="sticon ti-user"><span>Nuevo acudiente</span></a></li>
                                <li id="li-section-bar-2" class=""><a href="#section-bar-2" class="sticon icon-list"><span>Listado de acudientes</span></a></li>
                                <!-- <li class=""><a href="#section-bar-3" class="sticon ti-stats-up"><span>Analytics</span></a></li>
                                <li class=""><a href="#section-bar-4" class="sticon ti-upload"><span>Upload</span></a></li>
                                <li class=""><a href="#section-bar-5" class="sticon ti-settings"><span>Settings</span></a></li> -->
                            </ul>
                        </nav>
                        <div class="content-wrap">
                            <section id="section-bar-1" class="content-current">
                                <div class="panel panel-inverse">
                                    <div class="panel-heading"><i  class="{{ $opcion->icono }}"></i>&nbsp;&nbsp;Informaci&oacute;n del acudiente</div>
                                    <div class="panel-wrapper collapse in" aria-expanded="true">
                                        <div class="panel-body">
                                            <form action="{{ route('aten.create_acu') }}" method="post" id="create-form">
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
                                                                <input type="text" id="nom_acu" name="nom_acu" class="form-control" placeholder="Ingrese nombres" value="{{ old('nom_acu') }}">
                                                                <span class="text-danger">@error('nom_acu') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Apellidos</label>
                                                                <input type="text" id="ape_acu" name="ape_acu" class="form-control" placeholder="Ingrese apellidos" value="{{ old('ape_acu') }}">
                                                                <span class="text-danger">@error('ape_acu') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Tipo identificaci&oacute;n</label>
                                                                <select id="tid_acu" name="tid_acu" class="form-control selectpicker" title="Seleccione...">
                                                                    <option value="CC" {{ old('tid_acu') == "CC" || old('tid_acu') == null ? 'selected' : '' }}>C&eacute;dula</option>
                                                                    <option value="TI" {{ old('tid_acu') == "TI" ? 'selected' : '' }}>Tarjeta Identidad</option>
                                                                    <option value="CE" {{ old('tid_acu') == "CE" ? 'selected' : '' }}>C&eacute;dula extranjer&iacute;a</option>
                                                                    <option value="PS" {{ old('tid_acu') == "PS" ? 'selected' : '' }}>Pasaporte</option>
                                                                    <option value="RC" {{ old('tid_acu') == "RC" ? 'selected' : '' }}>Registro Civ&iacute;l</option>
                                                                </select>
                                                                <span class="text-danger">@error('tid_acu') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Identificaci&oacute;n</label>
                                                                <input type="text" id="ide_acu" name="ide_acu" class="form-control onlyNumbers" placeholder="Ingrese identificaci&oacute;n" value="{{ old('ide_acu') }}">
                                                                <span class="text-danger">@error('ide_acu') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Tel&eacute;fono</label>
                                                                <input type="text" id="tel_acu" name="tel_acu" class="form-control onlyNumbers" placeholder="Ingrese tel&eacute;fono" value="{{ old('tel_acu') }}">
                                                                <span class="text-danger">@error('tel_acu') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                                <label class="control-label">Direcci&oacute;n</label>
                                                                {{-- <textarea id="dir_acu" name="dir_acu" class="form-control" rows="3" style="resize: none;">{{ old('dir_acu') }}</textarea> --}}
                                                                <input type="text" id="dir_acu" name="dir_acu" class="form-control" placeholder="Ingrese la direcci&oacute;n" value="{{ old('dir_acu') }}">
                                                                <span class="text-danger">@error('dir_acu') {{ $message }} @enderror</span>
                                                            </div>

                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="form-actions m-t-20">
                                                    <button type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Guardar informaci&oacute;n del acudiente</button>
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
                                        <div class="well">
                                            @if(isset($acudientes))
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
                                                <h2>Lista de acudientes</h2>
                                                <table id="myTable" class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th class="cell_center">Identificaci&oacute;n</th>
                                                            <th class="cell_center">Tipo Identificaci&oacute;n</th>
                                                            <th class="cell_center">Nombres</th>
                                                            <th class="cell_center">Apellidos</th>
                                                            <th class="cell_center">Tel&eacute;fono</th>
                                                            <th class="cell_center">Direcci&oacute;n</th>
                                                            <th class="cell_center" style="width: 10%;">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(count($acudientes) > 0)
                                                            @foreach($acudientes as $acudiente)
                                                            <tr style="cursor: pointer;" json-data='@json($acudiente)'>
                                                                <td class="cell_center edit_row">{{ $acudiente->ide_acu }}</td>
                                                                <td class="cell_center edit_row">{{ $acudiente->tid_acu }}</td>
                                                                <td class="edit_row">{{ $acudiente->nom_acu }}</td>
                                                                <td class="edit_row">{{ $acudiente->ape_acu }}</td>
                                                                <td class="cell_center edit_row">{{ $acudiente->tel_acu }}</td>
                                                                <td class="edit_row">{{ $acudiente->dir_acu }}</td>
                                                                <td class="cell_center">
                                                                    <button type="button" ide="{{ $acudiente->ide_acu }}" class="modify_row btn btn-info"><i class="fa fa-pencil-square"></i></button>
                                                                    &nbsp;&nbsp;
                                                                    <button type="button" ide="{{ $acudiente->ide_acu }}" class="delete_row btn btn-inverse"><i class="fa fa-trash-o"></i></button>
                                                                </td>
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
                                                    {{ $acudientes->links('layouts.paginationlinks') }}
                                                </div> --}}
                                                <form id="form_delete" action="{{ route('aten.delete_acu') }}" method="post" style="display: none;">
                                                    @csrf
                                                    <input type="hidden" id="input_delete" name="input_delete">
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div id="div_edit_form" class="panel panel-info" style="display: none;">
                                    <div class="panel-heading"><i  class="{{ $opcion->icono }}"></i>&nbsp;&nbsp;Actualizar informaci&oacute;n del acudiente</div>
                                    <div class="panel-wrapper collapse in" aria-expanded="true">
                                        <div class="panel-body">
                                            <form action="{{ route('aten.update_acu') }}" method="post" id="update-form">
                                                @csrf

                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Nombres</label>
                                                                <input type="text" id="nom_acu_edit" name="nom_acu_edit" class="form-control" placeholder="Ingrese nombres" value="{{ old('nom_acu_edit') }}">
                                                                <span class="text-danger">@error('nom_acu_edit') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label">Apellidos</label>
                                                                <input type="text" id="ape_acu_edit" name="ape_acu_edit" class="form-control" placeholder="Ingrese apellidos" value="{{ old('ape_acu_edit') }}">
                                                                <span class="text-danger">@error('ape_acu_edit') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Tipo identificaci&oacute;n</label>
                                                                <select id="tid_acu_edit" name="tid_acu_edit" class="form-control selectpicker" title="Seleccione...">
                                                                    <option value="CC" {{ old('tid_acu_edit') == "CC" ? 'selected' : '' }}>C&eacute;dula</option>
                                                                    <option value="TI" {{ old('tid_acu_edit') == "TI" ? 'selected' : '' }}>Tarjeta Identidad</option>
                                                                    <option value="CE" {{ old('tid_acu_edit') == "CE" ? 'selected' : '' }}>C&eacute;dula extranjer&iacute;a</option>
                                                                    <option value="PS" {{ old('tid_acu_edit') == "PS" ? 'selected' : '' }}>Pasaporte</option>
                                                                    <option value="RC" {{ old('tid_acu_edit') == "RC" ? 'selected' : '' }}>Registro Civ&iacute;l</option>
                                                                </select>
                                                                <span class="text-danger">@error('tid_acu_edit') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Identificaci&oacute;n</label>
                                                                <input type="text" id="ide_acu_edit" name="ide_acu_edit" readonly="" class="form-control onlyNumbers" placeholder="Ingrese identificaci&oacute;n" value="{{ old('ide_acu_edit') }}">
                                                                <span class="text-danger">@error('ide_acu_edit') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Tel&eacute;fono</label>
                                                                <input type="text" id="tel_acu_edit" name="tel_acu_edit" class="form-control onlyNumbers" placeholder="Ingrese tel&eacute;fono" value="{{ old('tel_acu_edit') }}">
                                                                <span class="text-danger">@error('tel_acu_edit') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Direcci&oacute;n</label>
                                                                {{-- <textarea id="dir_acu_edit" name="dir_acu_edit" class="form-control" rows="3" style="resize: none;">{{ old('dir_acu_edit') }}</textarea> --}}
                                                                <input type="text" id="dir_acu_edit" name="dir_acu_edit" class="form-control" placeholder="Ingrese la direcci&oacute;n" value="{{ old('dir_acu_edit') }}">
                                                                <span class="text-danger">@error('dir_acu_edit') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-actions m-t-20">
                                                    <button type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Actualizar informaci&oacute;n del acudiente</button>
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
