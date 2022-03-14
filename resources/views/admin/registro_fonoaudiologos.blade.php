@extends('theme.default')
@section('content')

@push('scripts')
    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\FonoaudiologosCreateFormRequest', '#create-form'); !!}
    {!! JsValidator::formRequest('App\Http\Requests\FonoaudiologosUpdateFormRequest', '#update-form'); !!}
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
                            <li id="li-section-bar-1" class="tab-current"><a href="#section-bar-1" class="sticon ti-user"><span>Nuevo fonoaudiologo</span></a></li>
                            <li id="li-section-bar-2" class=""><a href="#section-bar-2" class="sticon icon-list"><span>Listado de fonoaudiologos</span></a></li>
                            <!-- <li class=""><a href="#section-bar-3" class="sticon ti-stats-up"><span>Analytics</span></a></li>
                            <li class=""><a href="#section-bar-4" class="sticon ti-upload"><span>Upload</span></a></li>
                            <li class=""><a href="#section-bar-5" class="sticon ti-settings"><span>Settings</span></a></li> -->
                        </ul>
                    </nav>
                    <div class="content-wrap">
                        <section id="section-bar-1" class="content-current">
                            <div class="panel panel-inverse">
                                <div class="panel-heading"><i  class="{{ $opcion->icono }}"></i>&nbsp;&nbsp;Informaci&oacute;n del fonoaudiologo</div>
                                <div class="panel-wrapper collapse in" aria-expanded="true">
                                    <div class="panel-body">
                                        <form action="{{ route('admin.create_fon') }}" method="post" id="create-form">
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
                                                    <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Usuario</label>
                                                            <select id="ide_usu" name="ide_usu" class="form-control selectpicker show-tick" data-live-search="true" title="Seleccione...">
                                                                @if(count($usuarios) > 0)
                                                                    @foreach($usuarios as $usuario)
                                                                    <option value="{{ $usuario->ide_usu }}" {{ old('ide_usu') == $usuario->ide_usu ? 'selected' : '' }}>{{ $usuario->nom_usu }} {{ $usuario->ape_usu }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <span class="text-danger">@error('ide_usu') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">N&uacute;mero de registro fonoaudiologo</label>
                                                            <input type="text" id="num_fon" name="num_fon" class="form-control onlyNumbers" autocomplete="off" placeholder="Ingrese n&uacute;mero de registro" value="{{ old('num_fon') }}">
                                                            <span class="text-danger">@error('num_fon') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions m-t-20">
                                                <button type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Guardar informaci&oacute;n del fonoaudiologo</button>
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
                                        @if(isset($fonoaudiologos))
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
                                            <h2>Lista de fonoaudiologos</h2>
                                            <table id="myTable" class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="cell_center">Identificaci&oacute;n</th>
                                                        <th class="cell_center">Nombres</th>
                                                        <th class="cell_center">Apellidos</th>
                                                        <th class="cell_center">N&uacute;mero de registro</th>
                                                        <th class="cell_center" style="width: 10%;">Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(count($fonoaudiologos) > 0)
                                                        @foreach($fonoaudiologos as $fonoaudiologo)
                                                        <tr style="cursor: pointer;" json-data='@json($fonoaudiologo)'>
                                                            <td class="cell_center edit_row">{{ $fonoaudiologo->usuarios_ide_usu }}</td>
                                                            <td class="edit_row">{{ $fonoaudiologo->nom_usu }}</td>
                                                            <td class="edit_row">{{ $fonoaudiologo->ape_usu }}</td>
                                                            <td class="cell_center edit_row">{{ $fonoaudiologo->num_fon }}</td>
                                                            <td class="cell_center">
                                                                <button type="button" ide="{{ $fonoaudiologo->ide_fon }}" class="modify_row btn btn-info"><i class="fa fa-pencil-square"></i></button>
                                                                {{-- &nbsp;&nbsp;
                                                                <button type="button" ide="{{ $paciente->ide_pac }}" class="delete_row btn btn-inverse"><i class="fa fa-trash-o"></i></button> --}}
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
                                            {{-- <form id="form_delete" action="{{ route('aten.delete_pac') }}" method="post" style="display: none;">
                                                @csrf
                                                <input type="hidden" id="input_delete" name="input_delete">
                                            </form> --}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div id="div_edit_form" class="panel panel-info" style="display: none;">
                                <div class="panel-heading"><i  class="{{ $opcion->icono }}"></i>&nbsp;&nbsp;Actualizar informaci&oacute;n del fonoaudiologo</div>
                                <div class="panel-wrapper collapse in" aria-expanded="true">
                                    <div class="panel-body">
                                        <form action="{{ route('admin.update_fon') }}" method="post" id="update-form">
                                            @csrf

                                            <div class="form-body">
                                                <input type="hidden" id="ide_fon_edit" name="ide_fon_edit" value="{{ old('ide_fon_edit') }}">
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Usuario</label>
                                                            <select id="usuarios_ide_usu_edit" name="usuarios_ide_usu_edit" class="form-control selectpicker show-tick" data-live-search="true" title="Seleccione...">
                                                                @if(count($usuarios_up) > 0)
                                                                    @foreach($usuarios_up as $usuario)
                                                                    <option value="{{ $usuario->ide_usu }}" {{ old('usuarios_ide_usu_edit') == $usuario->ide_usu ? 'selected' : '' }}>{{ $usuario->nom_usu }} {{ $usuario->ape_usu }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <span class="text-danger">@error('usuarios_ide_usu_edit') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-5 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">N&uacute;mero de registro fonoaudiologo</label>
                                                            <input type="text" id="num_fon_edit" name="num_fon_edit" class="form-control onlyNumbers" autocomplete="off" placeholder="Ingrese n&uacute;mero de registro" value="{{ old('num_fon_edit') }}">
                                                            <span class="text-danger">@error('num_fon_edit') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions m-t-20">
                                                <button type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Actualizar informaci&oacute;n del fonoaudiologo</button>
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
