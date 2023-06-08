<?php
    $configurations= App\Models\Tenant\Configuration::first();
?>
@extends('tenant.layouts.app')
@section('content')
    <vip-items
    type='clients'
    :configurations="{{ json_encode($configurations) }}"
    title='Listado de clientes vip'>
</vip-items>
@endsection