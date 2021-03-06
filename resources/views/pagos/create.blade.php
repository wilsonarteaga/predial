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
    <script src="{!! asset('theme/js/customjs/controlsite.js') !!}"></script>
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
                                                        <div class="col-lg-3 col-md-3 col-sm-5 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Fecha pago:</label>
                                                                <input type="text" id="fecha_pago" name="fecha_pago" class="form-control datepicker" autocomplete="off" placeholder="Ingrese fecha pago" value="{{ old('fecha_pago') }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-7 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Banco archivo:</label>
                                                                <select id="id_banco_archivo" name="id_banco_archivo" class="form-control selectpicker-noval show-tick" data-live-search="true" title="Sin informaci&oacute;n...">
                                                                    @if(count($bancos) > 0)
                                                                        @foreach($bancos as $banco)
                                                                        <option value="{{ $banco->id }}" {{ old('id_banco_archivo') == $banco->id ? 'selected' : '' }}>{{ $banco->codigo }} - {{ $banco->nombre }} ({{ $banco->asobancaria }})</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Paquete archivo:</label>
                                                                <input type="text" id="paquete_archivo" name="paquete_archivo" class="form-control onlyNumbers" autocomplete="off" placeholder="Ingrese n&uacute;mero de paquete" value="{{ old('paquete_archivo') }}" maxlength="2">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">C&oacute;digo de barras:</label>
                                                                <input type="text" id="codigo_barras" name="codigo_barras" class="form-control onlyNumbers" autocomplete="off" placeholder="Ingrese c&oacute;digo de barras" value="{{ old('codigo_barras') }}" maxlength="128">
                                                                <span class="text-danger">@error('codigo_barras') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">N&uacute;mero recibo:</label>
                                                                <input type="text" id="numero_recibo" name="numero_recibo" class="form-control onlyNumbers" autocomplete="off" placeholder="N&uacute;mero de recibo" value="{{ old('numero_recibo') }}" maxlength="128">
                                                                <span class="text-danger">@error('numero_recibo') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">C&oacute;digo predio:</label>
                                                                <select id="id_predio" name="id_predio" class="form-control selectpicker show-tick" data-live-search="true" title="Sin informaci&oacute;n...">
                                                                    @if(count($predios) > 0)
                                                                        @foreach($predios as $predio)
                                                                        <option value="{{ $predio->id }}" {{ old('id_predio') == $predio->id ? 'selected' : '' }}>{{ $predio->codigo_predio }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                                <span class="text-danger">@error('id_predio') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Valor facturado:</label>
                                                                <input type="text" id="valor_facturado" name="valor_facturado" class="form-control" autocomplete="off" placeholder="Ingrese valor" value="{{ old('valor_facturado') }}">
                                                                <span class="text-danger">@error('valor_facturado') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Fecha factura:</label>
                                                                <input type="text" id="fecha_factura" name="fecha_factura" class="form-control datepicker" autocomplete="off" placeholder="Ingrese fecha factura" value="{{ old('fecha_factura') }}">
                                                                <span class="text-danger">@error('fecha_factura') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-7 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Banco factura:</label>
                                                                <select id="id_banco_factura" name="id_banco_factura" class="form-control selectpicker show-tick" data-live-search="true" title="Sin informaci&oacute;n...">
                                                                    @if(count($bancos) > 0)
                                                                        @foreach($bancos as $banco)
                                                                        <option value="{{ $banco->id }}" {{ old('id_banco_factura') == $banco->id ? 'selected' : '' }}>{{ $banco->codigo }} - {{ $banco->nombre }} ({{ $banco->asobancaria }})</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                                <span class="text-danger">@error('id_banco_factura') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                                            <div class="form-group" style="margin-bottom: 5px;">
                                                                <label class="control-label">A&ntilde;o factura:</label>
                                                                <input type="text" id="anio_pago" name="anio_pago" class="form-control onlyNumbers" autocomplete="off" placeholder="Ingrese a&ntilde;o" value="{{ old('anio_pago') }}" maxlength="4">
                                                                <span class="text-danger">@error('anio_pago') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-actions m-t-20">
                                                    <button type="submit" class="btn btn-info"> <i class="fa fa-save"></i> Guardar informaci&oacute;n</button>
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
                                            @if(isset($pagos))
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
                                                <h2>Lista de pagos</h2>
                                                <table id="myTable" class="table table-hover table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="cell_center" style="width: 7%;">N&uacute;mero recibo</th>
                                                            <th class="cell_center" style="width: 7%;">Valor facturado</th>
                                                            <th class="cell_center" style="width: 7%;">A&ntilde;o pago</th>
                                                            <th class="cell_center" style="width: 7%;">Fecha factura</th>
                                                            <th class="cell_center" style="width: 7%;">Banco</th>
                                                            <th class="cell_center" style="width: 10%;">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(count($pagos) > 0)
                                                            @foreach($pagos as $pago)
                                                            <tr style="cursor: pointer;" id="tr_pago_{{ $pago->id }}" json-data='@json($pago)'>
                                                                <td class="cell_center edit_row">{{ $pago->numero_recibo }}</td>
                                                                <td class="cell_center edit_row">@money($pago->valor_facturado)</td>
                                                                <td class="edit_row cell_center">{{ $pago->anio_pago }}</td>
                                                                <td class="edit_row cell_center">{{ $pago->fecha_factura }}</td>
                                                                <td class="cell_center edit_row">{{ $pago->banco }}</td>
                                                                {{-- <td class="edit_row">{{ $pago->dir_acu }}</td> --}}
                                                                <td class="cell_center">
                                                                    <button type="button" ide="{{ $pago->id }}" class="modify_row btn btn-info"><i class="fa fa-pencil-square"></i></button>
                                                                    &nbsp;&nbsp;
                                                                    <button type="button" ide="{{ $pago->id }}" class="delete_row btn btn-inverse"><i class="fa fa-trash-o"></i></button>
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
                                                    {{ $pagos->links('layouts.paginationlinks') }}
                                                </div> --}}
                                                <form id="form_delete" action="{{ route('pagos.delete_pagos') }}" method="post" style="display: none;">
                                                    @csrf
                                                    <input type="hidden" id="input_delete" name="input_delete">
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div id="div_edit_form" class="panel panel-info" style="display: none; margin-bottom: 0px">
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
                                                                <select id="id_banco_archivo_edit" name="id_banco_archivo_edit" class="form-control selectpicker-noval show-tick" data-live-search="true" title="Sin informaci&oacute;n..." disabled="true">
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
                                                                <label class="control-label">N&uacute;mero recibo:</label>
                                                                <input type="text" id="numero_recibo_edit" name="numero_recibo_edit" class="form-control onlyNumbers" autocomplete="off" placeholder="N&uacute;mero de recibo" value="{{ old('numero_recibo_edit') }}" maxlength="128">
                                                                <span class="text-danger">@error('numero_recibo_edit') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">C&oacute;digo predio:</label>
                                                                <select id="id_predio_edit" name="id_predio_edit" class="form-control selectpicker show-tick" data-live-search="true" title="Sin informaci&oacute;n...">
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
                                                                <select id="id_banco_factura_edit" name="id_banco_factura_edit" class="form-control selectpicker show-tick" data-live-search="true" title="Sin informaci&oacute;n...">
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

                                                    {{-- <div class="row">
                                                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">C&oacute;digo pago:</label>
                                                                <input type="text" id="codigo_pago_edit" name="codigo_pago_edit" class="form-control onlyNumbers" autocomplete="off" placeholder="Ingrese c&oacute;digo pago" value="{{ old('codigo_pago_edit') }}" readonly="readonly">
                                                                <span class="text-danger">@error('codigo_pago_edit') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                        <div id="div_tipo_edit" class="col-lg-1 col-md-1 col-sm-2 col-xs-6" style="opacity: 0;">
                                                            <div class="form-group">
                                                                <label class="control-label">Tipo:</label>
                                                                <input type="hidden" id="tipo_edit" name="tipo_edit" value="{{ old('tipo_edit') }}">
                                                                <span id="span_tipo_edit" class="span_pago"></span>
                                                                <span class="text-danger">@error('tipo_edit') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                        <div id="div_sector_edit" class="col-lg-1 col-md-1 col-sm-2 col-xs-6" style="opacity: 0;">
                                                            <div class="form-group">
                                                                <label class="control-label">Sector:</label>
                                                                <input type="hidden" id="sector_edit" name="sector_edit" value="{{ old('sector_edit') }}">
                                                                <span id="span_sector_edit" class="span_pago"></span>
                                                                <span class="text-danger">@error('sector_edit') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>

                                                        <div id="div_manzana_edit" class="col-lg-1 col-md-1 col-sm-2 col-xs-6" style="opacity: 0;">
                                                            <div class="form-group">
                                                                <label class="control-label">Manzana:</label>
                                                                <input type="hidden" id="manzana_edit" name="manzana_edit" value="{{ old('manzana_edit') }}">
                                                                <span id="span_manzana_edit" class="span_pago"></span>
                                                                <span class="text-danger">@error('manzana_edit') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>

                                                        <div id="div_pago_edit" class="col-lg-1 col-md-1 col-sm-2 col-xs-6" style="opacity: 0;">
                                                            <div class="form-group">
                                                                <label class="control-label">Predio:</label>
                                                                <input type="hidden" id="pago_edit" name="pago_edit" value="{{ old('pago_edit') }}">
                                                                <span id="span_pago_edit" class="span_pago"></span>
                                                                <span class="text-danger">@error('pago_edit') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>

                                                        <div id="div_mejora_edit" class="col-lg-1 col-md-1 col-sm-2 col-xs-6" style="opacity: 0;">
                                                            <div class="form-group">
                                                                <label class="control-label">Mejora:</label>
                                                                <input type="hidden" id="mejora_edit" name="mejora_edit" value="{{ old('mejora_edit') }}">
                                                                <span id="span_mejora_edit" class="span_pago"></span>
                                                                <span class="text-danger">@error('mejora_edit') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-offset-1 col-lg-2 col-md-offset-1 col-md-2 col-sm-offset-1 col-sm-3 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Zona:</label>
                                                                <select id="id_zona_edit" name="id_zona_edit" class="form-control selectpicker show-tick" data-live-search="true" title="Seleccione...">
                                                                    @if(count($zonas) > 0)
                                                                        @foreach($zonas as $zona)
                                                                        <option value="{{ $zona->id }}" {{ old('id_zona_edit') == $zona->id ? 'selected' : '' }}>{{ $zona->descripcion }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                                <span class="text-danger">@error('id_zona_edit') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Direcci&oacute;n:</label>
                                                                <input type="text" id="direccion_edit" name="direccion_edit" class="form-control" autocomplete="off" placeholder="Ingrese direcci&oacute;n" value="{{ old('direccion_edit') }}" maxlength="128">
                                                                <span class="text-danger">@error('direccion_edit') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">&Aacute;rea metros:</label>
                                                                <input type="text" id="area_metros_edit" name="area_metros_edit" class="form-control" autocomplete="off" placeholder="Ingrese &aacute;rea metros" value="{{ old('area_metros_edit') }}">
                                                                <span class="text-danger">@error('area_metros_edit') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">&Aacute;rea construida:</label>
                                                                <input type="text" id="area_construida_edit" name="area_construida_edit" class="form-control" autocomplete="off" placeholder="Ingrese &aacute;rea construida" value="{{ old('area_construida_edit') }}">
                                                                <span class="text-danger">@error('area_construida_edit') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">&Aacute;rea hect&aacute;reas:</label>
                                                                <input type="text" id="area_hectareas_edit" name="area_hectareas_edit" class="form-control" autocomplete="off" placeholder="Ingrese &aacute;rea hect&aacute;reas" value="{{ old('area_hectareas_edit') }}">
                                                                <span class="text-danger">@error('area_hectareas_edit') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Tarifa actual:</label>
                                                                <input type="text" id="tarifa_actual_edit" name="tarifa_actual_edit" class="form-control" autocomplete="off" placeholder="Ingrese tarifa actual" value="{{ old('tarifa_actual_edit') }}">
                                                                <span class="text-danger">@error('tarifa_actual_edit') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">Aval&uacute;o:</label>
                                                                <input type="text" id="avaluo_edit" name="avaluo_edit" class="form-control" autocomplete="off" placeholder="Ingrese aval&uacute;o" value="{{ old('avaluo_edit') }}">
                                                                <span class="text-danger">@error('avaluo_edit') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
                                                            <div class="form-group">
                                                                <label class="control-label">&Uacute;ltimo a&ntilde;o pago:</label>
                                                                <input type="text" id="ultimo_anio_pago_edit" name="ultimo_anio_pago_edit" class="form-control onlyNumbers" autocomplete="off" placeholder="Ingrese a&ntilde;o" value="{{ old('ultimo_anio_pago_edit') }}" maxlength="4">
                                                                <span class="text-danger">@error('ultimo_anio_pago_edit') {{ $message }} @enderror</span>
                                                            </div>
                                                        </div>
                                                    </div> --}}

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

@section('buttons')
@endsection

@section('modales')
@endsection
