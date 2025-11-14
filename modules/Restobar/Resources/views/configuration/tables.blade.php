<?php
$configurations = \App\Models\Tenant\Configuration::first();
?>
@extends('tenant.layouts.app')

@section('content')
    <tenant-restobar-items type='caja/tables' title='Mesas' :configurations="{{ json_encode($configurations) }}"
    :type-user="{{json_encode(Auth::user()->type)}}" :user="{{json_encode(Auth::user())}}"
    ></tenant-restobar-items>
@endsection
