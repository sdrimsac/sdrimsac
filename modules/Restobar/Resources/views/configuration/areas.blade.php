<?php
$configurations = \App\Models\Tenant\Configuration::first();
?>
@extends('tenant.layouts.app')
@section('content')
    <tenant-restobar-items type='caja/areas' :configurations="{{ json_encode($configurations) }}"
        title='Listado de Áreas'>
    </tenant-restobar-items>
@endsection
