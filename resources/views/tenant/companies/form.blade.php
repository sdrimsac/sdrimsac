@extends('tenant.layouts.app')

@section('content')

    <div class="row">
    <div class="col-md-12">
    <div class="container-fluid p-l-0">
            <div class="page-header">
                <div class="row">
                <div class="col-sm-6">
                    <h6><span>Empresa</span></h6>
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active"><span class="text-muted">Configuración</span></li>
                    </ol>
                </div>

                </div>
            </div>
    </div>
    </div>
    <div class="col-md-12">
        <tenant-companies-form></tenant-companies-form>
        </div>

    </div>

@endsection
