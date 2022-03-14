@extends('theme.default')
@section('content')

@push('scripts')
    <script src="{!! asset('theme/js/customjs/controlsite.js') !!}"></script>
@endpush
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
                <div id="div_table" class="row">
                    <div class="col-lg-12">
                        @if(isset($pacientes))
                            <h2>
                                Reporte de pacientes
                                <a style="display: none;" id="generar_reporte" href="javascript:void(0)" url="{{ route('aten.patientreport') }}" class="btn btn-inverse pull-right">
                                    <i class="mdi mdi-auto-fix"></i>
                                    Generar reporte de pacientes
                                </a>
                            </h2>
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
                                                <button type="button" url="{{ route('aten.patientreport') }}/{{ $paciente->ide_pac }}" class="download_row btn btn-info"><i class="fa fa-download"></i></button>
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
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
