@extends('errors::minimal')

@php
    $host = request()->getHost();
    $bloqueoImg = (str_contains($host, 'guepardo') || str_contains($host, 'miperufactura'))
        ? '/logo/bloqueo2.png'
        : '/logo/bloqueo.png';
@endphp
<style>
    body {
        background-image: url('{{ $bloqueoImg }}');
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }
</style>

@section('title', __('Forbidden'))
{{-- @section('code', '403') --}}
@section('message', __($exception->getMessage() ?: ''))
{{-- CUENTA BLOQUEADA COMUNIQUESE CON SU PROVEEDOR DE SERVICIOS --}}
