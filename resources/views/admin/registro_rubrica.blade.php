@extends('theme.default')
@section('content')

@push('scripts')
    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\RubricasCreateFormRequest', '#create-form'); !!}
    {!! JsValidator::formRequest('App\Http\Requests\RubricasUpdateFormRequest', '#update-form'); !!}
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
                            <li id="li-section-bar-1" class="tab-current"><a href="#section-bar-1" class="sticon fa fa-tasks"><span>Nueva rubrica</span></a></li>
                            <li id="li-section-bar-2" class=""><a href="#section-bar-2" class="sticon icon-list"><span>Listado de rubricas</span></a></li>
                            <!-- <li class=""><a href="#section-bar-3" class="sticon ti-stats-up"><span>Analytics</span></a></li>
                            <li class=""><a href="#section-bar-4" class="sticon ti-upload"><span>Upload</span></a></li>
                            <li class=""><a href="#section-bar-5" class="sticon ti-settings"><span>Settings</span></a></li> -->
                        </ul>
                    </nav>
                    <div class="content-wrap">
                        <section id="section-bar-1" class="content-current">
                            <div class="panel panel-inverse">
                                <div class="panel-heading"><i  class="{{ $opcion->icono }}"></i>&nbsp;&nbsp;Informaci&oacute;n de rubrica</div>
                                <div class="panel-wrapper collapse in" aria-expanded="true">
                                    <div class="panel-body">
                                        <form action="{{ route('admin.create_rub') }}" method="post" id="create-form">
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
                                                    <div class="col-lg-5 col-md-7 col-sm-10 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Juego</label>
                                                            <select id="ide_jue" name="ide_jue" class="form-control selectpicker show-tick" data-live-search="true" title="Seleccione...">
                                                                @if(count($juegos) > 0)
                                                                    @foreach($juegos as $juego)
                                                                    <option value="{{ $juego->ide_jue }}" {{ old('ide_jue') == $juego->ide_jue ? 'selected' : '' }}>{{ $juego->nom_jue }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <span class="text-danger">@error('ide_jue') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Valor</label>
                                                            <input type="text" id="val_rub" name="val_rub" class="form-control" maxlength="1" placeholder="Valor" value="{{ old('val_rub') }}" autocomplete="off" onkeyup="this.value = this.value.toUpperCase().replace(/\s/, '');" style="width: 80px;">
                                                            <span class="text-danger">@error('val_rub') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Concepto</label>
                                                            <textarea id="con_rub" name="con_rub" class="form-control" rows="6" style="resize: none;">{{ old('con_rub') }}</textarea>
                                                            <span class="text-danger">@error('con_rub') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions m-t-20">
                                                <button type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Guardar informaci&oacute;n de la rubrica</button>
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
                                        @if(isset($rubricas))
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
                                            <h2>Lista de rubricas</h2>
                                            <table id="myTable" class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="cell_center">Id</th>
                                                        <th class="cell_center">Juego</th>
                                                        <th class="cell_center">Concepto</th>
                                                        <th class="cell_center">Valor</th>
                                                        <th class="cell_center" style="width: 10%;">Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(count($rubricas) > 0)
                                                        @foreach($rubricas as $rubrica)
                                                        <tr style="cursor: pointer;" json-data='@json($rubrica)'>
                                                            <td class="cell_center edit_row">{{ $rubrica->ide_rub }}</td>
                                                            <td class="edit_row">{{ $rubrica->nom_jue }}</td>
                                                            <td class="edit_row">{{ $rubrica->con_rub }}</td>
                                                            <td class="cell_center edit_row">{{ $rubrica->val_rub }}</td>
                                                            <td class="cell_center">
                                                                <button type="button" ide="{{ $rubrica->ide_rub }}" class="modify_row btn btn-info"><i class="fa fa-pencil-square"></i></button>
                                                                &nbsp;&nbsp;
                                                                <button type="button" ide="{{ $rubrica->ide_rub }}" class="delete_row btn btn-inverse"><i class="fa fa-trash-o"></i></button>
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
                                            <form id="form_delete" action="{{ route('admin.delete_rub') }}" method="post" style="display: none;">
                                                @csrf
                                                <input type="hidden" id="input_delete" name="input_delete">
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div id="div_edit_form" class="panel panel-info" style="display: none;">
                                <div class="panel-heading"><i  class="{{ $opcion->icono }}"></i>&nbsp;&nbsp;Actualizar informaci&oacute;n de rubrica</div>
                                <div class="panel-wrapper collapse in" aria-expanded="true">
                                    <div class="panel-body">
                                        <form action="{{ route('admin.update_rub') }}" method="post" id="update-form">
                                            @csrf

                                            <div class="form-body">
                                                <input type="hidden" id="ide_rub_edit" name="ide_rub_edit" value="{{ old('ide_rub_edit') }}">
                                                <div class="row">
                                                    <div class="col-lg-5 col-md-7 col-sm-10 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Juego</label>
                                                            <select id="juegos_ide_jue_edit" name="juegos_ide_jue_edit" class="form-control selectpicker show-tick" data-live-search="true" title="Seleccione...">
                                                                @if(count($juegos) > 0)
                                                                    @foreach($juegos as $juego)
                                                                    <option value="{{ $juego->ide_jue }}" {{ old('juegos_ide_jue_edit') == $juego->ide_jue ? 'selected' : '' }}>{{ $juego->nom_jue }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <span class="text-danger">@error('juegos_ide_jue_edit') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Valor</label>
                                                            <input type="text" id="val_rub_edit" name="val_rub_edit" class="form-control" maxlength="1" placeholder="Valor" value="{{ old('val_rub_edit') }}" autocomplete="off" onkeyup="this.value = this.value.toUpperCase().replace(/\s/, '');" style="width: 80px;">
                                                            <span class="text-danger">@error('val_rub_edit') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <div class="form-group">
                                                            <label class="control-label">Concepto</label>
                                                            <textarea id="con_rub_edit" name="con_rub_edit" class="form-control" rows="6" style="resize: none;">{{ old('con_rub_edit') }}</textarea>
                                                            <span class="text-danger">@error('con_rub_edit') {{ $message }} @enderror</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions m-t-20">
                                                <button type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Actualizar informaci&oacute;n de la rubrica</button>
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
