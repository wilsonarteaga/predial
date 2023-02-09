@extends('theme.default')

@section('content')

@push('scripts')
    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\PagosCreateFormRequest', '#create-form'); !!}
    {!! JsValidator::formRequest('App\Http\Requests\PagosUpdateFormRequest', '#update-form'); !!}
    <script src="{!! asset('theme/js/accounting.min.js') !!}"></script>
    <script src="{!! asset('theme/js/autonumeric.min.js') !!}"></script>
    <script src="{!! asset('theme/plugins/bower_components/jquery.serializeJSON/jquery.serializejson.min.js') !!}"></script>
    <script src="{!! asset('theme/plugins/bower_components/jquery-validation-1.19.5/jquery.validate.min.js') !!}"></script>
    <script src="{!! asset('theme/plugins/bower_components/blockUI/jquery.blockUI.js') !!}"></script>
            <div class="modal-header">
    <script src="{!! asset('theme/js/customjs/controlsite.js') !!}?{{ $current_time }}"></script>
   <script src="{!! asset('theme/js/customjs/pagos.js') !!}?{{ $current_time }}"></script>
    {{-- <script src="{!! asset('theme/js/customjs/pagos_forms.js') !!}"></script> --}}
@endpush
@if(Session::get('tab_current'))
<input type="hidden" id="tab" value="{{ Session::get('tab_current') }}">
@elseif($tab_current)
<input type="hidden" id="tab" value="{{ $tab_current }}">
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
                                <li id="li-section-bar-1" class="tab-current"><a href="#section-bar-1" class="sticon ti-pulse"><span>Nuevo pago</span></a></li>
                                <li id="li-section-bar-2" class=""><a href="#section-bar-2" class="sticon icon-list"><span>Listado de pagos</span></a></li>
                                <!-- <li class=""><a href="#section-bar-3" class="sticon ti-stats-up"><span>Analytics</span></a></li>
                                <li class=""><a href="#section-bar-4" class="sticon ti-upload"><span>Upload</span></a></li>
                                <li class=""><a href="#section-bar-5" class="sticon ti-settings"><span>Settings</span></a></li> -->
                            </ul>
                        </nav>
                        <div class="content-wrap">
                            <section id="section-bar-1" class="content-current">
                                <div class="panel panel-inverse">
                                    <div class="panel-heading"><i  class="{{ $opcion->icono }}"></i>&nbsp;&nbsp;Informaci&oacute;n del pago</div>
                                    <div class="panel-wrapper collapse in" aria-expanded="true">
                                        <div class="panel-body">
                                            <form action="{{ route('pagos.create_pagos') }}" method="post" id="create-form">
                                                <input type="hidden" id="id_predio" name="id_predio" value="">
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
                                                    <!-- <h3 class="box-title">Informaci&oacute;n de la pago</h3> -->
                                                    <!-- <hr> -->
                                                    <div class="row">
                                                        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Banco factura:</label>
                                                                <select id="id_banco_factura" name="id_banco_factura" class="form-control selectpicker show-tick" data-live-search="true" data-size="4" title="Sin informaci&oacute;n...">
                                                                    @if(count($bancos) > 0)
                                                                        @foreach($bancos as $banco)
                                                                        <option value="{{ $banco->id }}" {{ old('id_banco_factura') == $banco->id ? 'selected' : '' }}>{{ $banco->codigo }} - {{ $banco->nombre }} ({{ $banco->asobancaria }})</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                                <span class="text-danger">@error('id_banco_factura') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-2 col-sm-6 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Fecha pago:</label>
                                                                <input type="text" id="fecha_pago" name="fecha_pago" class="form-control datepicker" autocomplete="off" placeholder="Ingrese fecha pago" value="{{ old('fecha_pago') }}" style="width: 100%;">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-5 col-sm-12 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">N&uacute;mero factura:</label>
                                                                <input type="text" id="numero_recibo" name="numero_recibo" class="form-control onlyNumbers" autocomplete="off" placeholder="N&uacute;mero de recibo" value="{{ old('numero_recibo') }}" maxlength="9">
                                                                <span class="text-danger">@error('numero_recibo') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-5 col-md-6 col-sm-7 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Banco archivo:</label>
                                                                <select id="id_banco_archivo" name="id_banco_archivo" class="form-control selectpicker-noval show-tick" data-live-search="true" data-size="4" title="Sin informaci&oacute;n...">
                                                                    @if(count($bancos) > 0)
                                                                        @foreach($bancos as $banco)
                                                                        <option value="{{ $banco->id }}" {{ old('id_banco_archivo') == $banco->id ? 'selected' : '' }}>{{ $banco->codigo }} - {{ $banco->nombre }} ({{ $banco->asobancaria }})</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Paquete archivo:</label>
                                                                <input type="text" id="paquete_archivo" name="paquete_archivo" class="form-control onlyNumbers" autocomplete="off" placeholder="Ingrese n&uacute;mero de paquete" value="{{ old('paquete_archivo') }}" maxlength="2">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">C&oacute;digo predio:</label>
                                                                {{-- <select id="id_predio" name="id_predio" class="form-control selectpicker show-tick" data-live-search="true" data-size="4" title="Sin informaci&oacute;n...">
                                                                    @if(count($predios) > 0)
                                                                        @foreach($predios as $predio)
                                                                        <option value="{{ $predio->id }}" {{ old('id_predio') == $predio->id ? 'selected' : '' }}>{{ $predio->codigo_predio }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select> --}}
                                                                {{-- <select id="id_predio" class="form-control select2" name="id_predio">
                                                                </select>
                                                                <span class="text-danger">@error('id_predio') {{ $message }} @enderror</span> --}}
                                                                <input type="text" id="codigo_predio" name="codigo_predio" class="form-control onlyNumbers" autocomplete="off" placeholder="C&oacute;digo predio" value="{{ old('codigo_predio') }}" maxlength="128" readonly="readonly">
                                                                <span class="text-danger">@error('codigo_predio') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Valor facturado:</label>
                                                                <input type="text" id="valor_facturado" name="valor_facturado" class="form-control" autocomplete="off" placeholder="Ingrese valor" value="{{ old('valor_facturado') }}" readonly="readonly">
                                                                <span class="text-danger">@error('valor_facturado') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Fecha factura:</label>
                                                                <input type="text" id="fecha_factura" name="fecha_factura" class="form-control" autocomplete="off" placeholder="Ingrese fecha factura" value="{{ old('fecha_factura') }}" readonly="readonly">
                                                                <span class="text-danger">@error('fecha_factura') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                                            <div class="form-group" style="margin-bottom: 5px;">
                                                                <label class="control-label">A&ntilde;o factura:</label>
                                                                <input type="text" id="anio_pago" name="anio_pago" class="form-control onlyNumbers" autocomplete="off" placeholder="Ingrese a&ntilde;o" value="{{ old('anio_pago') }}" maxlength="4" readonly="readonly">
                                                                <span class="text-danger">@error('anio_pago') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-7 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">C&oacute;digo de barras:</label>
                                                                <input type="text" id="codigo_barras" name="codigo_barras" class="form-control onlyNumbers" autocomplete="off" placeholder="Ingrese c&oacute;digo de barras" value="{{ old('codigo_barras') }}" maxlength="128">
                                                                <span class="text-danger">@error('codigo_barras') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-actions m-t-20">
                                                    <button id="btn_save_info" type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Guardar informaci&oacute;n</button>
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
                                            {{-- @if(isset($pagos)) --}}
                                                {{-- <div class="result">
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
                                                </div> --}}
                                                <h2>Lista de pagos</h2>
                                                <form id="pagos-filtro-form">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-3 col-sm-5 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Seleccione fecha pago:</label>
                                                                <input type="text" id="fecha_pago_listar" name="fecha_pago_listar" class="form-control datepicker" autocomplete="off" placeholder="Selecione  fecha pago" value="{{ old('fecha_pago_listar') }}">
                                                                {{-- <span class="text-danger">@error('fecha_pago_listar') {{ $message }} @enderror</span> --}}
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-7 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Seleccione banco:</label>
                                                                <select id="id_banco" name="id_banco" class="form-control selectpicker-noval show-tick" data-live-search="true" data-size="4" title="Sin informaci&oacute;n...">
                                                                    @if(count($bancos) > 0)
                                                                        @foreach($bancos as $banco)
                                                                        <option value="{{ $banco->id }}" {{ old('id_banco') == $banco->id ? 'selected' : '' }}>{{ $banco->codigo }} - {{ $banco->nombre }} ({{ $banco->asobancaria }})</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                                {{-- <span class="text-danger">@error('id_banco') {{ $message }} @enderror</span> --}}
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label" style="display: block;"><br /></label>
                                                                <button type="button"  id="btn_buscar_pagos" class="btn btn-info"><i class="fa fa-save"></i> Filtrar pagos</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <table id="pagosTable" class="table table-hover table-striped table-bordered">
                                                </table>
                                                {{-- <div class="pagination-blobk">
                                                    {{ $pagos->links('layouts.paginationlinks') }}
                                                </div> --}}
                                                {{-- <form id="form_delete" action="{{ route('pagos.delete_pagos') }}" method="post" style="display: none;">
                                                    @csrf
                                                    <input type="hidden" id="input_delete" name="input_delete">
                                                </form> --}}
                                            {{-- @endif --}}
                                        </div>
                                    </div>
                                </div>
                                {{-- <div id="div_edit_form" class="panel panel-info" style="display: none; margin-bottom: 0px">
                                    <div class="panel-heading"><i  class="{{ $opcion->icono }}"></i>&nbsp;&nbsp;Actualizar informaci&oacute;n del pago</div>
                                    <div class="panel-wrapper collapse in" aria-expanded="true">
                                        <div class="panel-body">
                                            <form action="{{ route('pagos.update_pagos') }}" method="post" id="update-form">
                                                @csrf
                                                <div class="form-body">
                                                    <input type="hidden" id="id_edit" name="id_edit" value="{{ old('id_edit') }}">
                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-3 col-sm-5 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Fecha pago:</label>
                                                                <input type="text" id="fecha_pago_edit" name="fecha_pago_edit" class="form-control" autocomplete="off" placeholder="Ingrese fecha pago" value="{{ old('fecha_pago_edit') }}" readonly="true">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-7 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Banco archivo:</label>
                                                                <select id="id_banco_archivo_edit" name="id_banco_archivo_edit" class="form-control selectpicker-noval show-tick" data-live-search="true" data-size="4" title="Sin informaci&oacute;n..." disabled="true">
                                                                    @if(count($bancos) > 0)
                                                                        @foreach($bancos as $banco)
                                                                        <option value="{{ $banco->id }}" {{ old('id_banco_archivo_edit') == $banco->id ? 'selected' : '' }}>{{ $banco->codigo }} - {{ $banco->nombre }} ({{ $banco->asobancaria }})</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Paquete archivo:</label>
                                                                <input type="text" id="paquete_archivo_edit" name="paquete_archivo_edit" class="form-control onlyNumbers" autocomplete="off" placeholder="Ingrese n&uacute;mero de paquete" value="{{ old('paquete_archivo_edit') }}" readonly="true">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">C&oacute;digo de barras:</label>
                                                                <input type="text" id="codigo_barras_edit" name="codigo_barras_edit" class="form-control onlyNumbers" autocomplete="off" placeholder="Ingrese c&oacute;digo de barras" value="{{ old('codigo_barras_edit') }}" maxlength="128">
                                                                <span class="text-danger">@error('codigo_barras_edit') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">N&uacute;mero factura:</label>
                                                                <input type="text" id="numero_recibo_edit" name="numero_recibo_edit" class="form-control onlyNumbers" autocomplete="off" placeholder="N&uacute;mero de recibo" value="{{ old('numero_recibo_edit') }}" maxlength="9">
                                                                <span class="text-danger">@error('numero_recibo_edit') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">C&oacute;digo predio:</label>
                                                                <select id="id_predio_edit" name="id_predio_edit" class="form-control selectpicker show-tick" data-live-search="true" data-size="4" title="Sin informaci&oacute;n...">
                                                                    @if(count($predios) > 0)
                                                                        @foreach($predios as $predio)
                                                                        <option value="{{ $predio->id }}" {{ old('id_predio_edit') == $predio->id ? 'selected' : '' }}>{{ $predio->codigo_predio }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                                <span class="text-danger">@error('id_predio_edit') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Valor facturado:</label>
                                                                <input type="text" id="valor_facturado_edit" name="valor_facturado_edit" class="form-control" autocomplete="off" placeholder="Ingrese valor" value="{{ old('valor_facturado_edit') }}">
                                                                <span class="text-danger">@error('valor_facturado_edit') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Fecha factura:</label>
                                                                <input type="text" id="fecha_factura_edit" name="fecha_factura_edit" class="form-control datepicker" autocomplete="off" placeholder="Ingrese fecha factura" value="{{ old('fecha_factura_edit') }}">
                                                                <span class="text-danger">@error('fecha_factura_edit') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-7 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Banco factura:</label>
                                                                <select id="id_banco_factura_edit" name="id_banco_factura_edit" class="form-control selectpicker show-tick" data-live-search="true" data-size="4" title="Sin informaci&oacute;n...">
                                                                    @if(count($bancos) > 0)
                                                                        @foreach($bancos as $banco)
                                                                        <option value="{{ $banco->id }}" {{ old('id_banco_factura_edit') == $banco->id ? 'selected' : '' }}>{{ $banco->codigo }} - {{ $banco->nombre }} ({{ $banco->asobancaria }})</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                                <span class="text-danger">@error('id_banco_factura_edit') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                                            <div class="form-group" style="margin-bottom: 5px;">
                                                                <label class="control-label">A&ntilde;o factura:</label>
                                                                <input type="text" id="anio_pago_edit" name="anio_pago_edit" class="form-control onlyNumbers" autocomplete="off" placeholder="Ingrese a&ntilde;o" value="{{ old('anio_pago_edit') }}" maxlength="4">
                                                                <span class="text-danger">@error('anio_pago_edit') {{ $message }} @enderror</span>
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
                                </div> --}}
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

@section('buttons')
@endsection

@section('modales')
@endsection
