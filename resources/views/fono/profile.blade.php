@extends('theme.default')
@section('content')
<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">{{ Session::get('desc_role') }}</h4> </div>
            <!-- <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20">
                    <i class="ti-settings text-white"></i>
                </button>
                <a href="#" target="" class="btn btn-danger pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Buy Admin Now</a>
                <ol class="breadcrumb">
                    <li><a href="#">Dashboard</a></li>
                    <li class="active">Dashboard 1</li>
                </ol>
            </div> -->
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h1 style="color: #c0c0c0;">{{ Session::get('desc_role') }}</h1>
                </div>
            </div>
        </div>
</div>
@endsection
