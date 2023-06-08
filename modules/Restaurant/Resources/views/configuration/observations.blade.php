<?php
$configurations = App\Models\Tenant\Configuration::first();
?>
@extends('tenant.layouts.app')
@section('content')
    <tenant-restaurant-items type='restaurant/observations' :configurations="{{ json_encode($configurations) }}"
        title='Listado de observaciones'>
    </tenant-restaurant-items>
@endsection
