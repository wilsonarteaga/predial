@extends('theme.default')
@section('content')

@push('scripts')
    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\JuegosCreateFormRequest', '#create-form'); !!}
    {!! JsValidator::formRequest('App\Http\Requests\JuegosUpdateFormRequest', '#update-form'); !!}
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
                            <li id="li-section-bar-1" class="tab-current"><a href="#section-bar-1" class="sticon icon-puzzle"><span>Nuevo juego</span></a></li>
                            <li id="li-section-bar-2" class=""><a href="#section-bar-2" class="sticon icon-list"><span>Listado de juegos</span></a></li>
                            <!-- <li class=""><a href="#section-bar-3" class="sticon ti-stats-up"><span>Analytics</span></a></li>
                            <li class=""><a href="#section-bar-4" class="sticon ti-upload"><span>Upload</span></a></li>
                            <li class=""><a href="#section-bar-5" class="sticon ti-settings"><span>Settings</span></a></li> -->
                        </ul>
                    </nav>
                    <div class="content-wrap">
                        <section id="section-bar-1" class="content-current">
                            <div class="panel panel-inverse">
                                <div class="panel-heading"><i  class="{{ $opcion->icono }}"></i>&nbsp;&nbsp;Informaci&oacute;n del juego</div>
                                <div class="panel-wrapper collapse in" aria-expanded="true">
                                    <div class="panel-body">
                                        <form action="{{ route('admin.create_jue') }}" method="post" id="create-form">
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
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Nombre juego</label>
                                                            <input type="text" id="nom_jue" name="nom_jue" class="form-control" placeholder="Ingrese nombre" value="{{ old('nom_jue') }}">
                                                            <span class="text-danger">@error('nom_jue') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">M&oacute;dulo</label>
                                                            <select id="mod_jue" name="mod_jue" class="form-control selectpicker show-tick" title="Seleccione...">
                                                                <option value="Lectura" {{ old('mod_jue') == "Lectura" ? 'selected' : '' }}>Lectura</option>
                                                                <option value="Escritura" {{ old('mod_jue') == "Escritura" ? 'selected' : '' }}>Escritura</option>
                                                                <option value="Conciencia fonológica" {{ old('mod_jue') == "Conciencia fonológica" ? 'selected' : '' }}>Conciencia fonol&oacute;gica</option>
                                                                <option value="Discriminación auditiva" {{ old('mod_jue') == "Discriminación auditiva" ? 'selected' : '' }}>Discriminaci&oacute;n auditiva</option>
                                                            </select>
                                                            <span class="text-danger">@error('mod_jue') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Tipo calificaci&oacute;n</label>
                                                            <select id="tic_jue" name="tic_jue" class="form-control selectpicker show-tick" title="Seleccione...">
                                                                <option value="Cualitativa" {{ old('tic_jue') == "Cualitativa" ? 'selected' : '' }}>Cualitativa</option>
                                                                <option value="Cuantitativa" {{ old('tic_jue') == "Cuantitativa" ? 'selected' : '' }}>Cuantitativa</option>
                                                            </select>
                                                            <span class="text-danger">@error('tic_jue') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Aleatorio</label>
                                                            <select id="ale_jue" name="ale_jue" class="form-control selectpicker show-tick" title="Seleccione...">
                                                                <option value="V" {{ old('ale_jue') == "V" || old('ale_jue') == null ? 'selected' : '' }}>Si</option>
                                                                <option value="F" {{ old('ale_jue') == "F" ? 'selected' : '' }}>No</option>
                                                            </select>
                                                            <span class="text-danger">@error('ale_jue') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Puntaje</label>
                                                            <input type="text" id="pun_jue" name="pun_jue" class="form-control onlyNumbers" placeholder="Ingrese puntaje" value="{{ old('pun_jue') }}">
                                                            <span class="text-danger">@error('pun_jue') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Tipo juego</label>
                                                            <select id="ide_tju" name="ide_tju" class="form-control selectpicker show-tick dropdown" data-dropup-auto="false" data-live-search="true" data-size="3" title="Seleccione...">
                                                                @if(count($tipos_juegos) > 0)
                                                                    @foreach($tipos_juegos as $tipo_juego)
                                                                        <option value="{{ $tipo_juego->ide_tju }}" {{ old('ide_tju') == $tipo_juego->ide_tju ? 'selected' : '' }}>{{ $tipo_juego->nom_tju }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <span class="text-danger">@error('ide_tju') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions m-t-20">
                                                <button type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Guardar informaci&oacute;n del juego</button>
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
                                        @if(isset($juegos))
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
                                            <h2>Lista de juegos</h2>
                                            <table id="myTable" class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="cell_center">Id</th>
                                                        <th class="cell_center">Nombres</th>
                                                        <th class="cell_center">M&oacute;dulo</th>
                                                        <th class="cell_center">Tipo calificaci&oacute;n</th>
                                                        <th class="cell_center">Aleatorio</th>
                                                        <th class="cell_center">Puntaje</th>
                                                        <th class="cell_center">Tipo juego</th>
                                                        <th class="cell_center" style="width: 10%;">Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(count($juegos) > 0)
                                                        @foreach($juegos as $juego)
                                                        <tr style="cursor: pointer;" json-data='@json($juego)'>
                                                            <td class="cell_center edit_row">{{ $juego->ide_jue }}</td>
                                                            <td class="edit_row">{{ $juego->nom_jue }}</td>
                                                            <td class="edit_row">{{ $juego->mod_jue }}</td>
                                                            <td class="cell_center edit_row">{{ $juego->tic_jue }}</td>
                                                            <td class="cell_center edit_row">{{ $juego->ale_jue == 'V' ? 'Si' : 'No' }}</td>
                                                            <td class="cell_center edit_row">{{ $juego->pun_jue }}</td>
                                                            <td class="edit_row">{{ $juego->nom_tju }}</td>
                                                            <td class="cell_center">
                                                                <button type="button" ide="{{ $juego->ide_jue }}" class="modify_row btn btn-info"><i class="fa fa-pencil-square"></i></button>
                                                                &nbsp;&nbsp;
                                                                <button type="button" ide="{{ $juego->ide_jue }}" class="delete_row btn btn-inverse"><i class="fa fa-trash-o"></i></button>
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
                                            <form id="form_delete" action="{{ route('admin.delete_jue') }}" method="post" style="display: none;">
                                                @csrf
                                                <input type="hidden" id="input_delete" name="input_delete">
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div id="div_edit_form" class="panel panel-info" style="display: none;">
                                <div class="panel-heading"><i  class="{{ $opcion->icono }}"></i>&nbsp;&nbsp;Actualizar informaci&oacute;n del juego</div>
                                <div class="panel-wrapper collapse in" aria-expanded="true">
                                    <div class="panel-body">
                                        <form action="{{ route('admin.update_jue') }}" method="post" id="update-form">
                                            @csrf

                                            <div class="form-body">
                                                <input type="hidden" id="ide_jue_edit" name="ide_jue_edit" value="{{ old('ide_jue_edit') }}">
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Nombre juego</label>
                                                            <input type="text" id="nom_jue_edit" name="nom_jue_edit" class="form-control" placeholder="Ingrese nombre" value="{{ old('nom_jue_edit') }}">
                                                            <span class="text-danger">@error('nom_jue_edit') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">M&oacute;dulo</label>
                                                            <select id="mod_jue_edit" name="mod_jue_edit" class="form-control selectpicker show-tick" title="Seleccione...">
                                                                <option value="Lectura" {{ old('mod_jue_edit') == "Lectura" ? 'selected' : '' }}>Lectura</option>
                                                                <option value="Escritura" {{ old('mod_jue_edit') == "Escritura" ? 'selected' : '' }}>Escritura</option>
                                                                <option value="Conciencia fonológica" {{ old('mod_jue_edit') == "Conciencia fonológica" ? 'selected' : '' }}>Conciencia fonol&oacute;gica</option>
                                                                <option value="Discriminación auditiva" {{ old('mod_jue_edit') == "Discriminación auditiva" ? 'selected' : '' }}>Discriminaci&oacute;n auditiva</option>
                                                            </select>
                                                            <span class="text-danger">@error('mod_jue_edit') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Tipo calificaci&oacute;n</label>
                                                            <select id="tic_jue_edit" name="tic_jue_edit" class="form-control selectpicker show-tick" title="Seleccione...">
                                                                <option value="Cualitativa" {{ old('tic_jue_edit') == "Cualitativa" ? 'selected' : '' }}>Cualitativa</option>
                                                                <option value="Cuantitativa" {{ old('tic_jue_edit') == "Cuantitativa" ? 'selected' : '' }}>Cuantitativa</option>
                                                            </select>
                                                            <span class="text-danger">@error('tic_jue_edit') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Aleatorio</label>
                                                            <select id="ale_jue_edit" name="ale_jue_edit" class="form-control selectpicker show-tick" title="Seleccione...">
                                                                <option value="V" {{ old('ale_jue_edit') == "V" || old('ale_jue') == null ? 'selected' : '' }}>Si</option>
                                                                <option value="F" {{ old('ale_jue_edit') == "F" ? 'selected' : '' }}>No</option>
                                                            </select>
                                                            <span class="text-danger">@error('ale_jue_edit') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Puntaje</label>
                                                            <input type="text" id="pun_jue_edit" name="pun_jue_edit" class="form-control onlyNumbers" placeholder="Ingrese puntaje" value="{{ old('pun_jue_edit') }}">
                                                            <span class="text-danger">@error('pun_jue_edit') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Tipo juego</label>
                                                            <select id="tipos_juegos_ide_tju_edit" name="tipos_juegos_ide_tju_edit" class="form-control selectpicker show-tick dropdown" data-dropup-auto="false" data-live-search="true" data-size="3" title="Seleccione...">
                                                                @if(count($tipos_juegos) > 0)
                                                                    @foreach($tipos_juegos as $tipo_juego)
                                                                        <option value="{{ $tipo_juego->ide_tju }}" {{ old('tipos_juegos_ide_tju_edit') == $tipo_juego->ide_tju ? 'selected' : '' }}>{{ $tipo_juego->nom_tju }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <span class="text-danger">@error('tipos_juegos_ide_tju_edit') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions m-t-20">
                                                <button type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Actualizar informaci&oacute;n del juego</button>
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
