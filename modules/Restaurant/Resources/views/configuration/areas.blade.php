<?php
$configurations = \App\Models\Tenant\Configuration::first();
?>
@extends('tenant.layouts.app')
@section('content')
    <tenant-restaurant-items type='restaurant/areas' :configurations="{{ json_encode($configurations) }}"
        title='Listado de Áreas'>
    </tenant-restaurant-items>
@endsection
