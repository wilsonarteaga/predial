@extends('theme.default')

@section('content')

@push('scripts')
    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\PrediosExencionesCreateFormRequest', '#create-form'); !!}
    {!! JsValidator::formRequest('App\Http\Requests\PrediosExencionesUpdateFormRequest', '#update-form'); !!}
    <script src="{!! asset('theme/js/accounting.min.js') !!}"></script>
    <script src="{!! asset('theme/js/autonumeric.min.js') !!}"></script>
    <script src="{!! asset('theme/js/jquery.form.js') !!}"></script>
    <script src="{!! asset('theme/plugins/bower_components/jquery.serializeJSON/jquery.serializejson.min.js') !!}"></script>
    <script src="{!! asset('theme/plugins/bower_components/blockUI/jquery.blockUI.js') !!}"></script>
    <script src="{!! asset('theme/plugins/bower_components/bootstrap-filestyle/bootstrap-filestyle.min.js') !!}"></script>
    <script src="{!! asset('theme/js/customjs/controlsite.js') !!}"></script>
    <script src="{!! asset('theme/js/customjs/load_file.js') !!}"></script>
@endpush
@if(Session::get('tab_current'))
<input type="hidden" id="tab" value="{{ Session::get('tab_current') }}">
@elseif($tab_current)
<input type="hidden" id="tab" value="{{ $tab_current }}">
@endif
<input type="hidden" id="opcion" value='@json($opcion)'>
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
                                <li id="li-section-bar-1" class="tab-current"><a href="#section-bar-1" class="sticon ti-check-box"><span>Nueva exenci&oacute;n</span></a></li>
                                <li id="li-section-bar-2" class=""><a href="#section-bar-2" class="sticon icon-list"><span>Listado de exenciones</span></a></li>
                                <!-- <li class=""><a href="#section-bar-3" class="sticon ti-stats-up"><span>Analytics</span></a></li>
                                <li class=""><a href="#section-bar-4" class="sticon ti-upload"><span>Upload</span></a></li>
                                <li class=""><a href="#section-bar-5" class="sticon ti-settings"><span>Settings</span></a></li> -->
                            </ul>
                        </nav>
                        <div class="content-wrap">
                            <section id="section-bar-1" class="content-current">
                                <div class="panel panel-inverse">
                                    <div class="panel-heading"><i  class="{{ $opcion->icono }}"></i>&nbsp;&nbsp;Informaci&oacute;n de la exenci&oacute;n de vigencia</div>
                                    <div class="panel-wrapper collapse in" aria-expanded="true">
                                        <div class="panel-body">
                                            @if($opcion->resolucion_crea == 1)
                                            {{--
                                                Aqui se establecen todos los campos que se desee validar antes de enviar el formulario.
                                                Esto aplica solo para los formularios que necesitan una resolucion para edicion.
                                            --}}
                                            {{-- Campos --}}
                                            {{-- <input class="resolucion_validate_field_level-create-form" type="hidden" field="codigo_predio_edit" value="" /> --}}

                                            {{--
                                                Aqui se establece el id del formulario que se desea validar.
                                                Esto aplica solo para los formularios que necesitan una resolucion para edicion.
                                                Si se usa validacion de formulario no se deben usar campos aislados.
                                                En caso de que se use validacion de campos y formulario, se ignora los campos aislados
                                                y se hace una validacion completa del formulario.
                                                Cada campo dentro del formulario necesita llevar la clase res-validate.
                                            --}}
                                            {{-- Formulario --}}
                                            <input class="resolucion_validate_form_level-create-form" type="hidden" value="create-form" />
                                            @endif
                                            <div class="form-body">
                                                <!-- <h3 class="box-title">Informaci&oacute;n de la exenci&oacute;n</h3> -->
                                                <!-- <hr> -->
                                                <div class="row">
                                                    <div class="col-lg-7 col-md-7 col-sm-6 col-xs-12">
                                                        <form action="{{ route('prediosexenciones.create_exenciones') }}" method="post" id="create-form" desc-to-resolucion-modal="exenci&oacute;n de vigencias" class="create-form">
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
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <div class="form-group">
                                                                    <label class="control-label">Buscar predio:</label>
                                                                    <select id="id_predio" class="form-control select2 json prescripciones_exenciones res-validate" name="id_predio" data-placeholder="C&oacute;digo, propietario o direcci&oacute;n..." style="width: 100%">
                                                                    </select>
                                                                    <span class="text-danger">@error('id_predio') {{ $message }} @enderror</span>
                                                                </div>
                                                                <input type="hidden" id="file_name" name="file_name" value="">
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                                <div class="form-group">
                                                                    <label for="porcentaje" class="control-label">Porcentaje:</label>
                                                                    <div class="input-group">
                                                                        <input type="text" id="porcentaje_ex" name="porcentaje_ex" class="form-control res-validate" autocomplete="off" placeholder="Ingrese porcentaje" value="{{ old('porcentaje_ex') }}">
                                                                        <div class="input-group-addon">%</div>
                                                                    </div>
                                                                </div>
                                                                {{-- <span class="text-danger">@error('porcentaje_ex') {{ $message }} @enderror</span> --}}
                                                            </div>
                                                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                                <div class="form-group">
                                                                    <label class="control-label">A&ntilde;o:</label>
                                                                    {{-- <input type="text" id="exencion_hasta" name="exencion_hasta" class="form-control onlyNumbers res-validate" autocomplete="off" placeholder="A&ntilde;o..." value="{{ old('exencion_hasta') }}" maxlength="4"> --}}
                                                                    <select id="exencion_hasta" name="exencion_hasta" class="form-control selectpicker res-validate" data-size="3" title="A&ntilde;o..." style="width: 100%;">
                                                                    </select>
                                                                    <span class="text-danger">@error('exencion_hasta') {{ $message }} @enderror</span>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
                                                        {{-- <input type="hidden" id="filename" value=""> --}}
                                                        {{-- <input type="hidden" id="fileid" value=""> --}}
                                                        <form id="load-form" action="{{route('upload-file-resolucion')}}" method="post" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="form-body">
                                                                <div class="row">
                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Archivo resoluci&oacute;n</label><span class="text-muted" style="margin-left: 15px;">(*.pdf)</span>
                                                                            <input type="file" accept=".pdf" id="file" name="file" class="form-control filestyle" data-placeholder="" value="{{ old('file') }}" data-buttonName="btn-inverse" data-buttonBefore="true" data-buttonText="Buscar archivo">
                                                                            <span class="text-danger">@error('file') {{ $message }} @enderror</span>
                                                                        </div>
                                                                        <div class="progress">
                                                                            <div class="bar one"></div >
                                                                            <div class="porciento one">0%</div >
                                                                        </div>
                                                                        <span id="error_fileupload" class="text-danger" style="display: none;">Max file size 10 Mb</span>
                                                                        <span id="current_filename" class="text-inverse" style="display: block; padding-top: 15px;"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <button id="btn_cargar_archivo_resolucion" type="button" style="display: none;">Cargar archivo</button>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <span id="span_exencion" class="text-info">&nbsp;</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions m-t-20">
                                                <button id="btn_save_create" type="button" class="btn btn-info"> <i class="fa fa-save"></i> Guardar informaci&oacute;n</button>
                                                <!-- <button type="button" class="btn btn-default">Cancelar</button> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <section id="section-bar-2" class="">
                                <div id="div_table" class="row">
                                    <div class="col-lg-12">
                                        <div class="well">
                                            @if(isset($exenciones))
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
                                                <h2 style="width: 100%;">Lista de exenciones <i style="color: red; float: right; cursor: pointer;" class="fa fa-file-pdf-o"  id="print_exenciones" url="/generate_exenciones_pdf/"></i></h2>
                                                <table id="myTable" class="table table-hover table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="cell_center" style="width: auto;">C&oacute;digo predio</th>
                                                            <th class="cell_center" style="width: 7%;">Porcentaje</th>
                                                            <th class="cell_center" style="width: auto;">A&ntilde;o</th>
                                                            <th class="cell_center" style="width: auto;">Resoluci&oacute;n</th>
                                                            <th class="cell_center" style="width: auto;">Fecha creaci&oacute;n</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(count($exenciones) > 0)
                                                            @foreach($exenciones as $exencion)
                                                            <tr style="cursor: pointer;" id="tr_exencion_{{ $exencion->id }}" json-data='@json($exencion)' class='disabled'>
                                                                <td class="cell_center">{{ $exencion->codigo_predio }}</td>
                                                                <td class="cell_center">{{ $exencion->porcentaje }}</td>
                                                                <td class="cell_center">{{ $exencion->exencion_hasta }}</td>
                                                                @if(isset($exencion->file_name))
                                                                <td class="cell_center">
                                                                    <a data-toggle="tooltip" title="Descargar {{ $exencion->file_name }}" href="{{ route('download-file-resolucion', ['filename' => $exencion->file_name]) }}" style="color: red;"><i style="color: red;" class="fa fa-file-pdf-o"></i></a>
                                                                </td>
                                                                @else
                                                                <td class="cell_center">{!! $exencion->file_name !!}</td>
                                                                @endif
                                                                <td class="cell_center">{{ $exencion->created_at }}</td>
                                                            </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            @endif
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

@section('buttons')
@endsection

@section('modales')
@endsection

@section('resolucion')
    @if($opcion->resolucion_elimina == 1 || $opcion->resolucion_edita == 1 || $opcion->resolucion_crea == 1)
        @include('resoluciones.modal')
    @endif
@endsection
