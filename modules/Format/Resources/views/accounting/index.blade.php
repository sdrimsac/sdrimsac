@extends('tenant.layouts.app')

@section('content')
<!-- index principal del reporte contable -->
    <div class="row">
        <div class="col-md-12">
            <tenant-account-export></tenant-account-export>
        </div>
    </div>

@endsection