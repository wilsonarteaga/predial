@extends('theme.default')
@section('content')

@push('scripts')
    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\UsuariosCreateFormRequest', '#create-form'); !!}
    {!! JsValidator::formRequest('App\Http\Requests\UsuariosUpdateFormRequest', '#update-form'); !!}
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
                            <li id="li-section-bar-1" class="tab-current"><a href="#section-bar-1" class="sticon ti-user"><span>Nuevo usuario</span></a></li>
                            <li id="li-section-bar-2" class=""><a href="#section-bar-2" class="sticon icon-list"><span>Listado de usuarios</span></a></li>
                            <!-- <li class=""><a href="#section-bar-3" class="sticon ti-stats-up"><span>Analytics</span></a></li>
                            <li class=""><a href="#section-bar-4" class="sticon ti-upload"><span>Upload</span></a></li>
                            <li class=""><a href="#section-bar-5" class="sticon ti-settings"><span>Settings</span></a></li> -->
                        </ul>
                    </nav>
                    <div class="content-wrap">
                        <section id="section-bar-1" class="content-current">
                            <div class="panel panel-inverse">
                                <div class="panel-heading"><i  class="{{ $opcion->icono }}"></i>&nbsp;&nbsp;Informaci&oacute;n del usuario</div>
                                <div class="panel-wrapper collapse in" aria-expanded="true">
                                    <div class="panel-body">
                                        <form action="{{ route('admin.create_usu') }}" method="post" id="create-form">
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
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label">Nombres</label>
                                                            <input type="text" id="nom_usu" name="nom_usu" class="form-control" placeholder="Ingrese nombres" value="{{ old('nom_usu') }}">
                                                            <span class="text-danger">@error('nom_usu') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label">Apellidos</label>
                                                            <input type="text" id="ape_usu" name="ape_usu" class="form-control" placeholder="Ingrese apellidos" value="{{ old('ape_usu') }}">
                                                            <span class="text-danger">@error('ape_usu') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Tipo identificaci&oacute;n</label>
                                                            <select id="tid_usu" name="tid_usu" class="form-control selectpicker show-tick" title="Seleccione...">
                                                                <option value="CC" {{ old('tid_usu') == "CC"  || old('tid_usu') == null ? 'selected' : '' }}>C&eacute;dula</option>
                                                                {{-- <option value="TI" {{ old('tid_usu') == "TI" ? 'selected' : '' }}>Tarjeta Identidad</option> --}}
                                                                <option value="CE" {{ old('tid_usu') == "CE" ? 'selected' : '' }}>C&eacute;dula extranjer&iacute;a</option>
                                                                <option value="PS" {{ old('tid_usu') == "PS" ? 'selected' : '' }}>Pasaporte</option>
                                                                {{-- <option value="RC" {{ old('tid_usu') == "RC" ? 'selected' : '' }}>Registro Civ&iacute;l</option> --}}
                                                            </select>
                                                            <span class="text-danger">@error('tid_usu') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Identificaci&oacute;n</label>
                                                            <input type="text" id="ide_usu" name="ide_usu" class="form-control onlyNumbers" placeholder="Ingrese identificaci&oacute;n" value="{{ old('ide_usu') }}">
                                                            <span class="text-danger">@error('ide_usu') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Correo electr&oacute;nico</label>
                                                            <input type="email" id="cor_usu" name="cor_usu" class="form-control" placeholder="Ingrese correo electr&oacute;nico" value="{{ old('cor_usu') }}">
                                                            <span class="text-danger">@error('cor_usu') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Fecha nacimiento</label>
                                                            <div style="position:relative">
                                                                <div class="input-group">
                                                                    <input type="text" id="fec_usu" name="fec_usu" class="form-control datepicker withadon" autocomplete="off" placeholder="yyyy-mm-dd" value="{{ old('fec_usu') }}">
                                                                    <div class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-th"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <span class="text-danger">@error('fec_usu') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Tel&eacute;fono</label>
                                                            <input type="text" id="tel_usu" name="tel_usu" class="form-control onlyNumbers" placeholder="Ingrese tel&eacute;fono" value="{{ old('tel_usu') }}">
                                                            <span class="text-danger">@error('tel_usu') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-10 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Direcci&oacute;n</label>
                                                            <input type="text" id="dir_usu" name="dir_usu" class="form-control" placeholder="Ingrese direcci&oacute;n" value="{{ old('dir_usu') }}">
                                                            <span class="text-danger">@error('dir_usu') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="con_usu" class="control-label">Contrase&ntilde;a:</label>
                                                            <div class="input-group">
                                                                <input type="password" class="form-control withadon" id="con_usu" name="con_usu" value="{{ old('con_usu') }}">
                                                                <div class="input-group-addon"><i class="ti-lock"></i></div>
                                                            </div>
                                                            <span class="text-danger">@error('con_usu') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="con_usu_confirmation" class="control-label">Repita la contrase&ntilde;a:</label>
                                                            <div class="input-group">
                                                                <input type="password" class="form-control withadon" id="con_usu_confirmation" name="con_usu_confirmation" value="{{ old('con_usu_confirmation') }}">
                                                                <div class="input-group-addon"><i class="ti-lock"></i></div>
                                                            </div>
                                                            <span class="text-danger">@error('con_usu_confirmation') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Tipo usuario</label>
                                                            <select id="ide_tip" name="ide_tip" class="form-control selectpicker show-tick dropdown" data-dropup-auto="false" data-live-search="true" data-size="3" title="Seleccione...">
                                                                @if(count($tipos_usuarios) > 0)
                                                                    @foreach($tipos_usuarios as $tipo_usuario)
                                                                        <option value="{{ $tipo_usuario->ide_tip }}" {{ old('ide_tip') == $tipo_usuario->ide_tip ? 'selected' : '' }}>{{ $tipo_usuario->nom_tip }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <span class="text-danger">@error('ide_tip') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-2 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Estado</label>
                                                            <input id="est_usu" name="est_usu" type="hidden" value="A">
                                                            <div id="div_est_usu_tmp" class="checkbox checkbox-danger">
                                                                <input id="est_usu_tmp" name="est_usu_tmp" type="checkbox" checked="">
                                                                <label id="label_est_usu" for="est_usu_tmp"> Activo </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions m-t-20">
                                                <button type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Guardar informaci&oacute;n del usuario</button>
                                                <!-- <button type="button" class="btn btn-default">Cancelar</button> -->
                                            </div>
                                        </form>
                                        <br />
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section id="section-bar-2" class="">
                            <div id="div_table" class="row">
                                <div class="col-lg-12">
                                    <div class="well">
                                        @if(isset($usuarios))
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
                                            <h2>Lista de usuarios</h2>
                                            <table id="myTable" class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="cell_center">Identificaci&oacute;n</th>
                                                        {{-- <th class="cell_center">Tipo Identificaci&oacute;n</th> --}}
                                                        <th class="cell_center">Nombres</th>
                                                        <th class="cell_center">Apellidos</th>
                                                        <th class="cell_center">Correo electr&oacute;nico</th>
                                                        <th class="cell_center">Tel&eacute;fono</th>
                                                        <th class="cell_center">Tipo usuario</th>
                                                        <th class="cell_center">Estado</th>
                                                        <th class="cell_center" style="width: 10%;">Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(count($usuarios) > 0)
                                                        @foreach($usuarios as $usuario)
                                                        <tr style="cursor: pointer;" json-data='@json($usuario)'>
                                                            <td class="edit_row">{{ $usuario->tid_usu }}: {{ $usuario->ide_usu }}</td>
                                                            {{-- <td class="cell_center edit_row">{{ $usuario->tid_usu }}</td> --}}
                                                            <td class="edit_row">{{ $usuario->nom_usu }}</td>
                                                            <td class="edit_row">{{ $usuario->ape_usu }}</td>
                                                            <td class="edit_row">{{ $usuario->cor_usu }}</td>
                                                            <td class="edit_row">{{ $usuario->tel_usu }}</td>
                                                            <td class="cell_center edit_row">{{ $usuario->nom_tip }}</td>
                                                            <td class="cell_center edit_row">{{ $usuario->est_usu }}</td>
                                                            <td class="cell_center">
                                                                <button type="button" ide="{{ $usuario->ide_usu }}" class="modify_row btn btn-info"><i class="fa fa-pencil-square"></i></button>
                                                                &nbsp;&nbsp;
                                                                <button type="button" ide="{{ $usuario->ide_usu }}" class="delete_row btn btn-inverse"><i class="fa fa-trash-o"></i></button>
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
                                            <form id="form_delete" action="{{ route('admin.delete_usu') }}" method="post" style="display: none;">
                                                @csrf
                                                <input type="hidden" id="input_delete" name="input_delete">
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div id="div_edit_form" class="panel panel-info" style="display: none;">
                                <div class="panel-heading"><i  class="{{ $opcion->icono }}"></i>&nbsp;&nbsp;Actualizar informaci&oacute;n del usuario</div>
                                <div class="panel-wrapper collapse in" aria-expanded="true">
                                    <div class="panel-body">
                                        <form action="{{ route('admin.update_usu') }}" method="post" id="update-form">
                                            @csrf

                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label">Nombres</label>
                                                            <input type="text" id="nom_usu_edit" name="nom_usu_edit" class="form-control" placeholder="Ingrese nombres" value="{{ old('nom_usu_edit') }}">
                                                            <span class="text-danger">@error('nom_usu_edit') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="control-label">Apellidos</label>
                                                            <input type="text" id="ape_usu_edit" name="ape_usu_edit" class="form-control" placeholder="Ingrese apellidos" value="{{ old('ape_usu_edit') }}">
                                                            <span class="text-danger">@error('ape_usu_edit') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Tipo identificaci&oacute;n</label>
                                                            <select id="tid_usu_edit" name="tid_usu_edit" class="form-control selectpicker show-tick" title="Seleccione...">
                                                                <option value="CC" {{ old('tid_usu_edit') == "CC"  || old('tid_usu_edit') == null ? 'selected' : '' }}>C&eacute;dula</option>
                                                                {{-- <option value="TI" {{ old('tid_usu_edit') == "TI" ? 'selected' : '' }}>Tarjeta Identidad</option> --}}
                                                                <option value="CE" {{ old('tid_usu_edit') == "CE" ? 'selected' : '' }}>C&eacute;dula extranjer&iacute;a</option>
                                                                <option value="PS" {{ old('tid_usu_edit') == "PS" ? 'selected' : '' }}>Pasaporte</option>
                                                                {{-- <option value="RC" {{ old('tid_usu_edit') == "RC" ? 'selected' : '' }}>Registro Civ&iacute;l</option> --}}
                                                            </select>
                                                            <span class="text-danger">@error('tid_usu_edit') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Identificaci&oacute;n</label>
                                                            <input type="text" id="ide_usu_edit" name="ide_usu_edit" readonly="" class="form-control onlyNumbers" placeholder="Ingrese identificaci&oacute;n" value="{{ old('ide_usu_edit') }}">
                                                            <span class="text-danger">@error('ide_usu_edit') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-10 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Correo electr&oacute;nico</label>
                                                            <input type="email" id="cor_usu_edit" name="cor_usu_edit" class="form-control" placeholder="Ingrese correo electr&oacute;nico" value="{{ old('cor_usu_edit') }}">
                                                            <span class="text-danger">@error('cor_usu_edit') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Fecha nacimiento</label>
                                                            <div style="position:relative">
                                                                <div class="input-group">
                                                                    <input type="text" id="fec_usu_edit" name="fec_usu_edit" class="form-control datepicker withadon" autocomplete="off" placeholder="yyyy-mm-dd" value="{{ old('fec_usu_edit') }}">
                                                                    <div class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-th"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <span class="text-danger">@error('fec_usu_edit') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Tel&eacute;fono</label>
                                                            <input type="text" id="tel_usu_edit" name="tel_usu_edit" class="form-control onlyNumbers" placeholder="Ingrese tel&eacute;fono" value="{{ old('tel_usu_edit') }}">
                                                            <span class="text-danger">@error('tel_usu_edit') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Direcci&oacute;n</label>
                                                            <input type="text" id="dir_usu_edit" name="dir_usu_edit" class="form-control" placeholder="Ingrese direcci&oacute;n" value="{{ old('dir_usu_edit') }}">
                                                            <span class="text-danger">@error('dir_usu_edit') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="con_usu_edit" class="control-label">Contrase&ntilde;a:</label>
                                                            <div class="input-group">
                                                                <input type="password" class="form-control withadon" id="con_usu_edit" name="con_usu_edit" value="{{ old('con_usu_edit') }}">
                                                                <div class="input-group-addon"><i class="ti-lock"></i></div>
                                                            </div>
                                                            <span class="text-danger">@error('con_usu_edit') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label for="con_usu_edit_confirmation" class="control-label">Repita la contrase&ntilde;a:</label>
                                                            <div class="input-group">
                                                                <input type="password" class="form-control withadon" id="con_usu_edit_confirmation" name="con_usu_edit_confirmation" value="{{ old('con_usu_edit_confirmation') }}">
                                                                <div class="input-group-addon"><i class="ti-lock"></i></div>
                                                            </div>
                                                            <span class="text-danger">@error('con_usu_edit_confirmation') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Tipo usuario</label>
                                                            <select id="tipos_usuarios_ide_tip_edit" name="tipos_usuarios_ide_tip_edit" class="form-control selectpicker show-tick dropdown" data-dropup-auto="false" data-live-search="true" data-size="3" title="Seleccione...">
                                                                @if(count($tipos_usuarios) > 0)
                                                                    @foreach($tipos_usuarios as $tipo_usuario)
                                                                        <option value="{{ $tipo_usuario->ide_tip }}" {{ old('tipos_usuarios_ide_tip_edit') == $tipo_usuario->ide_tip ? 'selected' : '' }}>{{ $tipo_usuario->nom_tip }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <span class="text-danger">@error('tipos_usuarios_ide_tip_edit') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-2 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Estado</label>
                                                            <input id="est_usu_edit" name="est_usu_edit" type="hidden" value="">
                                                            <div id="div_est_usu_tmp_edit" class="checkbox checkbox-danger">
                                                                <input id="est_usu_tmp_edit" name="est_usu_tmp_edit" type="checkbox">
                                                                <label id="label_est_usu_edit" for="est_usu_tmp_edit"> Inactivo </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions m-t-20">
                                                <button type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Actualizar informaci&oacute;n del usuario</button>
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
