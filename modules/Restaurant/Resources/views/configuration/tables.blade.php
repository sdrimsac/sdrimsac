<?php
$configurations = \App\Models\Tenant\Configuration::first();
?>
@extends('tenant.layouts.app')

@section('content')
    <tenant-restaurant-items type='caja/tables' title='Mesas' :configurations="{{ json_encode($configurations) }}"></tenant-restaurant-items>
@endsection
