<?php
    $configurations=\App\Models\Tenant\Configuration::first();
?>
@extends('tenant.layouts.app')
@section('content')
    <vip-items
    type='categories'
    :configurations="{{ json_encode($configurations) }}"
    title='Listado de categorias vip'>
</vip-items>
@endsection