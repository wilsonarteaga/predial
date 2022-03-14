@extends('theme.default')
@section('content')

@push('scripts')
    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\AcudientesPacientesCreateFormRequest', '#create-form'); !!}
    {!! JsValidator::formRequest('App\Http\Requests\AcudientesPacientesUpdateFormRequest', '#update-form'); !!}
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
                                <li id="li-section-bar-1" class="tab-current"><a href="#section-bar-1" class="sticon ti-user"><span>Nueva asociaci&oacute;n</span></a></li>
                                <li id="li-section-bar-2" class=""><a href="#section-bar-2" class="sticon icon-list"><span>Listado de asociaciones</span></a></li>
                                <!-- <li class=""><a href="#section-bar-3" class="sticon ti-stats-up"><span>Analytics</span></a></li>
                                <li class=""><a href="#section-bar-4" class="sticon ti-upload"><span>Upload</span></a></li>
                                <li class=""><a href="#section-bar-5" class="sticon ti-settings"><span>Settings</span></a></li> -->
                            </ul>
                        </nav>
                        <div class="content-wrap">
                            <section id="section-bar-1" class="content-current">
                                <div class="panel panel-inverse">
                                    <div class="panel-heading"><i  class="{{ $opcion->icono }}"></i>&nbsp;&nbsp;Informaci&oacute;n a asociar</div>
                                    <div class="panel-wrapper collapse in" aria-expanded="true">
                                        <div class="panel-body">
                                            <form action="{{ route('aten.create_asoc') }}" method="post" id="create-form">
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
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label class="control-label">Acudiente</label>
                                                                <select id="ide_acu" name="ide_acu" class="form-control selectpicker show-tick dropdown" data-dropup-auto="false" data-live-search="true" data-size="3" title="Seleccione...">
                                                                    @if(count($acudientes) > 0)
                                                                        @foreach($acudientes as $acudiente)
                                                                            <option data-subtext="{{ $acudiente->ide_acu }}" value="{{ $acudiente->ide_acu }}" {{ old('ide_acu') == $acudiente->ide_acu ? 'selected' : '' }}>{{ $acudiente->nom_acu }} {{ $acudiente->ape_acu }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                                <span class="text-danger">@error('ide_acu') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">Tipo acudiente</label>
                                                                <select id="ide_tac" name="ide_tac" class="form-control selectpicker show-tick dropdown" data-dropup-auto="false" data-live-search="true" data-size="3" title="Seleccione...">
                                                                    @if(count($tipos_acudientes) > 0)
                                                                        @foreach($tipos_acudientes as $tipo_acudiente)
                                                                            <option value="{{ $tipo_acudiente->ide_tac }}" {{ old('ide_tac') == $tipo_acudiente->ide_tac ? 'selected' : '' }}>{{ $tipo_acudiente->nom_tac }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                                <span class="text-danger">@error('ide_tac') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="control-label">¿Tiene conocimiento de la dificultad del paciente?</label>
                                                                <select id="pre_paa" name="pre_paa" class="form-control selectpicker show-tick dropdown" data-width="fit" data-dropup-auto="false" data-live-search="true" data-size="3" title="Seleccione...">
                                                                    <option value="NO" {{ old('pre_paa') == "NO" ? 'selected' : '' }}>NO</option>
                                                                    <option value="SI" {{ old('pre_paa') == "SI"  || old('pre_paa') == null ? 'selected' : '' }}>SI</option>
                                                                </select>
                                                                <span class="text-danger">@error('pre_paa') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="control-label">Paciente</label>
                                                                <select id="ide_pac" name="ide_pac" class="form-control selectpicker show-tick dropdown" data-dropup-auto="false" data-live-search="true" data-size="3" title="Seleccione...">
                                                                    @if(count($pacientes) > 0)
                                                                        @foreach($pacientes as $paciente)
                                                                            <option data-subtext="{{ $paciente->ide_pac }}" value="{{ $paciente->ide_pac }}" {{ old('ide_pac') == $paciente->ide_pac ? 'selected' : '' }}>{{ $paciente->nom_pac }} {{ $paciente->ape_pac }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                                <span class="text-danger">@error('ide_pac') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-actions m-t-20">
                                                    <button type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Guardar asociaci&oacute;n</button>
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
                                        @if(isset($acudientes_pacientes))
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
                                            <h2>Lista de asociaciones</h2>
                                            <table id="myTable" class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="cell_center">Id</th>
                                                        <th class="cell_center">Acudiente</th>
                                                        <th class="cell_center">Tipo acudiente</th>
                                                        <th class="cell_center">Paciente</th>
                                                        <th class="cell_center" style="width: 10%;">Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(count($acudientes_pacientes) > 0)
                                                        @foreach($acudientes_pacientes as $acudiente_paciente)
                                                        <tr style="cursor: pointer;" json-data='@json($acudiente_paciente)'>
                                                            <td class="cell_center edit_row">{{ $acudiente_paciente->ide_paa }}</td>
                                                            <td class="edit_row">{{ $acudiente_paciente->nom_acu }} {{ $acudiente_paciente->ape_acu }}</td>
                                                            <td class="cell_center edit_row">{{ $acudiente_paciente->nom_tac }}</td>
                                                            <td class="edit_row">{{ $acudiente_paciente->nom_pac }} {{ $acudiente_paciente->ape_pac }}</td>
                                                            <td class="cell_center">
                                                                <button type="button" ide="{{ $acudiente_paciente->ide_paa }}" class="modify_row btn btn-info"><i class="fa fa-pencil-square"></i></button>
                                                                &nbsp;&nbsp;
                                                                <button type="button" ide="{{ $acudiente_paciente->ide_paa }}" class="delete_row btn btn-inverse"><i class="fa fa-trash-o"></i></button>
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
                                                {{ $acudientes->links('layouts.paginationlinks') }}
                                            </div> --}}
                                            <form id="form_delete" action="{{ route('aten.delete_asoc') }}" method="post" style="display: none;">
                                                @csrf
                                                <input type="hidden" id="input_delete" name="input_delete">
                                            </form>
                                        @endif
                                    </div>
                                </div>
                                <div id="div_edit_form" class="panel panel-info" style="display: none;">
                                    <div class="panel-heading"><i  class="{{ $opcion->icono }}"></i>&nbsp;&nbsp;Actualizar informaci&oacute;n del acudiente</div>
                                    <div class="panel-wrapper collapse in" aria-expanded="true">
                                        <div class="panel-body">
                                            <form action="{{ route('aten.update_asoc') }}" method="post" id="update-form">
                                                @csrf

                                                <div class="form-body">
                                                    <input type="hidden" id="ide_paa_edit" name="ide_paa_edit" value="{{ old('ide_paa_edit') }}">
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <label class="control-label">Acudiente</label>
                                                                <select id="acudientes_ide_acu_edit" name="acudientes_ide_acu_edit" class="form-control selectpicker show-tick dropdown" data-dropup-auto="false" data-live-search="true" data-size="3" title="Seleccione...">
                                                                    @if(count($acudientes) > 0)
                                                                        @foreach($acudientes as $acudiente)
                                                                            <option data-subtext="{{ $acudiente->ide_acu }}" value="{{ $acudiente->ide_acu }}" {{ old('acudientes_ide_acu_edit') == $acudiente->ide_acu ? 'selected' : '' }}>{{ $acudiente->nom_acu }} {{ $acudiente->ape_acu }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                                <span class="text-danger">@error('acudientes_ide_acu_edit') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label class="control-label">Tipo acudiente</label>
                                                                <select id="tipos_acudientes_ide_tac_edit" name="tipos_acudientes_ide_tac_edit" class="form-control selectpicker show-tick dropdown" data-dropup-auto="false" data-live-search="true" data-size="3" title="Seleccione...">
                                                                    @if(count($tipos_acudientes) > 0)
                                                                        @foreach($tipos_acudientes as $tipo_acudiente)
                                                                            <option value="{{ $tipo_acudiente->ide_tac }}" {{ old('tipos_acudientes_ide_tac_edit') == $tipo_acudiente->ide_tac ? 'selected' : '' }}>{{ $tipo_acudiente->nom_tac }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                                <span class="text-danger">@error('tipos_acudientes_ide_tac') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label class="control-label">¿Tiene conocimiento de la dificultad del paciente?</label>
                                                                <select id="pre_paa_edit" name="pre_paa_edit" class="form-control selectpicker show-tick dropdown" data-width="fit" data-dropup-auto="false" data-live-search="true" data-size="3" title="Seleccione...">
                                                                    <option value="NO" {{ old('pre_paa_edit') == "NO" ? 'selected' : '' }}>NO</option>
                                                                    <option value="SI" {{ old('pre_paa_edit') == "SI"  || old('pre_paa_edit') == null ? 'selected' : '' }}>SI</option>
                                                                </select>
                                                                <span class="text-danger">@error('pre_paa_edit') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
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
                                                    </div>
                                                </div>
                                                <div class="form-actions m-t-20">
                                                    <button type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Actualizar informaci&oacute;n</button>
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
